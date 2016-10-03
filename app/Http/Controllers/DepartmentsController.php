<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\User as User;
use App\Department as Department;
use App\Ticket as Ticket;
use App\NotificationLog as Log;
use App\Http\Requests;
use Validator;
use Session;

class DepartmentsController extends Controller
{

    /**
     * Manage Department Page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function manage(){
        // Redirect if user have not department
        if(!Auth::user()->department->id){
            return Redirect::back()->withErrors(['You are not admin of any department']);
        }
        // Getting Department
        $viewData['department'] = Auth::user()->department;
        return view('departments/manage')->with('data', $viewData);
    }

    /**
     * View Department Tickets
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tickets(){
        // Redirect if user have not department
        if(!Auth::user()->department->id){
            return Redirect::back()->withErrors(['You are not admin of any department']);
        }

        // Getting Department
        $department = Auth::user()->department;
        $viewData['department'] = $department;

        // Getting Tickets groupped by status
        $tickets = Ticket::where(['department_id' => $department->id, 'status' => 'accepted'])->get();
        $viewData['tickets'] = $tickets;

        // Getting Department Staff
        $viewData['staff'] = User::where('in_department', $department->id)->pluck('name', 'id');

        return view('departments/tickets')->with('data', $viewData);
    }

    /**
     * Staff Page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function staff(){
        $viewData['staff'] = User::where(['role' => 'admin'], ['in_department' => Auth::user()->department->id])->get();
        return view('departments/staff')->with('data', $viewData);
    }

    /**
     * AJAX REQUEST
     * Assign Ticket To User
     *
     * @param Request $request
     * @return JSON
     */
    public function assignTicketToStaff(Request $request){
        $ticket = Ticket::find($request->input('ticket'));
        if($ticket->update(['responsible_id' => $request->input('user'), 'status' => 'ongoing'])){
            $status = 'ok';
        }else{
            $status = 'error';
        }
        return response()->json(['status' => $status]);
    }
}
