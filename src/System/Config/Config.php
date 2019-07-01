<?php

namespace App\System\Config;

use Symfony\Component\Config\FileLocator;

class Config implements ConfigInterface
{
    /**
     * @var array
     */
    private $config = [];
    private $loader;
    /**
     * @var FileLocator
     */
    private $locator;

    public function __construct(string $directory)
    {
        $directories = [
            BASEPATH . '/' .  $directory,
        ];
        $this->setLocator($directories);
        $this->setLoader();
    }

    /**
     * @param string $file
     */
    public function addConfig(string $file): void
    {
        $configs = $this->loader->load($this->locator->locate($file));
        if (empty($configs)) {
            return;
        }
        foreach ($configs as $key => $value) {
            $this->config[$key] = $value;
        }
    }

    /**
     * database.dbname
     *
     * @param string $keyValue
     *
     * @return mixed|void
     */
    public function get(string $keyValue)
    {
        list($key, $value) = explode('.', $keyValue);
        if (!$key || !isset($this->config[$key])) {
            return null;
        }
        if ($value && isset($this->config[$key][$value])) {
            return $this->config[$key][$value];
        }
        return $this->config[$key];
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * Setter $loader
     */
    public function setLoader(): void
    {
        $this->loader = new YamlConfigLoader($this->locator);
    }

    /**
     * @param string $directory
     */
    public function setLocator(array $directory): void
    {
        $this->locator = new FileLocator($directory);
    }
}