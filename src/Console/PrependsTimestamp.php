<?php

namespace SYSOTEL\OTA\Common\Console;

trait PrependsTimestamp
{
    protected function getPrependString($string)
    {
        return date(property_exists($this, 'outputTimestampFormat') ?
                $this->outputTimestampFormat : '[Y-m-d H:i:s]').' ';
    }
}