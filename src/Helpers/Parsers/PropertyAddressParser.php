<?php

namespace SYSOTEL\OTA\Common\Helpers\Parsers;

use Illuminate\Support\Str;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\AddressContract;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\RawAddress;

class PropertyAddressParser
{
    protected AddressContract $address;

    public function __construct(AddressContract $address)
    {
        $this->address = $address;
    }

    public function localityCityAddress(): string
    {
        return $this->address->getAreaName() . ', ' . $this->address->getCityName();
    }
    
    /**
     * Get address containing city state and country name
     *
     * @return string
     */
    public function cityAddress(): string
    {
        return $this->address->getCityName() . ', ' . $this->address->getStateName() . ', ' . $this->address->getCountryName();
    }

    /**
     * Get full address
     *
     * @return string
     */
    public function fullAddress(): string
    {
        $addressLine = $this->address->getAddressLine();

        // add comma at the end of the address
        if(! Str::endsWith($addressLine, ',')) {
            $addressLine .= ', ';
        }

        return $addressLine . $this->address->getAreaName() . ', ' . $this->cityAddress() . ' ' . $this->address->getPostalCode();
    }
}