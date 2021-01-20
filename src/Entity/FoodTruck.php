<?php


namespace App\Entity;


class FoodTruck
{
    private $id;
    /** @var string */
    private $nom;
    /** @var boolean */
    private $commandOpen;
    /** @var Menu[] */
    private $menus;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return FoodTruck
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
     * @return FoodTruck
     */
    public function setNom(string $nom): FoodTruck
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return bool
     */
    public function isCommandOpen(): bool
    {
        return $this->commandOpen;
    }

    /**
     * @param bool $commandOpen
     * @return FoodTruck
     */
    public function setCommandOpen(bool $commandOpen): FoodTruck
    {
        $this->commandOpen = $commandOpen;

        return $this;
    }

    /**
     * @return Menu[]
     */
    public function getMenus(): array
    {
        return $this->menus;
    }

    /**
     * @param Menu[] $menus
     * @return FoodTruck
     */
    public function setMenus(array $menus): FoodTruck
    {
        $this->menus = $menus;

        return $this;
    }

    private function getMenusArray()
    {
        $menusArray = [];
        foreach ($this->menus as $menu) {
            $menusArray[] = [
                'id' => $menu->getId(),
                'nom' => $menu->getNom(),
                'prix' => $menu->getPrix(),
            ];
        }
        return $menusArray;
    }
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'commandOpen' => $this->commandOpen,
            'menus' => $this->getMenusArray(),
        ];
    }
    
}
