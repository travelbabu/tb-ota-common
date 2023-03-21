<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\CanResolveIntegerID;
use Delta4op\MongoODM\Traits\HasDefaultAttributes;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\LockException;
use Doctrine\ODM\MongoDB\Mapping\MappingException;
use Doctrine\ODM\MongoDB\MongoDBException;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use MongoDB\BSON\ObjectId;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Address;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\RawAddress;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyImages\PropertyImage;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy\AgePolicy;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy\CheckInPolicy;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy\CheckOutPolicy;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy\GuestIdentityPolicy;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy\PropertyRules;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Supplier;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\User;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDetails\PropertyDetails;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Traits\HasActivityIDs;
use SYSOTEL\OTA\Common\Helpers\Parsers\PropertyAddressParser;
use SYSOTEL\OTA\Common\Helpers\Parsers\PropertyParser;
use SYSOTEL\OTA\Common\Services\ImageServices\Facades\ImageStorageManager;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\Document(
 *     collection="properties",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyRepository::class
 * )
 * @ODM\HasLifecycleCallbacks
 */
class Property extends Document
{
    use CanResolveIntegerID, HasTimestamps, HasActivityIDs, HasDefaultAttributes;

    /**
     * @inheritdoc
     */
    protected string $collection = 'properties';

    /**
     * @inheritdoc
     */
    protected string $keyType = 'int';

    /**
     * @var int
     * @ODM\Id(strategy="CUSTOM", type="int", options={"class"=SYSOTEL\OTA\Common\DB\MongoODM\StorageStrategies\AutoIncrementID::class })
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
    public const TYPE_HOTEL = 'HOTEL';
    public const TYPE_RESORT = 'RESORT';
    public const TYPE_HOMESTAY = 'HOMESTAY';
    public const TYPE_VILLA = 'VILLA';
    public const TYPE_APARTMENT = 'APARTMENT';
    public const TYPE_GUEST_HOUSE = 'GUEST_HOUSE';
    public const TYPE_LODGE = 'LODGE';
    public const TYPE_HOUSEBOAT = 'HOUSEBOAT';
    public const TYPE_FARM_HOUSE = 'FARM_HOUSE';
    public const TYPE_PALACE = 'PALACE';
    public const TYPE_MOTEL = 'MOTEL';
    public const TYPE_DHARAMSHALA = 'DHARAMSHALA';
    public const TYPE_COTTAGE = 'COTTAGE';
    public const TYPE_CAMP = 'CAMP';

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $noOfRooms;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $noOfFloors;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $buildYear;

    /**
     * @var ObjectId
     * @ODM\Field(type="object_id")
     */
    public $cancellationPolicyID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_VERIFICATION_PENDING = 'VERIFICATION_PENDING';
    public const STATUS_ACTIVE = 'ACTIVE';
    public const STATUS_DISABLED = 'DISABLED';
    public const STATUS_BLOCKED = 'BLOCKED';

    /**
     * @var RawAddress
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\RawAddress::class)
     */
    public $rawAddress;

    /**
     * @var Address
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Address::class)
     */
    public $address;

    /**
     * @var ?UserReference
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference::class)
     */
    public $creator;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $creationSource;
    public const CREATION_SOURCE_EXTRANET = 'EXTRANET';
    public const CREATION_SOURCE_ADMIN_DATA_SHEET_UPLOAD = 'ADMIN_DATA_SHEET_UPLOAD';

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
    public const VALID_BASE_CURRENCIES = ['INR'];

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $cachedAt;

    public $defaults = [
        'starRating' => 0,
        'supplierID' => Supplier::ID_SELF,
        'baseCurrency' => 'INR',
        'status' => self::STATUS_VERIFICATION_PENDING,
    ];

    /**
     * @return bool
     */
    public function hasAnyAddress(): bool
    {
        return isset($this->address) || isset($this->rawAddress);
    }

    public function hasVerifiedAddress(): bool
    {
        return isset($this->address);
    }

    /**
     * Returns address parser
     *
     * @return PropertyAddressParser
     * @throws Exception
     */
    public function addressParser(): PropertyAddressParser
    {
        if (!isset($this->address) && !isset($this->rawAddress)) {
            throw new Exception('Property address does not have any value.');
        }

        return (new PropertyAddressParser($this->address ?? $this->rawAddress));
    }

    /**
     * Returns the parser
     *
     * @return PropertyParser
     */
    public function parser(): PropertyParser
    {
        return new PropertyParser($this);
    }

    /**
     * @param PropertyImage $image
     */
    public function setAvatar(PropertyImage $image)
    {
        $this->avatar = new PropertyAvatar([
            'filePath' => $image->filePath
        ]);
    }

    /**
     * @param bool $firstOrNew
     * @return PropertyDetails|null
     * @throws LockException
     * @throws MappingException|MongoDBException
     */
    public function propertyDetailsDocument(bool $firstOrNew = true): ?PropertyDetails
    {
        if ($firstOrNew) {
            return PropertyDetails::repository()->firstOrNew($this);
        }
        return PropertyDetails::repository()->find($this->id);
    }

    /**
     * @param string $ratio
     * @param string $size
     * @return string
     */
    public function avatarURL(string $ratio = PropertyImage::RATIO_STANDARD, string $size = PropertyImage::SIZE_MD): string
    {
        return ImageStorageManager::imageURL($this->avatar->filePath, $ratio, $size);
    }

    /**
     * @return $this
     */
    public function markAsCached(): static
    {
        $this->cachedAt = now();
        return $this;
    }

    /**
     * @return Collection
     */
    public function getAllExtranetUsers(): Collection
    {
        return User::repository()->getAllForProperty($this);
    }

    /**
     * @return array
     */
    public function getAllExtranetUserEmailIDs(): array
    {
        return $this->getAllExtranetUsers()->map(function (User $user) {
            return $user->email->id;
        })->toArray();
    }

    public function createSlug(): string
    {
        /** @var Property $result */
        if (!$this->displayName) {
            abort(500, 'Cannot generate slug without displayName value');
        }

        $nameSlug = Str::slug($this->displayName);
        $result = Property::repository()->findBySlug($nameSlug);
        if (!$result || $result->id === $this->id) {
            return $nameSlug;
        }

        /** @var Address|RawAddress|null $address */
        $address = $this->rawAddress ?? $this->address ?? null;

        if($address && $address->getCityName()) {

            $citySlug = Str::slug($address->getCityName());
            $nameCitySlug = "{$nameSlug}-{$citySlug}";
            $result = Property::repository()->findBySlug($nameCitySlug);

            if (!$result || $result->id === $this->id) {
                return $nameCitySlug;
            }

            return "{$nameCitySlug}-{$this->id}";
        }

        return "{$nameSlug}-{$this->id}";
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'id' => $this->id,
            'supplierID' => $this->supplierID,
            'slug' => $this->slug,
            'displayName' => $this->displayName,
            'buildYear' => $this->buildYear,
            'noOfRooms' => $this->noOfRooms,
            'noOfFloors' => $this->noOfFloors,
            'starRating' => $this->starRating,
            'rawAddress' => toArrayOrNull($this->rawAddress),
            'address' => toArrayOrNull($this->address),
            'baseCurrency' => $this->baseCurrency,
            'status' => $this->status,
            'creationMethod' => $this->creationMethod,
            'creator' => toArrayOrNull($this->creator),
            'avatar' => toArrayOrNull($this->avatar),
            'tgrDetails' => toArrayOrNull($this->tgrDetails),
            'cachedAt' => $this->cachedAt,
            'createdAt' => $this->createdAt,
            'udpatedAt' => $this->updatedAt,
        ]);
    }

    /**
     * @return PropertyRepository
     */
    public static function repository(): PropertyRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
