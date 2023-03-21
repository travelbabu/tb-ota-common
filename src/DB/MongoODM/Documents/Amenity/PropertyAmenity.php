<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Amenity;

use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\HasDefaultAttributes;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Supplier;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyAmenityRepository;

/**
 * @ODM\Document(
 *     collection="propertyAmenities",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyAmenityRepository::class
 * )
 * @ODM\HasLifecycleCallbacks
 */
class PropertyAmenity extends Document
{
    use HasTimestamps, HasDefaultAttributes;

    /**
     * @inheritdoc
     */
    protected string $collection = 'propertyAmenities';

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
     * @var string
     * @ODM\Field(type="string")
     */
    public $supplierID;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $spaceID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $amenityID;

    /**
     * @var bool
     * @ODM\Field(type="bool")
     */
    public $flag;

    protected $defaults = [
        'flag' => true,
        'supplierID' => Supplier::ID_SELF,
    ];

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([
            'id'         => $this->id,
            'supplierID' => $this->supplierID,
            'propertyID' => $this->propertyID,
            'spaceID'    => $this->spaceID,
            'amenityID'  => $this->amenityID,
            'flag'       => $this->flag,
            'createdAt'  => $this->createdAt,
            'updatedAt'  => $this->updatedAt,
        ]);
    }

    /**
     * User Repository
     *
     * @return PropertyAmenityRepository
     */
    public static function repository(): PropertyAmenityRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
