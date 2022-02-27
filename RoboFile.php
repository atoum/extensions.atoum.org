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
            ->taskScss(['ressources/sass/main.scss' => 'cache/assets/sass/main_sass.css'])
            ->addImportPath('ressources/sass/')
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

        $this->taskHash('cache/main.css')->to('source/assets/css/')->run();

        $this->say("CSS rebuilt successfully!");
    }

    protected function _buildJs()
    {
        $this->say("Starting JS rebuild");

        $types = [
            'critical' => [
                'vendor/bower-asset/lazyload/build/lazyload.js',
            ],
            'main' => [
                'vendor/bower-asset/highlightjs/highlight.pack.js',
                'ressources/js/main.js',
            ],
        ];

        foreach ($types as $type => $files) {
            $this
                ->taskConcat($files)
                ->to($cacheFile = sprintf('source/assets/js/%s.js', $type))
                ->run()
            ;

            $this
                ->taskMinify($cacheFile)
                ->keepImportantComments(false)
                ->to($webFile = sprintf('source/assets/js/%s.js', $type))
                ->run()
            ;

            $this->taskHash($webFile)->to('source/assets/js/')->run();
        }

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
        $this->_mkdir('source/assets/css');
        $this->_cleanDir('source/assets/css');
        $this->_mkdir('cache/assets/sass');
    }

    protected function _cleanJs()
    {
        $this->_mkdir('source/assets/js');
        $this->_cleanDir('source/assets/js');
    }
}
