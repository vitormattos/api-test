<?php

namespace Api;

use Api\Controller\UserController;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

class Route
{
    public static function build(App $app): void
    {
        $app->group('/api/user', function (RouteCollectorProxy $group) {
            $group->post('', [UserController::class, 'create']);
            $group->get('', [UserController::class, 'retrieve']);
            $group->delete('/{id}', [UserController::class, 'delete']);
            $group->delete('', [UserController::class, 'cleanDatabase']);
        });
    }
}
