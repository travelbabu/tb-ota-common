<?php

namespace SYSOTEL\OTA\Common\Helpers;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;

class TokenGenerator
{
    protected TokenConfig $config;

    /**
     * @throws Exception
     */
    public function __construct(TokenConfig $config)
    {
        $this->config = $config;
    }

    /**
     * Generate token for given token type
     *
     * @return string
     * @throws Exception
     */
    public function generateToken(): string
    {
        if($this->config->getDataType() == 'numeric'){
            return $this->generateRandomNumber($this->config->getLength());
        }

        return Str::random($this->config->getLength());
    }

    /**
     * @param Carbon $from
     * @return Carbon
     */
    public function getExpiryDate(Carbon $from): Carbon
    {
        return $from->copy()->addSeconds(
            $this->config->getValidityInSeconds()
        );
    }

    /**
     * Generates random number
     *
     * @param int $length
     * @return int
     * @throws Exception
     */
    protected function generateRandomNumber(int $length): int
    {
        $min = 10;
        foreach(range(1,$length) as $i){
            $min *= 10;
        }

        $max = ($min * 10) - 1;

        return random_int($min, $max);
    }
}
