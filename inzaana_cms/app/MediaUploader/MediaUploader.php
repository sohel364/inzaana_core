<?php

namespace Inzaana\MediaUploader;

use Log;
use \Symfony\Component\HttpFoundation\File\UploadedFile;

abstract class MediaUploader
{
	protected $__mediaType = null;
	protected $__storagePath = '/';
	protected $__uploadedFile;

	const STORAGE_PATH = 'app/media-archive';
	const LOG_PREFIX = '[Inzaana]';
	const MEDIA_UPLOAD_ERRORS = [ 
		'corrupted_media_file' => 'Uploaded media file is corrupted.',
		'size_limit_exits' => 'Please keep your media to the recommended file size',
		'ext_not_supported' => 'Uploaded media file is not supported!',
		'directory_create_error' => 'Uploaded file destination directory not created!',
		'file_move_error' => 'Uploaded file did not move!',
		'unknown' => 'Something went wrong during upload. We have already logged the problems. Please contact Inzaana help line for further assistance.'
	];

	abstract protected function validate(UploadedFile $uploadedFile);
	abstract protected function upload($fileName);

	protected function log()
	{
		Log::info(self::LOG_PREFIX . '[Media name: ' . $this->__uploadedFile->getClientOriginalName() . ']');
		Log::info(self::LOG_PREFIX . '[Media size: ' . ($this->__uploadedFile->getSize()/ 1000) . ' KB]');
		Log::info(self::LOG_PREFIX . '[Media type: ' . $this->__mediaType . ']');
	}
}

