<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * List actions class
 */
class ListActions implements \ArrayAccess
{
    public $Items = [];

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

    // Add and return a new option
    public function &add($name, $action, $allow = true, $method = ACTION_POSTBACK, $select = ACTION_MULTIPLE, $confirmMsg = "", $icon = "fas fa-star ew-icon", $success = "")
    {
        if (is_string($action)) {
            $item = new ListAction($name, $action, $allow, $method, $select, $confirmMsg, $icon, $success);
        } elseif ($action instanceof ListAction) {
            $item = $action;
        }
        $this->Items[$name] = $item;
        return $item;
    }

    // Get item by name (same as offsetGet)
    public function &getItem($name)
    {
        $item = $this->Items[$name] ?? null;
        return $item;
    }
}
