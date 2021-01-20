<?php


namespace App\Entity;


class Menu
{
    private $id;
    /** @var string */
    private $nom;
    /** @var float */
    private $prix;
    /** @var FoodTruck[] */
    private $foodTrucks;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Menu
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     * @return Menu
     */
    public function setNom(string $nom): Menu
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return float
     */
    public function getPrix(): float
    {
        return $this->prix;
    }

    /**
     * @param float $prix
     * @return Menu
     */
    public function setPrix(float $prix): Menu
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return FoodTruck[]
     */
    public function getFoodTrucks(): array
    {
        return $this->foodTrucks;
    }

    /**
     * @param FoodTruck[] $foodTrucks
     * @return Menu
     */
    public function setFoodTrucks(array $foodTrucks): Menu
    {
        $this->foodTrucks = $foodTrucks;

        return $this;
    }

    private function getFoodTrucksArray()
    {
        $foodtrucksArray = [];
        foreach ($this->foodTrucks as $foodTruck) {
            $foodtrucksArray[] = [

                'id' => $foodTruck->getId(),
                'nom' => $foodTruck->getNom(),
                'commandOpen' => $foodTruck->isCommandOpen(),
            ];
        }
        return $foodtrucksArray;
    }
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prix' => $this->prix,
            'foodtrucks' => $this->getFoodTrucksArray(),
        ];
    }
}
