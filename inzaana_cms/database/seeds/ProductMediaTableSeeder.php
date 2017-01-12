<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\File;
use Inzaana\Log;
use Inzaana\Exception;
use Inzaana\MediaUploader\MediaUploader;
use Inzaana\MediaUploader\ImageUploader;
use Inzaana\MediaUploader\VideoUploader;

class ProductMediaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$contexts = [ 'products', 'users' ];
    	$mediaGroups = [ ImageUploader::IMAGE_STORAGE_PATH, VideoUploader::VIDEO_STORAGE_PATH ];
    	foreach($mediaGroups as $mediaGroup)
        {
        	foreach($contexts as $context)
        	{
    			try
    			{
	        		$mediaDirectory = storage_path(MediaUploader::STORAGE_PATH . $mediaGroup . '/' . $context . '/');
    				echo 'Seeding :[' . $mediaDirectory . "][status:" . (File::exists($mediaDirectory) ? 'EXIST' : 'NOT-EXIST') . "]\n";
		            if(File::exists($mediaDirectory))
		            	continue;
		            if(!File::makeDirectory($mediaDirectory, 0777, true))
		            {
		                Log::error(MediaUploader::LOG_PREFIX . '[' . MediaUploader::MEDIA_UPLOAD_ERRORS['directory_create_error'] . ']');
		                continue;
		                Log::info(MediaUploader::LOG_PREFIX . '[ ' . $context . ' archive created to: ' . $mediaDirectory . ']');
		            }    				
    			}
    			catch(\Exception $e)
    			{
    				Log::error(MediaUploader::LOG_PREFIX . '[ ' . $e->getMessage() . ' ]');
    			} 
        	}
        }
    }
}
