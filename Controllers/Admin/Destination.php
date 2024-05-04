<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Common_model;
class Destination extends BaseController {
    protected $c_model;
    protected $session;
    protected $table;
    public function __construct() {
        $this->c_model = new Common_model();
        $this->session = session();
        $this->table = "dt_destinations";
    }
    function index() {
        $data = [];
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data["menu"] = "Destination Master";
        $data["title"] = "Destination List";
        $data['access']=checkWriteMenus(getUri(2));
        adminview('view-destination', $data);
    }
    function add_destination() {
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $data = [];
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data['access']=checkWriteMenus(getUri(2));
        $data["menu"] = "Destination Master";
        $data["title"] = !empty($id) ? "Edit Destination" : "Add Destination";
        $data['states'] = $this->c_model->getAllData("states",'id,state_name',['status'=>'Active']);
        $data['faqs'] = $this->c_model->getAllData("faqs", 'question,answer', ["table_name" => $this->table, 'table_list_id' => $id]);
        $savedData = $this->c_model->getSingle($this->table, '*', ['id' => $id]);
        $data['id'] = !empty($savedData['id']) ? $savedData['id'] : $id;
        $data['state_id'] = !empty($savedData['state_id']) ? $savedData['state_id'] : '';
        $data['state_name'] = !empty($savedData['state_name']) ? $savedData['state_name'] : '';
        $data['city_id'] = !empty($savedData['city_id']) ? $savedData['city_id'] : '';
        $data['city_name'] = !empty($savedData['city_name']) ? $savedData['city_name'] : '';
        $data['url'] = !empty($savedData['url']) ? $savedData['url'] : '';
        $data['h1'] = !empty($savedData['h1']) ? $savedData['h1'] : '';
        $data['description'] = !empty($savedData['description']) ? $savedData['description'] : '';
        $data['meta_title'] = !empty($savedData['meta_title']) ? $savedData['meta_title'] : '';
        $data['meta_description'] = !empty($savedData['meta_description']) ? $savedData['meta_description'] : '';
        $data['meta_keyword'] = !empty($savedData['meta_keyword']) ? $savedData['meta_keyword'] : '';
        $data['destination'] = !empty($savedData['destination']) ? $savedData['destination'] : '';
        $data['is_popular'] = !empty($savedData['is_popular']) ? $savedData['is_popular'] : 'Yes';
        $data['jpg_image'] = !empty($savedData['jpg_image']) ? $savedData['jpg_image'] : '';
        $data['webp_image'] = !empty($savedData['webp_image']) ? $savedData['webp_image'] : '';
        $data['image_alt'] = !empty($savedData['image_alt']) ? $savedData['image_alt'] : '';
        $data['faq_schema'] = !empty($savedData['faq_schema']) ? $savedData['faq_schema'] : '';
        $data['status'] = !empty($savedData['status']) ? $savedData['status'] : 'Active';
        adminview('add-destination', $data);
    }
    public function save_destination() {
        $post = $this->request->getVar();
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $data = [];
        $state = !empty($post['state']) ? explode(',', $post['state']) : [];
        $data['state_id'] = $state[0]??'';
        $data['state_name'] = $state[1]??'';
        $city = !empty($post['city']) ? explode(',', $post['city']) : [];
        $data['city_id'] = $city[0] ?? '';
        $cityNameParts = array_slice($city, 1, 3); 
        $data['city_name'] = implode(',', $cityNameParts);
        // echo "<pre>";
        // print_r($data);exit;
        $data['destination'] = ucwords(trim($post['destination']));
        $duplicate = $this->c_model->getSingle($this->table, 'id', $data);
        if ($duplicate && empty($id)) {
            $this->session->setFlashdata('failed', 'Duplicate Entry');
            return redirect()->to(base_url(ADMINPATH . 'destination-list'));
        }
        if ($file = $this->request->getFile('banner_image')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $filename = $file->getRandomName();
                if (is_file(ROOTPATH . 'uploads/' . $post['old_jpg_image']) && file_exists(ROOTPATH . 'uploads/' . $post['old_jpg_image'])) {
                    @unlink(ROOTPATH . 'uploads/' . $post['old_jpg_image']);
                }
                if (is_file(ROOTPATH . 'uploads/' . $post['old_webp_image']) && file_exists(ROOTPATH . 'uploads/' . $post['old_webp_image'])) {
                    @unlink(ROOTPATH . 'uploads/' . $post['old_webp_image']);
                }
                $image = \Config\Services::image()->withFile($file)->save(ROOTPATH . '/uploads/' . $filename);
                $webp_file = pathinfo($filename, PATHINFO_FILENAME) . '.webp';
                $webp_image = convertImageInToWebp('uploads', $filename, $webp_file);
                $data['jpg_image'] = $filename;
                $data['webp_image'] = $webp_image;
                
            }
        }
        $data['url'] = validate_slug(trim($post['url']));
        $data['h1'] = trim($post['h1']);
        $data['description'] = trim($post['description']);
        $data['is_popular'] = trim($post['is_popular']);
        $data['meta_title'] = trim($post['meta_title']);
        $data['meta_description'] = trim($post['meta_description']);
        $data['meta_keyword'] = trim($post['meta_keyword']);
        
        $data['image_alt'] = trim($post['image_alt']);
       
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
        $faq_data = [];
        $count = count($post["faq_question"]);
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
                $data['faq_schema'] = generateFaqSchema($faq_data);
                $this->c_model->updateRecords($this->table, $data, ['id' => $last_id]);
                $this->c_model->insertBatchItems("faqs", $faq_data);
            }
        }
        return redirect()->to(base_url(ADMINPATH . 'destination-list'));
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
