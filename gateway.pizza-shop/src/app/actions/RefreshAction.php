<?php

namespace pizzashop\gateway\app\actions;

use Cassandra\Exception\UnauthorizedException;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpUnauthorizedException;

class RefreshAction extends AbstractAction
{


    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $headers = $request->getHeaders();

            $client = new Client();
            $res = $client->request('POST', "http://api.pizza-auth/api/users/refresh", ['headers' => $headers]);
            $res = $res->getBody()->getContents();
            $response->withStatus(200);
            $response->getBody()->write($res);
            return $response;
        } catch (HttpUnauthorizedException $exception) {
            return $response->withStatus(40);
        }
    }
}