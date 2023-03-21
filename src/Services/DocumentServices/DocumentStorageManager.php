<?php

namespace SYSOTEL\OTA\Common\Services\DocumentServices;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\common\PropertyDocument;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;

class DocumentStorageManager
{
    public const TYPE_BANK = 'BANK';
    public const TYPE_PAN = 'PAN';
    public const TYPE_GST = 'GST';

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
     * @param UploadedFile $file
     * @param string $documentType
     * @return PropertyDocument
     */
    public function store(int|Property $property, UploadedFile $file, string $documentType): PropertyDocument
    {
        $path = $this->fullPath($property, $file, $documentType);

        $this->upload($path, $file);

        return new PropertyDocument([
            'filePath' => $path,
            'sizeInKb' => round($file->getSize()/1024, 2),
            'extension' => $file->extension()
        ]);
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
     * @param string $documentType
     * @return string
     */
    protected function fullPath(int|Property $property, UploadedFile $file, string $documentType): string
    {
        $propertyID = Property::resolveID($property);

        $documentType = match($documentType){
            self::TYPE_BANK => 'bank',
            self::TYPE_PAN => 'pan',
            self::TYPE_GST => 'gst',
            default => 'other'
        };

        $fileName = $this->fileName($property, $file);

        return "{$propertyID}/documents/{$documentType}/{$fileName}";
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
     * @param string|PropertyDocument $path
     * @return string
     */
    public function fileURL(string|PropertyDocument $path): string
    {
        $path = $path instanceof PropertyDocument ? $path->filePath : $path;

        return Storage::disk($this->driver)->url($path);
    }

    /**
     * @param string|PropertyDocument $document
     * @return StreamedResponse
     */
    public function fileResponse(string|PropertyDocument $document): StreamedResponse
    {
        $path = $document instanceof PropertyDocument ? $document->filePath : $document;

        return $this->storage()->response($path);
    }

    /**
     * @param string|PropertyDocument $document
     * @return StreamedResponse
     */
    public function fileDownloadResponse(string|PropertyDocument $document): StreamedResponse
    {
        $path = $document instanceof PropertyDocument ? $document->filePath : $document;

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
