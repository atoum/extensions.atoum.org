<?php

namespace atoum\ExtensionsWebsite;

use atoum\ExtensionsWebsite\Repository\ExtensionsRepository;
use Symfony\Component\Yaml\Yaml;
use Twig_Environment;
use Twig_Loader_Filesystem;

class Container
{
    /**
     * @return Twig_Environment
     */
    public function twig()
    {
        $loader = new Twig_Loader_Filesystem(__DIR__ . '/../ressources/views');
        $env = new Twig_Environment($loader, [
            'debug' => true,
            'cache' => false,
            'strict_variables' => false,
        ]);

        $env->addExtension(new \Agallou\TwigHashedFileExtension\Extension(__DIR__ . '/../web/', null));

        $env->addGlobal('extensions_groups', $this->getExtensionsRepository()->getExtensionsGroups());

        return $env;
    }

    /**
     * @return ExtensionsRepository
     */
    public function getExtensionsRepository()
    {
        $extensionsGroups = Yaml::parse(file_get_contents(__DIR__ . '/../config/extensions.yml'));
        return new ExtensionsRepository($extensionsGroups);
    }
}
