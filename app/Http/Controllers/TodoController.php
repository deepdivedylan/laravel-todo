<?php
namespace App\Http\Controllers;

class TodoController extends Controller {
	/*
	  |--------------------------------------------------------------------------
	  | Todo Controller
	  |--------------------------------------------------------------------------
	  |
	  | This controller is for the todos
	  |
	  */

	/**
	 * Create a new controller instance.
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Show the todos to the user
	 *
	 * @return Response
	 */
	public function index() {
		$todos = \App\Todo::get()->where('user_id',\Auth::user()->id);
		return \View::make('todos.index', array('todos' => $todos));
	}

	/**
	 * Edit the todo
	 *
	 * @return Response
	 */
	public function edit($id) {
		$todo = \App\Todo::find($id);
		if($todo->user_id == \Auth::user()->id) {
			return \View::make('todos.edit', array('todo' => $todo));
		} else {
			return \View::make('todos.error', array('message' => 'You don\'t have permission to edit this todo'));
		}
	}

	/**
	 * Create the todo
	 *
	 * @return Response
	 */
	public function create() {
		return \View::make('todos.create');
	}


	/**
	 * Store the todo
	 *
	 * @return Response
	 */
	public function store() {
		// validate
		// read more on validation at http://laravel.com/docs/validation
		$rules = array(
			'description' => 'required'
		);
		$validator = \Validator::make(\Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return \Redirect::to('todos/create')
				->withErrors($validator);
		} else {
			// store
			$todo = new \App\Todo();
			$todo->user_id = \Auth::user()->id;
			$todo->description = \Input::get('description');
			$todo->save();

			//get all todos and return them
			$todos = \App\Todo::get()->where('user_id',\Auth::user()->id);
			return \View::make('todos.index', array('todos' => $todos));
		}
	}


	/**
	 * Update the todo
	 *
	 * @return Response
	 */
	public function update($id) {
		// validate
		// read more on validation at http://laravel.com/docs/validation
		$rules = array(
			'description' => 'required'
		);
		$validator = \Validator::make(\Input::all(), $rules);

		// process the login
		if($validator->fails()) {
			return \Redirect::to('todos/create')
				->withErrors($validator);
		} else {
			// store
			$todo = \App\Todo::find($id);
			if($todo->user_id == \Auth::user()->id) {
				$todo->description = \Input::get('description');
				$todo->save();

				//get all todos and return them
				$todos = \App\Todo::get()->where('user_id', \Auth::user()->id);
				return \View::make('todos.index', array('todos' => $todos));
			} else {
				return \View::make('todos.error', array('message' => 'You don\'t have permission to edit this todo'));
			}
		}
	}

	/**
	 * Delete the todo
	 *
	 * @return Response
	 */
	public function delete($id)
	{
		$todo = \App\Todo::find($id);
		if($todo->user_id == \Auth::user()->id) {
			$todo->delete($id);
			//get all todos and return them
			$todos = \App\Todo::get()->where('user_id',\Auth::user()->id);
			return \View::make('todos.index', array('todos' => $todos));
		} else {
			return \View::make('todos.error', array('message' => 'You don\'t have permission to edit this todo'));
		}
	}
}