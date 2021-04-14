<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Menu class
 */
class Menu
{
    public $Id;
    public $IsRoot;
    public $IsNavbar;
    public $Accordion = true; // For sidebar menu only
    public $UseSubmenu = false;
    public $Items = [];
    public $Level = 0;
    protected $NullItem = null;

    // Constructor
    public function __construct($id, $isRoot = false, $isNavbar = false)
    {
        $this->Id = $id;
        $this->IsRoot = $isRoot;
        $this->IsNavbar = $isNavbar;
        if ($isNavbar) {
            $this->UseSubmenu = true;
            $this->Accordion = false;
        }
    }

    // Add a menu item ($src for backward compatibility only)
    public function addMenuItem($id, $name, $text, $url, $parentId = -1, $src = "", $allowed = true, $isHeader = false, $isCustomUrl = false, $icon = "", $label = "", $isNavbarItem = false)
    {
        $item = new MenuItem($id, $name, $text, $url, $parentId, $allowed, $isHeader, $isCustomUrl, $icon, $label, $isNavbarItem);

        // MenuItem_Adding event
        if (function_exists(PROJECT_NAMESPACE . "MenuItem_Adding") && !MenuItem_Adding($item)) {
            return;
        }
        if ($item->ParentId < 0) {
            $this->addItem($item);
        } elseif ($parentMenu = &$this->findItem($item->ParentId)) {
            $parentMenu->addItem($item);
        }
    }

    // Add item to internal array
    public function addItem($item)
    {
        $item->Level = $this->Level;
        $this->Items[] = $item;
    }

    // Clear all menu items
    public function clear()
    {
        $this->Items = [];
    }

    // Find item
    public function &findItem($id)
    {
        $cnt = count($this->Items);
        for ($i = 0; $i < $cnt; $i++) {
            $item = &$this->Items[$i];
            if ($item->Id == $id) {
                return $item;
            } elseif ($item->SubMenu != null) {
                if ($subitem = &$item->SubMenu->findItem($id)) {
                    return $subitem;
                }
            }
        }
        $nullItem = $this->NullItem;
        return $nullItem;
    }

    // Find item by menu text
    public function &findItemByText($txt)
    {
        $cnt = count($this->Items);
        for ($i = 0; $i < $cnt; $i++) {
            $item = &$this->Items[$i];
            if ($item->Text == $txt) {
                return $item;
            } elseif ($item->SubMenu != null) {
                if ($subitem = &$item->SubMenu->findItemByText($txt)) {
                    return $subitem;
                }
            }
        }
        $nullItem = $this->NullItem;
        return $nullItem;
    }

    // Get menu item count
    public function count()
    {
        return count($this->Items);
    }

    // Move item to position
    public function moveItem($text, $pos)
    {
        $cnt = count($this->Items);
        if ($pos < 0) {
            $pos = 0;
        } elseif ($pos >= $cnt) {
            $pos = $cnt - 1;
        }
        $item = null;
        $cnt = count($this->Items);
        for ($i = 0; $i < $cnt; $i++) {
            if ($this->Items[$i]->Text == $text) {
                $item = $this->Items[$i];
                break;
            }
        }
        if ($item) {
            unset($this->Items[$i]);
            $this->Items = array_merge(
                array_slice($this->Items, 0, $pos),
                [$item],
                array_slice($this->Items, $pos)
            );
        }
    }

    // Check if a menu item should be shown
    public function renderItem($item)
    {
        if ($item->SubMenu != null) {
            foreach ($item->SubMenu->Items as $subitem) {
                if ($item->SubMenu->renderItem($subitem)) {
                    return true;
                }
            }
        }
        return ($item->Allowed && $item->Url != "");
    }

    // Check if a menu item should be opened
    public function isItemOpened($item)
    {
        if ($item->SubMenu != null) {
            foreach ($item->SubMenu->Items as $subitem) {
                if ($item->SubMenu->isItemOpened($subitem)) {
                    return true;
                }
            }
        }
        return $item->Active;
    }

    // Check if this menu should be rendered
    public function renderMenu()
    {
        foreach ($this->Items as $item) {
            if ($this->renderItem($item)) {
                return true;
            }
        }
        return false;
    }

    // Check if this menu should be opened
    public function isOpened()
    {
        foreach ($this->Items as $item) {
            if ($this->isItemOpened($item)) {
                return true;
            }
        }
        return false;
    }

    // Render the menu as array of object
    public function render()
    {
        if ($this->IsRoot && function_exists(PROJECT_NAMESPACE . "Menu_Rendering")) {
            Menu_Rendering($this);
        }
        if (!$this->renderMenu()) {
            return;
        }
        $menu = [];
        $url = CurrentUrl();
        $checkUrl = function ($item) use ($url) {
            if (!$item->IsCustomUrl && CurrentPageName() == GetPageName($item->Url) || $item->IsCustomUrl && $url == $item->Url) { // Active
                $item->Active = true;
                $item->Url = "#";
                $item->setAttribute("onclick", "return false;");
            } elseif ($item->SubMenu != null && $item->Url != "#" && $this->IsNavbar && $this->IsRoot) { // Navbar root menu item with submenu
                $item->Attrs["data-url"] = $item->Url;
                $item->Url = "#"; // Does not support URL for root menu item with submenu
                $item->setAttribute("onclick", "return false;");
            }
        };
        foreach ($this->Items as $item) {
            if ($this->renderItem($item)) {
                if ($item->IsHeader && (!$this->IsRoot || !$this->UseSubmenu)) { // Group title (Header)
                    $checkUrl($item);
                    $menu[] = $item->render(false);
                    if ($item->SubMenu != null) {
                        foreach ($item->SubMenu->Items as $subitem) {
                            if ($this->renderItem($subitem)) {
                                $checkUrl($subitem);
                                $menu[] = $subitem->render();
                            }
                        }
                    }
                } else {
                    $checkUrl($item);
                    $menu[] = $item->render();
                }
            }
        }
        if ($this->IsRoot && function_exists(PROJECT_NAMESPACE . "Menu_Rendered")) {
            Menu_Rendered($this);
        }
        return count($menu) ? $menu : null;
    }

    // Returns the menu as JSON
    public function toJson()
    {
        return JsonEncode(["items" => $this->render(), "accordion" => $this->Accordion]);
    }

    // Returns the menu as script tag
    public function toScript()
    {
        return <<<EOT
<script>
ew.vars.{$this->Id} = {$this->toJson()};
</script>
EOT;
    }
}
