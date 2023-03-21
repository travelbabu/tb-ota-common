<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyCache;

use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\CanResolveIntegerID;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Illuminate\Support\Collection;
use MongoDB\BSON\ObjectId;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Address;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\PropertyAvatar;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\TgrDetails;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy\AgePolicy;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy\CheckInPolicy;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy\CheckOutPolicy;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy\GuestIdentityPolicy;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy\PropertyRules;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertySpace\PropertySpace;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyCacheRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\Document(
 *     collection="propertyCache",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyCacheRepository::class
 * )
 * @ODM\HasLifecycleCallbacks
 */
class PropertyCache extends Document
{
    use CanResolveIntegerID, HasTimestamps;

    /**
     * @inheritdoc
     */
    protected string $collection = 'propertyCache';

    /**
     * @inheritdoc
     */
    protected string $keyType = 'int';

    /**
     * @var int
     * @ODM\Id(strategy="none", type="int")
     */
    public $id;

    /**
     * @var ObjectId
     * @ODM\Field(type="object_id")
     */
    public $logID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $supplierID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $slug;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $displayName;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $starRating;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $type;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;

    /**
     * @var Address
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Address::class)
     */
    public $address;

    /**
     * @var ?PropertyAvatar
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\PropertyAvatar::class)
     */
    public $avatar;

    /**
     * @var ?TgrDetails
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\TgrDetails::class)
     */
    public $tgrDetails;

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

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $baseCurrency;

    /**
     * @var string[]
     * @ODM\Field(type="collection")
     */
    public $highlights;
    public const HIGHLIGHT_COUPLE_FRIENDLY = 'COUPLE_FRIENDLY';
    public const HIGHLIGHT_FLEXIBLE_CHECKIN = 'FLEXIBLE_CHECKIN';
    public const HIGHLIGHT_LOCAL_ID_ALLOWED = 'LOCAL_ID_ALLOWED';
    public const HIGHLIGHT_BACHELORS_ALLOWED = 'BACHELORS_ALLOWED';

    /**
     * @var ArrayCollection & PropertySpaceCache[]
     * @ODM\EmbedMany (targetDocument=PropertySpaceCache::class)
     */
    public $spaces;

    /**
     * @var ArrayCollection & PropertyProductCache[]
     * @ODM\EmbedMany (targetDocument=PropertyProductCache::class)
     */
    public $products;

    /**
     * @var ArrayCollection & PropertyAmenityCache[]
     * @ODM\EmbedMany (targetDocument=PropertyAmenityCache::class)
     */
    public $amenities;

    /**
     * @var ArrayCollection & PropertyImageCache[]
     * @ODM\EmbedMany (targetDocument=PropertyImageCache::class)
     */
    public $images;

    /**
    * CONSTRUCTOR
    */
    public function __construct(array $attributes = [])
    {
        $this->spaces = new ArrayCollection;
        $this->products = new ArrayCollection;
        $this->amenities = new ArrayCollection;
        $this->images = new ArrayCollection;

        parent::__construct($attributes);
    }

    /**
     * @return Property
     */
    public function createDummyPropertyDocument(): Property
    {
        return new Property([
            'id' => $this->id,
            'displayName' => $this->displayName,
            'starRating' => $this->starRating,
            'type' => $this->type,
            'checkInPolicy' => $this->checkInPolicy,
            'checkOutPolicy' => $this->checkOutPolicy,
            'rules' => $this->rules,
            'guestIdentityPolicy' => $this->guestIdentityPolicy,
            'status' => $this->status,
        ]);
    }

    /**
     * @return Collection
     */
    public function getSpaces(): Collection
    {
        return collect($this->spaces);
    }

    public function getProducts(int|PropertySpace $space): Collection
    {
        return collect($this->products)->where('spaceID', PropertySpace::resolveID($space));
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id'           => $this->id,
            'logId'        => $this->logId,
            'supplierID'   => $this->supplierID,
            'slug'         => $this->slug,
            'displayName'  => $this->displayName,
            'starRating'   => $this->starRating,
            'type'   => $this->type,
            'status'   => $this->status,
            'address'      => toArrayOrNull($this->address),
            'baseCurrency' => $this->baseCurrency,
            'avatar'       => toArrayOrNull($this->avatar),
            'tgrDetails'   => toArrayOrNull($this->tgrDetails),
            'spaces'       => collect($this->spaces)->toArray(),
            'products'     => collect($this->spaces)->toArray(),
            'amenities'    => collect($this->amenities)->toArray(),
            'images'    => collect($this->images)->toArray(),
            'createdAt'    => $this->createdAt,
            'udpatedAt'    => $this->updatedAt,
        ]);
    }

    /**
     * User Repository
     *
     * @return PropertyCacheRepository
     */
    public static function repository(): PropertyCacheRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
