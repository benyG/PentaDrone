<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * List option collection class
 */
class ListOptions implements \ArrayAccess
{
    public $Items = [];
    public $CustomItem = "";
    public $Tag;
    public $BlockTag = "td"; // Block
    public $InlineTag = "span"; // Inline
    public $TagClassName = "";
    public $TableVar = "";
    public $RowCnt = "";
    public $ScriptType = "block";
    public $ScriptId = "";
    public $ScriptClassName = "";
    public $RowSpan = 1;
    public $UseDropDownButton = false;
    public $UseButtonGroup = false;
    public $ButtonClass = "";
    public $GroupOptionName = "button";
    public $DropDownButtonPhrase = "";

    // Constructor
    public function __construct($blockTag = "")
    {
        if ($blockTag) {
            $this->BlockTag = $blockTag;
        }
    }

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

    // Check visible
    public function visible()
    {
        foreach ($this->Items as $item) {
            if ($item->Visible) {
                return true;
            }
        }
        return false;
    }

    // Check group option visible
    public function groupOptionVisible()
    {
        $cnt = 0;
        foreach ($this->Items as $item) {
            if (
                $item->Name != $this->GroupOptionName &&
                ($item->Visible && $item->ShowInDropDown && $this->UseDropDownButton ||
                $item->Visible && $item->ShowInButtonGroup && $this->UseButtonGroup)
            ) {
                $cnt += 1;
                if ($this->UseDropDownButton && $cnt > 1) {
                    return true;
                } elseif ($this->UseButtonGroup) {
                    return true;
                }
            }
        }
        return false;
    }

    // Add and return a new option
    public function &add($name)
    {
        $item = new ListOption($name);
        $item->Parent = &$this;
        $this->Items[$name] = $item;
        return $item;
    }

    // Load default settings
    public function loadDefault()
    {
        $this->CustomItem = "";
        foreach ($this->Items as $key => $item) {
            $this->Items[$key]->Body = "";
        }
    }

    // Hide all options
    public function hideAllOptions($lists = [])
    {
        foreach ($this->Items as $key => $item) {
            if (!in_array($key, $lists)) {
                $this->Items[$key]->Visible = false;
            }
        }
    }

    // Show all options
    public function showAllOptions()
    {
        foreach ($this->Items as $key => $item) {
            $this->Items[$key]->Visible = true;
        }
    }

    /**
     * Get item by name (same as offsetGet)
     *
     * @param string $name Predefined names: view/edit/copy/delete/detail_<DetailTable>/userpermission/checkbox
     * @return void
     */
    public function &getItem($name)
    {
        $item = $this->Items[$name] ?? null;
        return $item;
    }

    // Get item position
    public function itemPos($name)
    {
        $pos = 0;
        foreach ($this->Items as $item) {
            if ($item->Name == $name) {
                return $pos;
            }
            $pos++;
        }
        return false;
    }

    // Move item to position
    public function moveItem($name, $pos)
    {
        $cnt = count($this->Items);
        if ($pos < 0) { // If negative, count from the end
            $pos = $cnt + $pos;
        }
        if ($pos < 0) {
            $pos = 0;
        }
        if ($pos >= $cnt) {
            $pos = $cnt - 1;
        }
        $item = &$this->getItem($name);
        if ($item) {
            unset($this->Items[$name]);
            $this->Items = array_merge(
                array_slice($this->Items, 0, $pos),
                [$name => $item],
                array_slice($this->Items, $pos)
            );
        }
    }

    // Render list options
    public function render($part, $pos = "", $rowCnt = "", $scriptType = "block", $scriptId = "", $scriptClassName = "")
    {
        if ($this->CustomItem == "" && $groupitem = &$this->getItem($this->GroupOptionName) && $this->showPos($groupitem->OnLeft, $pos)) {
            if ($this->UseDropDownButton) { // Render dropdown
                $buttonValue = "";
                $cnt = 0;
                foreach ($this->Items as $item) {
                    if ($item->Name != $this->GroupOptionName && $item->Visible) {
                        if ($item->ShowInDropDown) {
                            $buttonValue .= $item->Body;
                            $cnt += 1;
                        } elseif ($item->Name == "listactions") { // Show listactions as button group
                            $item->Body = $this->renderButtonGroup($item->Body);
                        }
                    }
                }
                if ($cnt < 1 || $cnt == 1 && !ContainsString($buttonValue, "dropdown-menu")) { // No item to show in dropdown or only one item without dropdown menu
                    $this->UseDropDownButton = false; // No need to use drop down button
                } else {
                    $groupitem->Body = $this->renderDropDownButton($buttonValue, $pos);
                    $groupitem->Visible = true;
                }
            }
            if (!$this->UseDropDownButton && $this->UseButtonGroup) { // Render button group
                $visible = false;
                $buttongroups = [];
                foreach ($this->Items as $item) {
                    if ($item->Name != $this->GroupOptionName && $item->Visible && $item->Body != "") {
                        if ($item->ShowInButtonGroup) {
                            $visible = true;
                            $buttonValue = $item->Body;
                            if (!array_key_exists($item->ButtonGroupName, $buttongroups)) {
                                $buttongroups[$item->ButtonGroupName] = "";
                            }
                            $buttongroups[$item->ButtonGroupName] .= $buttonValue;
                        } elseif ($item->Name == "listactions") { // Show listactions as button group
                            $item->Body = $this->renderButtonGroup($item->Body);
                        }
                    }
                }
                $groupitem->Body = "";
                foreach ($buttongroups as $buttongroup => $buttonValue) {
                    $groupitem->Body .= $this->renderButtonGroup($buttonValue);
                }
                if ($visible) {
                    $groupitem->Visible = true;
                }
            }
        }
        if ($scriptId != "") {
            if ($pos == "right" || $pos == "bottom") { // Show all options script tags on the right/bottom (ignore left to avoid duplicate)
                echo $this->write($part, "", $rowCnt, "block", $scriptId, $scriptClassName) .
                    $this->write($part, "", $rowCnt, "inline", $scriptId) .
                    $this->write($part, "", $rowCnt, "single", $scriptId);
            }
        } else {
            echo $this->write($part, $pos, $rowCnt, $scriptType, $scriptId, $scriptClassName);
        }
    }

    // Get custom template script tag
    protected function customScriptTag($scriptId, $scriptType, $scriptClass, $rowCnt = "")
    {
        $id = "_" . $scriptId;
        if (!EmptyString($rowCnt)) {
            $id = $rowCnt . $id;
        }
        $id = "tp" . $scriptType . $id;
        return "<template id=\"" . $id . "\"" . (!EmptyString($scriptClass) ? " class=\"" . $scriptClass . "\"" : "") . ">";
    }

    // Write list options
    protected function write($part, $pos = "", $rowCnt = "", $scriptType = "block", $scriptId = "", $scriptClass = "")
    {
        $this->RowCnt = $rowCnt;
        $this->ScriptType = $scriptType;
        $this->ScriptId = $scriptId;
        $this->ScriptClassName = $scriptClass;
        $res = "";
        if ($scriptId != "") {
            $this->Tag = ($scriptType == "block") ? $this->BlockTag : $this->InlineTag;
            if ($scriptType == "block") {
                if ($part == "header") {
                    $res .= $this->customScriptTag($scriptId, "oh", $scriptClass);
                } elseif ($part == "body") {
                    $res .= $this->customScriptTag($scriptId, "ob", $scriptClass, $rowCnt);
                } elseif ($part == "footer") {
                    $res .= $this->customScriptTag($scriptId, "of", $scriptClass);
                }
            } elseif ($scriptType == "inline") {
                if ($part == "header") {
                    $res .= $this->customScriptTag($scriptId, "o2h", $scriptClass);
                } elseif ($part == "body") {
                    $res .= $this->customScriptTag($scriptId, "o2b", $scriptClass, $rowCnt);
                } elseif ($part == "footer") {
                    $res .= $this->customScriptTag($scriptId, "o2f", $scriptClass);
                }
                //$res .= $this->InlineTag ? "<" . $this->InlineTag . ">" : "";
            }
        } else {
            $this->Tag = ($pos != "" && $pos != "bottom" && $scriptType == "block") ? $this->BlockTag : $this->InlineTag; // Use inline tag for multi-column
        }
        if ($this->CustomItem != "") {
            $cnt = 0;
            $opt = null;
            foreach ($this->Items as $item) {
                if ($this->showItem($item, $scriptId, $pos)) {
                    $cnt++;
                }
                if ($item->Name == $this->CustomItem) {
                    $opt = $item;
                }
            }
            $useButtonGroup = $this->UseButtonGroup; // Backup options
            $this->UseButtonGroup = true; // Show button group for custom item
            if (is_object($opt) && $cnt > 0) {
                if ($scriptId != "" || $this->showPos($opt->OnLeft, $pos)) {
                    $res .= $opt->render($part, $cnt);
                } else {
                    $res .= $opt->render("", $cnt);
                }
            }
            $this->UseButtonGroup = $useButtonGroup; // Restore options
        } else {
            foreach ($this->Items as $item) {
                if ($this->showItem($item, $scriptId, $pos)) {
                    $res .= $item->render($part, 1);
                }
            }
        }
        if (in_array($scriptType, ["block", "inline"]) && $scriptId != "") {
            $res .= "</template>"; // End <template id="...">
        }
        return $res;
    }

    // Show item
    protected function showItem($item, $scriptId, $pos)
    {
        $show = $item->Visible && $this->showPos($item->OnLeft, $pos);
        if ($show) {
            if ($this->UseDropDownButton) {
                $show = ($item->Name == $this->GroupOptionName || !$item->ShowInDropDown);
            } elseif ($this->UseButtonGroup) {
                $show = ($item->Name == $this->GroupOptionName || !$item->ShowInButtonGroup);
            }
        }
        return $show;
    }

    // Show position
    protected function showPos($onLeft, $pos)
    {
        return $onLeft && $pos == "left" || !$onLeft && $pos == "right" || $pos == "" || $pos == "bottom";
    }

    /**
     * Concat options and return concatenated HTML
     *
     * @param string $pattern Regular expression pattern for matching the option names, e.g. '/^detail_/'
     * @param string $separator optional Separator
     * @return string
     */
    public function concat($pattern, $separator = "")
    {
        $ar = [];
        $keys = array_keys($this->Items);
        foreach ($keys as $key) {
            if (preg_match($pattern, $key) && trim($this->Items[$key]->Body) != "") {
                $ar[] = $this->Items[$key]->Body;
            }
        }
        return implode($separator, $ar);
    }

    /**
     * Merge options to the first option and return it
     *
     * @param string $pattern Regular expression pattern for matching the option names, e.g. '/^detail_/'
     * @param string $separator optional Separator
     * @return string
     */
    public function merge($pattern, $separator = "")
    {
        $keys = array_keys($this->Items);
        $first = null;
        foreach ($keys as $key) {
            if (preg_match($pattern, $key)) {
                if (!$first) {
                    $first = $this->Items[$key];
                    $first->Body = $this->concat($pattern, $separator);
                } else {
                    $this->Items[$key]->Visible = false;
                }
            }
        }
        return $first;
    }

    // Get button group link
    public function renderButtonGroup($body)
    {
        // Get all hidden inputs <input type="hidden" ...>
        $inputs = [];
        if (preg_match_all('/<input\s+([^>]*)>/i', $body, $inputmatches, PREG_SET_ORDER)) {
            foreach ($inputmatches as $inputmatch) {
                $body = str_replace($inputmatch[0], '', $body);
                if (preg_match('/\s+type\s*=\s*[\'"]hidden[\'"]/i', $inputmatch[0])) { // Match type='hidden'
                    $inputs[] = $inputmatch[0];
                }
            }
        }
        // Get all buttons <div class="btn-group ...">...</div>
        $btns = [];
        if (preg_match_all('/<div\s+class\s*=\s*[\'"]btn-group([^\'"]*)[\'"]([^>]*)>([\s\S]*?)<\/div\s*>/i', $body, $btnmatches, PREG_SET_ORDER)) {
            foreach ($btnmatches as $btnmatch) {
                $body = str_replace($btnmatch[0], '', $body);
                $btns[] = $btnmatch[0];
            }
        }
        $links = '';
        // Get all links/buttons <a ...>...</a> and <button ...>...</button>
        if (preg_match_all('/<(a|button)([^>]*)>([\s\S]*?)<\/(a|button)\s*>/i', $body, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $tag = $match[1];
                if (preg_match('/\s+class\s*=\s*[\'"]([\s\S]*?)[\'"]/i', $match[2], $submatches)) { // Match class='class'
                    $class = $submatches[1];
                    $attrs = str_replace($submatches[0], '', $match[2]);
                } else {
                    $class = '';
                    $attrs = $match[2];
                }
                $caption = $match[3];
                PrependClass($class, 'btn btn-default'); // Prepend button classes
                if ($this->ButtonClass != "") {
                    AppendClass($class, $this->ButtonClass);
                }
                $attrs = ' class="' . $class . '" ' . $attrs;
                $link = '<' . $tag . $attrs . '>' . $caption . '</' . $tag . '>';
                $links .= $link;
            }
        }
        if ($links != "") {
            $btngroup = '<div class="btn-group btn-group-sm ew-btn-group">' . $links . '</div>';
        } else {
            $btngroup = "";
        }
        foreach ($btns as $btn) {
            $btngroup .= $btn;
        }
        foreach ($inputs as $input) {
            $btngroup .= $input;
        }
        return $btngroup;
    }

    // Render drop down button
    public function renderDropDownButton($body, $pos)
    {
        // Get all hidden inputs <input type="hidden" ...>
        $inputs = [];
        if (preg_match_all('/<input\s+([^>]*)>/i', $body, $inputmatches, PREG_SET_ORDER)) {
            foreach ($inputmatches as $inputmatch) {
                $body = str_replace($inputmatch[0], '', $body);
                if (preg_match('/\s+type\s*=\s*[\'"]hidden[\'"]/i', $inputmatch[0])) { // Match type='hidden'
                    $inputs[] = $inputmatch[0];
                }
            }
        }

        // Remove all <div class="d-none ew-preview">...</div>
        $previewlinks = "";
        if (preg_match_all('/<div\s+class\s*=\s*[\'"]d-none\s+ew-preview[\'"]>([\s\S]*?)(<div([^>]*)>([\s\S]*?)<\/div\s*>)+([\s\S]*?)<\/div\s*>/i', $body, $inputmatches, PREG_SET_ORDER)) {
            foreach ($inputmatches as $inputmatch) {
                $body = str_replace($inputmatch[0], '', $body);
                $previewlinks .= $inputmatch[0];
            }
        }

        // Remove toggle button first <button ... data-toggle="dropdown">...</button>
        if (preg_match_all('/<button\s+([\s\S]*?)data-toggle\s*=\s*[\'"]dropdown[\'"]\s*>([\s\S]*?)<\/button\s*>/i', $body, $btnmatches, PREG_SET_ORDER)) {
            foreach ($btnmatches as $btnmatch) {
                $body = str_replace($btnmatch[0], '', $body);
            }
        }

        // Get all links/buttons <a ...>...</a> and <button ...>...</button>
        if (!preg_match_all('/<(a|button)([^>]*)>([\s\S]*?)<\/(a|button)\s*>/i', $body, $matches, PREG_SET_ORDER)) {
            return '';
        }
        $links = '';
        $submenu = false;
        $submenulink = "";
        $submenulinks = "";
        foreach ($matches as $match) {
            $tag = $match[1];
            if (preg_match('/\s+data-action\s*=\s*[\'"]([\s\S]*?)[\'"]/i', $match[2], $submatches)) { // Match data-action='action'
                $action = $submatches[1];
            } else {
                $action = '';
            }
            if (preg_match('/\s+class\s*=\s*[\'"]([\s\S]*?)[\'"]/i', $match[2], $submatches)) { // Match class='class'
                $classes = preg_replace('/btn[\S]*\s+/i', '', $submatches[1]);
                $attrs = str_replace($submatches[0], '', $match[2]);
            } else {
                $classes = '';
                $attrs = $match[2];
            }
            $attrs = preg_replace('/\s+title\s*=\s*[\'"]([\s\S]*?)[\'"]/i', '', $attrs); // Remove title='title'
            if (preg_match('/\s+data-caption\s*=\s*[\'"]([\s\S]*?)[\'"]/i', $attrs, $submatches)) { // Match data-caption='caption'
                $caption = $submatches[1];
            } else {
                $caption = '';
            }
            AppendClass($classes, "dropdown-item");
            $attrs = ' class="' . $classes . '" ' . $attrs;
            if (SameText($tag, "a")) { // Add href for <a>
                $attrs .= ' href="#"';
            }
            if (
                $caption != '' && // Has caption
                preg_match('/<i([^>]*)>([\s\S]*?)<\/i\s*>/i', $match[3], $submatches) && // Inner HTML contains <i> tag
                preg_match('/\s+class\s*=\s*[\'"]([\s\S]*?)[\'"]/i', $submatches[1], $subsubmatches) && // The <i> tag has 'class' attribute
                preg_match('/\bew-icon\b/', $subsubmatches[1])
            ) { // The classes contains 'ew-icon' => icon
                $classes = $subsubmatches[1];
                AppendClass($classes, 'mr-2'); // Add margin-right
                $caption = str_replace($subsubmatches[1], $classes, $submatches[0]) . $caption;
            }
            if ($caption == '') {
                $caption = $match[3];
            }
            $link = '<a' . $attrs . '>' . $caption . '</a>';
            if ($action == 'list') { // Start new submenu
                if ($submenu) { // End previous submenu
                    if ($submenulinks != '') { // Set up submenu
                        $links .= '<li class="dropdown-submenu dropdown-hover">' . $submenulink . '<ul class="dropdown-menu">' . $submenulinks . '</ul></li>';
                    } else {
                        $links .= '<li>' . $submenulink . '</li>';
                    }
                }
                $submenu = true;
                $submenulink = str_replace("dropdown-item", "dropdown-item dropdown-toggle", $link);
                $submenulinks = "";
            } else {
                if ($action == '' && $submenu) { // End previous submenu
                    if ($submenulinks != '') { // Set up submenu
                        $links .= '<li class="dropdown-submenu dropdown-hover">' . $submenulink . '<ul class="dropdown-menu">' . $submenulinks . '</ul></li>';
                    } else {
                        $links .= '<li>' . $submenulink . '</li>';
                    }
                    $submenu = false;
                }
                if ($submenu) {
                    $submenulinks .= '<li>' . $link . '</li>';
                } else {
                    $links .= '<li>' . $link . '</li>';
                }
            }
        }
        if ($links != "") {
            if ($submenu) { // End previous submenu
                if ($submenulinks != '') { // Set up submenu
                    $links .= '<li class="dropdown-submenu dropdown-hover">' . $submenulink . '<ul class="dropdown-menu">' . $submenulinks . '</ul></li>';
                } else {
                    $links .= '<li>' . $submenulink . '</li>';
                }
            }
            $buttonclass = "dropdown-toggle btn btn-default";
            if ($this->ButtonClass != "") {
                AppendClass($buttonclass, $this->ButtonClass);
            }
            $buttontitle = HtmlTitle($this->DropDownButtonPhrase);
            $buttontitle = ($this->DropDownButtonPhrase != $buttontitle) ? ' title="' . $buttontitle . '"' : '';
            $button = '<button class="' . $buttonclass . '"' . $buttontitle . ' data-toggle="dropdown">' . $this->DropDownButtonPhrase . '</button>' .
                '<ul class="dropdown-menu ' . (($pos == 'right') ? 'dropdown-menu-right ' : '') . 'ew-menu">' . $links . '</ul>';
            if ($pos == "bottom") { // Use dropup
                $btndropdown = '<div class="btn-group btn-group-sm dropup ew-btn-dropdown">' . $button . '</div>';
            } else {
                $btndropdown = '<div class="btn-group btn-group-sm ew-btn-dropdown">' . $button . '</div>';
            }
        } else {
            $btndropdown = "";
        }
        foreach ($inputs as $input) {
            $btndropdown .= $input;
        }
        $btndropdown .= $previewlinks;
        return $btndropdown;
    }

    // Hide detail items for dropdown
    public function hideDetailItemsForDropDown()
    {
        $showdtl = false;
        if ($this->UseDropDownButton) {
            foreach ($this->Items as $item) {
                if ($item->Name != $this->GroupOptionName && $item->Visible && $item->ShowInDropDown && !StartsString("detail_", $item->Name)) {
                    $showdtl = true;
                    break;
                }
            }
        }
        if (!$showdtl) {
            foreach ($this->Items as $item) {
                if (StartsString("detail_", $item->Name)) {
                    $item->Visible = false;
                }
            }
        }
    }
}
