<?php

namespace atoum\Sculpin\AtoumExtensionsBundle;

use Sculpin\Core\Sculpin;
use Sculpin\Core\Event\SourceSetEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ExtSubscriber implements EventSubscriberInterface
{
    protected $configuration;

    public static function getSubscribedEvents()
    {
        return array(
            Sculpin::EVENT_BEFORE_RUN => 'beforeRun',
        );
    }

    public function __construct(\Dflydev\DotAccessConfiguration\Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function beforeRun(SourceSetEvent $sourceSetEvent)
    {
        $sourceSet = $sourceSetEvent->sourceSet();

        foreach ($sourceSet->updatedSources() as $source) {

            $source->data()->append('use', 'official_extensions');
            $source->data()->append('use', 'community_extensions');

            if (!$source->data()->get('ext_url')) {
                continue;
            }

            // TODO fair file get content
            $markdown = file_get_contents($source->data()->get('ext_url'));

            $githubLink = $source->data()->get('ext_github_link');

            $Parsedown = new Parser(
                [
                    'url' => 'TODO',
                    'github_link' => $githubLink,
                ],
                $this->configuration->get('url')
            );
            $html = $Parsedown->text($markdown);
            $source->data()->set('readme_html', $html);
        }
    }
}
