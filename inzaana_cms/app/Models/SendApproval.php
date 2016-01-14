<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SendApproval extends Model
{
     protected table = 'send_approvals';
	 
	 public function user()
	 {
		return $this->belongsTo('App\User');
	 }
	 public function product()
	 {
		return $this->belongsTo('App\Product');
	 }
	 public function plan()
	 {
		return $this->belongsTo('App\Plan');
	 }
	 
}
