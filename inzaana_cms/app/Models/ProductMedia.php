<?php

namespace Inzaana;

use Illuminate\Database\Eloquent\Model;

use Inzaana\MediaUploader\MediaUploader;
use Inzaana\MediaUploader\ImageUploader;
use Inzaana\MediaUploader\VideoUploader;

use \Symfony\Component\HttpFoundation\File\UploadedFile;

use Inzaana\Log;
use Inzaana\Exception;

class ProductMedia extends Model
{
	const MEDIA_TYPES = ['UNKNOWN', 'IMAGE', 'VIDEO', 'AUDIO'];
    const SUPPORTED_MEDIA_MIMES = [
        'IMAGE' => [ 'png', 'jpeg', 'gif' ],
        'VIDEO' => [ 'video/avi', 'video/mpeg', 'video/quicktime', 'video/mp4' ],
        'AUDIO' => []
    ];
    const MAX_ALLOWED_IMAGE = 4;

    protected $table = 'product_medias';

    /**
     * Get all of the owning mediable models.
     */
    public function mediable()
    {
        return $this->morphTo();
    }

    public function store(array $serverFiles)
    {
        $success = true;
        foreach($serverFiles as $file)
        {
            $this->media_type = self::isMedia($file->getMimeType(), 'VIDEO') ? 'VIDEO' : 'IMAGE';
            $this->title = $file->getBasename();
            $this->url = $file->getRealPath();
            if(!$this->save())
            {
                $success = false;
            }
        }
        return $success;
    }

    public static function uuid()
    {
        $faker = \Faker\Factory::create('en_GB');
        $faker->addProvider(new \Faker\Provider\Uuid($faker));
        return $faker->unique()->uuid;
    }

    private static function uploadSingle($requestedFile)
    {
        $context = "products";
        // dd($requestedFile->getClientMimeType());
        $mediaUploader = self::isMedia($requestedFile->getClientMimeType(), 'VIDEO') ? new VideoUploader($context) : new ImageUploader($context);
        $mediaUploader->validate($requestedFile);
        // dd($mediaUploader->errors());
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

    /**
     * @param $mediaMime        the media MIME
     * @param $queryMediaType   the query of a type
     */
    private static function isMedia($mediaMime, $queryMediaType)
    {
        foreach(ProductMedia::SUPPORTED_MEDIA_MIMES as $mediaType => $mimes)
        {
            if($mediaType == $queryMediaType)
            {
                foreach($mimes as $mime)
                {
                    if($mime == $mediaMime)
                        return true;
                }   
            }
        }
        return false;
    }

    public static function isValidURL($url)
    {
        return (bool)parse_url($url);
    }
}
