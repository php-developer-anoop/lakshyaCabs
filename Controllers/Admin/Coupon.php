<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Common_model;
class Coupon extends BaseController {
    protected $c_model;
    protected $session;
    protected $table;
    public function __construct() {
        $this->c_model = new Common_model();
        $this->session = session();
        $this->table = "dt_coupon_list";
    }
    function index() {
        $data = [];
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data["menu"] = "Coupon Master";
        $data["title"] = "Coupon List";
        $data['access'] = checkWriteMenus(getUri(2));
        adminview('view-coupon', $data);
    }
    function add_coupon() {
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $data = [];
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data['access'] = checkWriteMenus(getUri(2));
        $data["menu"] = "Coupon Master";
        $data["title"] = !empty($id) ? "Edit Coupon" : "Add Coupon";
        $data['state_list'] = $this->c_model->getAllData('states', 'id,state_name', ['status' => 'Active']);
        $savedData = $this->c_model->getSingle($this->table, '*', ['id' => $id]);
        $data['id'] = !empty($savedData['id']) ? $savedData['id'] : $id;
        $data['trip_type'] = !empty($savedData['trip_type']) ? $savedData['trip_type'] : '';
        $data['coupon_code'] = !empty($savedData['coupon_code']) ? $savedData['coupon_code'] : '';
        $data['coupon_type'] = !empty($savedData['coupon_type']) ? $savedData['coupon_type'] : '';
        $data['coupon_value'] = !empty($savedData['coupon_value']) ? $savedData['coupon_value'] : '';
        $data['city_id'] = !empty($savedData['city_id']) ? $savedData['city_id'] : '';
        $data['state_id'] = !empty($savedData['state_id']) ? $savedData['state_id'] : '';
        $data['city_name'] = !empty($savedData['city_name']) ? $savedData['city_name'] : '';
        $data['valid_from'] = !empty($savedData['valid_from']) ? $savedData['valid_from'] : '';
        $data['valid_till'] = !empty($savedData['valid_till']) ? $savedData['valid_till'] : '';
        $data['minimum_cart_value'] = !empty($savedData['minimum_cart_value']) ? $savedData['minimum_cart_value'] : '';
        $data['maximum_discount'] = !empty($savedData['maximum_discount']) ? $savedData['maximum_discount'] : '';
        $data['title_name'] = !empty($savedData['title_name']) ? $savedData['title_name'] : '';
        $data['description'] = !empty($savedData['description']) ? $savedData['description'] : '';
        $data['status'] = !empty($savedData['status']) ? $savedData['status'] : 'Active';
        adminview('add-coupon', $data);
    }
    public function save_coupon() {
        $post = $this->request->getPost(); 
        $id = !empty($post['id']) ? $post['id'] : '';
        $data = [
                'trip_type' => trim($post['trip_type']),
                'coupon_code' => trim($post['coupon_code']),
                'coupon_type' => trim($post['coupon_type']),
                'coupon_value' => trim($post['coupon_value']),
                'valid_from' => date('Y-m-d', strtotime($post['valid_from'])), 
                'valid_till' => date('Y-m-d', strtotime($post['valid_till'])), 
                'minimum_cart_value' => isset($post['minimum_cart_value']) ? trim($post['minimum_cart_value']) : '', 
                'maximum_discount' => isset($post['maximum_discount']) ? trim($post['maximum_discount']) : '', 
                'title_name' => trim($post['title_name']),
                'description' => trim($post['description']),
                'city_id' => $post['city_id'],
                'state_id' => $post['state_id'],
                'city_name' => $post['city']];
                
        $duplicate = $this->c_model->getSingle($this->table, 'id', $data);
        if ($duplicate && empty($id)) {
            $this->session->setFlashdata('failed', 'Duplicate Entry');
            return redirect()->to(base_url(ADMINPATH . 'coupon-list'));
        }
        $data['status'] = trim($post['status']);
        $last_id = '';
        if (empty($id)) {
            $data['add_date'] = date('Y-m-d H:i:s');
            $last_id = $this->c_model->insertRecords($this->table, $data);
            $this->session->setFlashdata('success', 'Data Added Successfully');
        } else {
            $data['updated_on'] = date('Y-m-d H:i:s');
            $this->c_model->updateRecords($this->table, $data, ['id' => $id]);
            $last_id = $id;
            $this->session->setFlashdata('success', 'Data Updated Successfully');
        }
        return redirect()->to(base_url(ADMINPATH . 'coupon-list'));
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
            $where["trip_type LIKE '%" . $searchString . "%' OR coupon_code LIKE '%" . $searchString . "%' OR coupon_type LIKE '%" . $searchString . "%' OR coupon_value LIKE '%" . $searchString . "%' OR city_name LIKE '%" . $searchString . "%' "] = null;
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
        $select = '*,DATE_FORMAT(add_date , "%d-%m-%Y %r") AS add_date,DATE_FORMAT(updated_on , "%d-%m-%Y %r") AS update_date,DATE_FORMAT(valid_from , "%d-%m-%Y %r") AS valid_from,DATE_FORMAT(valid_till , "%d-%m-%Y %r") AS valid_till';
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
