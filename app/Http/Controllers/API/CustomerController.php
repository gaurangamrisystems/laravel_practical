<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;

class CustomerController extends BaseController
{
    public function __construct(){
        $this->customerDataUrl="https://api.hubapi.com/contacts/v1/lists/all/contacts/all";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $url = $this->customerDataUrl;
        $headers = ['Authorization: Bearer '.env('YOUR_ACCESS_TOKEN')];

        try {
            $response = makeCurlRequest($url,'GET', $headers);
            $customerMainArray=array();
            if($response['http_status'] == 200){
                // Handle the response as needed
                $customerData=json_decode($response['response'],true);               
                if(count($customerData)>0){
                    $customersInfo=$customerData['contacts'];     
                    $i=1;           
                    foreach($customersInfo as $customer){
                        $properties=$customer['properties'];
                        $emailPropertiesInfo=$customer['identity-profiles'][0]['identities'][0];
                        $url=url('customer/edit').'/'.$customer['canonical-vid'];
                        $customerArray['DT_RowIndex']=$i;
                        $customerArray['email']=($emailPropertiesInfo['type']=="EMAIL")?$emailPropertiesInfo['value']:'-';
                        $customerArray['firstname']=($properties['firstname'])?$properties['firstname']['value']:'-';
                        $customerArray['lastname']=($properties['lastname'])?$properties['firstname']['value']:'-';
                        $customerArray['company']=($properties['company'])?$properties['firstname']['value']:'-';
                        $customerArray['action']='<a href="'.$url.'" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete_customer btn btn-danger btn-sm" onclick="deleteContact('.$customer['canonical-vid'].')">Delete</a>';
                        $customerMainArray[]=$customerArray;
                        $i++;
                    }
                }
                
            }
            $response = [
                'success'         => true,
                'draw'            => 10,
                'recordsTotal'    => count($customerMainArray),
                'recordsFiltered' => count($customerMainArray),
                'data'            => $customerMainArray,
                'message'         => 'Customer Retrieved Successfully.',
            ];
            return $this->sendResponse($response);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }        
    } 
    /**
     * Create a customer.
     *
     * @return \Illuminate\Http\Response
     */
    public static function createCustomer($requestData){
        if($requestData){
            $url = 'https://api.hubapi.com/contacts/v1/contact';
            $headers = ['Authorization: Bearer '.env('YOUR_ACCESS_TOKEN')];
            try {
                $data = array(
                    "properties"=>array(
                        array(
                            "property"=> "email",
                            "value"=> $requestData['email']
                        ),
                        array(
                            "property"=> "firstname",
                            "value"=> $requestData['firstname']
                        ),
                        array(
                            "property"=> "lastname",
                            "value"=> $requestData['lastname']
                        ),
                        array(
                            "property"=> "company",
                            "value"=> $requestData['company']
                        ),
                    )
                );
                $response = makeCurlRequest($url,'POST',$headers,$data);
                if($response['http_status'] == "200"){
                    $response = [
                        'success'         => true,
                        'message'         => 'customers updated Successfully.'
                    ];
                    
                }
                else if($response['http_status'] == "409"){
                    $response = [
                        'success'         => true,
                        'message'         => $response['message']
                    ];
                    
                }
                else{
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
                'message'         => 'customer Information not exist!!',
            ];
            return $response;
        }
    }
    /**
     * Destroy a selected customer.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        // Example usage:
        $url = "https://api.hubapi.com/contacts/v1/contact/vid/".$id;
        $headers = ['Authorization: Bearer '.env('YOUR_ACCESS_TOKEN')];

        try {            
            $response = makeCurlRequest($url,'DELETE', $headers);
            if($response['http_status'] == 200){
                // Handle the response as needed
                $response = [
                    'success'         => true,
                    'message'         => 'customers deleted Successfully.',
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
     * Get a selected customer information.
     *
     * @return \Illuminate\Http\Response
     */

    public static function getcustomerInfo($id){
        $url = 'https://api.hubapi.com/contacts/v1/contact/vid/'.$id.'/profile';
        $headers = ['Authorization: Bearer '.env('YOUR_ACCESS_TOKEN')];
        try {
            $response = makeCurlRequest($url,'GET', $headers);
            if($response['http_status'] == 200){
                $customerData=json_decode($response['response'],true);
                $customerMainArray=array();
                if(!empty($customerData)){     
                    $customerProperties=$customerData['properties'];                
                    $customerArray['email']=($customerProperties['email'])?$customerProperties['email']['value']:'-';
                    $customerArray['firstname']=($customerProperties['firstname'])?$customerProperties['firstname']['value']:'-';
                    $customerArray['lastname']=($customerProperties['lastname'])?$customerProperties['lastname']['value']:'-';
                    $customerArray['company']=($customerProperties['company'])?$customerProperties['company']['value']:'-';
                }
                $response = [
                    'success'         => true,
                    'message'         => 'customers detail fetch Successfully.',
                    'data'            => $customerArray
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
     * update a selected customer information.
     *
     * @return \Illuminate\Http\Response
     */
    public static function updatecustomer($requestData){
        if($requestData['customerid']){
            $url = 'https://api.hubapi.com/contacts/v1/contact/vid/'.trim($requestData['customerid']).'/profile';
            $headers = ['Authorization: Bearer '.env('YOUR_ACCESS_TOKEN')];
            try {
                $data = array(
                    "properties"=>array(
                        array(
                            "property"=> "email",
                            "value"=> $requestData['email']
                        ),
                        array(
                            "property"=> "firstname",
                            "value"=> $requestData['firstname']
                        ),
                        array(
                            "property"=> "lastname",
                            "value"=> $requestData['lastname']
                        ),
                        array(
                            "property"=> "company",
                            "value"=> $requestData['company']
                        ),
                    )
                );
                $response = makeCurlRequest($url,'POST',$headers,$data);
                if($response['http_status'] == "204"){
                    
                    $response = [
                        'success'         => true,
                        'message'         => 'customers updated Successfully.'
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
                'message'         => 'customers Id not exists.',
            ];
            return $response;
        }        
    }
}