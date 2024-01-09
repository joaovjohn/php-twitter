<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap {

	protected function initRoutes() {

		$routes['home'] = [
			'route' => '/',
			'controller' => 'indexController',
			'action' => 'index'
		];

		$routes['inscreverse'] = [
			'route' => '/inscreverse',
			'controller' => 'indexController',
			'action' => 'inscreverse'
		];

		$routes['registrar'] = [
			'route' => '/registrar',
			'controller' => 'indexController',
			'action' => 'registrar'
		];

        $routes['autenticar'] = [
            'route' => '/autenticar',
            'controller' => 'AuthController',
            'action' => 'autenticar'
        ];

        $routes['timeline'] = [
            'route' => '/timeline',
            'controller' => 'AppController',
            'action' => 'timeline'
        ];

        $routes['sair'] = [
            'route' => '/sair',
            'controller' => 'AuthController',
            'action' => 'sair'
        ];

        $routes['tweet'] = [
            'route' => '/tweet',
            'controller' => 'AppController',
            'action' => 'tweet'
        ];

        $routes['deleteTweet'] = [
            'route' => '/deleteTweet',
            'controller' => 'AppController',
            'action' => 'deleteTweet'
        ];

        $routes['seguir'] = [
            'route' => '/seguir',
            'controller' => 'AppController',
            'action' => 'seguir'
        ];

        $routes['acao'] = [
            'route' => '/acao',
            'controller' => 'AppController',
            'action' => 'acao'
        ];

        $this->setRoutes($routes);
	}

}

?>