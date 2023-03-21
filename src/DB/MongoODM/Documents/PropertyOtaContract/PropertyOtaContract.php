<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyOtaContract;

use Carbon\Carbon;
use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\HasDefaultAttributes;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Verification;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyOtaContractRepository;

/**
 * @ODM\Document(
 *     collection="propertyOtaContracts",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\PropertyOtaContractRepository::class
 * )
 * @ODM\HasLifecycleCallbacks
 */
class PropertyOtaContract extends Document
{
    use HasTimestamps, HasDefaultAttributes;

    /**
     * @inheritdoc
     */
    protected string $collection = 'propertyOtaContracts';

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
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $issuedAt;

    /**
     * @var UserReference
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference::class)
     */
    public $issuer;

    /**
     * @var OtaCommission
     * @ODM\EmbedOne (targetDocument=OtaCommission::class)
     */
    public $commission;

    /**
     * @var ContractProperty
     * @ODM\EmbedOne (targetDocument=ContractProperty::class)
     */
    public $propertyDetails;

    /**
     * @var ContractPropertyBankDetails
     * @ODM\EmbedOne (targetDocument=ContractPropertyBankDetails::class)
     */
    public $bankDetails;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $issuedFilePath;

    /**
     * @var Signatory
     * @ODM\EmbedOne (targetDocument=Signatory::class)
     */
    public $signatory;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $uploadedFilePath;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $contractFilePath;

    /**
     * @var Verification
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Verification::class)
     */
    public $verification;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $status;
    public const STATUS_ISSUED = 'ISSUED';
    public const STATUS_SIGNATORY_CREATED = 'SIGNATORY_CREATED';
    public const STATUS_SIGNATORY_APPROVED = 'SIGNATORY_APPROVED';
    public const STATUS_ACTIVE = 'ACTIVE';
    public const STATUS_INVALID = 'INVALID';

    /**
     * @var bool
     * @ODM\Field(type="bool")
     */
    public $forceESigned;

    /**
     * @var UserReference
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference::class)
     */
    public $forceESignCauser;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $forceESignedAt;

    /**
     * @var Carbon
     * @ODM\Field(type="carbon")
     */
    public $invalidatedAt;

    public $defaults = [
        'status' => self::STATUS_ISSUED
    ];

    /**
     * User Repository
     *
     * @return PropertyOtaContractRepository
     */
    public static function repository(): PropertyOtaContractRepository
    {
        return DocumentManager::getRepository(self::class);
    }

    public function toArray(): array
    {
        return [];
    }
}