<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy\Rules\BachelorsRule;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy\Rules\ChildrenRule;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy\Rules\CovidRule;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy\Rules\GuestBelow18Rule;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy\Rules\PetsRule;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy\Rules\PostBookingAmendments;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy\Rules\UnmarriedCoupleRule;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;
use function SYSOTEL\OTA\Common\Helpers\toArrayOrNull;

/**
 * @ODM\EmbeddedDocument
 */
class PropertyRules extends EmbeddedDocument
{
    /**
     * @var PostBookingAmendments
     * @ODM\EmbedOne (targetDocument=Rules\PostBookingAmendments::class)
     */
    public $postBookingAmendments;

    /**
     * @var BachelorsRule
     * @ODM\EmbedOne (targetDocument=Rules\BachelorsRule::class)
     */
    public $bachelors;

    /**
     * @var UnmarriedCoupleRule
     * @ODM\EmbedOne (targetDocument=Rules\UnmarriedCoupleRule::class)
     */
    public $unmarriedCouple;

    /**
     * @var ChildrenRule
     * @ODM\EmbedOne (targetDocument=Rules\ChildrenRule::class)
     */
    public $children;

    /**
     * @var CovidRule
     * @ODM\EmbedOne (targetDocument=Rules\CovidRule::class)
     */
    public $covid;

    /**
     * @var GuestBelow18Rule
     * @ODM\EmbedOne (targetDocument=Rules\GuestBelow18Rule::class)
     */
    public $guestBelow18;

    /**
     * @var PetsRule
     * @ODM\EmbedOne (targetDocument=Rules\PetsRule::class)
     */
    public $pets;

    /**
     * @return array
     */
    public function getRulesStringArray(): array
    {
        $arr = [];
        foreach(['bachelors', 'unmarriedCouple', 'children', 'covid', 'pets', 'guestBelow18', 'postBookingAmendments'] as $key) {
            if($this->{$key} && !empty($this->{$key}->description())) {
                $arr[] = $this->{$key}->description();
            }
        }

        return $arr;

    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return arrayFilter([
            'postBookingAmendments' => toArrayOrNull($this->postBookingAmendments),
            'bachelors'             => toArrayOrNull($this->bachelors),
            'unmarriedCouple'       => toArrayOrNull($this->unmarriedCouple),
            'children'              => toArrayOrNull($this->children),
            'covid'                 => toArrayOrNull($this->covid),
            'guestBelow18'          => toArrayOrNull($this->guestBelow18),
            'pets'                  => toArrayOrNull($this->pets),
        ]);
    }
}
