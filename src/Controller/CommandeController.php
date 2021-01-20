<?php

namespace App\Controller;

use App\Entity\Commande;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/command")
 */
class CommandeController extends AbstractController
{
    use JeuDeDonneesTrait;
    public function __construct()
    {
        $this->init();;
    }
    /**
     * @Route("/", name="command_main")
     */
    public function index(Request $request)
    {
        $client = $request->query->get('client');
        if (empty($client)) {
            throw new BadRequestHttpException('il manque le nom du client');
        }
        try {
            $foodtruckId = $request->query->get('foodtruck');
            $foodtruck = $this->getFoodTruck($foodtruckId);
            $menuId = $request->query->get('menu');
            $menu = $this->getMenu($menuId);
        } catch (Exception $e) {
            throw new BadRequestHttpException('Les identifiants ne correspondent pas à des ressources connues');
        }
        // On s'assure que le menu est bien servi par le food truck
        $menuOk = false;
        foreach ($foodtruck->getMenus() as $fmenu) {
            if ($fmenu->getId() != $menu->getId()) {
                continue;
            }
            $menuOk = true;
        }
        $commande = null;
        if ($menuOk) {
            $commande = new Commande();
            $commande
                ->setId(1)
                ->setDateDeCommande(new \DateTime())
                ->setFoodTruck($foodtruck)
                ->setMenu($menu)
                ->setClient($client);
            return $this->json(
                $commande->toArray()
            );
        } else {
            $message = "Nous ne pouvons pas accepter votre commande";
            return $this->json([
                'message' => $message,
            ]);
        }
    }
}