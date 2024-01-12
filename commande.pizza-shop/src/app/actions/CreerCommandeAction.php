<?php

namespace pizzashop\commande\app\actions;

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
        $json = $request->getBody();
        $var = json_decode($json, true);
        $uuid4 = Uuid::uuid4();

        $itemlist = [];
        if (!isset($var["items"]) || !isset($var["type_livraison"]) || !isset($var["mail_client"])){
            throw new HttpBadRequestException($request);
        }
        $items = $var["items"];
        foreach ($items as $i){
            $itemlist[] = new ItemDTO($i["numero"], $i["taille"], $i["quantite"], "", "", 0);
        }

        $commande = new CommandeDTO($uuid4, date("Y-m-d H:i:s"), $var["type_livraison"], 1, $var["mail_client"], 0, 0, $itemlist);
        try {
            $comm = $this->container->get("sCommande")->creerCommande($commande);


        $response->getBody()->write(json_encode($comm));
        $response->withStatus(201);
        $response->withHeader("Location", "/commandes/{$comm->id}");
        return $response;
        } catch (\Error $e){
            echo $e;
            throw new HttpBadRequestException($request);
        }


    }
}