<?php
namespace App\Controllers\Vendor;
use App\Controllers\BaseController;
use App\Models\Common_model;
class Driver extends BaseController {
    protected $c_model;
    public function __construct() {
        $this->c_model = new Common_model();
    }
    public function index() {
        $data = [];
        $data['title'] = 'Assign Driver';
        $data['menu'] = 'Assign Driver';
        $data['booking_details'] = !empty($this->request->getVar('booking_id')) ? $this->c_model->getSingle('bookings', 'id,booking_id,guest_name,guest_mobile_no,trip_type,pickup_city_name,DATE_FORMAT(pickup_date_time, "%d/%M/%Y  %r") as formatted_pickup_date_time,package_name,drop_city_name,driver_name,driver_mobile_no,vehicle_no', ['id' => $this->request->getVar('booking_id')]) : [];
        vendorView('assign-driver', $data);
    }
    public function assignDriver(){
        $post=$this->request->getVar();
        
        $driver_name = !empty($post['driver_name'])?$post['driver_name']:'';
        $driver_mobile_no = !empty($post['driver_mobile_no'])?$post['driver_mobile_no']:'';
        $vehicle_no = !empty($post['vehicle_no'])?$post['vehicle_no']:'';
        $booking_id = !empty($post['booking_id'])?$post['booking_id']:'';
        
        if(empty($driver_name)){
            $response = ['status'=>false,'message'=>'Enter Driver Name'];
            echo json_encode($response);exit;
        }
        if(empty($driver_mobile_no)){
            $response = ['status'=>false,'message'=>'Enter Driver Mobile Number'];
            echo json_encode($response);exit;
        }
        if(empty($vehicle_no)){
            $response = ['status'=>false,'message'=>'Enter Vehicle Number'];
            echo json_encode($response);exit;
        }
        if(empty($booking_id)){
            $response = ['status'=>false,'message'=>'Enter Driver Name'];
            echo json_encode($response);exit;
        }
        $saveData=[];
        $saveData['driver_name']=$driver_name;
        $saveData['driver_mobile_no']=$driver_mobile_no;
        $saveData['vehicle_no']=$vehicle_no;
        
        $update=$this->c_model->updateData('bookings',$saveData,['id'=>$booking_id]);
        if($update){
            $response=['status'=>true,'message'=>'Driver Assigned Successfully'];
            echo json_encode($response);exit;
        }
            $response=['status'=>false,'message'=>'Something Went Wrong'];
            echo json_encode($response);exit;
    }
}