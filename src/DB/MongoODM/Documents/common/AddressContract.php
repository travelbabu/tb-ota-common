<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\common;

interface AddressContract
{
    public function getPostalCode(): string|null;
    public function getAddressLine(): string|null;
    public function getAreaName(): string|null;
    public function getCityName(): string|null;
    public function getStateName(): string|null;
    public function getCountryName(): string|null;
}