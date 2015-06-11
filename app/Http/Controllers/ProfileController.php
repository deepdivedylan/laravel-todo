<?php
namespace App\Http\Controllers;

class ProfileController extends Controller {
	/*
	|--------------------------------------------------------------------------
	| Profile Controller
	|--------------------------------------------------------------------------
	|
	| This controller is for the profiles
	|
	*/

	/**
	 * Create a new controller instance.
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Show the profile to the user
	 *
	 * @return Response
	 */
	public function index() {
		$profile = \App\Profile::get()->where('user_id',\Auth::user()->id)->first();
		if($profile === null) {
			return \View::make('profile.create', array('profile' => $profile));
		} else {
			return \View::make('profile.index', array('profile' => $profile));
		}
	}
	/**
	 * Edit the profile
	 *
	 * @return Response
	 */
	public function edit() {
		$profile = \App\Profile::get()->where('user_id',\Auth::user()->id)->first();
		return \View::make('profile.edit', array('profile' => $profile));
	}

	/**
	 * Update the profile
	 *
	 * @return Response
	 */
	public function update()
	{
		// validate
		// read more on validation at http://laravel.com/docs/validation
		$rules = array(
			'bio' => 'required'
		);
		$validator = \Validator::make(\Input::all(), $rules);
		// process the login
		if ($validator->fails()) {
			return Redirect::to('profile.create')
				->withErrors($validator);
		} else {
			// store
			$profile = \App\Profile::get()->where('user_id',\Auth::user()->id)->first();
			if($profile === null) {
				$profile = new \App\Profile();
				$profile->user_id = \Auth::user()->id;
			}
			$profile->bio = \Input::get('bio');
			$profile->save();
			return \View::make('profile.index', array('profile' => $profile));
		}
	}
}