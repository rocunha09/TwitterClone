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

        $this->setRoutes($routes);

    }
}

?>