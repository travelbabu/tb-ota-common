<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\OtaBankAccount;

use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Traits\HasRepository;
use Delta4op\MongoODM\Traits\HasTimestamps;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(
 *     collection="otaBankAccounts",
 * )
 * @ODM\HasLifecycleCallbacks
 */
class OtaBankAccount extends Document
{
    use HasRepository, HasTimestamps;

    /**
     * @inheritdoc
     */
    protected string $collection = 'otaBankAccounts';

    /**
     * @var ?string
     * @ODM\Id
     */
    public $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $accountHolder;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $accountNumber;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $ifsc;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $bankName;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $branchName;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $branchCode;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    public $status;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([

        ]);
    }
}
