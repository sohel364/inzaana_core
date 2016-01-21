<?php

namespace Inzaana;

use Illuminate\Database\Eloquent\Model;

class SendApproval extends Model
{
     protected table = 'send_approvals';
	 
	 public function user()
	 {
		return $this->belongsTo('Inzaana\User');
	 }
	 public function product()
	 {
		return $this->belongsTo('Inzaana\Product');
	 }
	 public function plan()
	 {
		return $this->belongsTo('Inzaana\Plan');
	 }
	 
}
