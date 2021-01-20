<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\FoodTruck;
use App\Entity\Menu;
use \Exception;
trait JeuDeDonneesTrait
{
/**
* @var FoodTruck[]

*/
private $foodTrucks;
/**
* @var Menu[]
*/
private $menus;
private function init()
{
$foodTruck1 = new FoodTruck();
$foodTruck1
->setId(1)
->setCommandOpen(true)
->setNom('Food Truck 1');
$foodTruck2 = new FoodTruck();
$foodTruck2
->setId(2)
->setCommandOpen(true)
->setNom('Food Truck 2');
$foodTruck3 = new FoodTruck();
$foodTruck3
->setId(3)
->setCommandOpen(false)
->setNom('Food Truck 3');
$menu1 = new Menu();
$menu1
->setId(1)
->setNom('Menu 1')
->setPrix(7.5);
$menu2 = new Menu();
$menu2
->setId(2)
->setNom('Menu 2')
->setPrix(8.5);
// Le menu 1 est servi par les food truck 1 et 2
// Le menu 2 est servi par les food truck 1, 2 et 3
$menu1->setFoodTrucks([$foodTruck1, $foodTruck2]);
$menu2->setFoodTrucks([$foodTruck1, $foodTruck2, $foodTruck3]);
$foodTruck1->setMenus([$menu1, $menu2]);
$foodTruck2->setMenus([$menu1, $menu2]);
$foodTruck3->setMenus([$menu2]);
$this->foodTrucks = [
$foodTruck1,
$foodTruck2,
$foodTruck3,
];
$this->menus = [
$menu1,
$menu2,
];

$commande1 = new Commande();
$commande1
->setId(1)
->setClient('Carlos')
->setFoodTruck($foodTruck1)
->setMenu($menu1)
->setDateDeCommande(new \DateTime('-1 days'));
$commande2 = new Commande();
$commande2
->setId(2)
->setClient('Yoann')
->setFoodTruck($foodTruck2)
->setMenu($menu2)
->setDateDeCommande(new \DateTime('-12 hours'));
$commande3 = new Commande();
$commande3
->setId(3)
->setClient('Pierre')
->setFoodTruck($foodTruck2)
->setMenu($menu2)
->setDateDeCommande(new \DateTime('-6 hours'));
$this->commandes = [
$commande1,
$commande2,
$commande3,
];


}
/**
* @param $id
* @return FoodTruck
* @throws Exception
*/
private function getFoodTruck($id)
{
foreach ($this->foodTrucks as $foodTruck) {
if ($foodTruck->getId() == $id) {
return $foodTruck;
}
}
throw new Exception('Food Truck inconnu');
}
/**
* @param $id
* @return Menu
* @throws Exception
*/
private function getMenu($id)

{
foreach ($this->menus as $menu) {
if ($menu->getId() == $id) {
return $menu;
}
}
throw new Exception('Menu inconnu');
}
}