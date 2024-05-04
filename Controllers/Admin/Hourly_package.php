<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Common_model;
class Hourly_package extends BaseController {
    protected $c_model;
    protected $session;
    protected $table;
    public function __construct() {
        $this->c_model = new Common_model();
        $this->session = session();
        $this->table = "dt_hourly_package";
    }
    function index() {
        $data = [];
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data["menu"] = "Hourly Package Master";
        $data["title"] = "Hourly Package List";
        $data['access']=checkWriteMenus(getUri(2));
        adminview('view-hourly-package', $data);
    }
    function add_hourly_package() {
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $data = [];
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data['access']=checkWriteMenus(getUri(2));
        $data["menu"] = "Hourly Package Master";
        $data["title"] = !empty($id) ? "Edit Hourly Package" : "Add Hourly Package";
        $savedData = $this->c_model->getSingle($this->table, '*', ['id' => $id]);
        $data['id'] = !empty($savedData['id']) ? $savedData['id'] : $id;
        $data['package_name'] = !empty($savedData['package_name']) ? $savedData['package_name'] : '';
        $data['city_id'] = !empty($savedData['city_id']) ? $savedData['city_id'] : '';
        $city_name = !empty($savedData['city_name']) ? $savedData['city_name'] : '';
        $state_name = !empty($savedData['state_name']) ? $savedData['state_name'] : '';
        $data['city_name'] = !empty($state_name) && !empty($city_name) ? $city_name . ' , ' . $state_name : $city_name;
        $data['covered_km'] = !empty($savedData['covered_km']) ? $savedData['covered_km'] : '';
        $data['covered_hours'] = !empty($savedData['covered_hours']) ? $savedData['covered_hours'] : '';
        $data['status'] = !empty($savedData['status']) ? $savedData['status'] : 'Active';
        adminview('add-hourly-package', $data);
    }
    public function save_hourly_package() {
        $post = $this->request->getVar();
        // echo "<pre>";
        // print_r($post);exit;
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $data = [];
        $data['package_name'] = ucwords(trim($post['package_name']));
        $data['covered_km'] = trim($post['covered_km']);
        $data['covered_hours'] = trim($post['covered_hours']);
        $city = !empty($post['city']) ? explode(' , ', $post['city']) : [];
        $data['city_id'] = $post['city_id'];
        $state_id=$this->c_model->getSingle("cities",'state_id',['status'=>'Active','id'=>$post['city_id']]);
        $data['state_id']=$state_id['state_id'];
        $data['city_name'] = $city['0'] ?? '';
        
        $duplicate = $this->c_model->getSingle($this->table, 'id', $data);
        if ($duplicate && empty($id)) {
            $this->session->setFlashdata('failed', 'Duplicate Entry');
            return redirect()->to(base_url(ADMINPATH . 'hourly-package-list'));
        }
        $data['status'] = trim($post['status']);
        $last_id = '';
        if (empty($id)) {
            $data['add_date'] = date('Y-m-d H:i:s');
            $last_id = $this->c_model->insertRecords($this->table, $data);
            $this->session->setFlashdata('success', 'Data Added Successfully');
        } else {
            $data['update_date'] = date('Y-m-d H:i:s');
            $this->c_model->updateRecords($this->table, $data, ['id' => $id]);
            $last_id = $id;
            $this->session->setFlashdata('success', 'Data Updated Successfully');
        }

        return redirect()->to(base_url(ADMINPATH . 'hourly-package-list'));
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
            $where["package_name LIKE '%" . $searchString . "%'"] = null;
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
        $select = '*';
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
