<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy;

use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyPolicyRepository;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\Document(
 *     collection="propertyPolicies",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyPolicyRepository::class
 * )
 * @ODM\HasLifecycleCallbacks
 */
class PropertyPolicy extends Document
{
    use HasTimestamps;

    /**
     * @inheritdoc
     */
    protected string $collection = 'propertyPolicies';

    /**
     * @var string
     * @ODM\Id
     */
    public $id;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $propertyID;

    /**
     * @var CheckInPolicy
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy\CheckInPolicy::class)
     */
    public $checkInPolicy;

    /**
     * @var CheckOutPolicy
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy\CheckOutPolicy::class)
     */
    public $checkOutPolicy;

    /**
     * @var AgePolicy
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy\AgePolicy::class)
     */
    public $agePolicy;

    /**
     * @var GuestIdentityPolicy
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy\GuestIdentityPolicy::class)
     */
    public $guestIdentityPolicy;

    /**
     * @var PropertyRules
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy\PropertyRules::class)
     */
    public $rules;

    public function __construct(array $attributes = [])
    {
        $this->policyItems = new ArrayCollection;

        parent::__construct($attributes);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'propertyID'          => $this->propertyID,
            'agePolicy'           => toArrayOrNull($this->agePolicy),
            'checkInPolicy'       => toArrayOrNull($this->checkInPolicy),
            'checkOutPolicy'      => toArrayOrNull($this->checkOutPolicy),
            'rules'               => toArrayOrNull($this->rules),
            'guestIdentityPolicy' => toArrayOrNull($this->guestIdentityPolicy),
            'createdAt'           => $this->createdAt,
        ]);
    }

    /**
     * @return PropertyPolicyRepository
     */
    public static function repository(): PropertyPolicyRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
