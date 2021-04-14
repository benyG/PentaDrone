<?php

namespace PHPMaker2021\ITaudit_backoffice_v2;

/**
 * Numeric pager class
 */
class NumericPager extends Pager
{
    public $Items = [];
    public $ButtonCount = 0;

    // Constructor
    public function __construct($fromIndex, $pageSize, $recordCount, $pageSizes = "", $range = 10, $autoHidePager = null, $autoHidePageSizeSelector = null, $usePageSizeSelector = null)
    {
        parent::__construct($fromIndex, $pageSize, $recordCount, $pageSizes, $range, $autoHidePager, $autoHidePageSizeSelector, $usePageSizeSelector);
        if ($this->AutoHidePager && $fromIndex == 1 && $recordCount <= $pageSize) {
            $this->Visible = false;
        }
        $this->FirstButton = new PagerItem();
        $this->PrevButton = new PagerItem();
        $this->NextButton = new PagerItem();
        $this->LastButton = new PagerItem();
        $this->init();
    }

    // Init pager
    protected function init()
    {
        if ($this->FromIndex > $this->RecordCount) {
            $this->FromIndex = $this->RecordCount;
        }
        $this->ToIndex = $this->FromIndex + $this->PageSize - 1;
        if ($this->ToIndex > $this->RecordCount) {
            $this->ToIndex = $this->RecordCount;
        }
        $this->setupNumericPager();

        // Update button count
        if ($this->FirstButton->Enabled) {
            $this->ButtonCount++;
        }
        if ($this->PrevButton->Enabled) {
            $this->ButtonCount++;
        }
        if ($this->NextButton->Enabled) {
            $this->ButtonCount++;
        }
        if ($this->LastButton->Enabled) {
            $this->ButtonCount++;
        }
        $this->ButtonCount += count($this->Items);
    }

    // Add pager item
    protected function addPagerItem($startIndex, $text, $enabled)
    {
        $item = new PagerItem();
        $item->Start = $startIndex;
        $item->Text = $text;
        $item->Enabled = $enabled;
        $this->Items[] = $item;
    }

    // Setup pager items
    protected function setupNumericPager()
    {
        if ($this->RecordCount > $this->PageSize) {
            $eof = ($this->RecordCount < ($this->FromIndex + $this->PageSize));
            $hasPrev = ($this->FromIndex > 1);

            // First Button
            $tempIndex = 1;
            $this->FirstButton->Start = $tempIndex;
            $this->FirstButton->Enabled = ($this->FromIndex > $tempIndex);

            // Prev Button
            $tempIndex = $this->FromIndex - $this->PageSize;
            if ($tempIndex < 1) {
                $tempIndex = 1;
            }
            $this->PrevButton->Start = $tempIndex;
            $this->PrevButton->Enabled = $hasPrev;

            // Page links
            if ($hasPrev || !$eof) {
                $x = 1;
                $y = 1;
                $dx1 =(int)(($this->FromIndex - 1)/($this->PageSize * $this->Range)) * $this->PageSize * $this->Range + 1;
                $dy1 =(int)(($this->FromIndex - 1)/($this->PageSize * $this->Range)) * $this->Range + 1;
                if (($dx1 + $this->PageSize * $this->Range - 1) > $this->RecordCount) {
                    $dx2 =(int)($this->RecordCount/$this->PageSize) * $this->PageSize + 1;
                    $dy2 =(int)($this->RecordCount/$this->PageSize) + 1;
                } else {
                    $dx2 = $dx1 + $this->PageSize * $this->Range - 1;
                    $dy2 = $dy1 + $this->Range - 1;
                }
                while ($x <= $this->RecordCount) {
                    if ($x >= $dx1 && $x <= $dx2) {
                        $this->addPagerItem($x, $y, $this->FromIndex != $x);
                        $x += $this->PageSize;
                        $y++;
                    } elseif ($x >= ($dx1 - $this->PageSize * $this->Range) && $x <= ($dx2 + $this->PageSize * $this->Range)) {
                        if ($x + $this->Range * $this->PageSize < $this->RecordCount) {
                            $this->addPagerItem($x, $y . "-" . ($y + $this->Range - 1), true);
                        } else {
                            $ny =(int)(($this->RecordCount - 1) / $this->PageSize) + 1;
                            if ($ny == $y) {
                                $this->addPagerItem($x, $y, true);
                            } else {
                                $this->addPagerItem($x, $y . "-" . $ny, true);
                            }
                        }
                        $x += $this->Range * $this->PageSize;
                        $y += $this->Range;
                    } else {
                        $x += $this->Range * $this->PageSize;
                        $y += $this->Range;
                    }
                }
            }

            // Next Button
            $tempIndex = $this->FromIndex + $this->PageSize;
            $this->NextButton->Start = $tempIndex;
            $this->NextButton->Enabled = !$eof;

            // Last Button
            $tempIndex =(int)(($this->RecordCount - 1) / $this->PageSize) * $this->PageSize + 1;
            $this->LastButton->Start = $tempIndex;
            $this->LastButton->Enabled = ($this->FromIndex < $tempIndex);
        }
    }

    // Render
    public function render()
    {
        global $Language;
        $html = "";
        $href = CurrentPageUrl();
        if ($this->isVisible()) {
            if ($this->FirstButton->Enabled) {
                $html .= '<li class="page-item"><a class="page-link" href="' . $href . '?start=' . $this->FirstButton->Start . '">' . $Language->phrase("PagerFirst") . '</a></li>';
            }
            if ($this->PrevButton->Enabled) {
                $html .= '<li class="page-item"><a class="page-link" href="' . $href . '?start=' . $this->PrevButton->Start . '">' . $Language->phrase("PagerPrevious") . '</a></li>';
            }
            foreach ($this->Items as $pagerItem) {
                $html .= '<li class="page-item' . ($pagerItem->Enabled ? '' : ' active') . '"><a class="page-link" href="' . ($pagerItem->Enabled ? $href . '?start=' . $pagerItem->Start : "#") . '">' . $pagerItem->Text . '</a></li>';
            }
            if ($this->NextButton->Enabled) {
                $html .= '<li class="page-item"><a class="page-link" href="' . $href . '?start=' . $this->NextButton->Start . '">' . $Language->phrase("PagerNext") . '</a></li>';
            }
            if ($this->LastButton->Enabled) {
                $html .= '<li class="page-item"><a class="page-link" href="' . $href . '?start=' . $this->LastButton->Start . '">' . $Language->phrase("PagerLast") . '</a></li>';
            }
            $html = <<<PAGER
<div class="ew-pager">
	<div class="ew-numeric-page">
		<ul class="pagination">
		{$html}
		</ul>
	</div>
</div>
PAGER;
            $html .= parent::render();
        }
        return $html;
    }
}
