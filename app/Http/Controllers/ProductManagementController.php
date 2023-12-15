<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreProductRequest;
use App\Http\Controllers\API\ProductController;

class ProductManagementController extends Controller
{
    /**
     * Instantiate a new ProductManagementController instance.
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
        return view('products.list');
    } 
    /**
     * Display a dashboard to authenticated users.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }
    /**
     * Store product view.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        if($request){
            $updateProduct= ProductController::createProduct($request->all());
            if($updateProduct['success'] == false){
                return redirect()->route('productlist')->withError('Something went wrong!!');
            }else{
                return redirect()->route('productlist')->withSuccess('Product Details Updated Successfully!');
            }            
        }else{
            return redirect()->route('productlist')->withError('Product Id Doesn;t exist!');
        }
    }
    /**
     * Edit product view.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        if(!empty($id)){
            $productInfo=ProductController::getProductInfo($id);
            if(count($productInfo['data']) != 0){
                $productInfo=$productInfo['data'];
                $productInfo['productId']=$id;
                return view('products.edit',compact('productInfo'));
            }            
        }else{
            return redirect('/product/list');
        }        
    } 
    /**
     * Update product view.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProductRequest $request)
    {
        if($request['productid']){
            $updateProduct= ProductController::updateProduct($request->all());
            if($updateProduct['success'] == false){
                return redirect()->route('productlist')->withError('Something went wrong!!');
            }else{
                return redirect()->route('productlist')->withSuccess('Product Details Updated Successfully!');
            }            
        }else{
            return redirect()->route('productlist')->withError('Product Id Doesn;t exist!');
        }
    }
    
}