<?php

namespace atoum\ExtensionsWebsite\Repository;

class ExtensionsRepository
{
    /**
     * @var array
     */
    protected $extensionsGroups;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->extensionsGroups = $config;
    }

    /**
     * @param string $label
     *
     * @return array|null
     */
    public function findUrl($label)
    {
        foreach ($this->extensionsGroups as $group) {
            foreach ($group['extensions'] as $extension) {
                if ($extension['label'] == $label) {
                    return $extension;
                }
            }
        }

        return null;
    }

    /**
     * @return array
     */
    public function getExtensionsGroups()
    {
        return $this->extensionsGroups;
    }
}
