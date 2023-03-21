<?php

namespace SYSOTEL\OTA\Common\Services\CorporateDocumentServices;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\StreamedResponse;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\File;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\CorporateAccount\CorporateAccount;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\CorporateAccount\CorporateAccountBranch;

class CorporateAccountStorageManager
{
    public const TYPE_BANK = 'BANK';
    public const TYPE_GST = 'GST';
    public const TYPE_PAN = 'PAN';

    /**
     * @var string
     */
    protected $driver;

    public function __construct(string $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @param int|CorporateAccount $account
     * @param int|CorporateAccountBranch|null $branch
     * @param UploadedFile $file
     * @param string $documentType
     * @return File
     */
    public function store(int|CorporateAccount $account, int|CorporateAccountBranch|null $branch, UploadedFile $file, string $documentType): File
    {
        $path = $this->fullPath($account, $branch, $file, $documentType);

        $this->upload($path, $file);

        return new File([
            'filePath' => $path,
            'sizeInKb' => round($file->getSize()/1024, 2),
            'extension' => $file->extension()
        ]);
    }

    /**
     * @param int|CorporateAccount $account
     * @param UploadedFile $file
     * @return string
     */
    protected function fileName(int|CorporateAccount $account, UploadedFile $file): string
    {
        $uniqueID = $this->uniqueID(CorporateAccount::resolveID($account));
        $extension = $file->extension();

        return $uniqueID . '.' . $extension;
    }

    /**
     * @param int|CorporateAccount $account
     * @return string
     */
    protected function uniqueID(int|CorporateAccount $account): string
    {
        return \uniqid(now()->timestamp . CorporateAccount::resolveID($account));
    }

    /**
     * @param int|CorporateAccount $account
     * @param int|CorporateAccountBranch|null $branch
     * @param UploadedFile $file
     * @param string $documentType
     * @return string
     */
    protected function fullPath(int|CorporateAccount $account, int|null|CorporateAccountBranch $branch, UploadedFile $file, string $documentType): string
    {
        $accountID = CorporateAccount::resolveID($account);

        $documentType = match($documentType) {
            self::TYPE_BANK => 'bank',
            self::TYPE_PAN => 'pan',
            self::TYPE_GST => 'gst',
            default => 'other'
        };

        $fileName = $this->fileName($account, $file);

        if($branch) {
            $branchID = CorporateAccountBranch::resolveID($branch);
            return "{$accountID}/branches/{$branchID}/documents/{$documentType}/{$fileName}";
        } else {
            return "{$accountID}/documents/{$documentType}/{$fileName}";
        }
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
