<?php

namespace App\Service;

use App\Helpers\AppHelper;
use Doctrine\ORM\EntityManager;

class Service
{
    /**
     * @return EntityManager
     */
    protected function getEntityManager(): EntityManager
    {
        return AppHelper::app()->get('orm')->getEntityManager();
    }
}