<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Attributes class
 */
class Attributes implements \ArrayAccess, \IteratorAggregate
{
    private $container;

    // Constructor
    public function __construct(array $attrs = [])
    {
        $this->container = $attrs;
    }

    // offsetSet
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    // offsetExists
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    // offsetUnset
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    // offsetGet
    public function offsetGet($offset)
    {
        return $this->container[$offset] ?? ""; // No undefined index
    }

    // getIterator
    public function getIterator()
    {
        return new \ArrayIterator($this->container);
    }

    // Append class
    public function appendClass($value)
    {
        $cls = $this->offsetGet("class");
        AppendClass($cls, $value);
        $this->container["class"] = trim($cls);
        return $this->container["class"];
    }

    // Prepend class
    public function prependClass($value)
    {
        $cls = $this->offsetGet("class");
        PrependClass($cls, $value);
        $this->container["class"] = trim($cls);
        return $this->container["class"];
    }

    // Remove class
    public function removeClass($value)
    {
        $cls = $this->offsetGet("class");
        RemoveClass($cls, $value);
        $this->container["class"] = trim($cls);
        return $this->container["class"];
    }

    // Append
    public function append($offset, $value, $sep = "")
    {
        if (SameText($offset, "class")) {
            return $this->appendClass($value);
        }
        $ar = array_filter([$this->offsetGet($offset), $value]);
        $this->container[$offset] = implode($sep, $ar);
        return $this->container[$offset];
    }

    // Prepend
    public function prepend($offset, $value, $sep = "")
    {
        if (SameText($offset, "class")) {
            return $this->prependClass($value);
        }
        $ar = array_filter([$value, $this->offsetGet($offset)]);
        $this->container[$offset] = implode($sep, $ar);
        return $this->container[$offset];
    }

    // Merge attributes
    public function merge($attrs)
    {
        if ($attrs instanceof Attributes) {
            $attrs = $attrs->toArray();
        }
        if (is_array($attrs)) {
            $this->container = array_merge($this->container, $attrs); // Overwrite
        }
    }

    // To array
    public function toArray()
    {
        return $this->container;
    }

    /**
     * To string
     *
     * @param array $exclude Keys to exclude
     * @return string
     */
    public function toString($exclude = [])
    {
        $att = "";
        foreach ($this->container as $k => $v) {
            $key = trim($k);
            if (in_array($key, $exclude)) {
                continue;
            }
            $value = trim($v);
            if (IsBooleanAttribute($key) && $value !== false) { // Allow boolean attributes, e.g. "disabled"
                $att .= ' ' . $key . (($value != "" && $value !== true) ? '="' . $value . '"' : '');
            } elseif ($key != "" && $value != "") {
                $att .= ' ' . $key . '="' . $value . '"';
            } elseif ($key == "alt" && $value == "") { // Allow alt="" since it is a required attribute
                $att .= ' alt=""';
            }
        }
        return $att;
    }
}
