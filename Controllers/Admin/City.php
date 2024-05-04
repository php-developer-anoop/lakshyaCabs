<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Common_model;
class City extends BaseController {
    protected $c_model;
    protected $session;
    protected $table;
    public function __construct() {
        $this->c_model = new Common_model();
        $this->session = session();
        $this->table = "dt_cities";
    }
    function index() {
        $data = [];
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data["menu"] = "City Master";
        $data["title"] = "City List";
        $data['access']=checkWriteMenus(getUri(2));
        adminview('view-city', $data);
    }
    function add_city() {
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $data = [];
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data['access']=checkWriteMenus(getUri(2));
        $data["menu"] = "City Master";
        $data["title"] = !empty($id) ? "Edit City" : "Add City";
        $data['states'] = $this->c_model->getAllData("states",'id,state_name',['status'=>'Active']);
        $data['faqs'] = $this->c_model->getAllData("faqs", 'question,answer', ["table_name" => $this->table, 'table_list_id' => $id]);
        $savedData = $this->c_model->getSingle($this->table, '*', ['id' => $id]);
        $data['id'] = !empty($savedData['id']) ? $savedData['id'] : $id;
        $data['state_id'] = !empty($savedData['state_id']) ? $savedData['state_id'] : '';
        $data['city_name'] = !empty($savedData['city_name']) ? $savedData['city_name'] : '';
        $data['url'] = !empty($savedData['url']) ? $savedData['url'] : '';
        $data['pincode'] = !empty($savedData['pincode']) ? $savedData['pincode'] : '';
        $data['latitude'] = !empty($savedData['latitude']) ? $savedData['latitude'] : '';
        $data['longitude'] = !empty($savedData['longitude']) ? $savedData['longitude'] : '';
        $data['fare_radius'] = !empty($savedData['fare_radius']) ? $savedData['fare_radius'] : '';
        $data['driver_radius'] = !empty($savedData['driver_radius']) ? $savedData['driver_radius'] : '';
        
        $data['status'] = !empty($savedData['status']) ? $savedData['status'] : 'Active';
        adminview('add-city', $data);
    }
    public function save_city() {
        $post = $this->request->getVar();
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $data = [];
        $state = !empty($post['state']) ? explode(',', $post['state']) : [];
        $data['state_id'] = $state[0]??'';
        $data['state_name'] = $state[1]??'';
        $data['city_name'] = ucwords(trim($post['city_name']));
        $duplicate = $this->c_model->getSingle($this->table, 'id', $data);
        $url=!empty($id)?'?id='.$id:'';
        if ($duplicate && empty($id)) {
            $this->session->setFlashdata('failed', 'Duplicate Entry');
            return redirect()->to(base_url(ADMINPATH . 'add-city').$url);
        }
       
        //$data['url'] = validate_slug(trim($post['url']));
        //$data['pincode'] = trim($post['pincode']);
        $data['latitude'] = trim($post['latitude']);
        $data['longitude'] = trim($post['longitude']);
       // $data['fare_radius'] = trim($post['fare_radius']);
        //$data['driver_radius'] = trim($post['driver_radius']);
        
       
        $data['status'] = trim($post['status']);
        $last_id = '';
        if (empty($id)) {
            $data['add_date'] = date('Y-m-d H:i:s');
            $last_id = $this->c_model->insertRecords($this->table, $data);
            $this->session->setFlashdata('success', 'Data Added Successfully ');
        } else {
            $data['update_date'] = date('Y-m-d H:i:s');
            $this->c_model->updateRecords($this->table, $data, ['id' => $id]);
            $last_id = $id;
            $this->session->setFlashdata('success', 'Data Updated Successfully');
        }
       
        return redirect()->to(base_url(ADMINPATH . 'add-city').'?id='.$last_id);
    }
    public function getRecords() {
        $post = $this->request->getVar();
        $get = $this->request->getVar();
        $limit = (int)(!empty($get["length"]) ? $get["length"] : 1);
        $start = (int)!empty($get["start"]) ? $get["start"] : 0;
        $is_count = !empty($post["is_count"]) ? $post["is_count"] : "";
        $totalRecords = !empty($get["recordstotal"]) ? $get["recordstotal"] : 0;
        $orderby = "DESC";
        $where = [];
        $searchString = null;
        if (!empty($get["search"]["value"])) {
            $searchString = trim($get["search"]["value"]);
            $where[" state_name LIKE '%" . $searchString . "%' OR city_name LIKE '%" . $searchString . "%'"] = null;
            $limit = 100;
            $start = 0;
        }
        $countData = $this->c_model->countRecords($this->table, $where, 'id');
        if ($is_count == "yes") {
            echo (int)(!empty($countData) ? sizeof($countData) : 0);
            exit();
        }
        if (!empty($get["showRecords"])) {
            $limit = $get["showRecords"];
            $orderby = "DESC";
        }
        $select = '*,DATE_FORMAT(add_date , "%d-%m-%Y %r") AS add_date,DATE_FORMAT(update_date , "%d-%m-%Y %r") AS update_date';
        $listData = $this->c_model->getAllData($this->table, $select, $where, $limit, $start, $orderby);
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
}
