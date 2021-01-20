<?php


namespace App\Entity;


class Commande
{
    private $id;
    /** @var \DateTime */
    private $dateDeCommande;
    /** @var FoodTruck */
    private $foodTruck;
    /** @var Menu */
    private $menu;
    /** @var string */
    private $client;
    /** @var \DateTime */
    private $dateDeRetrait;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Commande
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateDeCommande(): \DateTime
    {
        return $this->dateDeCommande;
    }

    /**
     * @param \DateTime $dateDeCommande
     * @return Commande
     */
    public function setDateDeCommande(\DateTime $dateDeCommande): Commande
    {
        $this->dateDeCommande = $dateDeCommande;

        return $this;
    }

    /**
     * @return FoodTruck
     */
    public function getFoodTruck(): FoodTruck
    {
        return $this->foodTruck;
    }

    /**
     * @param FoodTruck $foodTruck
     * @return Commande
     */
    public function setFoodTruck(FoodTruck $foodTruck): Commande
    {
        $this->foodTruck = $foodTruck;

        return $this;
    }

    /**
     * @return Menu
     */
    public function getMenu(): Menu
    {
        return $this->menu;
    }

    /**
     * @param Menu $menu
     * @return Commande
     */
    public function setMenu(Menu $menu): Commande
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * @return string
     */
    public function getClient(): string
    {
        return $this->client;
    }

    /**
     * @param string $client
     * @return Commande
     */
    public function setClient(string $client): Commande
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateDeRetrait(): \DateTime
    {
        return $this->dateDeRetrait;
    }

    /**
     * @param \DateTime $dateDeRetrait
     * @return Commande
     */
    public function setDateDeRetrait(\DateTime $dateDeRetrait): Commande
    {
        $this->dateDeRetrait = $dateDeRetrait;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'client' => $this->client,
            'foodTruck' => $this->foodTruck->toArray(),
            'menu' => $this->menu->toArray(),
            'dateDeCommande' => $this->dateDeCommande,
            'dateDeRetrait' => $this->dateDeRetrait,
        ];
    }
}
