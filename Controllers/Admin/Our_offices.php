<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Common_model;
class Our_offices extends BaseController {
    protected $c_model;
    protected $session;
    protected $table;
    public function __construct() {
        $this->c_model = new Common_model();
        $this->session = session();
        $this->table = "dt_offices";
    }
    function index() {
        $data = [];
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data["menu"] = "Our Offices";
        $data["title"] = "Our Offices";
        $data['access']=checkWriteMenus(getUri(2));
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $data['states'] = $this->c_model->getAllData("states", 'id,state_name', ['status' => 'Active']);
        $savedData = $this->c_model->getSingle($this->table, '*', ['id' => $id]);
        $data['id'] = !empty($savedData['id']) ? $savedData['id'] : $id;
        $data['office_type'] = !empty($savedData['office_type']) ? $savedData['office_type'] : '';
        $data['city_id'] = !empty($savedData['city_id']) ? $savedData['city_id'] : '';
        $data['city_name'] = !empty($savedData['city_name']) ? $savedData['city_name'] : '';
        $data['state_id'] = !empty($savedData['state_id']) ? $savedData['state_id'] : '';
        $data['phone'] = !empty($savedData['phone']) ? $savedData['phone'] : '';
        $data['email'] = !empty($savedData['email']) ? $savedData['email'] : '';
        $data['address'] = !empty($savedData['address']) ? $savedData['address'] : '';
        $data['status'] = !empty($savedData['status']) ? $savedData['status'] : 'Active';
        adminview('our-offices', $data);
    }
    public function save_office() {
        $post = $this->request->getVar();
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $data = [];
        $data['office_type'] = ucwords(trim($post['office_type']));
        $data['phone'] = trim($post['phone']);
        $data['email'] = trim($post['email']);
        $data['address'] = trim($post['address']);
        $city = !empty($post['city']) ? explode(',', $post['city']) : [];
        $state = !empty($post['state']) ? explode(',', $post['state']) : [];
        $data['city_id'] = $city['0']??'';
        $data['city_name'] = $city['1']??'';
        $data['state_id'] = $state['0']??'';
        $data['state_name'] = $state['1']??'';
        $duplicate = $this->c_model->getSingle($this->table, 'id', $data);
        if ($duplicate && empty($id)) {
            $this->session->setFlashdata('failed', 'Duplicate Entry');
            return redirect()->to(base_url(ADMINPATH . 'office-list'));
        }
        $last_id = '';
        if (empty($id)) {
            $data['add_date'] = date('Y-m-d H:i:s');
            $last_id = $this->c_model->insertRecords($this->table, $data);
            $this->session->setFlashdata('success', 'Data Added Successfully');
        } else {
            $data['upd_date'] = date('Y-m-d H:i:s');
            $this->c_model->updateRecords($this->table, $data, ['id' => $id]);
            $last_id = $id;
            $this->session->setFlashdata('success', 'Data Updated Successfully');
        }
        return redirect()->to(base_url(ADMINPATH . 'office-list'));
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
            $where["office_type LIKE '%" . $searchString . "%' OR phone LIKE '%" . $searchString . "%' OR email LIKE '%" . $searchString . "%' OR address LIKE '%" . $searchString . "%' OR city_name LIKE '%" . $searchString . "%' OR state_name LIKE '%" . $searchString . "%'"] = null;
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
