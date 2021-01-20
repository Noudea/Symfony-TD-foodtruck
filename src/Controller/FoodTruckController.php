<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/foodtruck")
 */
class FoodTruckController extends AbstractController
{
    use JeuDeDonneesTrait;
    public function __construct()
    {
        $this->init();;
    }
    /**
     * @Route("/{id}", name="food_truck_main")
     */
    public function index($id = '')
    {
        if (!empty($id)) {
            try {
                $foodtruck = $this->getFoodTruck($id);
            } catch (\Exception $e) {
                throw new BadRequestHttpException();
            }
        }
        if (empty($foodtruck)) {
            // On renvoie la liste de tous les food trucks.
            return $this->json($this->toArray($this->foodTrucks));
        }
        // On renvoie le food truck demandé
        return $this->json($foodtruck->toArray());
    }
    /**
     * @param FoodTruck[] $foodTrucks
     * @return array
     */
    private function toArray($foodTrucks)
    {
        $foodTrucksArray = [];
        foreach ($foodTrucks as $foodTruck) {
            $foodTrucksArray[] = $foodTruck->toArray();
        }
        return $foodTrucksArray;
    }
}