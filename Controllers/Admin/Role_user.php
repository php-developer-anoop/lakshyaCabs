<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Common_model;
class Role_user extends BaseController {
    protected $c_model;
    protected $session;
    protected $table;
    public function __construct() {
        $this->c_model = new Common_model();
        $this->session = session();
        $this->table = "dt_role_users";
    }
    function index() {
        $data = [];
        $data["menu"] = "Role User Master";
        $data["title"] = "Role User List";
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data['access']=checkWriteMenus(getUri(2));
        $data["menu_list"] = $this->c_model->getAllData('menus','id,menu_name',['type'=>'Menu','status'=>'Active']);
        adminview('view-role-user', $data);
    }
    function add_role_user() {
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $data = [];
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data['access']=checkWriteMenus(getUri(2));
        $data["menu"] = "Role User Master";
        $data["title"] = !empty($id) ? "Edit Role User" : "Add Role User";
        $savedData = $this->c_model->getSingle($this->table, '*', ['id' => $id]);
        $data['id'] = !empty($savedData['id']) ? $savedData['id'] : $id;
        $data['user_name'] = !empty($savedData['user_name']) ? $savedData['user_name'] : '';
        $data['enc_password'] = !empty($savedData['enc_password']) ? $savedData['enc_password'] : '';
        $data['user_email'] = !empty($savedData['user_email']) ? $savedData['user_email'] : '';
        $data['user_phone'] = !empty($savedData['user_phone']) ? $savedData['user_phone'] : '';
        $data['status'] = !empty($savedData['status']) ? $savedData['status'] : 'Active';
        adminview('add-role-user', $data);
    }
    public function save_role_user() {
        $post = $this->request->getVar();
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $data = [];
        $data['user_name'] = ucwords(trim($post['user_name']));
        $data['user_type'] = 'Role User';
        $duplicate = $this->c_model->getSingle($this->table, 'id', $data);
        if ($duplicate && empty($id)) {
            $response['status'] = false;
            $response['message'] = 'Duplicate Entry';
            echo json_encode($response);
            exit;
        }   
        $data['user_email'] = trim($post['user_email']);
        $data['user_phone'] = trim($post['user_phone']);
        if(empty($id)){
            $password=generate_password(10);
            $data['enc_password'] = md5($password);
            sendEmailPassword($data['user_email'],$data['user_email'],$password);
        }

        $data['status'] = trim($post['status']);
        $last_id = '';
        if (empty($id)) {
            $data['add_date'] = date('Y-m-d H:i:s');
            $last_id = $this->c_model->insertRecords($this->table, $data);
            $message = 'Data Added Successfully';
        } else {
            $data['update_date'] = date('Y-m-d H:i:s');
            $this->c_model->updateRecords($this->table, $data, ['id' => $id]);
            $last_id = $id;
            $message = 'Data Updated Successfully';
        }
        $url = base_url(ADMINPATH . 'add-role-user') . '?id=' . $last_id;
        $response['status'] = true;
        $response['message'] = $message;
        $response['url'] = $url;
        echo json_encode($response);
        exit;
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
        $where['user_type'] = 'Role User';
        $searchString = null;
        if (!empty($get["search"]["value"])) {
            $searchString = trim($get["search"]["value"]);
            $where['user_type'] = 'Role User';
            $where["user_name LIKE '%" . $searchString . "%' OR user_email LIKE '%" . $searchString . "%' OR user_phone LIKE '%" . $searchString . "%' OR status LIKE '%" . $searchString . "%' "] = null;
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
        $select = '*,DATE_FORMAT(add_date , "%d-%m-%Y %r") AS add_date,DATE_FORMAT(update_date , "%d-%m-%Y %r") AS update_date,DATE_FORMAT(last_login , "%d-%m-%Y %r") AS last_login';
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
