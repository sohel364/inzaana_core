<?php

namespace Inzaana\MediaUploader;

use File;

class ImageUploader extends MediaUploader
{
	const IMAGE_STORAGE_PATH = '/images';

	private $__errors = [];

	public function __construct($context = 'products')
	{
		$__mediaType = ProductMedia::MEDIA_TYPES[0];
		$__storagePath = MediaUploader::STORAGE_PATH . self::IMAGE_STORAGE_PATH . '/' . $context;
	}

	public function fails()
	{
		return !collect($__errors)->isEmpty();
	}

	public function validate(UploadedFile $uploadedFile)
	{
		$__uploadedFile = $uploadedFile;

        if (!$__uploadedFile->isValid())
        {
            $__errors['corrupted_media_file'] = 'Upladed image file is corrupted';
            flash()->error($__errors['corrupted_media_file']);
            return $__errors;
        }

        if($__uploadedFile->getSize() >= $__uploadedFile->getMaxFilesize())
        {
            $__errors['size_limit_exits'] = 'Please keep your image file size below ' . ($__uploadedFile->getMaxFilesize() / 1000) . ' KB';
            flash()->warning($__errors['size_limit_exits']);
            return $__errors;
        }
        if(!self::isSupportedExtension($__uploadedFile->getClientOriginalExtension()))
        {
            $__errors['ext_not_supported'] = 'Upladed image file (*.' . $__uploadedFile->getClientOriginalExtension() . ') is not supported!';
            flash()->warning($__errors['ext_not_supported']);
            return $__errors;
        }

        $this->log();
        return $__errors;
	}

	public function upload($fileName)
	{
        try
        {
        	$destinationDir = str_replace('\\', '\\\\', $__storagePath);
            if(File::makeDirectory($destinationPath . '/' . $fileName, 0775, true))
            {
                $errors['directory_create_error'] = 'Upladed file destination directory not created!';
                Log::error(MediaUploader::LOG_PREFIX . '[' . $errors['directory_create_error'] . ']');
                flash()->error('Something went wrong during upload. We have already logged the problems. Please contact Inzaana help line for further assistance.');
                return $errors;
            }  
            //Move Uploaded File
            $serverFile = $__uploadedFile->move($destinationPath, $__uploadedFile->getClientOriginalName());
            if(!$serverFile)
            {
                $errors['file_move_error'] = 'Upladed file did not move!';
                Log::error(MediaUploader::LOG_PREFIX . '[' . $errors['file_move_error'] . ']');
                flash()->error('Something went wrong during upload. We have already logged the problems. Please contact Inzaana help line for further assistance.');
                return $errors;
            }      
            Log::info(MediaUploader::LOG_PREFIX . '[ Uploading image success to ' . $serverFile->getRealPath() . ']');
            return $serverFile->getBasename();
        }
        catch(FileException $fe)
        {
            $errors['unknown_file_error'] = MediaUploader::LOG_PREFIX . '[ Upload failed: ' . $fe->getMessage() . ']';
            Log::critical($errors['unknown_file_error']);
            return $errors;
        }
        return [];
	}	

    public static function isSupportedExtention($extension)
    {
        foreach(ProductMedia::SUPPORTED_MEDIA_EXTENSIONS as $ext)
        {
            if($ext == $extension)
                return true;
        }
        return false;
    }
}