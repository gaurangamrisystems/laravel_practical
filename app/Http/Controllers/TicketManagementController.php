<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Controllers\API\TicketController;

class TicketManagementController extends Controller
{
    /**
     * Instantiate a new TicketManagementController instance.
     */
    public function __construct()
    {
        if(!Auth::check()){
            return view('auth.login');
        }
    }    
    /**
     * Display a dashboard to authenticated users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tickets.list');
    } 
    /**
     * Display a dashboard to authenticated users.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tickets.create');
    }
    /**
     * Store Ticket view.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTicketRequest $request)
    {
        if($request){
            $updateTicket= TicketController::createTicket($request->all());
            if($updateTicket['success'] == false){
                return redirect()->route('ticketlist')->withError('Something went wrong!!');
            }else{
                return redirect()->route('ticketlist')->withSuccess('Ticket Details Updated Successfully!');
            }            
        }else{
            return redirect()->route('ticketlist')->withError('Ticket Id Doesn;t exist!');
        }
    }
    /**
     * Edit Ticket view.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        if(!empty($id)){
            $TicketInfo=TicketController::getTicketInfo($id);
            if(count($TicketInfo['data']) != 0){
                $ticketInfo=$TicketInfo['data'];
                $ticketInfo['ticketid']=$id;
                return view('tickets.edit',compact('ticketInfo'));
            }            
        }else{
            return redirect('/Ticket/list');
        }        
    } 
    /**
     * Update Ticket view.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTicketRequest $request)
    {
        if($request['ticketid']){
            $updateTicket= TicketController::updateTicket($request->all());
            if($updateTicket['success'] == false){
                return redirect()->route('ticketlist')->withError('Something went wrong!!');
            }else{
                return redirect()->route('ticketlist')->withSuccess('Ticket Details Updated Successfully!');
            }            
        }else{
            return redirect()->route('ticketlist')->withError('Ticket Id Doesn;t exist!');
        }
    }
    
}