<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy;

use Carbon\Carbon;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;

/**
 * @ODM\EmbeddedDocument
 */
class CheckOutPolicy extends EmbeddedDocument
{
    /**
     * @var bool
     * @ODM\Field(type="bool")
     */
    public $isFlexible;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $from;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $to;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $lateCheckOut;
    public const LATE_CHECK_OUT_ALLOWED = 'ALLOWED';
    public const LATE_CHECK_OUT_NOT_ALLOWED = 'NOT_ALLOWED';
    public const LATE_CHECK_OUT_AS_PER_AVAILABILITY = 'AS_PER_AVAILABILITY';

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $note;

    /**
     * @return string
     */
    public function getStandardCheckOutTimeString(): string
    {
        $s = $this->from;
        if(isset($this->to) && $this->from != $this->to) {
            $s .= ' - ' . $this->to;
        }

        return $s;
    }

    public function checkOutTimeDescription()
    {
        $str = '';

        if($this->from) {
            $str .= 'Standard check-out time is ' . Carbon::createFromFormat('H:i', $this->from)->format('h:i A');
            if($this->to) {
                $str .= ' to ' . Carbon::createFromFormat('H:i', $this->to)->format('h:i A');
            }
        }

        if(!empty($str)) {
            $str .= '.';
        }

        return $str;
    }

    public function lateCheckOutDescription(): string
    {
        return match($this->earlyCheckIn) {
            self::LATE_CHECK_OUT_ALLOWED => 'Late checkout is allowed.',
            self::LATE_CHECK_OUT_AS_PER_AVAILABILITY => 'Late checkout is allowed as per availability.',
            self::LATE_CHECK_OUT_NOT_ALLOWED => 'Late checkout is NOT allowed.',
            default => ''
        };
    }

    public function fullPolicyDescription(): string
    {
        $str = $this->checkOutTimeDescription() . ' ' . $this->lateCheckOutDescription();
        if($this->note){
            $str .= ' ' . $this->note;
        }

        return $str;
    }

    public function getFromValue()
    {
        return Carbon::createFromFormat('H:i', $this->from)->format('h:i A');
    }

    public function getToValue()
    {
        return Carbon::createFromFormat('H:i', $this->to)->format('h:i A');
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'isFlexible' => $this->isFlexible,
            'from' => $this->from,
            'to' => $this->to,
            'lateCheckOut' => $this->lateCheckOut,
            'earlyCheckOutCharges' => $this->earlyCheckOutCharges,
            'note' => $this->note,
        ];
    }
}
