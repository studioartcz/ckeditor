<?php

namespace StudioArtCz;

use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;

class RouterFactory
{
    /**
     * @return array|RouteList
     */
    public function createRouter()
    {
        $router = new RouteList();
        $router[] = new Route("fman", "Fman:default");

        return $router;
    }
}