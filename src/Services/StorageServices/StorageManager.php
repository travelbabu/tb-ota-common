<?php

namespace SYSOTEL\OTA\Common\Services\StorageServices;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\FileV2;

abstract class StorageManager
{
    /**
     * @var string
     */
    protected string $driver;

    public function __construct(string $driver)
    {
        $this->driver = $driver;
    }

    public abstract function isPublicVisibility(): bool;

    /**
     * @param UploadedFile $uploadFile
     * @param string $path
     * @param string $fileName
     * @return FileV2
     */
    public function store(UploadedFile $uploadFile, string $path, string $fileName): FileV2
    {
        $file = new FileV2;
        $file->filePath = $path;
        $file->byteSize = $uploadFile->getSize() ?? null;
        $file->extension = $uploadFile->extension();

        $file->name = $fileName;

        $this->upload($file->filePath, $uploadFile);

        return $file;
    }

    /**
     * @param $fullPath
     * @param UploadedFile $file
     */
    protected function upload($fullPath, UploadedFile $file): void
    {
        $this->storage()->put(
            $fullPath,
            $file->getContent(),
            $this->isPublicVisibility() ? 'PUBLIC' : []
    );
    }

    /**
     * @param string|FileV2 $path
     * @return string
     */
    public function fileURL(string|FileV2 $path): string
    {
        $path = $path instanceof FileV2 ? $path->filePath : $path;

        return Storage::disk($this->driver)->url($path);
    }

    /**
     * @param string|FileV2 $document
     * @return StreamedResponse
     */
    public function fileResponse(string|FileV2 $document): StreamedResponse
    {
        $path = $document instanceof FileV2 ? $document->filePath : $document;

        return $this->storage()->response($path);
    }

    /**
     * @param string|FileV2 $document
     * @return StreamedResponse
     */
    public function fileDownloadResponse(string|FileV2 $document): StreamedResponse
    {
        $path = $document instanceof FileV2 ? $document->filePath : $document;

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
