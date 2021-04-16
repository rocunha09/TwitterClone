<?php
namespace App;

use MF\Init\Bootstrap;

class Route extends  Bootstrap {

    public function initRoutes(){
        $routes['home'] = array(
            'route' => '/',
            'controller' => 'IndexController',
            'action' => 'index'
        );

        $routes['inscreverse'] = array(
            'route' => '/inscreverse',
            'controller' => 'IndexController',
            'action' => 'inscreverse'
        );

        $this->setRoutes($routes);

    }
}

?>