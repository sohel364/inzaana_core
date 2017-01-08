<?php

namespace Inzaana;

use Illuminate\Database\Eloquent\Model;

use Inzaana\MediaUploader\MediaUploader;
use Inzaana\MediaUploader\ImageUploader;

use Inzaana\Log;

class ProductMedia extends Model
{
	const MEDIA_TYPES = ['UNKNOWN', 'IMAGE', 'AUDIO', 'VIDEO'];
    const SUPPORTED_MEDIA_EXTENSIONS = [ 'IMAGE' => [ 'png', 'jpeg', 'gif' ] ];

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

    private static function uploadSingle($requestedFile)
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
            $serverEntity = self::uploadSingle($requestedFile);
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
}
