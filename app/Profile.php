<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 **/
	protected $table = 'profiles';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 **/
	protected $fillable = ['bio'];

	/**
	 * DEFINE RELATIONSHIPS
	 * each profile belongs to one user
	 **/
	public function user() {
		return $this->belongsTo('User');
	}
}