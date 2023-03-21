<?php

namespace SYSOTEL\OTA\Common\Services\OtaContractServices;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Property\Property;
class OtaContractStorageManager
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
     * @param UploadedFile|string $file
     * @param string $status
     * @return string
     */
    public function store(int|Property $property, UploadedFile|string $file, string $status): string
    {
        $path = $this->fullPath($property, $file, $status);

        $this->upload($path, $file);

        return $path;
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
     * @param UploadedFile|string $file
     * @param string $status
     * @return string
     */
    protected function fullPath(int|Property $property, UploadedFile|string $file, string $status): string
    {
        $propertyID = Property::resolveID($property);
        $extension = $file instanceof UploadedFile ? $file->extension() : 'pdf';

        $folder = match($status){
            'issued' => 'issued',
            'submitted' => 'submitted',
            default => 'other'
        };
        $prefix = match($status){
            'issued' => 'ipoc_',
            'submitted' => 'spoc_',
            default => ''
        };

        $fileName = $prefix . Property::resolveID($property) . '_' . $this->uniqueID($property) . '.' . $extension;

        return "{$propertyID}/otaContracts/{$folder}/{$fileName}";
    }

    /**
     * @param $fullPath
     * @param UploadedFile|string $file
     */
    protected function upload($fullPath, UploadedFile|string $file)
    {
        $contents = $file instanceof UploadedFile ? $file->getContent() : $file;
        $this->storage()->put($fullPath, $contents, 'private');
    }

    /**
     * @param string|null $path
     * @return string|null
     */
    public function fileURL(string $path = null): ?string
    {
        if(!$path) return null;

        $url = Storage::disk($this->driver)->url($path);

        return !empty($url) ? $url : null;
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
