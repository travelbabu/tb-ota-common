<?php

namespace SYSOTEL\OTA\Common\Helpers;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;

class TokenConfig
{
    /**
     * @var string
     */
    protected string $dataType;

    /**
     * @var int
     */
    protected int $length;

    /**
     * @var int
     */
    protected int $validityInDays;

    /**
     * @param string $tokenType
     * @throws Exception
     */
    public function __construct(string $tokenType)
    {
        $config = config('user-tokens.config');
        $knownTokenTypes = array_keys($config);

        if(! in_array($tokenType,$knownTokenTypes)){
            throw new Exception('Invalid token type');
        }

        $this->dataType = $config[$tokenType]['type'];
        $this->length = $config[$tokenType]['length'];
        $this->validityInDays = $config[$tokenType]['validTimeLength'];
    }

    /**
     * @return string
     */
    public function getDataType(): string
    {
        return $this->dataType;
    }

    /**
     * @return int
     */
    public function getLength(): int
    {
        return $this->length;
    }

    /**
     * @return int
     */
    public function getValidityInSeconds(): int
    {
        return $this->validityInDays;
    }

    /**
     * @throws Exception
     */
    public function getTokenGenerator(): TokenGenerator
    {
        return new TokenGenerator($this);
    }
}
