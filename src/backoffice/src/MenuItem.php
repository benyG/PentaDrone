<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Menu item class
 */
class MenuItem
{
    public $Id = "";
    public $Name = "";
    public $Text = "";
    public $Url = "";
    public $ParentId = -1;
    public $SubMenu = null; // Data type = Menu
    public $Allowed = true;
    public $Target = "";
    public $IsHeader = false;
    public $IsCustomUrl = false;
    public $Href = ""; // Href attribute
    public $Active = false;
    public $Icon = "";
    public $Attrs; // HTML attributes
    public $Label = ""; // HTML (for vertical menu only)
    public $IsNavbarItem = "";
    public $Level = 0;

    // Constructor
    public function __construct($id, $name, $text, $url, $parentId = -1, $allowed = true, $isHeader = false, $isCustomUrl = false, $icon = "", $label = "", $isNavbarItem = false)
    {
        $this->Id = $id;
        $this->Name = $name;
        $this->Text = $text;
        $this->Url = $url;
        $this->ParentId = $parentId;
        $this->Allowed = $allowed;
        $this->IsHeader = $isHeader;
        $this->IsCustomUrl = $isCustomUrl;
        $this->Icon = $icon;
        $this->Label = $label;
        $this->IsNavbarItem = $isNavbarItem;
        $this->Attrs = new Attributes();
    }

    // Set property case-insensitively (for backward compatibility) // PHP
    public function __set($name, $value)
    {
        $vars = get_class_vars(get_class($this));
        foreach ($vars as $key => $val) {
            if (SameText($name, $key)) {
                $this->$key = $value;
                break;
            }
        }
    }

    // Get property case-insensitively (for backward compatibility) // PHP
    public function __get($name)
    {
        $vars = get_class_vars(get_class($this));
        foreach ($vars as $key => $val) {
            if (SameText($name, $key)) {
                return $this->$key;
                break;
            }
        }
        return null;
    }

    // Add submenu item
    public function addItem($item)
    {
        if ($this->SubMenu === null) {
            $this->SubMenu = new Menu($this->Id);
        }
        $this->SubMenu->Level = $this->Level + 1;
        $this->SubMenu->addItem($item);
    }

    // Set attribute
    public function setAttribute($name, $value)
    {
        if (is_string($this->Attrs) && !preg_match('/\b' . preg_quote($name, '/') . '\s*=/', $this->Attrs)) { // Only set if attribute does not already exist
            $this->Attrs .= ' ' . $name . '="' . $value . '"';
        } elseif ($this->Attrs instanceof Attributes) {
            if (StartsText("on", $name)) { // Events
                $this->Attrs->append($name, $value, ";");
            } elseif (SameText("class", $name)) { // Class
                $this->Attrs->appendClass($value);
            } else {
                $this->Attrs->append($name, $value);
            }
        }
    }

    // Render
    public function render($deep = true)
    {
        $url = GetUrl($this->Url);
        if (IsMobile() && !$this->IsCustomUrl && $url != "#") {
            $url = str_replace("#", (ContainsString($url, "?") ? "&" : "?") . "hash=", $url);
        }
        if ($url == "") {
            $url = "#";
            $this->setAttribute("onclick", "return false;");
        }
        $attrs = is_string($this->Attrs) ? $this->Attrs : $this->Attrs->toString();
        $class = trim($this->Icon);
        if ($class) {
            $ar = explode(" ", $class);
            foreach ($ar as $name) {
                if (
                    StartsString("fa-", $name) &&
                    !in_array("fa", $ar) &&
                    !in_array("fas", $ar) &&
                    !in_array("fab", $ar) &&
                    !in_array("far", $ar) &&
                    !in_array("fal", $ar)
                ) {
                    $ar[] = "fas";
                    break;
                }
            }
            $class = implode(" ", $ar);
        }
        return [
            "id" => $this->Id,
            "name" => $this->Name,
            "text" => $this->Text,
            "parentId" => $this->ParentId,
            "level" => $this->Level,
            "href" => $url,
            "attrs" => $attrs,
            "target" => $this->Target,
            "isHeader" => $this->IsHeader,
            "active" => $this->Active,
            "icon" => $class,
            "label" => $this->Label,
            "isNavbarItem" => $this->IsNavbarItem,
            "items" => ($deep && $this->SubMenu !== null) ? $this->SubMenu->render() : null,
            "open" => ($deep && $this->Submenu !== null) ? $this->SubMenu->isOpened() : false
        ];
    }
}
