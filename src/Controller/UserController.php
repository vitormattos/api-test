<?php

namespace Api\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;

class UserController
{
    private string $database;
    public function __construct()
    {
        $this->database = __DIR__ . '/../../storage/database.json';
    }
    public function retrieve(Request $request, Response $response): Response
    {
        $database = $this->getDatabase();

        $response->getBody()->write(json_encode($database));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }

    public function create(Request $request, Response $response): Response
    {
        $database = $this->getDatabase();

        $requestData = $request->getParsedBody();
        if (!array_key_exists($requestData['id'], $database)) {
            $database[$requestData['id']] = [
                'name' => $requestData['name']
            ];
        } else {
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(409);
        }

        file_put_contents($this->database, json_encode($database));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }

    public function delete(Request $request, Response $response): Response
    {
        $database = $this->getDatabase();
        $routeContext = RouteContext::fromRequest($request);
        $route = $routeContext->getRoute();
        if (array_key_exists($route->getArgument('id'), $database)) {
            unset($database[$route->getArgument('id')]);
            file_put_contents($this->database, json_encode($database));
        }
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }

    public function cleanDatabase(Request $request, Response $response): Response
    {
        if (file_exists($this->database)) {
            if (!is_writable($this->database)) {
                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(403);
            }
            unlink($this->database);
        }
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }

    protected function getDatabase(): array
    {
        if (file_exists($this->database)) {
            return json_decode(file_get_contents($this->database), true);
        }
        return [];
    }
}
