<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDetails;

use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\CanResolveIntegerID;
use Delta4op\MongoODM\Traits\HasDefaultAttributes;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Illuminate\Support\Arr;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Supplier;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyDetailsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document(
 *     collection="propertyDetails",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyDetailsRepository::class
 * )
 * @ODM\HasLifecycleCallbacks
 */
class PropertyDetails extends Document
{
    use CanResolveIntegerID, HasTimestamps, HasNearbyPlaces, HasDefaultAttributes;

    /**
     * @inheritdoc
     */
    protected string $collection = 'propertyDetails';

    /**
     * @inheritdoc
     */
    protected string $keyType = 'int';

    /**
     * @var int
     * @ODM\Id(strategy="none")
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $supplierID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $tagline;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $description;

    /**
     * @ODM\EmbedMany(targetDocument=PropertyWebLink::class)
     */
    public $webLinks;

    /**
     * @var Arr
     * @ODM\EmbedMany(targetDocument=NearbyPlace::class)
     */
    public $nearbyPlaces;

    protected $defaults = [
        'supplierID' => Supplier::ID_SELF
    ];

    /**
     * CONSTRUCTOR
     */
    public function __construct(array $attributes = [])
    {
        $this->links = new ArrayCollection;
        $this->nearbyPlaces = new ArrayCollection;

        parent::__construct($attributes);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id'           => $this->id,
            'tagline'      => $this->tagline,
            'description'  => $this->description,
            'links'        => collect($this->links)->toArray(),
            'nearbyPlaces' => collect($this->nearbyPlaces)->toArray(),
        ]);
    }

    /**
     * User Repository
     *
     * @return PropertyDetailsRepository
     */
    public static function repository(): PropertyDetailsRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
