<?php

namespace Inzaana\MediaUploader;

use Log;
use Inzaana\ProductMedia;

use \Symfony\Component\HttpFoundation\File\UploadedFile;
use \Symfony\Component\HttpFoundation\File\Exception\FileException;

abstract class MediaUploader
{
	protected $__mediaName = '';
	protected $__mediaSize = 0;
	protected $__mediaType = ProductMedia::MEDIA_TYPES[0];
	protected $__storagePath = '/';
	protected UploadedFile $__uploadedFile;

	const STORAGE_PATH = 'app/media-archive';
	const LOG_PREFIX = '[Inzaana]';
	const MEDIA_UPLOAD_ERRORS = [ 
		'corrupted_media_file' => 'Upladed media file is corrupted.',
		'size_limit_exits', => 'Please keep your media file size below ' . (UploadedFile::getMaxFilesize() / 1000) . ' KB.',
		'ext_not_supported' => 'Upladed media file is not supported!',
		'directory_create_error' => 'Upladed file destination directory not created!',
		'file_move_error' => 'Upladed file did not move!',
		'unknown' => 'Something went wrong during upload. We have already logged the problems. Please contact Inzaana help line for further assistance.'
	];

	abstract protected function validate(UploadedFile $uploadedFile);
	abstract protected function upload($fileName);

	protected function log()
	{
		Log::info(self::LOG_PREFIX . '[Media name: ' . $__mediaName . ']');
		Log::info(self::LOG_PREFIX . '[Media size: ' . $__mediaSize . ']');
		Log::info(self::LOG_PREFIX . '[Media type: ' . $__mediaType . ']');
	}
}

