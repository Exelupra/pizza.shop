<?php

namespace pizzashop\gateway\app\actions;

use GuzzleHttp\Client;
use pizzashop\commande\domain\dto\CommandeDTO;
use pizzashop\commande\domain\dto\ItemDTO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;
use Slim\Exception\HttpBadRequestException;

class CreerCommandeAction extends AbstractAction
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $headers = $request->getHeaders();
        $body = $request->getBody();

        $client = new Client();

        $res = $client->request('POST', "http://api.commande.pizza-shop/commandes/", ['headers' => $headers, "body" => $body]);
        $res = $res->getBody()->getContents();
        $response->getBody()->write($res);
        return $response;
    }
}