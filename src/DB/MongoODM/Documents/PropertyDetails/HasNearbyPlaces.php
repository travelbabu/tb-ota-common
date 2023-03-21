<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDetails;

use Doctrine\Common\Collections\ArrayCollection;

trait HasNearbyPlaces
{
    public function addOrUpdateNearbyPlace(string $name, NearbyPlace $newDocument)
    {
        $item = collect($this->nearbyPlaces)->firstWhere('name', $name);

        if ($item) {
            $this->updateNearbyPlace($name, $newDocument);
            return;
        }

        $this->nearbyPlaces->add($newDocument);
    }

    public function updateNearbyPlace(string $name, NearbyPlace $newDocument)
    {
        $this->removeNearbyPlace($name);
        $this->nearbyPlaces->add($newDocument);
        return;
    }

    /**
     * @param string $name
     * @return NearbyPlace|null
     */
    public function getNearbyPlace(string $name): ?NearbyPlace
    {
        return collect($this->nearbyPlaces)->firstWhere('name', $name);
    }

    /**
     * @param string $name
     */
    public function removeNearbyPlace(string $name)
    {
        $items = new ArrayCollection;
        foreach($this->nearbyPlaces as $nearbyPlace) {
            if($nearbyPlace->name === $name) continue;
            $items->add($nearbyPlace);
        }

        $this->nearbyPlaces = $items;
    }
}
