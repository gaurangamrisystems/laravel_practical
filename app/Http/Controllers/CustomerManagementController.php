<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Controllers\API\CustomerController;

class CustomerManagementController extends Controller
{
    /**
     * Instantiate a new CustomerManagementController instance.
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
        return view('customer.list');
    } 
    /**
     * Display a dashboard to authenticated users.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer.create');
    }
    /**
     * Store Customer view.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    {
        if($request){
            $updateProduct= CustomerController::createCustomer($request->all());
            if($updateProduct['success'] == false){
                return redirect()->route('customerlist')->withError($updateProduct['message']);
            }else{
                return redirect()->route('customerlist')->withSuccess($updateProduct['message']);
            }            
        }else{
            return redirect()->route('customerlist')->withError('Customer Id Doesn;t exist!');
        }
    }
    /**
     * Edit Customer view.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        if(!empty($id)){
            $customerInfo=CustomerController::getcustomerInfo($id);
            if(count($customerInfo['data']) != 0){
                $customerInfo=$customerInfo['data'];
                $customerInfo['customerid']=$id;
                return view('customer.edit',compact('customerInfo'));
            }            
        }else{
            return redirect('/customer/list');
        }        
    } 
    /**
     * Update Customer view.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCustomerRequest $request)
    {
        if($request['customerid']){
            $updateProduct= CustomerController::updateCustomer($request->all());
            if($updateProduct['success'] == false){
                return redirect()->route('customerlist')->withError($updateProduct['message']);
            }else{
                return redirect()->route('customerlist')->withSuccess($updateProduct['message']);
            }            
        }else{
            return redirect()->route('customerlist')->withError('Customer Id Doesn;t exist!');
        }
    }
    
}