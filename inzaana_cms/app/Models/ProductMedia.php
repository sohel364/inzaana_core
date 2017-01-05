<?php

namespace Inzaana;

use Illuminate\Database\Eloquent\Model;

class ProductMedia extends Model
{
	const MEDIA_TYPES = ['UNKNOWN', 'IMAGE', 'AUDIO', 'VIDEO'];
    const SUPPORTED_MEDIA_EXTENSIONS = [ 'jpg', 'jpeg', 'gif' ];

    protected $table = 'product_medias';

    /**
     * Get all of the owning mediable models.
     */
    public function mediable()
    {
        return $this->morphTo();
    }

    public function getTitleAttribute($value)
    {
    	$faker = new Faker\Generator();
		$faker->addProvider(new Faker\Provider\Uuid($faker));
    	return $faker->unique()->uuid;
    }
}
