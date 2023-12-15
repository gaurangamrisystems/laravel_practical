<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;

class ProductController extends BaseController
{
    public function __construct(){
        $this->productUrl="https://api.hubapi.com/crm-objects/v1/objects/products/";
        $this->productSearch="properties=name&properties=description&properties=price";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $url = $this->productUrl.'paged?'.$this->productSearch;
        $headers = ['Authorization: Bearer '.env('YOUR_ACCESS_TOKEN')];

        try {
            $response = makeCurlRequest($url,'GET', $headers);
            $productMainArray=array();
            if($response['http_status'] == 200){
                // Handle the response as needed
                $productData=json_decode($response['response'],true);
                $prodculist=$productData['objects'];
                
                if(count($prodculist)>0){     
                    $i=1;           
                    foreach($prodculist as $products){
                        $url=url('product/edit').'/'.$products['objectId'];
                        $productArray['DT_RowIndex']=$i;
                        $productArray['name']=($products['properties']['name'])?$products['properties']['name']['versions'][0]['value']:'-';
                        $productArray['description']=($products['properties']['description'])?$products['properties']['description']['versions'][0]['value']:'-';
                        $productArray['price']=($products['properties']['price'])?$products['properties']['price']['versions'][0]['value']:'-';
                        $productArray['action']='<a href="'.$url.'" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete_product btn btn-danger btn-sm" onclick="deleteProduct('.$products['objectId'].')">Delete</a>';
                        $productMainArray[]=$productArray;
                        $i++;
                    }
                }                
            }
            $response = [
                'success'         => true,
                'draw'            => 10,
                'recordsTotal'    => count($productMainArray),
                'recordsFiltered' => count($productMainArray),
                'data'            => $productMainArray,
                'message'         => 'Products Retrieved Successfully.',
            ];
            return $this->sendResponse($response);
            
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }        
    } 
    /**
     * Create a Product.
     *
     * @return \Illuminate\Http\Response
     */
    public static function createProduct($requestData){
        if($requestData){
            $url = 'https://api.hubapi.com/crm-objects/v1/objects/products/';
            $headers = ['Authorization: Bearer '.env('YOUR_ACCESS_TOKEN')];
            try {
                $data = array(
                    array(
                        "name"=> "name",
                        "value"=> $requestData['name']
                    ),
                    array(
                        "name"=> "description",
                        "value"=> $requestData['description']
                    ),
                    array(
                        "name"=> "price",
                        "value"=> number_format($requestData['price'],2)
                    ),
                );
                $response = makeCurlRequest($url,'POST',$headers,$data);
                if($response['http_status'] == "200"){
                    $response = [
                        'success'         => true,
                        'message'         => 'Products updated Successfully.'
                    ];
                    
                }else{
                    $response = [
                        'success'         => false,
                        'message'         => 'Something went wrong!!!'
                    ];
                }
                return $response;
            } catch (Exception $e) {
                return $e->getMessage();
            }  
        }else{
            $response = [
                'success'         => false,
                'message'         => 'Product Information not exist!!',
            ];
            return $response;
        }
    }
    /**
     * Destroy a selected product.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Example usage:
        $url = $this->productUrl.$id;
        $headers = ['Authorization: Bearer '.env('YOUR_ACCESS_TOKEN')];

        try {            
            $response = makeCurlRequest($url,'DELETE', $headers);
            if($response['http_status'] == 204){
                // Handle the response as needed
                $response = [
                    'success'         => true,
                    'message'         => 'Products deleted Successfully.',
                ];
                return $this->sendResponse($response);
            }else{
                return $this->sendError("Something went wrong!!!");
            }
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }   
    }
     /**
     * Get a selected product information.
     *
     * @return \Illuminate\Http\Response
     */

    public static function getProductInfo($id){
        $url = 'https://api.hubapi.com/crm-objects/v1/objects/products/'.$id.'?properties=name&properties=description&properties=price';
        $headers = ['Authorization: Bearer '.env('YOUR_ACCESS_TOKEN')];
        try {
            $response = makeCurlRequest($url,'GET', $headers);
            if($response['http_status'] == 200){
                $productData=json_decode($response['response'],true);
                $products=$productData;
                $productMainArray=array();
                if(!empty($products)){     
                    $productProperties=$products['properties'];                
                    $productArray['name']=($productProperties['name'])?$productProperties['name']['value']:'-';
                    $productArray['description']=($productProperties['description'])?$productProperties['description']['value']:'-';
                    $productArray['price']=($productProperties['price'])?$productProperties['price']['value']:'-';
                }
                $response = [
                    'success'         => true,
                    'message'         => 'Products detail fetch Successfully.',
                    'data'            => $productArray
                ];               
            }else{
                $response = [
                    'success'         => false,
                    'message'         => 'Something went wrong!!!'
                ];
            }      
            return $response;      
        } catch (Exception $e) {
            return $e->getMessage();
        }  
    }
    /**
     * update a selected product information.
     *
     * @return \Illuminate\Http\Response
     */
    public static function updateProduct($requestData){
        if($requestData['productid']){
            $url = 'https://api.hubapi.com/crm-objects/v1/objects/products/'.trim($requestData['productid']);
            $headers = ['Authorization: Bearer '.env('YOUR_ACCESS_TOKEN')];
            try {
                $data = array(
                    array(
                        "name"=> "name",
                        "value"=> $requestData['name']
                    ),
                    array(
                        "name"=> "description",
                        "value"=> $requestData['description']
                    ),
                    array(
                        "name"=> "price",
                        "value"=> number_format($requestData['price'],2)
                    ),
                );
                $response = makeCurlRequest($url,'PUT',$headers,$data);
                if($response['http_status'] == 200){
                    $response = [
                        'success'         => true,
                        'message'         => 'Products updated Successfully.'
                    ];
                    
                }else{
                    $response = [
                        'success'         => false,
                        'message'         => 'Something went wrong!!!'
                    ];
                }
                return $response;
            } catch (Exception $e) {
                return $e->getMessage();
            }  
        }else{
            $response = [
                'success'         => false,
                'message'         => 'Products Id not exists.',
            ];
            return $response;
        }        
    }
}