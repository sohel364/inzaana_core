<?php

namespace Inzaana;

use Illuminate\Database\Eloquent\Model;

use Inzaana\MediaUploader\MediaUploader;
use Inzaana\MediaUploader\ImageUploader;

use \Symfony\Component\HttpFoundation\File\UploadedFile;

use Inzaana\Log;

class ProductMedia extends Model
{
	const MEDIA_TYPES = ['UNKNOWN', 'IMAGE', 'AUDIO', 'VIDEO'];
    const SUPPORTED_MEDIA_MIMES = [ 'IMAGE' => [ 'png', 'jpeg', 'gif' ], 'VIDEO' => [ 'video/avi', 'video/mpeg', 'video/quicktime' ] ];

    protected $table = 'product_medias';

    /**
     * Get all of the owning mediable models.
     */
    public function mediable()
    {
        return $this->morphTo();
    }

    public static function uuid()
    {
        $faker = \Faker\Factory::create('en_GB');
        $faker->addProvider(new \Faker\Provider\Uuid($faker));
        return $faker->unique()->uuid;
    }
    
    public function store(array $serverFiles)
    {

    }

    private static function uploadImage($requestedFile)
    {
        $mediaUploader = new ImageUploader("products");
        $mediaUploader->validate($requestedFile);
        if($mediaUploader->fails())
        {
            return $mediaUploader->errors();
        }
        $serverFile = $mediaUploader->upload();
        if($mediaUploader->fails())
        {
            return $mediaUploader->errors();
        }
        return $serverFile;
    }

    public static function upload(array $requestedFiles)
    {
        $serverFiles = [];
        $errors = [];
        foreach($requestedFiles as $requestedFile)
        {
            $requestedFileName = $requestedFile->getClientOriginalName();
            $serverEntity = self::uploadImage($requestedFile);
            if(!is_array($serverEntity))
            {
                $serverFiles []= $serverEntity;
                continue;
            }
            Log::error('[Inzaana][ Uploading media failed for ' . $requestedFileName . ']');
            $errors []= $serverEntity;
        }
        return [ 'server_files' => $serverFiles, 'errors' => $errors  ];
    }

    public static function tidyMimes($mediaType)
    {
        $dirtyChars = '[]""';
        $mimes = trim(collect(ProductMedia::SUPPORTED_MEDIA_MIMES[$mediaType])->toJson(), $dirtyChars);
        $dirtyChars = '","';
        $mimes = str_replace($dirtyChars, ",", $mimes);
        if($mediaType == 'VIDEO')
            $dirtyChars = "\/";
        return str_replace($dirtyChars, "/", $mimes);
    }

    public static function getMediaRule($mediaType)
    {
        $size_limit_rule = '|max:' . (UploadedFile::getMaxFilesize()/ 1000);
        if($mediaType == 'IMAGE')
            return 'image|mimes:' . self::tidyMimes('IMAGE') . $size_limit_rule;
        return 'mimetypes:' . self::tidyMimes('VIDEO') . $size_limit_rule;
    }
}
