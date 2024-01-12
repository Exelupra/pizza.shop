<?php

namespace pizzashop\commande\app\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpUnauthorizedException;

class ValiderCommandeAction extends AbstractAction
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $json = $request->getParsedBody();
        $sco = $this->container->get("sCommande");
        if (!isset($json["etat"])) {
            throw new HttpUnauthorizedException($request, "L'état doit être 'validee'");
        }
        $etat = $json["etat"];
        if ($etat == "validee") {
            //Checker si la commande existe
            if (!$sco->existeCommande($args['id'])) {
                throw new HttpNotFoundException($request, "Commande inexistante");
            }

            $comm = $sco->accederCommande($args['id']);
            if ($comm->etat == 1) {
                $sco->validerCommande($args['id']);
            } else {
                throw new HttpBadRequestException($request, "Transition pas correcte");
            }
        } else {
            throw new HttpUnauthorizedException($request, "L'état doit être 'validee'");
        }

        $res = $sco->accederCommande($args['id']);

        $rep = [
            "type" => "ressource",
            "commande" => $res,
            "link" => [
                "self" => [
                    "href" => "/commandes/$res->id"
                ],
                "valider" => [
                    "href" => "/commandes/$res->id"
                ]
            ]
        ];


        $response->getBody()->write(json_encode($rep));
        return $response;
    }

}