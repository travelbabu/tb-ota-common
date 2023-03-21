<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Repositories;

use Delta4op\MongoODM\DocumentRepositories\DocumentRepository;
use Illuminate\Support\Collection;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\IAM\AccessRights;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Location\Country;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Location\State;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\User;

class CountryRepository extends DocumentRepository
{
    public function findForIndia(): ?Country
    {
        return $this->find('IND');
    }

    /**
     * @param string $slug
     * @return State|null
     */
    public function finBySlug(string $slug): ?State
    {
        return $this->findOneBy(compact('slug'));
    }
}
