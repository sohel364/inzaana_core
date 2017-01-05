<?php

namespace Inzaana\MediaUploader;

use Log;
use Inzaana\ProductMedia;

use \Symfony\Component\HttpFoundation\File\UploadedFile;
use \Symfony\Component\HttpFoundation\File\Exception\FileException;

abstract class MediaUploader
{
	const STORAGE_PATH = 'app/media-archive';
	const LOG_PREFIX = '[Inzaana]';

	protected $__mediaName = '';
	protected $__mediaSize = 0;
	protected $__mediaType = ProductMedia::MEDIA_TYPES[0];
	protected $__storagePath = '/';
	protected UploadedFile $__uploadedFile;

	abstract protected function validate(UploadedFile $uploadedFile);
	abstract protected function upload($fileName);

	protected function log()
	{
		Log::info(self::LOG_PREFIX . '[Media name: ' . $__mediaName . ']');
		Log::info(self::LOG_PREFIX . '[Media size: ' . $__mediaSize . ']');
		Log::info(self::LOG_PREFIX . '[Media type: ' . $__mediaType . ']');
	}
}

