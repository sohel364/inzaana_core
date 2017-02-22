<?php

namespace Inzaana\MediaUploader;

use File;
use Log;
use Inzaana\ProductMedia;
use Inzaana\MediaUploader\MediaUploader;

use \Symfony\Component\HttpFoundation\File\UploadedFile;
use \Symfony\Component\HttpFoundation\File\Exception\FileException;

class ImageUploader extends MediaUploader
{
	const IMAGE_STORAGE_PATH = '/images';

	private $__errors = [];

	public function __construct($context)
	{
		$this->__mediaType = 'IMAGE';
		$this->__storagePath = storage_path(MediaUploader::STORAGE_PATH . self::IMAGE_STORAGE_PATH . '/' . $context . '/');
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
        if (!$this->__uploadedFile->isValid())
        {
            $this->__errors []= MediaUploader::MEDIA_UPLOAD_ERRORS['corrupted_media_file'];
        }
        if(!$this->isSupportedExtension())
        {
            $this->__errors []= MediaUploader::MEDIA_UPLOAD_ERRORS['ext_not_supported'] . '(Supported: ' . ProductMedia::tidyMimes($this->__mediaType) . ')';
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
        	$destinationDir = $this->__storagePath;
            if(!File::exists($destinationDir))
            {
                if(!File::makeDirectory($destinationDir, 0775, true))
                {
                    Log::error(MediaUploader::LOG_PREFIX . '[' . MediaUploader::MEDIA_UPLOAD_ERRORS['directory_create_error'] . ']');
                    $this->__errors []= MediaUploader::MEDIA_UPLOAD_ERRORS['unknown'];
                    return null;
                }  
            }
            //Move Uploaded File
            $serverFileName = $fileName ?: ProductMedia::uuid() . '.' . $this->__uploadedFile->getClientOriginalExtension();
            //dd($serverFileName);
            $beforeMoveFileSize = $this->__uploadedFile->getSize();
            $serverFile = $this->__uploadedFile->move($destinationDir, $serverFileName);
            if(!$serverFile || ($serverFile->getSize() != $beforeMoveFileSize))    
            {
                Log::critical(MediaUploader::LOG_PREFIX . '[' . MediaUploader::MEDIA_UPLOAD_ERRORS['file_move_error'] . ']');
                $this->__errors []= MediaUploader::MEDIA_UPLOAD_ERRORS['unknown'];
                return null;
            }      
            Log::info(MediaUploader::LOG_PREFIX . '[ Uploading image success to ' . $serverFile->getRealPath() . ']');
            return $serverFile;
        }
        catch(FileException $fe)
        {
            Log::critical(MediaUploader::LOG_PREFIX . '[ Upload failed: ' . $fe->getMessage() . ']');
            $this->__errors []= MediaUploader::MEDIA_UPLOAD_ERRORS['unknown'];
        }
        return null;
	}	

    private function isSupportedExtension()
    {
        foreach(ProductMedia::SUPPORTED_MEDIA_MIMES[$this->__mediaType] as $ext)
        {
            if($ext == strtolower($this->__uploadedFile->getClientOriginalExtension()))
                return true;
        }
        return false;
    }
}