<?php

namespace Inzaana;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'plans';
	 
	public function user()
    {
        return $this->belongsTo('Inzaana\User');
    }
	public function sendApprovals()
	{
		return $this->hasMany('Inzaana\SendApproval');
	}
}
