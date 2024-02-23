<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\common;

use Delta4op\MongoODM\Documents\EmbeddedDocument;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use hisorange\BrowserDetect\Facade as Browser;

/**
 * @ODM\EmbeddedDocument
 * @ODM\HasLifecycleCallbacks
 */
class BrowserDetails extends EmbeddedDocument
{
    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    protected $deviceType;

    /**
     * @var string|null
     * @ODM\Field(type="string")
     */
    protected $mobileGrade;

    /**
     * @var string|null
     * @ODM\Field(type="string")
     */
    protected $platformName;

    /**
     * @var string|null
     * @ODM\Field(type="string")
     */
    protected $platformVersion;

    /**
     * @var string|null
     * @ODM\Field(type="string")
     */
    protected $platformFamily;

    /**
     * @var int|null
     * @ODM\Field(type="int")
     */
    protected $platformVersionMajor;

    /**
     * @var int|null
     * @ODM\Field(type="int")
     */
    protected $platformVersionMinor;

    /**
     * @var int|null
     * @ODM\Field(type="int")
     */
    protected $platformVersionPatch;

    /**
     * @var string|null
     * @ODM\Field(type="string")
     */
    protected $deviceModel;

    /**
     * @var string|null
     * @ODM\Field(type="string")
     */
    protected $deviceFamily;

    /**
     * @var string|null
     * @ODM\Field(type="string")
     */
    protected $browserName;

    /**
     * @var string|null
     * @ODM\Field(type="string")
     */
    protected $browserFamily;


    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    protected $browserType;

    /**
     * @var string|null
     * @ODM\Field(type="string")
     */
    protected $browserEngine;

    /**
     * @var string|null
     * @ODM\Field(type="string")
     */
    protected $browserVersion;

    /**
     * @var ?string
     * @ODM\Field(type="string")
     */
    protected $os;

    /**
     * @var string|null
     * @ODM\Field(type="string")
     */
    protected $userAgent;

    public static function autoInit(): BrowserDetails
    {
        $instance = new self;

        $instance->setDeviceType(Browser::deviceType());
        $instance->setDeviceModel(Browser::deviceModel());
        $instance->setDeviceFamily(Browser::deviceFamily());

        $instance->setBrowserName(Browser::browserName());
        if(Browser::isChrome()) {
            $instance->setBrowserType('CHROME');
        } else if(Browser::isEdge()) {
            $instance->setBrowserType('EDGE');
        } else if(Browser::isSafari()) {
            $instance->setBrowserType('SAFARI');
        } else if(Browser::isFirefox()) {
            $instance->setBrowserType('FIREFOX');
        } else if(Browser::isOpera()) {
            $instance->setBrowserType('OPERA');
        } else if(Browser::isInApp()) {
            $instance->setBrowserType('IN_APP');
        } else if(Browser::isIE()) {
            $instance->setBrowserType('INTERNET_EXPLORER');
        }

        $instance->setBrowserEngine(Browser::browserEngine());
        $instance->setBrowserVersion(Browser::browserVersion());
        $instance->setBrowserFamily(Browser::browserFamily());

        if(Browser::isAndroid()) {
            $instance->setOs('ANDROID');
        } else if(Browser::isMac()) {
            $instance->setOs('MAC');
        } else if(Browser::isWindows()) {
            $instance->setOs('WINDOWS');
        } else if(Browser::isLinux()) {
            $instance->setOs('LINUX');
        }

        $instance->setUserAgent(Browser::userAgent());

        $instance->setPlatformName(Browser::platformName());
        $instance->setPlatformVersion(Browser::platformVersion());
        $instance->setPlatformFamily(Browser::platformFamily());
        $instance->setPlatformVersionMajor(Browser::platformVersionMajor());
        $instance->setPlatformVersionMinor(Browser::platformVersionMinor());
        $instance->setPlatformVersionPatch(Browser::platformVersionPatch());

        return $instance;
    }

    /**
     * @return string|null
     */
    public function getDeviceType(): ?string
    {
        return $this->deviceType;
    }

    /**
     * @param string|null $deviceType
     * @return BrowserDetails
     */
    public function setDeviceType(?string $deviceType): BrowserDetails
    {
        $this->deviceType = $deviceType;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeviceModel(): ?string
    {
        return $this->deviceModel;
    }

    /**
     * @param string|null $deviceModel
     */
    public function setDeviceModel(?string $deviceModel): void
    {
        $this->deviceModel = $deviceModel;
    }

    /**
     * @return string|null
     */
    public function getDeviceFamily(): ?string
    {
        return $this->deviceFamily;
    }

    /**
     * @param string|null $deviceFamily
     */
    public function setDeviceFamily(?string $deviceFamily): void
    {
        $this->deviceFamily = $deviceFamily;
    }

    /**
     * @return string|null
     */
    public function getBrowserName(): ?string
    {
        return $this->browserName;
    }

    /**
     * @param string|null $browserName
     * @return BrowserDetails
     */
    public function setBrowserName(?string $browserName): BrowserDetails
    {
        $this->browserName = $browserName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBrowserType(): ?string
    {
        return $this->browserType;
    }

    /**
     * @param string|null $browserType
     * @return BrowserDetails
     */
    public function setBrowserType(?string $browserType): BrowserDetails
    {
        $this->browserType = $browserType;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBrowserFamily(): ?string
    {
        return $this->browserFamily;
    }

    /**
     * @param string|null $browserFamily
     */
    public function setBrowserFamily(?string $browserFamily): void
    {
        $this->browserFamily = $browserFamily;
    }

    /**
     * @return string|null
     */
    public function getBrowserEngine(): ?string
    {
        return $this->browserEngine;
    }

    /**
     * @param string|null $browserEngine
     * @return BrowserDetails
     */
    public function setBrowserEngine(?string $browserEngine): BrowserDetails
    {
        $this->browserEngine = $browserEngine;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOs(): ?string
    {
        return $this->os;
    }

    /**
     * @param string|null $os
     * @return BrowserDetails
     */
    public function setOs(?string $os): BrowserDetails
    {
        $this->os = $os;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBrowserVersion(): ?string
    {
        return $this->browserVersion;
    }

    /**
     * @param string|null $browserVersion
     * @return BrowserDetails
     */
    public function setBrowserVersion(?string $browserVersion): BrowserDetails
    {
        $this->browserVersion = $browserVersion;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUserAgent(): ?string
    {
        return $this->userAgent;
    }

    /**
     * @param string|null $userAgent
     * @return BrowserDetails
     */
    public function setUserAgent(?string $userAgent): BrowserDetails
    {
        $this->userAgent = $userAgent;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMobileGrade(): ?string
    {
        return $this->mobileGrade;
    }

    /**
     * @param string|null $mobileGrade
     */
    public function setMobileGrade(?string $mobileGrade): void
    {
        $this->mobileGrade = $mobileGrade;
    }

    /**
     * @return string|null
     */
    public function getPlatformName(): ?string
    {
        return $this->platformName;
    }

    /**
     * @param string|null $platformName
     */
    public function setPlatformName(?string $platformName): void
    {
        $this->platformName = $platformName;
    }

    /**
     * @return string|null
     */
    public function getPlatformVersion(): ?string
    {
        return $this->platformVersion;
    }

    /**
     * @param string|null $platformVersion
     */
    public function setPlatformVersion(?string $platformVersion): void
    {
        $this->platformVersion = $platformVersion;
    }

    /**
     * @return string|null
     */
    public function getPlatformFamily(): ?string
    {
        return $this->platformFamily;
    }

    /**
     * @param string|null $platformFamily
     */
    public function setPlatformFamily(?string $platformFamily): void
    {
        $this->platformFamily = $platformFamily;
    }

    /**
     * @return int|null
     */
    public function getPlatformVersionMajor(): ?int
    {
        return $this->platformVersionMajor;
    }

    /**
     * @param int|null $platformVersionMajor
     */
    public function setPlatformVersionMajor(?int $platformVersionMajor): void
    {
        $this->platformVersionMajor = $platformVersionMajor;
    }

    /**
     * @return int|null
     */
    public function getPlatformVersionMinor(): ?int
    {
        return $this->platformVersionMinor;
    }

    /**
     * @param int|null $platformVersionMinor
     */
    public function setPlatformVersionMinor(?int $platformVersionMinor): void
    {
        $this->platformVersionMinor = $platformVersionMinor;
    }

    /**
     * @return int|null
     */
    public function getPlatformVersionPatch(): ?int
    {
        return $this->platformVersionPatch;
    }

    /**
     * @param int|null $platformVersionPatch
     */
    public function setPlatformVersionPatch(?int $platformVersionPatch): void
    {
        $this->platformVersionPatch = $platformVersionPatch;
    }

    public function toArray()
    {
        // TODO: Implement toArray() method.
    }
}
