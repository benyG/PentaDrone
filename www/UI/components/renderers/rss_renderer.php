<?php

include_once dirname(__FILE__) . '/' . 'renderer.php';
include_once dirname(__FILE__) . '/' . '../dataset_rss_generator.php';

// require_once 'components/renderers/renderer.php';
// require_once 'components/dataset_rss_generator.php';

class RssRenderer extends Renderer
{
    public function RenderPage(Page $Page)
    {
        $rssGenerator = $Page->GetRssGenerator();
        $this->result = $rssGenerator->Generate();
    }

    public function RenderGrid(Grid $Grid)
    { }
}