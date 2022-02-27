<?php

use atoum\Sculpin\AtoumExtensionsBundle\AtoumExtensionsBundle;

require_once __DIR__ . '/../vendor/autoload.php';

class SculpinKernel extends \Sculpin\Bundle\SculpinBundle\HttpKernel\AbstractKernel
{
    protected function getAdditionalSculpinBundles(): array
    {
        return [
              AtoumExtensionsBundle::class,
        ];
    }
}
