<?php

namespace SYSOTEL\OTA\Common\Services\AgentDocumentServices;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\StreamedResponse;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\AgentAccount\AgentAccount;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\File;

class AgentAccountStorageManager
{
    public const TYPE_BANK = 'BANK';
    public const TYPE_GST = 'GST';
    public const TYPE_PAN = 'PAN';
    public const TYPE_IATA = 'IATA';
    public const TYPE_TAN = 'TAN';
    public const TYPE_ITR = 'ITR';

    /**
     * @var string
     */
    protected $driver;

    public function __construct(string $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @param int|AgentAccount $account
     * @param UploadedFile $file
     * @param string $documentType
     * @return File
     */
    public function store(int|AgentAccount $account, UploadedFile $file, string $documentType): File
    {
        $path = $this->fullPath($account, $file, $documentType);

        $this->upload($path, $file);

        return new File([
            'filePath' => $path,
            'sizeInKb' => round($file->getSize()/1024, 2),
            'extension' => $file->extension()
        ]);
    }

    /**
     * @param int|AgentAccount $account
     * @param UploadedFile $file
     * @return string
     */
    protected function fileName(int|AgentAccount $account, UploadedFile $file): string
    {
        $uniqueID = $this->uniqueID($account);
        $extension = $file->extension();

        return $uniqueID . '.' . $extension;
    }

    /**
     * @param int|AgentAccount $account
     * @return string
     */
    protected function uniqueID(int|AgentAccount $account): string
    {
        $propertyID = AgentAccount::resolveID($account);

        return \uniqid(now()->timestamp . $propertyID);
    }

    /**
     * @param int|AgentAccount $account
     * @param UploadedFile $file
     * @param string $documentType
     * @return string
     */
    protected function fullPath(int|AgentAccount $account, UploadedFile $file, string $documentType): string
    {
        $accountID = AgentAccount::resolveID($account);

        $documentType = match($documentType){
            self::TYPE_BANK => 'bank',
            self::TYPE_PAN => 'pan',
            self::TYPE_GST => 'gst',
            self::TYPE_IATA => 'iata',
            self::TYPE_TAN => 'tan',
            self::TYPE_ITR => 'itr',
            default => 'other'
        };

        $fileName = $this->fileName($account, $file);

        return "{$accountID}/documents/{$documentType}/{$fileName}";
    }

    /**
     * @param $fullPath
     * @param UploadedFile $file
     */
    protected function upload($fullPath, UploadedFile $file)
    {
        $this->storage()->put($fullPath, $file->getContent());
    }

    /**
     * @param string|File $path
     * @return string
     */
    public function fileURL(string|File $path): string
    {
        $path = $path instanceof File ? $path->filePath : $path;

        return Storage::disk($this->driver)->url($path);
    }

    /**
     * @param string $path
     * @return StreamedResponse
     */
    public function fileResponse(string $path): StreamedResponse
    {
        return $this->storage()->response($path);
    }

    /**
     * @param string $path
     * @return StreamedResponse
     */
    public function fileDownloadResponse(string $path): StreamedResponse
    {
        return $this->storage()->response($path);
    }

    /**
     * @return Filesystem
     */
    public function storage(): Filesystem
    {
        return Storage::disk($this->driver);
    }
}
