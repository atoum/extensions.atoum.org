<?php

namespace atoum\ExtensionsWebsite;

use atoum\ExtensionsWebsite\Repository\ExtensionsRepository;
use DI\ContainerBuilder;
use function DI\env;
use Interop\Container\ContainerInterface;
use Symfony\Component\Yaml\Yaml;
use Twig_Environment;
use Twig_Loader_Filesystem;
use Agallou\TwigHashedFileExtension\Extension;

class App extends \DI\Bridge\Slim\App
{
    /**
     * @param ContainerBuilder $builder
     */
    protected function configureContainer(ContainerBuilder $builder)
    {
        $definitions = [
        	'onProduction' => \DI\env('PHP_VERSION', false),
            'settings.addContentLengthHeader' => false,
            \Twig_Environment::class => function (ContainerInterface $container) {
                $loader = new Twig_Loader_Filesystem(__DIR__ . '/../ressources/views');

                $env = new Twig_Environment($loader, [
                    'debug' => ! $container->get('onProduction'),
                    'cache' => $container->get('onProduction') ? (__DIR__ . '/../cache/views') : false,
                    'strict_variables' => false,
                ]);

                $env->addExtension(new Extension(__DIR__ . '/../web/', null));

                foreach ($container->get('twig.globals') as $name => $value) {
                    $env->addGlobal($name, $value);
                }

                return $env;
            },

            'twig.globals' => function (ContainerInterface $container) {
                return [
                    'extensions_groups' => $container->get(ExtensionsRepository::class)->getExtensionsGroups(),
                    'ga_ua' => $container->get('ga_ua'),
                ];
            },

            'ga_ua' => \DI\env('GA_UA', false),

            ExtensionsRepository::class => function (ContainerInterface $container) {
                $extensionsGroups = Yaml::parse(file_get_contents(__DIR__ . '/../config/extensions.yml'));
                return new ExtensionsRepository($extensionsGroups);
            }
        ];

        $builder->addDefinitions($definitions);
    }
}
