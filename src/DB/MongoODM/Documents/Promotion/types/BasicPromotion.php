<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Promotion\types;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Promotion\embedded\PromotionDiscountConfig;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\User\User;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\Document
 */
class BasicPromotion extends User
{
    public $type = 'BASIC';

    /**
     * @var ?PromotionDiscountConfig
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\Promotion\embedded\PromotionDiscountConfig::class)
     */
    public $discountForAllUsers;

    /**
     * @var ?PromotionDiscountConfig
     * @ODM\EmbedOne(targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\Promotion\embedded\PromotionDiscountConfig::class)
     */
    public $discountForLoggedInUsers;

    /**
     * @return PromotionDiscountConfig|null
     */
    public function getDiscountForAllUsers(): ?PromotionDiscountConfig
    {
        return $this->discountForAllUsers;
    }

    /**
     * @param PromotionDiscountConfig|null $discountForAllUsers
     */
    public function setDiscountForAllUsers(?PromotionDiscountConfig $discountForAllUsers): void
    {
        $this->discountForAllUsers = $discountForAllUsers;
    }

    /**
     * @return PromotionDiscountConfig|null
     */
    public function getDiscountForLoggedInUsers(): ?PromotionDiscountConfig
    {
        return $this->discountForLoggedInUsers;
    }

    /**
     * @param PromotionDiscountConfig|null $discountForLoggedInUsers
     */
    public function setDiscountForLoggedInUsers(?PromotionDiscountConfig $discountForLoggedInUsers): void
    {
        $this->discountForLoggedInUsers = $discountForLoggedInUsers;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter(
            array_merge(parent::toArray(),[

            ])
        );
    }
}