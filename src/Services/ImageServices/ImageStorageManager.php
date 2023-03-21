<?php

namespace SYSOTEL\OTA\Common\Services\ImageServices;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyImages\ImageMetadata;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyImages\ImageResolution;
use SYSOTEL\OTA\Common\DB\MongoODM\Documents\PropertyImages\PropertyImage;

class ImageStorageManager
{
    /**
     * @var PropertyImage
     */
    protected $document;

    /**
     * @var string
     */
    protected $driver;

    /**
     * @var array
     */
    protected $imageSizes;

    /**
     * @var string
     */
    protected $originalImageFolderName = 'original';

    public function __construct(string $driver, $imageSizes)
    {
        $this->driver = $driver;
        $this->imageSizes = $imageSizes;
    }

    /**
     * @param PropertyImage $document
     * @return $this
     */
    public function useDocument(PropertyImage $document): static
    {
        $this->document = $document;

        return $this;
    }

    /**
     * @param UploadedFile $imageFile
     * @return PropertyImage
     */
    public function storeImage(UploadedFile $imageFile): PropertyImage
    {
        $image = Image::make($imageFile);
        $extension = $imageFile->extension();
        $uniqueID = $this->uniqueID();

        $image->backup();

        $fileName = $uniqueID . '.' . $extension;
        $filePath = $this->basePath() . "/{$this->originalImageFolderName}/" . $fileName;
        $this->upload($filePath, $image);

        $this->document->filePath = $filePath;
        $this->document->metadata =  new ImageMetadata([
            'resolution' => new ImageResolution([
                'widthInPX' => $image->width(),
                'heightInPX' => $image->height(),
            ]),
            'extension' => strtolower($extension),
            'sizeInKB' => $image->filesize(),
        ]);

        foreach ($this->imageSizes as $ratioType => $item) {

            foreach ($item['sizes'] as $size => $dimentions) {

                $image->fit($dimentions['width'], $dimentions['height']);

                $filePath = $this->basePath() . '/' . $ratioType . '/' . $size . '/' . $fileName;
                $this->upload($filePath, $image);

                $image->reset();
            }
        }

        return $this->document;
    }

    /**
     * @return string
     */
    protected function uniqueID(): string
    {
        return \uniqid(now()->timestamp . $this->document->propertyID);
    }

    /**
     * @return string
     */
    protected function basePath(): string
    {
        return $this->document->propertyID . '/images';
    }

    /**
     * @param $fullPath
     * @param $image
     */
    protected function upload($fullPath, $image)
    {
        Storage::disk($this->driver)->put($fullPath, $image->stream(), 'public');
    }

    /**
     * @param string|PropertyImage $path
     * @param string $ratio
     * @param string $size
     * @return string
     */
    public function imageURL(string|PropertyImage $path, string $ratio = PropertyImage::RATIO_STANDARD, string $size = PropertyImage::SIZE_MD): string
    {
        $path = $path instanceof PropertyImage ? $path->filePath : $path;

        $path = str_replace(
            $this->originalImageFolderName,
            $ratio . '/' . $size,
            $path
        );

        return Storage::disk($this->driver)->url($path);
    }
}
