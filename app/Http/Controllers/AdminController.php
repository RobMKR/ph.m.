<?php

namespace App\Http\Controllers;

use App\RoleGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\User as User;
use App\Department as Department;
use App\Ticket as Ticket;
use App\NotificationLog as Log;
use App\Http\Requests;
use Config;
use Validator;
use Session;

class AdminController extends Controller
{
    /**
     * Admin Panel Home Page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	public function index(){
    	// Getting User Level
    	$user_level = Auth::user()->getLevel();
    	switch($user_level){
    		case 2:
    			$users = User::whereIn('role', ['user','staff'])->get();
    			break;
    		case 3:
    			$users = User::where('role', '!=', 'superadmin')->get();
    			break;
			default:
				$users = [];
    	}
        return view('admin/home')->with('users', $users);
    }

    /**
     * Admin Panel Edit Account
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editAccount(Request $request){
        // Getting User
        $user = Auth::user();

        // Post Data
        if($request->isMethod('post')){
            // Validating other fields
            $this->validate($request, [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users,email,'.$user->id,
                'password' => 'min:6|old_password:' . Auth::user()->password,
                'new_password' => 'confirmed|min:6',
                'new_password_confirmation' => 'min:6'
            ]);
            $update['name'] = $request->name;
            $update['email'] = $request->email;

            if(!empty($request->new_password)){
                 $update['password'] = bcrypt($request->new_password);
            }

            // Updating model
            if (!$user->update($update)) {
                return Redirect::back()
                    ->withErrors(['Something wrong happened while saving your model'])
                    ->withInput();
            }

            // Account Updated,  redirect to index
            Session::flash('success', 'Account Succesfully Updated');
            return redirect()->action('AdminController@index');
        }

        return view('admin/edit_account')->with('data', $user);
    }

    /**
     * Edit User
     *
     * @param $request
     * @param $id
     * @return view
     */
    public function editUser(Request $request, $id){
    	// Decoding Id
    	$id = $this->decode($id);

    	// Getting User
		$user = User::find($id);

		// Redirect with errors, if incorrect id has passed
    	if(empty($user)){
    		return Redirect::back()->withErrors(['User Not Found']);
    	}

    	// Post Data
    	if($request->isMethod('post')){
    		$this->validate($request, [
	            'name' => 'required|max:255',
	            'email' => 'required|email|max:255|unique:users,email,'.$id,
	            'role_group' => 'required|exists:role_groups,id',
	        ]);

	        if (!$user->update(Input::all())) {
        		return Redirect::back()
                ->withErrors(['Something wrong happened while saving your model'])
                ->withInput();
    		}

    		Session::flash('success', 'User Successfully Updated');
    		return redirect()->action('AdminController@index');
    	}

    	// Creating View Data
    	$viewData['user'] = $user;

    	// Getting Available Roles for User
    	$viewData['role_groups'] = RoleGroup::pluck('name', 'id');

    	return view('admin/edit_user')->with('data', $viewData);
    }

    /**
     * Delete User
     *
     * @return redirect
     */
    public function deleteUser($id){
    	// Decoding Id
    	$id = $this->decode($id);

    	// Getting User
		$user = User::find($id);

		// Redirect with errors, if incorrect id has passed
    	if(empty($user) || Auth::user()->getLevel($user->role) > Auth::user()->getLevel()){
    		return Redirect::back()->withErrors(['User Not Found']);
    	}

    	if($user->delete($id)){
    		Session::flash('success', 'User Succesfully Deleted');
    		return redirect()->action('AdminController@index');
    	}
    }
}
