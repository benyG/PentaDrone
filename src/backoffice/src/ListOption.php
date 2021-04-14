<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * List option class
 */
class ListOption
{
    public $Name;
    public $OnLeft;
    public $CssStyle;
    public $CssClass;
    public $Visible = true;
    public $Header;
    public $Body;
    public $Footer;
    public $Parent;
    public $ShowInButtonGroup = true;
    public $ShowInDropDown = true;
    public $ButtonGroupName = "_default";

    // Constructor
    public function __construct($name)
    {
        $this->Name = $name;
    }

    // Add a link
    public function addLink($attrs, $phraseId)
    {
        $this->Body .= GetLinkHtml($attrs, $phraseId);
    }

    // Clear
    public function clear()
    {
        $this->Body = "";
    }

    // Move to
    public function moveTo($pos)
    {
        $this->Parent->moveItem($this->Name, $pos);
    }

    // Render
    public function render($part, $colSpan = 1)
    {
        $tagclass = $this->Parent->TagClassName;
        $isTableCell = SameText($this->Parent->Tag, "td");
        if ($part == "header") {
            if ($tagclass == "") {
                $tagclass = "ew-list-option-header";
            }
            $value = $this->Header;
        } elseif ($part == "body") {
            if ($tagclass == "") {
                $tagclass = "ew-list-option-body";
            }
            if (!$isTableCell) {
                AppendClass($tagclass, "ew-list-option-separator");
            }
            $value = $this->Body;
        } elseif ($part == "footer") {
            if ($tagclass == "") {
                $tagclass = "ew-list-option-footer";
            }
            $value = $this->Footer;
        } else {
            $value = $part;
        }
        if (strval($value) == "" && $this->Parent->Tag == $this->Parent->InlineTag && $this->Parent->ScriptId == "") { // Skip for multi-column inline tag
            return "";
        }
        $res = ($value != "") ? $value : "&nbsp;";
        $attrs = new Attributes(["class" => $tagclass, "style" => $this->CssStyle, "data-name" => $this->Name]);
        $attrs->appendClass($this->CssClass);
        if ($isTableCell && $this->Parent->RowSpan > 1) {
            $attrs["rowspan"] = $this->Parent->RowSpan;
        }
        if ($isTableCell && $colSpan > 1) {
            $attrs["colspan"] = $colSpan;
        }
        $name = $this->Parent->TableVar . "_" . $this->Name;
        if ($this->Name != $this->Parent->GroupOptionName) {
            if (!in_array($this->Name, ["checkbox", "rowcnt"])) {
                if ($this->Parent->UseButtonGroup && $this->ShowInButtonGroup) {
                    $res = $this->Parent->renderButtonGroup($res);
                    if ($this->OnLeft && $isTableCell && $colSpan > 1) {
                        $res = '<div class="text-right">' . $res . '</div>';
                    }
                }
            }
            if ($part == "header") {
                $res = '<span id="elh_' . $name . '" class="' . $name . '">' . $res . '</span>';
            } elseif ($part == "body") {
                $res = '<span id="el' . $this->Parent->RowCnt . '_' . $name . '" class="' . $name . '">' . $res . '</span>';
            } elseif ($part == "footer") {
                $res = '<span id="elf_' . $name . '" class="' . $name . '">' . $res . '</span>';
            }
        }
        $tag = ($isTableCell && $part == "header") ? "th" : $this->Parent->Tag;
        if ($this->Parent->UseButtonGroup && $this->ShowInButtonGroup) {
            $attrs->appendClass("text-nowrap");
        }
        $res = $tag ? HtmlElement($tag, $attrs, $res) : $res;
        if ($this->Parent->ScriptId != "" && $this->Parent->ScriptType == "single") {
            if ($part == "header") {
                $res = '<template id="tpoh_' . $this->Parent->ScriptId . '_' . $this->Name . '">' . $res . '</template>';
            } elseif ($part == 'body') {
                $res = '<template id="tpob' . $this->Parent->RowCnt . '_' . $this->Parent->ScriptId . '_' . $this->Name . '">' . $res . '</template>';
            } elseif ($part == 'footer') {
                $res = '<template id="tpof_' . $this->Parent->ScriptId . '_' . $this->Name . '">' . $res . '</template>';
            }
        }
        return $res;
    }
}
