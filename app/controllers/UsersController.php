<?php

class UsersController extends BaseController {

  public function __construct() {
   $this->beforeFilter('csrf', array('on'=>'post'));
  }

  //Make a new user
  public function postCreate() {
    $validator = Validator::make(Input::all(), User::$rules);

    if($validator->passes()) {
      $user = new User;
      $user->username = Input::get('username');
      $user->password = Hash::make(Input::get('password'));
      $user->email = Input::get('email');
      $user->save();

      return Redirect::to('users/login')->with('message', 'Thanks for registering!');
    }
    return Redirect::to('users/register')->with('message', 'Errors have occured')->withErrors($validator)->withInput();
  }

  //Authenticate a login
  public function postLogin() {
    $validator = Validator::make(Input::all(), User::$rules);
    if(Auth::attempt(array("username" => Input::get("username"), "password" => Input::get("password")))) {
      return Redirect::to('/')->with('message', 'Logged in!');
    }
    return Redirect::to('users/login')->with('message', 'Invalid Login Credentials');
  }

  //Logout
  public function destroy() {
    Auth::logout();
    return Redirect::home()->with('message', 'Logged out!');
  }

  //Display login form
  public function getLogin() {
    return View::make('users.login');
  }

  //Display registration form
  public function getRegister() {
    return View::make('users.register');
  }

  //Display user profile page
  public function getUser($username) {
    return View::make('users.view')->with('username', $username);
  }
}
?>
