<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/menu")
 */
class MenuController extends AbstractController
{
    use JeuDeDonneesTrait;
    public function __construct()
    {
        $this->init();;
    }
    /**
     * @Route("/{id}", name="menu_main")
     */
    public function index($id = '')
    {
        if (!empty($id)) {
            try {
                $menu = $this->getMenu($id);
            } catch (Exception $e) {
                throw new BadRequestHttpException();
            }
        }
        if (empty($menu)) {
            // On renvoie la liste de tous les food trucks.
            return $this->json($this->toArray($this->menus));
        }
        // On renvoie le food truck demandé
        return $this->json($menu->toArray());
    }
    /**
     * @param Menu[] $menus
     * @return array
     */
    private function toArray($menus)
    {
        $menusArray = [];
        foreach ($menus as $menu) {
            $menusArray[] = $menu->toArray();
        }
        return $menusArray;
    }
}
