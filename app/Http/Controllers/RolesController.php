<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\RoleGroup as RoleGroup;
use Validator;
use Session;

class RolesController extends Controller
{
    /**
     * Manage Role Groups Page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function groups(){
        $viewData['roles_aliases'] = json_encode(config('roles_aliases'), true);
        $viewData['groups'] = RoleGroup::all();
        return view('superadmin/groups')->with('data',$viewData);
    }

    /**
     * Create Role Group
     *
     * @param $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createGroup(Request $request){
        // Post Data
        if($request->isMethod('post')){
            $RoleGroup = new RoleGroup();
            // Validating other fields
            $this->validate($request, [
                'name' => 'required|max:255|unique:role_groups,name',
            ]);

            // Trying to create JSON object
            if($options = json_encode($request->roles)){
                $RoleGroup->name = $request->name;
                $RoleGroup->options = $options;

                // Saving
                $RoleGroup->save();
            }else{
                return Redirect::back()
                    ->withErrors(['Something wrong happened while saving your model'])
                    ->withInput();
            }

            // Setting Succes flash and redirect back to groups page
            Session::flash('success', 'Role Group Succesfully Created');
            return redirect()->action('RolesController@groups');
        }

        $viewData['roles'] = config('roles');
        $viewData['roles_aliases'] = config('roles_aliases');
        return view('superadmin/create_group')->with('data', $viewData);
    }

    /**
     * Edit Role Group
     *
     * @param $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editGroup(Request $request, $id){
        // Decoding id
        $id = $this->decode($id);

        // Getting Group
        $group = RoleGroup::find($id);

        // Redirect with errors, if incorrect id has passed
        if(empty($group)){
            return Redirect::back()->withErrors(['Group Not Found']);
        }

        // Post Data
        if($request->isMethod('post')){
            // Validating other fields
            $this->validate($request, [
                'name' => 'required|max:255|unique:role_groups,name,'.$group->id,
            ]);

            // Trying to create JSON object
            if($options = json_encode($request->roles)){
                $update['name'] = $request->name;
                $update['options'] = $options;

                // Saving
                $group->update($update);
            }else{
                return Redirect::back()
                    ->withErrors(['Something wrong happened while saving your model'])
                    ->withInput();
            }

            // Setting Succes flash and redirect back to groups page
            Session::flash('success', 'Role Group Successfully Updated');
            return redirect()->action('RolesController@groups');
        }

        $viewData['roles'] = config('roles');
        $viewData['roles_aliases'] = config('roles_aliases');
        $viewData['group'] = $group;
        $viewData['options'] = json_decode($group->options, true);
        return view('superadmin/edit_group')->with('data', $viewData);
    }

    /**
     * Delete Role Group
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function deleteGroup($id){
        // Decoding id
        $id = $this->decode($id);

        // Getting Group
        $group = RoleGroup::find($id);

        // Redirect with errors, if incorrect id has passed
        if(empty($group)){
            return Redirect::back()->withErrors(['Group Not Found']);
        }

        // Delete Group
        if($group->delete($id)){
            // Redirect with success flash message
            Session::flash('success', 'Group Successfully Deleted');
            return redirect()->action('AdminController@group');
        }
    }
}
