<?php
namespace App\System\Config;

interface ConfigInterface
{
    /**
     * @param string $file
     */
    public function addConfig(string $file): void;

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get(string $key);

//    /**
//     * @param array $files
//     */
//    public function addConfigs(array $files): void;
}
