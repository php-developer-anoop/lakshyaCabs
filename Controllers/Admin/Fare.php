<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Common_model;
class Fare extends BaseController {
    protected $c_model;
    protected $session;
    protected $table;
    public function __construct() {
        $this->c_model = new Common_model();
        $this->session = session();
        $this->table = "dt_fare_configuration";
    }
    
    function index() {
        $data = [];
        $data["menu"] = "Fare Master";
        $data["title"] = "Fare List";
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data['access']=checkWriteMenus(getUri(2)); 
        adminview('fares/view-fare', $data);
    }
    
    function add_oneway_fare() {
        $data = []; 
        $data["menu"] = "Oneway Fare Master";
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $data['btn'] = ($id) ? 'Update' : 'Submit' ; 
        $data['title'] = ($id) ? 'Update Oneway Fare' : 'Add Oneway Fare' ; 

        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data['access']=checkWriteMenus(getUri(2));
        $data['triptype'] = $this->c_model->getAllData("dt_trip_type_master", '`trip_type`, `display_name`', ['status' => 'Active'],null,null, 'ASC', 'priority');
        $data['statelist'] = $this->c_model->getAllData("dt_states", '`id`, `state_name`', ['status' => 'Active'],null,null, 'ASC', 'state_name');

        $data['vmodellist'] = $this->c_model->getAllData("dt_vehicle_model", '`id`, `model_name`', ['status' => 'Active'],null,null, 'ASC', 'model_name');
        $getdata = $this->c_model->getSingle($this->table, '*', ['id' => $id]);
        

        $data['id']                 = !empty($getdata['id']) ? $getdata['id'] : "";
        $data['model_id']           = !empty($getdata['model_id']) ? $getdata['model_id'] : "";
        $data['base_fare']          = !empty($getdata['base_fare']) ? $getdata['base_fare'] : 0;
        $data['base_covered_km']    = !empty($getdata['base_covered_km']) ? $getdata['base_covered_km'] : 0;
        $data['covered_hours']      = !empty($getdata['covered_hours']) ? $getdata['covered_hours'] : 0;
        $data['per_minute_charge']  = !empty($getdata['per_minute_charge']) ? $getdata['per_minute_charge'] : 0;
        $data['per_km_charge']      = !empty($getdata['per_km_charge']) ? $getdata['per_km_charge'] : 0;
        $data['night_charge']       = !empty($getdata['night_charge']) ? $getdata['night_charge'] : 0;
        $data['driver_charge']      = !empty($getdata['driver_charge']) ? $getdata['driver_charge'] : 0;
        $data['package_id']         = !empty($getdata['package_id']) ? $getdata['package_id'] : "";
        $data['trip_type']          = !empty($getdata['trip_type']) ? $getdata['trip_type'] : "";
        $data['pickup_state_id']    = !empty($getdata['pickup_state_id']) ? $getdata['pickup_state_id'] : "";
        $data['pickup_city_id']     = !empty($getdata['pickup_city_id']) ? $getdata['pickup_city_id'] : "";
        $data['pickup_city_name']   = !empty($getdata['pickup_city_name']) ? $getdata['pickup_city_name'] : "";
        $data['drop_state_id']      = !empty($getdata['drop_state_id']) ? $getdata['drop_state_id'] : "";
        $data['drop_city_id']       = !empty($getdata['drop_city_id']) ? $getdata['drop_city_id'] : "";
        $data['drop_city_name']     = !empty($getdata['drop_city_name']) ? $getdata['drop_city_name'] : "";
        $data['night_charge_from']  = !empty($getdata['night_charge_from']) ? date('h:i A', strtotime($getdata['night_charge_from'])) : date('h:i A', strtotime('22:00'));
        $data['night_charge_till']  = !empty($getdata['night_charge_till']) ? date('h:i A', strtotime($getdata['night_charge_till'])) : date('h:i A', strtotime('06:00'));
        $data['toll_charge']        = !empty($getdata['toll_charge']) ? $getdata['toll_charge'] : 0;
        $data['parking_charge']     = !empty($getdata['parking_charge']) ? $getdata['parking_charge'] : 0;
        $data['airport_parking']    = !empty($getdata['airport_parking']) ? $getdata['airport_parking'] : 0;
        $data['state_entry_charge'] = !empty($getdata['state_entry_charge']) ? $getdata['state_entry_charge'] : 0;
        $data['status']             = !empty($getdata['status']) ? $getdata['status'] : "Active";
//        $data['citylist'] = $this->c_model->getAllData("dt_cities", '`id`, `city_name`', ['status' => 'Active', 'state_id' => $data['drop_state_id']],null,null, 'ASC', 'state_name');

        adminview('fares/add-oneway-fare', $data);
    }

    function add_outstation_fare() {
        $data = []; 
        $data["menu"] = "Outstation Fare Master";
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $data['btn'] = ($id) ? 'Update' : 'Submit' ; 
        $data['title'] = ($id) ? 'Update Outstation Fare' : 'Add Outstation Fare' ;
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data['access']=checkWriteMenus(getUri(2));
        $data['triptype'] = $this->c_model->getAllData("dt_trip_type_master", '`trip_type`, `display_name`', ['status' => 'Active'],null,null, 'ASC', 'priority');
        $data['statelist'] = $this->c_model->getAllData("dt_states", '`id`, `state_name`', ['status' => 'Active'],null,null, 'ASC', 'state_name');
        $data['vmodellist'] = $this->c_model->getAllData("dt_vehicle_model", '`id`, `model_name`', ['status' => 'Active'],null,null, 'ASC', 'model_name');
        $getdata = $this->c_model->getSingle($this->table, '*', ['id' => $id]);
        $data['citylist'] = $this->c_model->getAllData("dt_states", '`id`, `state_name`', ['status' => 'Active'],null,null, 'ASC', 'state_name');

        $data['id']                 = !empty($getdata['id']) ? $getdata['id'] : "";
        $data['model_id']           = !empty($getdata['model_id']) ? $getdata['model_id'] : "";
        $data['base_fare']          = !empty($getdata['base_fare']) ? $getdata['base_fare'] : 0;
        $data['base_covered_km']    = !empty($getdata['base_covered_km']) ? $getdata['base_covered_km'] : 0;
        $data['covered_hours']      = !empty($getdata['covered_hours']) ? $getdata['covered_hours'] : 0;
        $data['per_minute_charge']  = !empty($getdata['per_minute_charge']) ? $getdata['per_minute_charge'] : 0;
        $data['per_km_charge']      = !empty($getdata['per_km_charge']) ? $getdata['per_km_charge'] : 0;
        $data['night_charge']       = !empty($getdata['night_charge']) ? $getdata['night_charge'] : 0;
        $data['driver_charge']      = !empty($getdata['driver_charge']) ? $getdata['driver_charge'] : 0;
        $data['package_id']         = !empty($getdata['package_id']) ? $getdata['package_id'] : "";
        $data['trip_type']          = !empty($getdata['trip_type']) ? $getdata['trip_type'] : "";
        $data['pickup_state_id']    = !empty($getdata['pickup_state_id']) ? $getdata['pickup_state_id'] : "";
        $data['pickup_city_id']     = !empty($getdata['pickup_city_id']) ? $getdata['pickup_city_id'] : "";
        $data['pickup_city_name']   = !empty($getdata['pickup_city_name']) ? $getdata['pickup_city_name'] : "";
        $data['drop_state_id']      = !empty($getdata['drop_state_id']) ? $getdata['drop_state_id'] : "";
        $data['drop_city_id']       = !empty($getdata['drop_city_id']) ? $getdata['drop_city_id'] : "";
        $data['drop_city_name']     = !empty($getdata['drop_city_name']) ? $getdata['drop_city_name'] : "";
        $data['night_charge_from']  = !empty($getdata['night_charge_from']) ? date('h:i A', strtotime($getdata['night_charge_from'])) : date('h:i A', strtotime('22:00'));
        $data['night_charge_till']  = !empty($getdata['night_charge_till']) ? date('h:i A', strtotime($getdata['night_charge_till'])) : date('h:i A', strtotime('06:00'));
        $data['toll_charge']        = !empty($getdata['toll_charge']) ? $getdata['toll_charge'] : 0;
        $data['parking_charge']     = !empty($getdata['parking_charge']) ? $getdata['parking_charge'] : 0;
        $data['airport_parking']    = !empty($getdata['airport_parking']) ? $getdata['airport_parking'] : 0;
        $data['state_entry_charge'] = !empty($getdata['state_entry_charge']) ? $getdata['state_entry_charge'] : 0;
        $data['status']             = !empty($getdata['status']) ? $getdata['status'] : "Active";

        adminview('fares/add-outstation-fare', $data);
    }

    function add_local_fare() {
        $data = []; 
        $data["menu"] = "Local Fare Master";
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $data['btn'] = ($id) ? 'Update' : 'Submit' ; 
        $data['title'] = ($id) ? 'Update Local Fare' : 'Add Local Fare' ;
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data['access']=checkWriteMenus(getUri(2));
        $data['triptype'] = $this->c_model->getAllData("dt_trip_type_master", '`trip_type`, `display_name`', ['status' => 'Active'],null,null, 'ASC', 'priority');
        $data['statelist'] = $this->c_model->getAllData("dt_states", '`id`, `state_name`', ['status' => 'Active'],null,null, 'ASC', 'state_name');
        $data['vmodellist'] = $this->c_model->getAllData("dt_vehicle_model", '`id`, `model_name`', ['status' => 'Active'],null,null, 'ASC', 'model_name');
        $getdata = $this->c_model->getSingle($this->table, '*', ['id' => $id]);
        $data['citylist'] = $this->c_model->getAllData("dt_states", '`id`, `state_name`', ['status' => 'Active'],null,null, 'ASC', 'state_name');

        $data['id']                 = !empty($getdata['id']) ? $getdata['id'] : "";
        $data['model_id']           = !empty($getdata['model_id']) ? $getdata['model_id'] : "";
        $data['base_fare']          = !empty($getdata['base_fare']) ? $getdata['base_fare'] : 0;
        $data['base_covered_km']    = !empty($getdata['base_covered_km']) ? $getdata['base_covered_km'] : 0;
        $data['covered_hours']      = !empty($getdata['covered_hours']) ? $getdata['covered_hours'] : 0;
        $data['per_hour_charge']    = !empty($getdata['state_entry_charge']) ? $getdata['state_entry_charge'] : 0;
        $data['per_minute_charge']  = !empty($getdata['per_minute_charge']) ? $getdata['per_minute_charge'] : 0;
        $data['per_km_charge']      = !empty($getdata['per_km_charge']) ? $getdata['per_km_charge'] : 0;
        $data['night_charge']       = !empty($getdata['night_charge']) ? $getdata['night_charge'] : 0;
        $data['driver_charge']      = !empty($getdata['driver_charge']) ? $getdata['driver_charge'] : 0;
        $data['package_id']         = !empty($getdata['package_id']) ? $getdata['package_id'] : "";
        $data['trip_type']          = !empty($getdata['trip_type']) ? $getdata['trip_type'] : "";
        $data['pickup_state_id']    = !empty($getdata['pickup_state_id']) ? $getdata['pickup_state_id'] : "";
        $data['pickup_city_id']     = !empty($getdata['pickup_city_id']) ? $getdata['pickup_city_id'] : "";
        $data['pickup_city_name']   = !empty($getdata['pickup_city_name']) ? $getdata['pickup_city_name'] : "";
        $data['drop_state_id']      = !empty($getdata['drop_state_id']) ? $getdata['drop_state_id'] : "";
        $data['drop_city_id']       = !empty($getdata['drop_city_id']) ? $getdata['drop_city_id'] : "";
        $data['drop_city_name']     = !empty($getdata['drop_city_name']) ? $getdata['drop_city_name'] : "";
        $data['night_charge_from']  = !empty($getdata['night_charge_from']) ? date('h:i A', strtotime($getdata['night_charge_from'])) : date('h:i A', strtotime('22:00'));
        $data['night_charge_till']  = !empty($getdata['night_charge_till']) ? date('h:i A', strtotime($getdata['night_charge_till'])) : date('h:i A', strtotime('06:00'));
        $data['toll_charge']        = !empty($getdata['toll_charge']) ? $getdata['toll_charge'] : 0;
        $data['parking_charge']     = !empty($getdata['parking_charge']) ? $getdata['parking_charge'] : 0;
        $data['airport_parking']    = !empty($getdata['airport_parking']) ? $getdata['airport_parking'] : 0;
        $data['state_entry_charge'] = !empty($getdata['state_entry_charge']) ? $getdata['state_entry_charge'] : 0;
        $data['status']             = !empty($getdata['status']) ? $getdata['status'] : "Active";
        $data['localp'] = $this->c_model->getAllData("dt_hourly_package", '`id`, `package_name`, `covered_km`, `covered_hours`', ['status' => 'Active','city_id'=>$data['pickup_city_id']],null,null, 'ASC', 'package_name');

        adminview('fares/add-local-fare', $data);
    }

    function add_airport_fare() {
        $data = []; 
        $data["menu"] = "Airport Fare Master";
         $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $data['btn'] = ($id) ? 'Update' : 'Submit' ; 
        $data['title'] = ($id) ? 'Update Airport Fare' : 'Add Airport Fare' ;
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data['access']=checkWriteMenus(getUri(2));
        $data['triptype'] = $this->c_model->getAllData("dt_trip_type_master", '`trip_type`, `display_name`', ['status' => 'Active'],null,null, 'ASC', 'priority');
        $data['statelist'] = $this->c_model->getAllData("dt_states", '`id`, `state_name`', ['status' => 'Active'],null,null, 'ASC', 'state_name');
        $data['vmodellist'] = $this->c_model->getAllData("dt_vehicle_model", '`id`, `model_name`', ['status' => 'Active'],null,null, 'ASC', 'model_name');
        $getdata = $this->c_model->getSingle($this->table, '*', ['id' => $id]);
        $data['citylist'] = $this->c_model->getAllData("dt_states", '`id`, `state_name`', ['status' => 'Active'],null,null, 'ASC', 'state_name');

        $data['id']                 = !empty($getdata['id']) ? $getdata['id'] : "";
        $data['model_id']           = !empty($getdata['model_id']) ? $getdata['model_id'] : "";
        $data['base_fare']          = !empty($getdata['base_fare']) ? $getdata['base_fare'] : 0;
        $data['base_covered_km']    = !empty($getdata['base_covered_km']) ? $getdata['base_covered_km'] : 0;
        $data['covered_hours']      = !empty($getdata['covered_hours']) ? $getdata['covered_hours'] : 0;
        $data['per_hour_charge']    = !empty($getdata['state_entry_charge']) ? $getdata['state_entry_charge'] : 0;
        $data['per_minute_charge']  = !empty($getdata['per_minute_charge']) ? $getdata['per_minute_charge'] : 0;
        $data['per_km_charge']      = !empty($getdata['per_km_charge']) ? $getdata['per_km_charge'] : 0;
        $data['night_charge']       = !empty($getdata['night_charge']) ? $getdata['night_charge'] : 0;
        $data['driver_charge']      = !empty($getdata['driver_charge']) ? $getdata['driver_charge'] : 0;
        $data['package_id']         = !empty($getdata['package_id']) ? $getdata['package_id'] : "";
        $data['trip_type']          = !empty($getdata['trip_type']) ? $getdata['trip_type'] : "";
        $data['pickup_state_id']    = !empty($getdata['pickup_state_id']) ? $getdata['pickup_state_id'] : "";
        $data['pickup_city_id']     = !empty($getdata['pickup_city_id']) ? $getdata['pickup_city_id'] : "";
        $data['pickup_city_name']   = !empty($getdata['pickup_city_name']) ? $getdata['pickup_city_name'] : "";
        $data['drop_state_id']      = !empty($getdata['drop_state_id']) ? $getdata['drop_state_id'] : "";
        $data['drop_city_id']       = !empty($getdata['drop_city_id']) ? $getdata['drop_city_id'] : "";
        $data['drop_city_name']     = !empty($getdata['drop_city_name']) ? $getdata['drop_city_name'] : "";
        $data['night_charge_from']  = !empty($getdata['night_charge_from']) ? date('h:i A', strtotime($getdata['night_charge_from'])) : date('h:i A', strtotime('22:00'));
        $data['night_charge_till']  = !empty($getdata['night_charge_till']) ? date('h:i A', strtotime($getdata['night_charge_till'])) : date('h:i A', strtotime('06:00'));
        $data['toll_charge']        = !empty($getdata['toll_charge']) ? $getdata['toll_charge'] : 0;
        $data['parking_charge']     = !empty($getdata['parking_charge']) ? $getdata['parking_charge'] : 0;
        $data['airport_parking']    = !empty($getdata['airport_parking']) ? $getdata['airport_parking'] : 0;
        $data['state_entry_charge'] = !empty($getdata['state_entry_charge']) ? $getdata['state_entry_charge'] : 0;
        $data['status']             = !empty($getdata['status']) ? $getdata['status'] : "Active";
        
$data['airportl'] = $this->c_model->getAllData("dt_airport", '`id`, `airport_name`', ['status' => 'Active','city_id'=>$data['pickup_city_id']],null,null, 'ASC', 'airport_name');
        adminview('fares/add-airport-fare', $data);
    }
    
    
    public function save_fare() {
        $post = $this->request->getVar();
        //echo '<pre>';
        //print_r($post); exit;
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $data = [];
        $data['trip_type']       = !empty($post['trip_type']) ? ucwords(trim($post['trip_type'])) : "";
        $data['pickup_state_id'] = !empty($post['pickup_state_id']) ? trim($post['pickup_state_id']) : "";
 

        $pickupcity = !empty($post['pickup_city_id']) ? ($post['pickup_city_id']) : "";
        $keys = !empty($post['key']) ? ($post['key']) : "";
        $message = '';
        if(!empty($pickupcity)){
            foreach ($pickupcity as $key => $cityval) {
                if(!empty($keys)){
                    foreach ($keys as $key => $keysval) { 
                        $data['model_id']        = !empty($keysval['model_id']) ? trim($keysval['model_id']) : "";
                        $data['pickup_city_id'] = !empty($cityval) ? explodeMe( $cityval, ',', 0 ) : 0;
                        $duplicate = $this->c_model->getSingle($this->table, 'id', $data);
                        if ($duplicate && empty($id)) {
                        }else{
                            $data['night_charge_from']      = !empty($post['night_charge_from']) ? date('H:i:s', strtotime($post['night_charge_from'])) : "22:00:00";
                            $data['night_charge_till']      = !empty($post['night_charge_till']) ? date('H:i:s', strtotime($post['night_charge_till'])) : "06:00:00";
                            $data['toll_charge']            = !empty($post['toll_charge']) ? $post['toll_charge'] : 0;
                            $data['parking_charge']         = !empty($post['parking_charge']) ? $post['parking_charge'] : 0;
                            $data['airport_parking']        = !empty($post['airport_parking']) ? $post['airport_parking'] : 0;
                            $data['state_entry_charge']     = !empty($post['state_entry_charge']) ? $post['state_entry_charge'] : 0;
                            $data['status']                 = !empty($post['status']) ? $post['status'] : "";
                            $data['pickup_city_name']       = !empty($data['pickup_city_id']) ? getCityStateName($data['pickup_city_id']) : '';
                            $data['drop_city_id']           = !empty($post['drop_city_id']) ?   $post['drop_city_id'] : 0;
                            $data['drop_state_id']          = !empty($post['drop_state_id']) ?   $post['drop_state_id'] : 0;
                            $data['drop_city_name']         = !empty($post['drop_city']) ?   $post['drop_city'] : '';
                            $data['base_fare']              = !empty($keysval['base_fare']) ? $keysval['base_fare'] : 0;
                            $data['per_km_charge']          = !empty($keysval['per_km_charge']) ? ($keysval['per_km_charge']) : 0;
                            $data['base_covered_km']        = !empty($keysval['base_covered_km']) ? ($keysval['base_covered_km']) : 0;
                            $data['driver_charge']          = !empty($keysval['driver_charge']) ? ($keysval['driver_charge']) : 0;
                            $data['night_charge']           = !empty($keysval['night_charge']) ? ($keysval['night_charge']) : 0;
                            $data['covered_hours']          = !empty($keysval['covered_hours']) ? ($keysval['covered_hours']) : 0;
                            $data['per_hour_charge']        = !empty($keysval['per_hour_charge']) ? ($keysval['per_hour_charge']) : 0;

                            // echo '<pre>';
//       print_r($data);exit;
                             if (empty($id)) {
                                $message = 'Added';
                                $data['add_date'] = date('Y-m-d H:i:s');
                                $data['update_date'] = date('Y-m-d H:i:s');
                                $this->c_model->insertRecords($this->table, $data);
                            } else {
                                $message = 'Updated';
                                $data['update_date'] = date('Y-m-d H:i:s');
                                $this->c_model->updateRecords($this->table, $data, ['id' => $id]);
                            }
                        }
                    }
                }
            }
        } 
        $this->session->setFlashdata('success', 'Data '.$message.' Successfully');
        return redirect()->to($_SERVER['HTTP_REFERER']);        
    }
    
     public function save_fare_transfer() {
        $post = $this->request->getVar();
 
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $data = [];
        $data['trip_type']       = !empty($post['trip_type']) ? ucwords(trim($post['trip_type'])) : "";
        $data['pickup_state_id'] = !empty($post['pickup_state_id']) ? trim($post['pickup_state_id']) : "";
 //       $data['model_id']        = !empty($post['model_id']) ? trim($post['model_id']) : "";
        $data['package_id']      = !empty($post['package_id']) ? trim($post['package_id']) : "";

        $cityval = !empty($post['pickup_city_id']) ? ($post['pickup_city_id']) : "";
        $keys = !empty($post['key']) ? ($post['key']) : "";
        $message = '';
        if(!empty($cityval)){
                if(!empty($keys)){
                    foreach ($keys as $key => $keysval) {
                        $data['model_id']        = !empty($keysval['model_id']) ? trim($keysval['model_id']) : "";
                        $data['pickup_city_id'] = !empty($cityval) ? explodeMe( $cityval, ',', 0 ) : 0;
                        $duplicate = $this->c_model->getSingle($this->table, 'id', $data);
                        if ($duplicate && empty($id)) {
                            
                        }else{
                            $data['night_charge_from']      = !empty($post['night_charge_from']) ? date('H:i:s', strtotime($post['night_charge_from'])) : "22:00:00";
                            $data['night_charge_till']      = !empty($post['night_charge_till']) ? date('H:i:s', strtotime($post['night_charge_till'])) : "06:00:00";
                            $data['toll_charge']            = !empty($post['toll_charge']) ? $post['toll_charge'] : 0;
                            $data['parking_charge']         = !empty($post['parking_charge']) ? $post['parking_charge'] : 0;
                            $data['airport_parking']        = !empty($post['airport_parking']) ? $post['airport_parking'] : 0;
                            $data['state_entry_charge']     = !empty($post['state_entry_charge']) ? $post['state_entry_charge'] : 0;
                            $data['status']                 = !empty($post['status']) ? $post['status'] : "";
                            $data['pickup_city_name']       = !empty($post['pickup_city_name']) ? $post['pickup_city_name'] : '';
                            $data['drop_city_id']           = 0;//!empty($post['drop_city_id']) ?   $post['drop_city_id'] : 0;
                            $data['drop_state_id']          = 0;//!empty($post['drop_state_id']) ?   $post['drop_state_id'] : 0;
                            $data['drop_city_name']         = 0;//!empty($post['drop_city']) ?   $post['drop_city'] : '';
                            $data['base_fare']              = !empty($keysval['base_fare']) ? $keysval['base_fare'] : 0;
                            $data['per_km_charge']          = !empty($keysval['per_km_charge']) ? ($keysval['per_km_charge']) : 0;
                            $data['base_covered_km']        = !empty($keysval['base_covered_km']) ? ($keysval['base_covered_km']) : 0;
                            $data['driver_charge']          = !empty($keysval['driver_charge']) ? ($keysval['driver_charge']) : 0;
                            $data['night_charge']           = !empty($keysval['night_charge']) ? ($keysval['night_charge']) : 0;
                            $data['covered_hours']          = !empty($keysval['covered_hours']) ? ($keysval['covered_hours']) : 0;
                            $data['per_hour_charge']        = !empty($keysval['per_hour_charge']) ? ($keysval['per_hour_charge']) : 0;

//                            echo '<pre>';
//                            print_r($data);exit;
                             if (empty($id)) {
                                $message = 'Added';
                                $data['add_date'] = date('Y-m-d H:i:s');
                                $data['update_date'] = date('Y-m-d H:i:s');
                                $this->c_model->insertRecords($this->table, $data);
                            } else {
                                $message = 'Updated';
                                $data['update_date'] = date('Y-m-d H:i:s');
                                $this->c_model->updateRecords($this->table, $data, ['id' => $id]);
                            }
                        }
                    }
                }
        } 
        $this->session->setFlashdata('success', 'Data '.$message.' Successfully');
        return redirect()->to($_SERVER['HTTP_REFERER']);        
    }
    
    public function save_fare_local() {
        $post = $this->request->getVar();
 
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $data = [];
        $data['trip_type']       = !empty($post['trip_type']) ? ucwords(trim($post['trip_type'])) : "";
        $data['pickup_state_id'] = !empty($post['pickup_state_id']) ? trim($post['pickup_state_id']) : "";
        $data['package_id']      = !empty($post['package_id']) ? trim($post['package_id']) : "";

        $cityval = !empty($post['pickup_city_id']) ? ($post['pickup_city_id']) : "";
        $keys = !empty($post['key']) ? ($post['key']) : "";
//        echo '<pre>';
//        print_r($keys);exit;
        $message = '';
        if(!empty($cityval)){
                if(!empty($keys)){
                    foreach ($keys as $key => $keysval) {
                        $data['model_id']        = !empty($keysval['model_id']) ? trim($keysval['model_id']) : "";
                        $data['pickup_city_id'] = !empty($cityval) ? explodeMe( $cityval, ',', 0 ) : 0;
                        $duplicate = $this->c_model->getSingle($this->table, 'id', $data);
                        if ($duplicate && empty($id)) {
                        }else{
                            $data['night_charge_from']      = !empty($post['night_charge_from']) ? date('H:i:s', strtotime($post['night_charge_from'])) : "22:00:00";
                            $data['night_charge_till']      = !empty($post['night_charge_till']) ? date('H:i:s', strtotime($post['night_charge_till'])) : "06:00:00";
                            $data['toll_charge']            = !empty($post['toll_charge']) ? $post['toll_charge'] : 0;
                            $data['parking_charge']         = !empty($post['parking_charge']) ? $post['parking_charge'] : 0;
                            $data['airport_parking']        = !empty($post['airport_parking']) ? $post['airport_parking'] : 0;
                            $data['state_entry_charge']     = !empty($post['state_entry_charge']) ? $post['state_entry_charge'] : 0;
                            $data['status']                 = !empty($post['status']) ? $post['status'] : "";
                            $data['pickup_city_name']       = !empty($cityval) ? getCityStateName(  $data['pickup_city_id'] ) : '';
                            $data['drop_city_id']           = 0;//!empty($post['drop_city_id']) ?   $post['drop_city_id'] : 0;
                            $data['drop_state_id']          = 0;//!empty($post['drop_state_id']) ?   $post['drop_state_id'] : 0;
                            $data['drop_city_name']         = '';//!empty($post['drop_city']) ?   $post['drop_city'] : '';
                            $data['base_fare']              = !empty($keysval['base_fare']) ? $keysval['base_fare'] : 0;
                            $data['per_km_charge']          = !empty($keysval['per_km_charge']) ? ($keysval['per_km_charge']) : 0;
                            $data['base_covered_km']        = !empty($keysval['base_covered_km']) ? ($keysval['base_covered_km']) : 0;
                            $data['driver_charge']          = !empty($keysval['driver_charge']) ? ($keysval['driver_charge']) : 0;
                            $data['night_charge']           = !empty($keysval['night_charge']) ? ($keysval['night_charge']) : 0;
                            $data['covered_hours']          = !empty($keysval['covered_hours']) ? ($keysval['covered_hours']) : 0;
                            $data['per_hour_charge']        = !empty($keysval['per_hour_charge']) ? ($keysval['per_hour_charge']) : 0;

                            
                             if (empty($id)) {
                                $message = 'Added';
                                $data['add_date'] = date('Y-m-d H:i:s');
                                $data['update_date'] = date('Y-m-d H:i:s');
                                $this->c_model->insertRecords($this->table, $data);
                            } else {
                                $message = 'Updated';
                                $data['update_date'] = date('Y-m-d H:i:s');
                                $this->c_model->updateRecords($this->table, $data, ['id' => $id]);
                            }
                        }
                    }
                }
        } 
        $this->session->setFlashdata('success', 'Data '.$message.' Successfully');
        return redirect()->to($_SERVER['HTTP_REFERER']);        
    }
    
    public function getRecords() {
        $post = $this->request->getVar();
        $get = $this->request->getVar();
        $limit = (int)(!empty($get["length"]) ? $get["length"] : 1);
        $start = (int)!empty($get["start"]) ? $get["start"] : 0;
        $is_count = !empty($post["is_count"]) ? $post["is_count"] : "";
        $totalRecords = !empty($get["recordstotal"]) ? $get["recordstotal"] : 0;
        $orderBy = "DESC";
        $orderByKeys = "a.id";
        $where = [];
        $searchString = null;
        if (!empty($get["search"]["value"])) {
            $searchString = trim($get["search"]["value"]);
            $where["a.base_fare LIKE '%" . $searchString . "%' OR a.trip_type LIKE '%" . $searchString . "%' OR a.pickup_city_name LIKE '%" . $searchString . "%' OR a.drop_city_name LIKE '%" . $searchString . "%'"] = null;
            $limit = 100;
            $start = 0;
        }
        
        if (!empty($get["showRecords"])) {
            $limit = $get["showRecords"];
            $orderBy = "DESC";
        }
        
        $joinArray = [];
        $joinArray[0]['table'] = 'dt_vehicle_model as b';
        $joinArray[0]['join_on'] = 'a.model_id = b.id';
        $joinArray[0]['join_type'] = 'LEFT';
        
        $tableName = 'dt_fare_configuration as a';
        $columNames = 'b.category_name,b.model_name, a.*,DATE_FORMAT(a.add_date , "%d-%m-%Y %p") AS add_date,DATE_FORMAT(a.update_date , "%d-%m-%Y %p") AS update_date';
        
        if ($is_count == "yes") {
            $countData = $this->c_model->getBulkRecords( $tableName, $where, 'a.id', 'count', null, null , null, null, $joinArray );
            echo (int)(!empty($countData) ? $countData : 0);
            exit();
        }
        
        $listData = $this->c_model->getBulkRecords( $tableName, $where, $columNames, 'get', $orderBy, $orderByKeys , $start, $limit, $joinArray );
        $result = [];
        if (!empty($listData)) {
            $i = $start + 1;
            foreach ($listData as $key => $value) {
                $push = [];
                $push = $value;
                $push["sr_no"] = $i;
                array_push($result, $push);
                $i++;
            }
        }
        $json_data = [];
        if (!empty($get["search"]["value"])) {
            $countItems = !empty($result) ? count($result) : 0;
            $json_data["draw"] = intval($get["draw"]);
            $json_data["recordsTotal"] = intval($countItems);
            $json_data["recordsFiltered"] = intval($countItems);
            $json_data["data"] = !empty($result) ? $result : [];
        } else {
            $json_data["draw"] = intval($get["draw"]);
            $json_data["recordsTotal"] = intval($totalRecords);
            $json_data["recordsFiltered"] = intval($totalRecords);
            $json_data["data"] = !empty($result) ? $result : [];
        }
        echo json_encode($json_data);
    }
    public function import_export_fare() {
        $data = [];
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data['access']=checkWriteMenus(getUri(2));
        $data["menu"] = "Fare Master";
        $data["title"] = "Import-Export Fare";
        $data['states'] = $this->c_model->getAllData("states", 'id,state_name', ['status' => 'Active']);
        adminview('export-fare', $data);
    }
}
