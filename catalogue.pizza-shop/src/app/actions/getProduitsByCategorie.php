<?php

namespace pizzashop\catalogue\app\actions;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpUnauthorizedException;

class getProduitsByCategorie extends AbstractAction
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $sca = $this->container->get("sCatalogue");
        try {
            $res = $sca->getProduitsParCategorie($args['id']);
        } catch (\Exception $exception){
            throw new HttpNotFoundException($request, "Mauvaise catégorie");
        }

        $response->getBody()->write(json_encode($res));
        return $response;
    }
}