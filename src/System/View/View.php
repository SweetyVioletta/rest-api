<?php
namespace App\System\View;

use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;

/**
 * Class View
 * @package App\System\View
 */
class View implements ViewInterface
{
    /**
     * @var PhpEngine
     */
    private $templating;

    /**
     * View constructor.
     */
    public function __construct()
    {
        $fileSystemLoader = new FilesystemLoader(BASEPATH . 'resources/views/%name%.php');
        $this->templating = new PhpEngine(new TemplateNameParser(), $fileSystemLoader);
    }

    /**
     * @param string $path
     * @param array $data
     *
     * @return false|string
     */
    public function make(string $path, array $data = []): ?string
    {
        return $this->templating->render($path, $data);
    }
}