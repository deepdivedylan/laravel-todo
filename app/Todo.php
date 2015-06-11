<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'todos';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['description'];

	/**
	 * DEFINE RELATIONSHIPS
	 * each todo belongs to one user
	 **/
	public function user() {
		return $this->belongsTo('User');
	}
}