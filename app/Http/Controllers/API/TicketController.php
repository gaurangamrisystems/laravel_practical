<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;

class TicketController extends BaseController
{
    public function __construct(){
        $this->ticketUrl="https://api.hubapi.com/crm-objects/v1/objects/tickets/";
        $this->ticketSearch="properties=subject&properties=content&properties=hs_pipeline&properties=hs_pipeline_stage";
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $url = $this->ticketUrl.'paged?'.$this->ticketSearch;
        $headers = ['Authorization: Bearer '.env('YOUR_ACCESS_TOKEN')];

        try {
            $response = makeCurlRequest($url,'GET', $headers);
            $ticketMainArray=array();
            if($response['http_status'] == 200){
                // Handle the response as needed
                $ticketData=json_decode($response['response'],true);
                $ticketlist=$ticketData['objects'];
                
                if(count($ticketlist)>0){     
                    $i=1;           
                    foreach($ticketlist as $tickets){
                        $url=url('ticket/edit').'/'.$tickets['objectId'];
                        $ticketArray['DT_RowIndex']=$i;
                        $ticketArray['subject']=(isset($tickets['properties']['subject']))?$tickets['properties']['subject']['versions'][0]['value']:'-';
                        $ticketArray['content']=($tickets['properties']['content'])?$tickets['properties']['content']['versions'][0]['value']:'-';
                        $ticketArray['action']='<a href="'.$url.'" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete_ticket btn btn-danger btn-sm" onclick="deleteticket('.$tickets['objectId'].')">Delete</a>';
                        $ticketMainArray[]=$ticketArray;
                        $i++;
                    }
                }
                              
            }
            $response = [
                'success'         => true,
                'draw'            => 10,
                'recordsTotal'    => count($ticketMainArray),
                'recordsFiltered' => count($ticketMainArray),
                'data'            => $ticketMainArray,
                'message'         => 'tickets Retrieved Successfully.',
            ];  
            return $this->sendResponse($response);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }        
    } 
    /**
     * Create a ticket.
     *
     * @return \Illuminate\Http\Response
     */
    public static function createticket($requestData){
        if($requestData){
            $url = 'https://api.hubapi.com/crm-objects/v1/objects/tickets/';
            $headers = ['Authorization: Bearer '.env('YOUR_ACCESS_TOKEN')];
            try {
                $data = array(
                    array(
                        "name"=> "subject",
                        "value"=> $requestData['subject']
                    ),
                    array(
                        "name"=> "content",
                        "value"=> $requestData['content']
                    ),
                    array(
                        "name"=> "hs_pipeline",
                        "value"=> "0"
                    ),
                    array(
                        "name"=> "hs_pipeline_stage",
                        "value"=> "1"
                    )
                );
                $response = makeCurlRequest($url,'POST',$headers,$data);
                if($response['http_status'] == "200"){
                    $response = [
                        'success'         => true,
                        'message'         => 'tickets created Successfully.'
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
                'message'         => 'ticket Information not exist!!',
            ];
            return $response;
        }
    }
    /**
     * Destroy a selected ticket.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Example usage:
        $url = $this->ticketUrl.$id;
        $headers = ['Authorization: Bearer '.env('YOUR_ACCESS_TOKEN')];

        try {            
            $response = makeCurlRequest($url,'DELETE', $headers);
            if($response['http_status'] == 204){
                // Handle the response as needed
                $response = [
                    'success'         => true,
                    'message'         => 'tickets deleted Successfully.',
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
     * Get a selected ticket information.
     *
     * @return \Illuminate\Http\Response
     */

    public static function getticketInfo($id){
        $url = 'https://api.hubapi.com/crm-objects/v1/objects/tickets/'.$id.'?properties=subject&properties=content&properties=created_by&properties=hs_pipeline&properties=hs_pipeline_stage
        ';
        $headers = ['Authorization: Bearer '.env('YOUR_ACCESS_TOKEN')];
        try {
            $response = makeCurlRequest($url,'GET', $headers);
            if($response['http_status'] == 200){
                $ticketData=json_decode($response['response'],true);

                $ticketArray=array();
                if(!empty($ticketData)){     
                    $ticketProperties=$ticketData['properties'];                
                    $ticketArray['subject']=(isset($ticketData['properties']['subject']))?$ticketData['properties']['subject']['versions'][0]['value']:'-';
                    $ticketArray['content']=($ticketData['properties']['content'])?$ticketData['properties']['content']['versions'][0]['value']:'-';
                }
                $response = [
                    'success'         => true,
                    'message'         => 'tickets detail fetch Successfully.',
                    'data'            => $ticketArray
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
     * update a selected ticket information.
     *
     * @return \Illuminate\Http\Response
     */
    public static function updateticket($requestData){
        if($requestData['ticketid']){
            $url = 'https://api.hubapi.com/crm-objects/v1/objects/tickets/'.trim($requestData['ticketid']);
            $headers = ['Authorization: Bearer '.env('YOUR_ACCESS_TOKEN')];
            try {
                $data = array(
                    array(
                        "name"=> "subject",
                        "value"=> $requestData['subject']
                    ),
                    array(
                        "name"=> "content",
                        "value"=> $requestData['content']
                    ),
                    array(
                        "name"=> "hs_pipeline",
                        "value"=> "0"
                    ),
                    array(
                        "name"=> "hs_pipeline_stage",
                        "value"=> "1"
                    )
                );
                $response = makeCurlRequest($url,'PUT',$headers,$data);
                if($response['http_status'] == 200){
                    $response = [
                        'success'         => true,
                        'message'         => 'tickets updated Successfully.'
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
                'message'         => 'tickets Id not exists.',
            ];
            return $response;
        }        
    }
}