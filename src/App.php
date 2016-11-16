<?php

namespace atoum\ExtensionsWebsite;

use atoum\ExtensionsWebsite\Repository\ExtensionsRepository;
use DI\ContainerBuilder;
use Interop\Container\ContainerInterface;
use Symfony\Component\Yaml\Yaml;
use Twig_Environment;
use Twig_Loader_Filesystem;

class App extends \DI\Bridge\Slim\App
{
    /**
     * @param ContainerBuilder $builder
     */
    protected function configureContainer(ContainerBuilder $builder)
    {
        $definitions = [
            'settings.addContentLengthHeader' => false,
            \Twig_Environment::class => function (ContainerInterface $container) {
                $loader = new Twig_Loader_Filesystem(__DIR__ . '/../ressources/views');

                $env = new Twig_Environment($loader, [
                    'debug' => true,
                    'cache' => false,
                    'strict_variables' => false,
                ]);

                $env->addExtension(new \Agallou\TwigHashedFileExtension\Extension(__DIR__ . '/../web/', null));

                foreach ($container->get('twig.globals') as $name => $value) {
                    $env->addGlobal($name, $value);
                }

                return $env;
            },

            'twig.globals' => function (ContainerInterface $container) {
                return [
                    'extensions_groups' => $container->get(ExtensionsRepository::class)->getExtensionsGroups(),
                ];
            },

            ExtensionsRepository::class => function (ContainerInterface $container) {
                $extensionsGroups = Yaml::parse(file_get_contents(__DIR__ . '/../config/extensions.yml'));
                return new ExtensionsRepository($extensionsGroups);
            }
        ];

        $builder->addDefinitions($definitions);
    }
}
