<?php

namespace App\System\Controller;

use Symfony\Component\HttpFoundation\Response;

interface ControllerInterface
{
    /**
     * @param string $path
     * @param array $data
     *
     * @return Response
     */
    public function render(string $path, array $data = []): Response;
}
