<?php

namespace atoum\Sculpin\AtoumExtensionsBundle;

class Parser extends \Parsedown
{
    /**
     * @var string
     */
    private $siteUrl;

    /**
     * @var array
     */
    protected $extension;

    public function __construct(array $extension, string $siteUrl = null)
    {
        $this->siteUrl = $siteUrl;
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

        if (null === $inline) {
            return $inline;
        }

        $src = $inline['element']['attributes']['src'];

        if (0 !== strpos($src, 'http')) {
            $inline['element']['attributes']['src'] = $this->siteUrl . dirname($this->extension['url']) . '/' . $src;
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
            $inline['element']['text'] = '<a href="' . $this->extension['github_link'] . '" class="github-link"><img src="' . $this->siteUrl . '/assets/github-icon.svg" /></a> ' . $inline['element']['text'];
        }

        return $inline;
    }

}
