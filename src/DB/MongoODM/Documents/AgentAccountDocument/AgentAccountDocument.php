<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\AgentAccountDocument;

use Delta4op\MongoODM\Documents\Document;
use Delta4op\MongoODM\Facades\DocumentManager;
use Delta4op\MongoODM\Traits\HasTimestamps;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\HttpFoundation\StreamedResponse;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Verification;
use SYSOTEL\OTA\Common\DB\MongoODM\Repositories\TravelAgentDocumentRepository;
use SYSOTEL\OTA\Common\Services\AgentDocumentServices\Facades\AgentAccountStorageManager;

/**
 * @ODM\Document(
 *     collection="agentAccountDocuments",
 *     repositoryClass=SYSOTEL\OTA\Common\DB\MongoODM\Repositories\TravelAgentDocumentRepository::class
 * ),
 * @ODM\HasLifecycleCallbacks
 */
class AgentAccountDocument extends Document
{
    use HasTimestamps;

    /**
     * @inheritdoc
     */
    protected string $collection = 'agentAccountDocuments';

    /**
     * @var string
     * @ODM\Id
     */
    public $id;

    /**
     * @var int
     * @ODM\Field(type="int")
     */
    public $travelAgentAccountID;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    public $docType;
    public const DOC_TYPE_BANK = 'BANK';
    public const DOC_TYPE_GST = 'GST';
    public const DOC_TYPE_PAN = 'PAN';
    public const DOC_TYPE_IATA = 'IATA';
    public const DOC_TYPE_TAN = 'TAN';
    public const DOC_TYPE_ITR = 'ITR';

    /**
     * @ODM\EmbedOne(
     *   discriminatorField="docType",
     *   discriminatorMap={
     *     "BANK"=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\BankDetails::class,
     *     "GST"=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\GSTDetails::class,
     *     "PAN"=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\PanDetails::class,
     *     "IATA"=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\IataDetails::class,
     *     "TAN"=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\TanDetails::class,
     *     "ITR"=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\ItrDetails::class
     *   }
     * )
     */
    public $details;

    /**
     * @var Verification
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\Verification::class)
     */
    public $verification;

    /**
     * @var UserReference
     * @ODM\EmbedOne (targetDocument=SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\UserReference::class)
     */
    public $causer;

    /**
     * @return string|null
     */
    public function getDocTypeLabel(): string|null
    {
        return match($this->docType) {
            self::DOC_TYPE_BANK => 'Bank Details',
            self::DOC_TYPE_GST => 'GST Details',
            self::DOC_TYPE_PAN => 'PAN Details',
            self::DOC_TYPE_IATA => 'IATA Details',
            self::DOC_TYPE_TAN => 'TAN Details',
            self::DOC_TYPE_ITR => 'ITR Details',
            default => $this->docType
        };
    }

    /**
     * @return string|null
     */
    public function url(): ?string
    {
        return $this->hasFile()
            ? AgentAccountStorageManager::fileURL($this->details->file->filePath)
            : null;
    }

    /**
     * @return StreamedResponse
     */
    public function fileResponse(): StreamedResponse
    {
        if(!$this->hasFile()) {
            abort(500);
        }
        return AgentAccountStorageManager::fileResponse($this->details->file->filePath);
    }

    /**
     * @return StreamedResponse
     */
    public function fileDownloadResponse(): StreamedResponse
    {
        if(!$this->hasFile()) {
            abort(500);
        }
        return AgentAccountStorageManager::fileDownloadResponse($this->details->file->filePath);
    }

    public function hasFile(): bool
    {
        return isset($this->details->file);
    }


    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'travelAgentAccountID' => $this->travelAgentAccountID,
        ]);
    }

    /**
     * @return TravelAgentDocumentRepository
     */
    public static function repository(): TravelAgentDocumentRepository
    {
        return DocumentManager::getRepository(self::class);
    }
}
