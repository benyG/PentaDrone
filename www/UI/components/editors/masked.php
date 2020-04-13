<?php

include_once dirname(__FILE__) . '/' . 'custom.php';
include_once dirname(__FILE__) . '/' . '../utils/array_wrapper.php';

class MaskedEdit extends CustomEditor {
    private $value;
    private $mask;
    private $hint;

    /**
     * @param string $name
     * @param string $mask see http://digitalbush.com/projects/masked-input-plugin/ for details
     * @param string $hint
     */
    public function __construct($name, $mask, $hint = '') {
        parent::__construct($name, null);
        $this->mask = $mask;
        $this->hint = $hint;
    }

    public function GetValue() {
        return $this->value;
    }

    public function SetValue($value) {
        $this->value = $value;
    }

    public function extractValueFromArray(ArrayWrapper $arrayWrapper, &$valueChanged) {
        if ($arrayWrapper->IsValueSet($this->GetName())) {
            $valueChanged = true;
            return $arrayWrapper->GetValue($this->GetName());
        } else {
            $valueChanged = false;
            return null;
        }
    }

    public function GetMask() {
        return $this->mask;
    }

    public function GetHint() {
        return $this->hint;
    }

    /**
     * @return string
     */
    public function getEditorName()
    {
        return 'masked';
    }
}