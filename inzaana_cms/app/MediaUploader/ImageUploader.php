<?php

namespace Inzaana\MediaUploader;

use File;

class ImageUploader extends MediaUploader
{
	const IMAGE_STORAGE_PATH = '/images';

	private $__errors = [];

	public function __construct($context = 'products')
	{
		$this->__mediaType = ProductMedia::MEDIA_TYPES[0];
		$this->__storagePath = MediaUploader::STORAGE_PATH . self::IMAGE_STORAGE_PATH . '/' . $context . '/';
	}

	public function fails()
	{
		return !collect($this->__errors)->isEmpty();
	}

    public function errors()
    {
        return $this->__errors;
    }

	public function validate(UploadedFile $uploadedFile)
	{
        $this->__uploadedFile = $uploadedFile;
        if (!$__uploadedFile->isValid())
        {
            $this->__errors []= MediaUploader::MEDIA_UPLOAD_ERRORS['corrupted_media_file'];
        }
        if(!self::isSupportedExtension($this->__uploadedFile->getClientOriginalExtension()))
        {
            $this->__errors []= MediaUploader::MEDIA_UPLOAD_ERRORS['ext_not_supported'];
        }
        if($this->__uploadedFile->getSize() >= UploadedFile::getMaxFilesize())
        {
            $this->__errors []= MediaUploader::MEDIA_UPLOAD_ERRORS['size_limit_exits'];
        }
        $this->log();
	}

    // returns Symfony\Component\HttpFoundation\File\File or null
	public function upload($fileName = null)
	{
        try
        {
        	$destinationDir = str_replace('\\', '\\\\', $this->__storagePath);
            if(File::makeDirectory($destinationPath, 0775, true))
            {
                Log::error(MediaUploader::LOG_PREFIX . '[' . MediaUploader::MEDIA_UPLOAD_ERRORS['directory_create_error'] . ']');
                $__errors []= MediaUploader::MEDIA_UPLOAD_ERRORS['unknown'];
                return null;
            }  
            //Move Uploaded File
            $serverFile = $this->__uploadedFile->move($destinationPath, $fileName ? $fileName : ProductMedia::uuid() . '.' . $this->__uploadedFile->getClientOriginalExtension());
            if(!$serverFile)
            {
                Log::critical(MediaUploader::LOG_PREFIX . '[' . MediaUploader::MEDIA_UPLOAD_ERRORS['file_move_error'] . ']');
                $__errors []= MediaUploader::MEDIA_UPLOAD_ERRORS['unknown'];
                return null;
            }      
            Log::info(MediaUploader::LOG_PREFIX . '[ Uploading image success to ' . $serverFile->getRealPath() . ']');
            return $serverFile;
        }
        catch(FileException $fe)
        {
            Log::critical(MediaUploader::LOG_PREFIX . '[ Upload failed: ' . $fe->getMessage() . ']');
            $__errors []= MediaUploader::MEDIA_UPLOAD_ERRORS['unknown'];
        }
        return null;
	}	

    public static function isSupportedExtention($extension)
    {
        foreach(ProductMedia::SUPPORTED_MEDIA_EXTENSIONS[ProductMedia::MEDIA_TYPES[1]] as $ext)
        {
            if($ext == $extension)
                return true;
        }
        return false;
    }
}