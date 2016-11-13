<?php

class RoboFile extends \Robo\Tasks
{
    use Agallou\RoboHash\loadTasks;

    public function build()
    {
        $this->_clean();
        $this->_buildCss();
        $this->_buildJs();
    }

    protected function _buildCss()
    {
        $this->say("Starting CSS rebuild");

        $this
            ->taskScss(['ressources/assets/sass/main.scss' => 'cache/assets/sass/main_sass.css'])
            ->addImportPath('ressources/assets/sass/')
            ->run()
        ;

        $this
            ->taskConcat([
                'vendor/bower-asset/highlightjs/styles/railscasts.css',
                'cache/assets/sass/main_sass.css',
            ])
            ->to('cache/main.css')
            ->run()
        ;

        $this
            ->taskMinify('cache/main.css')
            ->to('cache/main.css')
            ->run()
        ;

        $this->taskHash('cache/main.css')->to('web/css/')->run();

        $this->say("CSS rebuilt successfully!");
    }

    protected function _buildJs()
    {
        $this->say("Starting JS rebuild");

        $this
            ->taskConcat([
                'vendor/bower-asset/highlightjs/highlight.pack.js',
                'ressources/assets/js/main.js',
            ])
            ->to($cacheFile = 'web/js/main.js')
            ->run()
        ;

        $this
            ->taskMinify($cacheFile)
            ->keepImportantComments(false)
            ->to($webFile = 'web/js/main.js')
            ->run()
        ;

        $this->taskHash($webFile)->to('web/js/')->run();

        $this->say("JS rebuilt successfully!");
    }

    protected function _clean()
    {
        $this->_mkdir('cache/');
        $this->_cleanBase();
        $this->_cleanCss();
        $this->_cleanJs();
    }

    protected function _cleanBase()
    {
        $this->_cleanDir('cache/');
    }

    protected function _cleanCss()
    {
        $this->_mkdir('web/css');
        $this->_cleanDir('web/css');
        $this->_mkdir('cache/assets/sass');
    }

    protected function _cleanJs()
    {
        $this->_mkdir('web/js');
        $this->_cleanDir('web/js');
    }
}
