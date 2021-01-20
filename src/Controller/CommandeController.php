<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Menu;
use App\Service\CommandExtractor;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

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
     * @Route("/{id}", name="command_get", methods={"GET"})
     */
    public function index($id = '')

    {
        if (!empty($id)) {
            try {
                $commande = $this->getCommande($id);
            } catch (Exception $e) {
                throw new BadRequestHttpException();
            }
        }
        if (empty($commande)) {
            // On renvoie la liste de tous les food trucks.
            return $this->json($this->toArray($this->commandes));
        }
        // On renvoie le food truck demandé
        return $this->json($commande->toArray());
    }
    /**
     * @param Commande[] $commandes
     * @return array
     */
    private function toArray($commandes)
    {
        $commandesArray = [];
        foreach ($commandes as $commande) {
            $commandesArray[] = $commande->toArray();
        }
        return $commandesArray;
    }

    /**
     * @Route("/", name="commande_create", methods={"POST"})
     */
    public function create(Request $request)
    {
        $client = $request->get('client');
        if (empty($client)) {
            throw new BadRequestHttpException('il manque le nom du client');
        }
        try {
            $foodtruckId = $request->get('foodtruck');
            $foodtruck = $this->getFoodTruck($foodtruckId);
            $menuId = $request->get('menu');
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
            $id = rand(10, 10000);
            $commande = new Commande();
            $commande
            ->setId($id)
            ->setDateDeCommande(new \DateTime())
            ->setFoodTruck($foodtruck)
            ->setMenu($menu)
            ->setClient($client);
            return $this->json(
                $commande->toArray(),

                Response::HTTP_CREATED, // On indique qu'on a une nouvelle resource,
                ['Location' => '/commande/' . $id]
            );
        } else {
            $message = "Nous ne pouvons pas accepter votre commande";
            throw new UnprocessableEntityHttpException($message);
        }
    }

    /**
     * @Route("/{id}", name="command_update", methods={"PUT", "PATCH"})
     */
    public function update(Request $request, SerializerInterface $serializer, CommandExtractor $commandExtractor, $id)
    {
        if (empty($id)) {
            throw new BadRequestHttpException();
        }
        try {
            $commande = $this->getCommande($id);
        } catch (Exception $e) {
            throw new BadRequestHttpException();
        }
        // $menu = new Menu();
        // $menu->getFoodTrucks();
       (new ObjectNormalizer(
                null,
                null,
                null,
                $commandExtractor
            ))->setSerializer($serializer);

        if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
            try {
                $newCommande = $serializer->deserialize(
                    $request->getContent(),
                    Commande::class,
                    'json',
                    [
                        AbstractObjectNormalizer::DEEP_OBJECT_TO_POPULATE => true,
                        AbstractNormalizer::OBJECT_TO_POPULATE => $commande
                    ]
                );
            } catch (Exception $e) {
                throw new UnprocessableEntityHttpException($e);
            }
        }
        if ($commande->getId() != $id) {
            throw new BadRequestHttpException('do not change the id');
        }
        return $this->json(
            $newCommande->toArray()
        );
    }
    /**
     * @Route("/{id}", name="command_delete", methods={"DELETE"})
     */
    public function delete(Request $request, $id)
    {
        if (empty($id)) {
            throw new BadRequestHttpException();
        }
        try {
           $success =  $this->deleteCommande($id);
           if($success)
           {
               return New Response(null,Response::HTTP_NO_CONTENT);
           }
            // return $this->json(
            //     'success'
            // );
        } catch (Exception $e) {
            throw new BadRequestHttpException();
        }

    }
}