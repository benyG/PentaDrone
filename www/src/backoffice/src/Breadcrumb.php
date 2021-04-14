<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Breadcrumb class
 */
class Breadcrumb
{
    public $Links = [];
    public $SessionLinks = [];
    public $Visible = true;
    public static $CssClass = "breadcrumb float-sm-right ew-breadcrumbs";

    // Constructor
    public function __construct($homePage)
    {
        global $Language;
        $this->Links[] = ["home", "HomePage", $homePage, "ew-home", "", false]; // Home
    }

    // Check if an item exists
    protected function exists($pageid, $table, $pageurl)
    {
        if (is_array($this->Links)) {
            $cnt = count($this->Links);
            for ($i = 0; $i < $cnt; $i++) {
                @list($id, $title, $url, $tablevar, $cur) = $this->Links[$i];
                if ($pageid == $id && $table == $tablevar && $pageurl == $url) {
                    return true;
                }
            }
        }
        return false;
    }

    // Add breadcrumb
    public function add($pageid, $pagetitle, $pageurl, $pageurlclass = "", $table = "", $current = false)
    {
        // Load session links
        $this->loadSession();

        // Get list of master tables
        $mastertable = [];
        if ($table != "") {
            $tablevar = $table;
            while (Session(PROJECT_NAME . "_" . $tablevar . "_" . Config("TABLE_MASTER_TABLE")) != "") {
                $tablevar = Session(PROJECT_NAME . "_" . $tablevar . "_" . Config("TABLE_MASTER_TABLE"));
                if (in_array($tablevar, $mastertable)) {
                    break;
                }
                $mastertable[] = $tablevar;
            }
        }

        // Add master links first
        if (is_array($this->SessionLinks)) {
            $cnt = count($this->SessionLinks);
            for ($i = 0; $i < $cnt; $i++) {
                @list($id, $title, $url, $cls, $tbl, $cur) = $this->SessionLinks[$i];
                //if ((in_array($tbl, $mastertable) || $tbl == $table) && $id == "list") {
                if (in_array($tbl, $mastertable) && $id == "list") {
                    if ($url == $pageurl) {
                        break;
                    }
                    if (!$this->exists($id, $tbl, $url)) {
                        $this->Links[] = [$id, $title, $url, $cls, $tbl, false];
                    }
                }
            }
        }

        // Add this link
        if (!$this->exists($pageid, $table, $pageurl)) {
            $this->Links[] = [$pageid, $pagetitle, $pageurl, $pageurlclass, $table, $current];
        }

        // Save session links
        $this->saveSession();
    }

    // Save links to Session
    protected function saveSession()
    {
        $_SESSION[SESSION_BREADCRUMB] = $this->Links;
    }

    // Load links from Session
    protected function loadSession()
    {
        $links = Session(SESSION_BREADCRUMB);
        if (is_array($links)) {
            $this->SessionLinks = $links;
        }
    }

    // Load language phrase
    protected function languagePhrase($title, $table, $current)
    {
        global $Language;
        $wrktitle = ($title == $table) ? $Language->TablePhrase($title, "TblCaption") : $Language->phrase($title);
        if ($current) {
            $wrktitle = "<span id=\"ew-page-caption\">" . $wrktitle . "</span>";
        }
        return $wrktitle;
    }

    // Render
    public function render()
    {
        if (!$this->Visible || Config("PAGE_TITLE_STYLE") == "" || Config("PAGE_TITLE_STYLE") == "None") {
            return;
        }
        $nav = "<ol class=\"" . self::$CssClass . "\">";
        if (is_array($this->Links)) {
            $cnt = count($this->Links);
            if (Config("PAGE_TITLE_STYLE") == "Caption") {
                // Already shown in content header, just ignore
                //list($id, $title, $url, $cls, $table, $cur) = $this->Links[$cnt - 1];
                //echo "<div class=\"ew-page-title\">" . $this->LanguagePhrase($title, $table, $cur) . "</div>";
                return;
            } else {
                for ($i = 0; $i < $cnt; $i++) {
                    list($id, $title, $url, $cls, $table, $cur) = $this->Links[$i];
                    if ($i < $cnt - 1) {
                        $nav .= "<li class=\"breadcrumb-item\" id=\"ew-breadcrumb" . ($i + 1) . "\">";
                    } else { // Last => Current page
                        $nav .= "<li class=\"breadcrumb-item active\" id=\"ew-breadcrumb" . ($i + 1) . "\">";
                        $url = ""; // No need to show URL for current page
                    }
                    $text = $this->languagePhrase($title, $table, $cur);
                    $title = HtmlTitle($text);
                    if ($url != "") {
                        $nav .= "<a href=\"" . GetUrl($url) . "\"";
                        if ($title != "" && $title != $text) {
                            $nav .= " title=\"" . HtmlEncode($title) . "\"";
                        }
                        if ($cls != "") {
                            $nav .= " class=\"" . $cls . "\"";
                        }
                        $nav .= ">" . $text . "</a>";
                    } else {
                        $nav .= $text;
                    }
                    $nav .= "</li>";
                }
            }
        }
        $nav .= "</ol>";
        echo $nav;
    }
}
