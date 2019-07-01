<?php
namespace App\System\View;

interface ViewInterface
{
    /**
     * @param string $path
     * @param array $data
     *
     * @return string|false
     */
    public function make(string $path, array $data = []): ?string;
}
