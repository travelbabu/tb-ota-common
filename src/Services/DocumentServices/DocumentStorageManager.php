<?php

namespace SYSOTEL\OTA\Common\Services\DocumentServices;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyDocuments\embedded\DocumentFile;
use SYSOTEL\OTA\Common\Enums\PropertyDocumentType;

class DocumentStorageManager
{
    /**
     * @var string
     */
    protected $driver;

    public function __construct(string $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @param int|Property $property
     * @param UploadedFile|UploadedFile[] $files
     * @param PropertyDocumentType $documentType
     * @return DocumentFile[]
     */
    public function store(int|Property $property, UploadedFile|array $files, PropertyDocumentType $documentType): array
    {
        /** @var UploadedFile[] $files */
        $files = Arr::wrap($files);

        $documentFiles = [];

        foreach ($files as $i => $file) {

            $documentFile = new DocumentFile;
            $documentFile->filePath = $this->fullPath($property, $file, $documentType);
            $documentFile->byteSize = $file->getSize() ?? null;
            $documentFile->extension = $file->extension();

            $documentFile->name = $documentType->label();
            if(count($files) > 1) {
                $documentFile->name = "$documentFile->name " . $i + 1;
            }

            $this->upload($documentFile->filePath, $file);

            $documentFiles[] = $documentFile;
        }


        return $documentFiles;
    }

    /**
     * @param int|Property $property
     * @param UploadedFile $file
     * @return string
     */
    protected function fileName(int|Property $property, UploadedFile $file): string
    {
        $uniqueID = $this->uniqueID($property);
        $extension = $file->extension();

        return $uniqueID . '.' . $extension;
    }

    /**
     * @param int|Property $property
     * @return string
     */
    protected function uniqueID(int|Property $property): string
    {
        $propertyID = Property::resolveID($property);

        return \uniqid(now()->timestamp . $propertyID);
    }

    /**
     * @param int|Property $property
     * @param UploadedFile $file
     * @param PropertyDocumentType $documentType
     * @return string
     */
    protected function fullPath(int|Property $property, UploadedFile $file, PropertyDocumentType $documentType): string
    {
        $propertyID = Property::resolveID($property);

        $fileName = $this->fileName($property, $file);

        return "{$propertyID}/documents/{$documentType->value}/{$fileName}";
    }

    /**
     * @param $fullPath
     * @param UploadedFile $file
     */
    protected function upload($fullPath, UploadedFile $file): void
    {
        $this->storage()->put($fullPath, $file->getContent());
    }

    /**
     * @param string|DocumentFile $path
     * @return string
     */
    public function fileURL(string|DocumentFile $path): string
    {
        $path = $path instanceof DocumentFile ? $path->filePath : $path;

        return Storage::disk($this->driver)->url($path);
    }

    /**
     * @param string|DocumentFile $document
     * @return StreamedResponse
     */
    public function fileResponse(string|DocumentFile $document): StreamedResponse
    {
        $path = $document instanceof DocumentFile ? $document->filePath : $document;

        return $this->storage()->response($path);
    }

    /**
     * @param string|DocumentFile $document
     * @return StreamedResponse
     */
    public function fileDownloadResponse(string|DocumentFile $document): StreamedResponse
    {
        $path = $document instanceof DocumentFile ? $document->filePath : $document;

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
