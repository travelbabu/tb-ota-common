<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyPolicy;

use Carbon\Carbon;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;

/**
 * @ODM\EmbeddedDocument
 */
class CheckInPolicy extends EmbeddedDocument
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
    public $earlyCheckIn;
    public const EARLY_CHECK_IN_ALLOWED = 'ALLOWED';
    public const EARLY_CHECK_IN_NOT_ALLOWED = 'NOT_ALLOWED';
    public const EARLY_CHECK_IN_AS_PER_AVAILABILITY = 'AS_PER_AVAILABILITY';

    /**
     * @return string
     */
    public function getStandardCheckInTimeString(): string
    {
        $s = $this->from;
        if(isset($this->to) && $this->from != $this->to) {
            $s .= ' - ' . $this->to;
        }

        return $s;
    }

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $note;

    public function checkInTimeDescription()
    {
        $str = '';

        if($this->isFlexible) {
            $str .= '24 hours check-in is available. ';
        }

        if($this->from) {
            $str .= 'Standard check-in time is ' . Carbon::createFromFormat('H:i', $this->from)->format('h:i A');
            if($this->to) {
                $str .= ' to ' . Carbon::createFromFormat('H:i', $this->to)->format('h:i A');
            }
        }

        if(!empty($str)) {
            $str .= '.';
        }

        return $str;
    }

    public function earlyCheckInDescription(): string
    {
        return match($this->earlyCheckIn) {
            self::EARLY_CHECK_IN_AS_PER_AVAILABILITY => 'Early checkin is allowed as per availability.',
            self::EARLY_CHECK_IN_ALLOWED => 'Early checkin is allowed.',
            self::EARLY_CHECK_IN_NOT_ALLOWED => 'Early checkin is NOT allowed.',
            default => ''
        };
    }

    public function fullPolicyDescription(): string
    {
        $str = $this->checkInTimeDescription() . ' ' . $this->earlyCheckInDescription();
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
            'earlyCheckIn' => $this->earlyCheckIn,
            'note' => $this->note,
        ];
    }
}
