<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Common_model;


class CmsTabMaster extends BaseController {
    
    protected $c_model;
    protected $session;
    protected $table;
     
    
    public function __construct() {
        $this->c_model = new Common_model();
        $this->session = session();
        $this->table = 'dt_cms_tab_master'; 
    }
    
    
    function index() {
        $data = [];
        $loginData = $this->session->get('admin_login_data');
        $data['user_type']  = $loginData['role'];
        $data["menu"]       = "Route CMS Master";
        $data["title"]      = "Route CMS List";
        $data['access']     = checkWriteMenus(getUri(2));
        
        adminview('view-cms-tab', $data);
    }
    
    
    
    function add_tab() {
        
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $data = [];
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data['access']=checkWriteMenus(getUri(2));
        
        $data["menu"] = "CMS Tab Master";
        $data["title"] = !empty($id) ? "Edit CMS Tab " : "Add CMS Tab";
        
        
        $savedData = $this->c_model->getSingle($this->table, '*', ['id' => $id]);
        $data['id'] = !empty($savedData['id']) ? $savedData['id'] : ''; 
        $data['tab_name']          = !empty($savedData['tab_name']) ? $savedData['tab_name'] : '';
        $data['trip_type']          = !empty($savedData['trip_type']) ? $savedData['trip_type'] : '';
        $data['priority']         = !empty($savedData['priority']) ? $savedData['priority'] : '';
        $data['status']             = !empty($savedData['status']) ? $savedData['status'] : 'Active';
        
        $data['trip_type_list'] =  dropDownList('dt_trip_type_master', ['status'=>'Active'], 'trip_type', 'trip_type','Select Trip Type');
        $data['view_page_link'] =  'routes-list';
        $data['post_data_url']  =  'save-route';
        
        adminview('add-cms-tab', $data);
    }
    
    
    
    
    public function save_tab() {
        $post = $this->request->getVar();
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        
        //echo '<pre>';
        //print_r( $post ); exit;
        
        $saveData = [];
        $saveData['tab_name'] = ucwords(trim($post['tab_name']));
        $saveData['trip_type'] = ucwords(trim($post['trip_type']));
        $duplicate = $this->c_model->getSingle($this->table, 'id', $saveData);
        
        if ($duplicate && empty($id)) {
            $this->session->setFlashdata('failed', 'Duplicate Entry');
            return redirect()->to(base_url(ADMINPATH . 'routes-list'));
        }


        
        $saveData['status'] = trim($post['status']); 
        $saveData['priority'] = trim($post['priority']);  
        
        
        $last_id = '';
        
        if (empty($id)) {
            $saveData['add_date'] = date('Y-m-d H:i:s');
            $last_id = $this->c_model->insertRecords($this->table, $saveData);
            $this->session->setFlashdata('success', 'Data Added Successfully ');
        } else {
            $saveData['updated_on'] = date('Y-m-d H:i:s');
            $this->c_model->updateRecords($this->table, $saveData, ['id' => $id]);
            $last_id = $id;
            $this->session->setFlashdata('success', 'Data Updated Successfully');
        }
       
       
        return redirect()->to( base_url(ADMINPATH . 'add-cms-tabs'.( $id ? '?id='.$id : '') ));
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
            $where["(tab_name LIKE '%" . $searchString . "%' OR trip_type LIKE '%" . $searchString . "%' ) "] = null;
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
            $orderby = "ASC";
        }
        
        $url = base_url();
        $select = 'id,tab_name,status,priority,trip_type,DATE_FORMAT(add_date , "%d-%m-%Y %r") AS add_date,';
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