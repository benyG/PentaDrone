<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Sub pages class
 */
class SubPages implements \ArrayAccess
{
    public $Justified = false;
    public $Fill = false;
    public $Vertical = false;
    public $Align = "left"; // "left" or "center" or "right"
    public $Style = ""; // "tabs" or "pills" or "" (accordion)
    public $Classes = ""; // Other CSS classes
    public $Parent = false; // For accordion only, if a selector is provided, then all collapsible elements under the specified parent will be closed when a collapsible item is shown.
    public $Items = [];
    public $ValidKeys = null;
    public $ActiveIndex = null;

    // Implements offsetSet
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->Items[] = &$value;
        } else {
            $this->Items[$offset] = &$value;
        }
    }

    // Implements offsetExists
    public function offsetExists($offset)
    {
        return isset($this->Items[$offset]);
    }

    // Implements offsetUnset
    public function offsetUnset($offset)
    {
        unset($this->Items[$offset]);
    }

    // Implements offsetGet
    public function &offsetGet($offset)
    {
        $item = $this->Items[$offset] ?? null;
        return $item;
    }

    // Get nav classes
    public function navStyle()
    {
        $style = "";
        if ($this->Style) {
            $style .= "nav nav-" . $this->Style;
        }
        if ($this->Justified) {
            $style .= " nav-justified";
        }
        if ($this->Fill) {
            $style .= " nav-fill";
        }
        if (SameText($this->Align, "center")) {
            $style .= " justify-content-center";
        } elseif (SameText($this->Align, "right")) {
            $style .= " justify-content-end";
        }
        if ($this->Vertical) {
            $style .= " flex-column";
        }
        if ($this->Classes) {
            $style .= " " . $this->Classes;
        }
        return $style;
    }

    // Check if a page is active
    public function isActive($k)
    {
        return ($this->activePageIndex() == $k);
    }

    // Get page classes
    public function pageStyle($k)
    {
        if ($this->isActive($k)) { // Active page
            if ($this->Style != "") { // "tabs" or "pills"
                return " active show";
            } else { // accordion
                return " show"; // .collapse does not use .active
            }
        }
        $item = &$this->getItem($k);
        if ($item) { // "tabs" or "pills"
            if (!$item->Visible) {
                return " d-none ew-hidden";
            } elseif ($item->Disabled) {
                return " disabled ew-disabled";
            }
        }
        return "";
    }

    // Get count
    public function count()
    {
        return count($this->Items);
    }

    // Add item by name
    public function &add($name = "")
    {
        $item = new SubPage();
        if (strval($name) != "") {
            $this->Items[$name] = $item;
        }
        if (!is_int($name)) {
            $this->Items[] = $item;
        }
        return $item;
    }

    // Get item by key
    public function &getItem($k)
    {
        $item = $this->Items[$k] ?? null;
        return $item;
    }

    // Active page index
    public function activePageIndex()
    {
        if ($this->ActiveIndex !== null) {
            return $this->ActiveIndex;
        }

        // Return first active page
        foreach ($this->Items as $key => $item) {
            if ((!is_array($this->ValidKeys) || in_array($key, $this->ValidKeys)) && $item->Visible && !$item->Disabled && $item->Active && $key !== 0) { // Not common page
                $this->ActiveIndex = $key;
                return $this->ActiveIndex;
            }
        }

        // If not found, return first visible page
        foreach ($this->Items as $key => $item) {
            if ((!is_array($this->ValidKeys) || in_array($key, $this->ValidKeys)) && $item->Visible && !$item->Disabled && $key !== 0) { // Not common page
                $this->ActiveIndex = $key;
                return $this->ActiveIndex;
            }
        }

        // Not found
        return null;
    }
}
