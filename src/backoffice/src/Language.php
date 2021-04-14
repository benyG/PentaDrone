<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Langauge class
 */
class Language
{
    protected $Phrases = null;
    public $LanguageId;
    public $LanguageFolder;
    public $Template = ""; // JsRender template
    public $Method = "prependTo"; // JsRender template method
    public $Target = ".navbar-nav.ml-auto"; // JsRender template target
    public $Type = "LI"; // LI/DROPDOWN (for used with top Navbar) or SELECT/RADIO (NOT for used with top Navbar)

    // Constructor
    public function __construct()
    {
        global $CurrentLanguage;
        $this->LanguageFolder = Config("LANGUAGE_FOLDER");
        $this->loadFileList(); // Set up file list
        if (Param("language", "") != "") {
            $this->LanguageId = Param("language");
            $_SESSION[SESSION_LANGUAGE_ID] = $this->LanguageId;
        } elseif (Session(SESSION_LANGUAGE_ID) != "") {
            $this->LanguageId = Session(SESSION_LANGUAGE_ID);
        } else {
            $this->LanguageId = Config("LANGUAGE_DEFAULT_ID");
        }
        $CurrentLanguage = $this->LanguageId;
        Config("CSS_FLIP", IsRTL());
        $this->loadLanguage($this->LanguageId);

        // Call Language Load event
        $this->languageLoad();
        SetClientVar("languages", ["languages" => $this->getLanguages()]);
    }

    // Load language file list
    protected function loadFileList()
    {
        global $LANGUAGES;
        if (is_array($LANGUAGES)) {
            $cnt = count($LANGUAGES);
            for ($i = 0; $i < $cnt; $i++) {
                $LANGUAGES[$i][1] = $this->loadFileDesc($this->LanguageFolder . $LANGUAGES[$i][2]);
            }
        }
    }

    // Load language file description
    protected function loadFileDesc($file)
    {
        $ar = Xml2Array(substr(file_get_contents($file), 0, 512)); // Just read the first part
        return (is_array($ar)) ? @$ar["ew-language"]["attr"]["desc"] : "";
    }

    // Load language file
    protected function loadLanguage($id)
    {
        global $DECIMAL_POINT, $THOUSANDS_SEP, $MON_DECIMAL_POINT, $MON_THOUSANDS_SEP,
            $CURRENCY_SYMBOL, $POSITIVE_SIGN, $NEGATIVE_SIGN, $FRAC_DIGITS,
            $P_CS_PRECEDES, $P_SEP_BY_SPACE, $N_CS_PRECEDES, $N_SEP_BY_SPACE,
            $P_SIGN_POSN, $N_SIGN_POSN, $TIME_ZONE,
            $DATE_SEPARATOR, $TIME_SEPARATOR, $DATE_FORMAT, $DATE_FORMAT_ID;
        $fileName = $this->getFileName($id);
        if ($fileName == "") {
            $fileName = $this->getFileName(Config("LANGUAGE_DEFAULT_ID"));
        }
        if ($fileName == "") {
            return;
        }
        $phrases = Session(PROJECT_NAME . "_" . $fileName);
        if (is_array($phrases)) {
            $this->Phrases = $phrases;
        } else {
            $this->Phrases = Xml2Array(file_get_contents($fileName));
        }

        // Set up locale / currency format for language
        extract(LocaleConvert());
        if (!empty($decimal_point)) {
            $DECIMAL_POINT = $decimal_point;
        }
        if (!empty($thousands_sep)) {
            $THOUSANDS_SEP = $thousands_sep;
        }
        if (!empty($mon_decimal_point)) {
            $MON_DECIMAL_POINT = $mon_decimal_point;
        }
        if (!empty($mon_thousands_sep)) {
            $MON_THOUSANDS_SEP = $mon_thousands_sep;
        }
        if (!empty($currency_symbol)) {
            $CURRENCY_SYMBOL = $currency_symbol;
        }
        if (isset($positive_sign)) {
            $POSITIVE_SIGN = $positive_sign; // Note: $positive_sign can be empty.
        }
        if (!empty($negative_sign)) {
            $NEGATIVE_SIGN = $negative_sign;
        }
        if (isset($frac_digits)) {
            $FRAC_DIGITS = $frac_digits;
        }
        if (isset($p_cs_precedes)) {
            $P_CS_PRECEDES = $p_cs_precedes;
        }
        if (isset($p_sep_by_space)) {
            $P_SEP_BY_SPACE = $p_sep_by_space;
        }
        if (isset($n_cs_precedes)) {
            $N_CS_PRECEDES = $n_cs_precedes;
        }
        if (isset($n_sep_by_space)) {
            $N_SEP_BY_SPACE = $n_sep_by_space;
        }
        if (isset($p_sign_posn)) {
            $P_SIGN_POSN = $p_sign_posn;
        }
        if (isset($n_sign_posn)) {
            $N_SIGN_POSN = $n_sign_posn;
        }
        if (!empty($date_sep)) {
            $DATE_SEPARATOR = $date_sep;
        }
        if (!empty($time_sep)) {
            $TIME_SEPARATOR = $time_sep;
        }
        if (!empty($date_format)) {
            $DATE_FORMAT = DateFormat($date_format);
            $DATE_FORMAT_ID = DateFormatId($date_format);
        }

        // Set up time zone from language file for multi-language site
        // Read http://www.php.net/date_default_timezone_set for details
        // and http://www.php.net/timezones for supported time zones
        if (!empty($time_zone)) {
            $TIME_ZONE = $time_zone;
        }
        if (!empty($TIME_ZONE)) {
            date_default_timezone_set($TIME_ZONE);
        }
    }

    // Get language file name
    protected function getFileName($id)
    {
        global $LANGUAGES;
        if (is_array($LANGUAGES)) {
            $cnt = count($LANGUAGES);
            for ($i = 0; $i < $cnt; $i++) {
                if ($LANGUAGES[$i][0] == $id) {
                    return $this->LanguageFolder . $LANGUAGES[$i][2];
                }
            }
        }
        return "";
    }

    // Get phrase
    public function phrase($id, $useText = false)
    {
        $imageClass = ConvertFromUtf8(@$this->Phrases["ew-language"]["global"]["phrase"][strtolower($id)]["attr"]["class"]);
        if (isset($this->Phrases["ew-language"]["global"]["phrase"][strtolower($id)])) {
            $text = ConvertFromUtf8(@$this->Phrases["ew-language"]["global"]["phrase"][strtolower($id)]["attr"]["value"]);
        } else {
            $text = $id;
        }
        if (!$useText && $imageClass != "") {
            return '<i data-phrase="' . $id . '" class="' . $imageClass . '" data-caption="' . HtmlEncode($text) . '"></i>';
        }
        return $text;
    }

    // Set phrase
    public function setPhrase($id, $value)
    {
        $this->setPhraseAttr($id, "value", $value);
    }

    // Get project phrase
    public function projectPhrase($id)
    {
        return ConvertFromUtf8(@$this->Phrases["ew-language"]["project"]["phrase"][strtolower($id)]["attr"]["value"]);
    }

    // Set project phrase
    public function setProjectPhrase($id, $value)
    {
        $this->Phrases["ew-language"]["project"]["phrase"][strtolower($id)]["attr"]["value"] = $value;
    }

    // Get menu phrase
    public function menuPhrase($menuId, $id)
    {
        return ConvertFromUtf8(@$this->Phrases["ew-language"]["project"]["menu"][$menuId]["phrase"][strtolower($id)]["attr"]["value"]);
    }

    // Set menu phrase
    public function setMenuPhrase($menuId, $id, $value)
    {
        $this->Phrases["ew-language"]["project"]["menu"][$menuId]["phrase"][strtolower($id)]["attr"]["value"] = $value;
    }

    // Get table phrase
    public function tablePhrase($tblVar, $id)
    {
        return ConvertFromUtf8(@$this->Phrases["ew-language"]["project"]["table"][strtolower($tblVar)]["phrase"][strtolower($id)]["attr"]["value"]);
    }

    // Set table phrase
    public function setTablePhrase($tblVar, $id, $value)
    {
        $this->Phrases["ew-language"]["project"]["table"][strtolower($tblVar)]["phrase"][strtolower($id)]["attr"]["value"] = $value;
    }

    // Get chart phrase
    public function chartPhrase($tblVar, $chtVar, $id)
    {
        return ConvertFromUtf8(@$this->Phrases["ew-language"]["project"]["table"][strtolower($tblVar)]["chart"][strtolower($chtVar)]["phrase"][strtolower($id)]["attr"]["value"]);
    }

    // Set chart phrase
    public function setChartPhrase($tblVar, $chtVar, $id, $value)
    {
        $this->Phrases["ew-language"]["project"]["table"][strtolower($tblVar)]["chart"][strtolower($chtVar)]["phrase"][strtolower($id)]["attr"]["value"] = $value;
    }

    // Get field phrase
    public function fieldPhrase($tblVar, $fldVar, $id)
    {
        return ConvertFromUtf8(@$this->Phrases["ew-language"]["project"]["table"][strtolower($tblVar)]["field"][strtolower($fldVar)]["phrase"][strtolower($id)]["attr"]["value"]);
    }

    // Set field phrase
    public function setFieldPhrase($tblVar, $fldVar, $id, $value)
    {
        $this->Phrases["ew-language"]["project"]["table"][strtolower($tblVar)]["field"][strtolower($fldVar)]["phrase"][strtolower($id)]["attr"]["value"] = $value;
    }

    // Get phrase attribute
    protected function phraseAttr($id, $name)
    {
        return ConvertFromUtf8(@$this->Phrases["ew-language"]["global"]["phrase"][strtolower($id)]["attr"][strtolower($name)]);
    }

    // Set phrase attribute
    protected function setPhraseAttr($id, $name, $value)
    {
        $this->Phrases["ew-language"]["global"]["phrase"][strtolower($id)]["attr"][strtolower($name)] = $value;
    }

    // Get phrase class
    public function phraseClass($id)
    {
        return $this->PhraseAttr($id, "class");
    }

    // Set phrase attribute
    public function setPhraseClass($id, $value)
    {
        $this->setPhraseAttr($id, "class", $value);
    }

    // Output XML as JSON
    public function xmlToJson($xpath)
    {
        $nodeList = $this->Phrases->selectNodes($xpath);
        $res = [];
        foreach ($nodeList as $node) {
            $id = $this->getNodeAtt($node, "id");
            $value = $this->getNodeAtt($node, "value");
            $res[$id] = $value;
        }
        return JsonEncode($res);
    }

    // Output array as JSON
    public function arrayToJson($client)
    {
        $ar = @$this->Phrases["ew-language"]["global"]["phrase"];
        $res = [];
        if (is_array($ar)) {
            foreach ($ar as $id => $node) {
                $isClient = @$node["attr"]["client"] == '1';
                $value = ConvertFromUtf8(@$node["attr"]["value"]);
                if (!$client || $client && $isClient) {
                    $res[$id] = $value;
                }
            }
        }
        return JsonEncode($res);
    }

    // Output all phrases as JSON
    public function allToJson()
    {
        return "ew.language = new ew.Language(" . $this->arrayToJson(false) . ");";
    }

    // Output client phrases as JSON
    public function toJson()
    {
        return "ew.language = new ew.Language(" . $this->arrayToJson(true) . ");";
    }

    // Output languages as array
    protected function getLanguages()
    {
        global $LANGUAGES, $CurrentLanguage;
        $ar = [];
        if (is_array($LANGUAGES)) {
            $cnt = count($LANGUAGES);
            if ($cnt > 1) {
                for ($i = 0; $i < $cnt; $i++) {
                    $langId = $LANGUAGES[$i][0];
                    $phrase = $this->phrase($langId) ?: $LANGUAGES[$i][1];
                    $ar[] = ["id" => $langId, "desc" => ConvertFromUtf8($phrase), "selected" => $langId == $CurrentLanguage];
                }
            }
        }
        return $ar;
    }

    // Get template
    public function getTemplate()
    {
        if ($this->Template == "") {
            if (SameText($this->Type, "LI")) { // LI template (for used with top Navbar)
                return '{{for languages}}<li class="nav-item"><a href="#" class="nav-link{{if selected}} active{{/if}} ew-tooltip" title="{{>desc}}" onclick="ew.setLanguage(this);" data-language="{{:id}}">{{:id}}</a></li>{{/for}}';
            } elseif (SameText($this->Type, "DROPDOWN")) { // DROPDOWN template (for used with top Navbar)
                return '<li class="nav-item dropdown"><a href="#" class="nav-link" data-toggle="dropdown"><i class="fas fa-globe ew-icon"></i></span></a><div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">{{for languages}}<a href="#" class="dropdown-item{{if selected}} active{{/if}}" onclick="ew.setLanguage(this);" data-language="{{:id}}">{{>desc}}</a>{{/for}}</div></li>';
            } elseif (SameText($this->Type, "SELECT")) { // SELECT template (NOT for used with top Navbar)
                return '<div class="ew-language-option"><select class="custom-select" id="ew-language" name="ew-language" onchange="ew.setLanguage(this);">{{for languages}}<option value="{{:id}}"{{if selected}} selected{{/if}}>{{:desc}}</option>{{/for}}</select></div>';
            } elseif (SameText($this->Type, "RADIO")) { // RADIO template (NOT for used with top Navbar)
                return '<div class="ew-language-option"><div class="btn-group" data-toggle="buttons">{{for languages}}<input type="radio" name="ew-language" id="ew-Language-{{:id}}" onchange="ew.setLanguage(this);{{if selected}} checked{{/if}}" value="{{:id}}"><label class="btn btn-default ew-tooltip" for="ew-language-{{:id}}" data-container="body" data-placement="bottom" title="{{>desc}}">{{:id}}</label>{{/for}}</div></div>';
            }
        }
        return $this->Template;
    }

    // Language Load event
    public function languageLoad()
    {
        // Example:
        //$this->setPhrase("MyID", "MyValue"); // Refer to language file for the actual phrase id
        //$this->setPhraseClass("MyID", "fas fa-xxx ew-icon"); // Refer to https://fontawesome.com/icons?d=gallery&m=free [^] for icon name
    }
}
