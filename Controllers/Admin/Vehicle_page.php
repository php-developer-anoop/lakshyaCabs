<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Common_model;
class Vehicle_page extends BaseController {
    protected $c_model;
    protected $session;
    protected $table;
    public function __construct() {
        $this->c_model = new Common_model();
        $this->session = session();
        $this->table = 'dt_vehicle_page_master';
    }
    function index() {
        $data = [];
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data["menu"] = "Vehicle Page Master";
        $data["title"] = "Vehicle Page List";
        $data['access'] = checkWriteMenus(getUri(2));
        adminview('view-vehicle-page', $data);
    }
    function add_vehicle_page() {
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $data = [];
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data['access'] = checkWriteMenus(getUri(2));
        $data["menu"] = "Vehicle Page Master";
        $data["title"] = !empty($id) ? "Edit Vehicle Page" : "Add Vehicle Page";
        $data['states'] = $this->c_model->getAllData('dt_states','id,state_name',['status'=>'Active']);
        $data['model_list'] = $this->c_model->getAllData('dt_vehicle_model','id,model_name',['status'=>'Active']);
        $savedData = $this->c_model->getSingle($this->table, '*', ['id' => $id]);
        $data['id'] = !empty($savedData['id']) ? $savedData['id'] : '';
        $data['h1_heading'] = !empty($savedData['h1_heading']) ? $savedData['h1_heading'] : '';
        $data['display_name'] = !empty($savedData['display_name']) ? $savedData['display_name'] : '';
        $data['slug'] = !empty($savedData['slug']) ? $savedData['slug'] : '';
        $data['model_id'] = !empty($savedData['model_id']) ? $savedData['model_id'] : '';
        $data['state_id'] = !empty($savedData['state_id']) ? $savedData['state_id'] : '';
        $data['city_id'] = !empty($savedData['city_id']) ? $savedData['city_id'] : '';
        $data['banner_image_jpg'] = !empty($savedData['banner_image_jpg']) ? $savedData['banner_image_jpg'] : '';
        $data['banner_image_webp'] = !empty($savedData['banner_image_webp']) ? $savedData['banner_image_webp'] : '';
        $data['banner_image_alt'] = !empty($savedData['banner_image_alt']) ? $savedData['banner_image_alt'] : '';
        $data['short_description'] = !empty($savedData['short_description']) ? $savedData['short_description'] : '';
        $data['description'] = !empty($savedData['description']) ? $savedData['description'] : '';
        $data['is_popular'] = !empty($savedData['is_popular']) ? $savedData['is_popular'] : 'No';
        $data['is_home'] = !empty($savedData['is_home']) ? $savedData['is_home'] : 'No';
        $data['meta_title'] = !empty($savedData['meta_title']) ? $savedData['meta_title'] : '';
        $data['meta_description'] = !empty($savedData['meta_description']) ? $savedData['meta_description'] : '';
        $data['meta_keyword'] = !empty($savedData['meta_keyword']) ? $savedData['meta_keyword'] : '';
        $data['faq_schema'] = !empty($savedData['faq_schema']) ? $savedData['faq_schema'] : '';
        $data['page_schema'] = !empty($savedData['page_schema']) ? $savedData['page_schema'] : '';
        $data['status'] = !empty($savedData['status']) ? $savedData['status'] : 'Active';
        $data['faqs'] = !empty($id) ? $this->c_model->getAllData("faqs", 'question,answer', ["table_name" => $this->table, 'table_list_id' => $id]) : [];
        adminview('add-vehicle-page', $data);
    }
    public function save_vehicle_page() {
        $post = $this->request->getVar();
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $saveData = [];
        $saveData['display_name'] = ucwords(trim($post['display_name']));
        $duplicate = $this->c_model->getSingle($this->table, 'id', $saveData);
        if ($duplicate && empty($id)) {
            $this->session->setFlashdata('failed', 'Duplicate Entry');
            return redirect()->to(base_url(ADMINPATH . 'vehicle-page-list'));
        }
        /*Image image */
        $filename = $post['old_banner_image_jpg'];
        if ($fileImage = $this->request->getFile('banner_image')) {
            $fileDataImage = uploadJpgWebp($fileImage, true);
            if (!empty($fileDataImage)) {
                if (!empty($fileDataImage['jpg'])) {
                    $saveData['banner_image_jpg'] = $fileDataImage['jpg'];
                    $filename = $saveData['banner_image_jpg'];
                    removeImage($post['old_banner_image_jpg']);
                }
                if (!empty($fileDataImage['webp'])) {
                    $saveData['banner_image_webp'] = $fileDataImage['webp'];
                    removeImage($post['old_banner_image_webp']);
                }
            }
        }
        $city = !empty($post['city'])?explode(',',$post['city']):[];
        $saveData['slug'] = validate_slug(trim($post['slug']));
        $saveData['h1_heading'] = trim($post['h1_heading']);
        $saveData['model_id'] = trim($post['model_id']);
        $saveData['state_id'] = trim($post['state_id']);
        $saveData['state_name'] = trim(getStateName($post['state_id']));
        $saveData['city_id'] = $city[0]??'';
        $saveData['city_name'] = $city[1]??'';
        $saveData['meta_title'] = trim($post['meta_title']);
        $saveData['meta_description'] = trim($post['meta_description']);
        $saveData['meta_keyword'] = trim($post['meta_keyword']);
        $saveData['banner_image_alt'] = trim($post['banner_image_alt']);
        $saveData['short_description'] = trim($post['short_description']);
        $saveData['description'] = trim($post['description']);
        $saveData['is_popular'] = trim($post['is_popular']);
        $saveData['is_home'] = trim($post['is_home']);
        $saveData['status'] = trim($post['status']);
        $saveData['page_schema'] = empty(($post['page_schema'])) ? generateProductSchema(trim($post['display_name']), $filename, trim($post['meta_description'])) : trim($post['page_schema']);
        $last_id = '';
        if (empty($id)) {
            $saveData['add_date'] = date('Y-m-d H:i:s');
            $last_id = $this->c_model->insertRecords($this->table, $saveData);
            $this->session->setFlashdata('success', 'Data Added Successfully ');
        } else {
            $saveData['update_date'] = date('Y-m-d H:i:s');
            $this->c_model->updateRecords($this->table, $saveData, ['id' => $id]);
            $last_id = $id;
            $this->session->setFlashdata('success', 'Data Updated Successfully');
        }
        $faq_data = [];
        $count = !empty($post["faq_question"]) ? count($post["faq_question"]) : 0;
        for ($i = 0;$i < $count;$i++) {
            if ($post["faq_question"][$i] == "" || $post["faq_answer"][$i] == "") {
                continue;
            }
            $arr = ["table_name" => $this->table, "table_list_id" => $last_id, "question" => $post["faq_question"][$i], "answer" => $post["faq_answer"][$i], "add_date" => date('Y-m-d H:i:s') ];
            array_push($faq_data, $arr);
        }
        if (count($faq_data) > 0) {
            $del = $this->c_model->deleteRecords("faqs", ['table_list_id' => $last_id, "table_name" => $this->table]);
            if ($del == true) {
                $saveData = [];
                $saveData['faq_schema'] = generateFaqSchema($faq_data);
                $this->c_model->updateRecords($this->table, $saveData, ['id' => $last_id]);
                $this->c_model->insertBatchItems("dt_faqs", $faq_data);
            }
        }
        return redirect()->to(base_url(ADMINPATH . 'vehicle-page-list'));
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
        // $where['page_type'] = $this->page_type;
        $searchString = null;
        if (!empty($get["search"]["value"])) {
            $searchString = trim($get["search"]["value"]);
            $where["(display_name LIKE '%" . $searchString . "%' OR slug LIKE '%" . $searchString . "%') "] = null;
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
        $url = base_url('');
        $select = 'id,display_name,status,slug,CONCAT("' . $url . '",slug) as page_url,DATE_FORMAT(add_date , "%d-%m-%Y %r") AS add_date,DATE_FORMAT(update_date , "%d-%m-%Y %r") AS update_date,is_popular,is_home';
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
