<?php

namespace App\Service;

use App\Entity\FoodTruck;
use App\Entity\Menu;
use Symfony\Component\PropertyInfo\PropertyTypeExtractorInterface;
use Symfony\Component\PropertyInfo\Type;

class CommandExtractor implements PropertyTypeExtractorInterface
{
    /**
     * {@inheritdoc}
     */
    public function getTypes($class, $property, array $context = array())
    {
        if ('foodTruck' === $property) {
            return [
                new Type(Type::BUILTIN_TYPE_OBJECT, true, FoodTruck::class)
            ];
        }
        if ('menu' === $property) {
            return [
                new Type(Type::BUILTIN_TYPE_OBJECT, true, Menu::class)
            ];
        }
        return null;
    }
}