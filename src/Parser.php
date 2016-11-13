<?php

namespace atoum\ExtensionsWebsite;

class Parser extends \Parsedown
{
    /**
     * @var array
     */
    protected $extension;

    /**
     * @param array $extension
     */
    public function __construct(array $extension)
    {
        $this->extension = $extension;
    }

    /**
     * @param $Excerpt
     *
     * @return array|void
     */
    protected function inlineImage($Excerpt)
    {
        $inline = parent::inlineImage($Excerpt);

        $src = $inline['element']['attributes']['src'];
        if (0 !== strpos($src, 'http')) {
            $inline['element']['attributes']['src'] = dirname($this->extension['url']) . '/' . $src;
        }

        $inline['element']['attributes']['data-src'] = $inline['element']['attributes']['src'];
        $inline['element']['attributes']['src'] = "data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==";
        $inline['element']['attributes']['onload'] = "lzld(this)";

        return $inline;
    }

    protected function blockHeader($Line)
    {
        $inline = parent::blockHeader($Line);

        if ($inline['element']['name'] == 'h1' && isset($this->extension['github_link'])) {
            $inline['element']['text'] .= '<a href="' . $this->extension['github_link'] . '" class="github-link"><img src="/assets/github-icon.svg" /></a>';
        }

        return $inline;
    }

}
