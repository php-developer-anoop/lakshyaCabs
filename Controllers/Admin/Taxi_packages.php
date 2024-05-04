<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Common_model;
class Taxi_packages extends BaseController {
    protected $c_model;
    protected $session;
    protected $table;
    public function __construct() {
        $this->c_model = new Common_model();
        $this->session = session();
        $this->table = "dt_taxi_package_list";
    }
    function index() {
        $data = [];
        $data["menu"] = "Taxi Package Master";
        $data["title"] = "Taxi Package List";
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data['access']=checkWriteMenus(getUri(2));
        adminview('view-taxi-package', $data);
    }
    function add_taxi_package() {
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $data = [];
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data['access']=checkWriteMenus(getUri(2));
        $data["menu"] = "Taxi Package Master";
        $data["title"] = !empty($id) ? "Edit Taxi Package" : "Add Taxi Package";
        $data['models'] = $this->c_model->getAllData("vehicle_model",'id,model_name',['status'=>'Active']);
        $data['cities'] = $this->c_model->getAllData("cities",'id,city_name',['status'=>'Active']);
        $data['faqs'] = $this->c_model->getAllData("faqs", 'question,answer', ["table_name" => $this->table, 'table_list_id' => $id]);
        $data['vehicle_price_list'] = $this->c_model->getAllData("taxi_package_vehicle_price", 'model_id,fixed_price,per_km_price', ['taxi_package_id' => $id]);
        $savedData = $this->c_model->getSingle($this->table, '*', ['id' => $id]);
        $data['id'] = !empty($savedData['id']) ? $savedData['id'] : $id;
        $data['package_name'] = !empty($savedData['package_name']) ? $savedData['package_name'] : '';
        $data['package_title'] = !empty($savedData['package_title']) ? $savedData['package_title'] : '';
        $data['url'] = !empty($savedData['url']) ? $savedData['url'] : '';
        $data['h1'] = !empty($savedData['h1']) ? $savedData['h1'] : '';
        $data['description'] = !empty($savedData['description']) ? $savedData['description'] : '';
        $data['itd_list'] = !empty($savedData['itenary_description']) ? json_decode($savedData['itenary_description'],true) : [];
        $data['cancellation_terms_conditions'] = !empty($savedData['cancellation_terms_conditions']) ? $savedData['cancellation_terms_conditions'] : '';
        $data['meta_title'] = !empty($savedData['meta_title']) ? $savedData['meta_title'] : '';
        $data['meta_description'] = !empty($savedData['meta_description']) ? $savedData['meta_description'] : '';
        $data['meta_keyword'] = !empty($savedData['meta_keyword']) ? $savedData['meta_keyword'] : '';
        $data['is_home'] = !empty($savedData['is_home']) ? $savedData['is_home'] : 'Yes';
        $data['is_popular'] = !empty($savedData['is_popular']) ? $savedData['is_popular'] : 'Yes';
        $data['jpg_image'] = !empty($savedData['jpg_image']) ? $savedData['jpg_image'] : '';
        $data['webp_image'] = !empty($savedData['webp_image']) ? $savedData['webp_image'] : '';
        $data['image_alt'] = !empty($savedData['image_alt']) ? $savedData['image_alt'] : '';
        $data['bottom_banner_jpg'] = !empty($savedData['bottom_banner_jpg']) ? $savedData['bottom_banner_jpg'] : '';
        $data['bottom_banner_webp'] = !empty($savedData['bottom_banner_webp']) ? $savedData['bottom_banner_webp'] : '';
        $data['bottom_banner_image_alt'] = !empty($savedData['bottom_banner_image_alt']) ? $savedData['bottom_banner_image_alt'] : '';
        $data['page_schema'] = !empty($savedData['page_schema']) ? $savedData['page_schema'] : '';
        $data['priority'] = !empty($savedData['priority']) ? $savedData['priority'] : '';
        $data['mrp_price'] = !empty($savedData['mrp_price']) ? $savedData['mrp_price'] : '';
        $data['offer_price'] = !empty($savedData['offer_price']) ? $savedData['offer_price'] : '';
        $data['from_city'] = !empty($savedData['from_city']) ? $savedData['from_city'] : '';
        $data['covered_kms'] = !empty($savedData['covered_kms']) ? $savedData['covered_kms'] : '';
        $data['short_description'] = !empty($savedData['short_description']) ? $savedData['short_description'] : '';
        $data['faq_schema'] = !empty($savedData['faq_schema']) ? $savedData['faq_schema'] : '';
        $data['inclusion'] = !empty($savedData['inclusion']) ? $savedData['inclusion'] : '';
        $data['exclusion'] = !empty($savedData['exclusion']) ? $savedData['exclusion'] : '';
        $data['to_city'] = !empty($savedData['to_city']) ? explode('|',$savedData['to_city']) : [];
        $data['status'] = !empty($savedData['status']) ? $savedData['status'] : 'Active';
        adminview('add-taxi-package', $data);
    }
    public function save_taxi_package() {
        $post = $this->request->getVar();
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $data = [];
        $data['package_title'] = (trim($post['package_title']));
        $duplicate = $this->c_model->getSingle($this->table, 'id', $data);
        if ($duplicate && empty($id)) {
            $this->session->setFlashdata('failed', 'Duplicate Entry');
            return redirect()->to(base_url(ADMINPATH . 'taxi-packages-list'));
        }
        $filename = $post['old_jpg_image'];
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
         
        if ($file = $this->request->getFile('bottom_banner')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $filenamebb = $file->getRandomName();
                if (is_file(ROOTPATH . 'uploads/' . $post['old_bottom_banner_jpg']) && file_exists(ROOTPATH . 'uploads/' . $post['old_bottom_banner_jpg'])) {
                    @unlink(ROOTPATH . 'uploads/' . $post['old_bottom_banner_jpg']);
                }
                if (is_file(ROOTPATH . 'uploads/' . $post['old_bottom_banner_webp']) && file_exists(ROOTPATH . 'uploads/' . $post['old_bottom_banner_webp'])) {
                    @unlink(ROOTPATH . 'uploads/' . $post['old_bottom_banner_webp']);
                }
                $image = \Config\Services::image()->withFile($file)->save(ROOTPATH . '/uploads/' . $filenamebb);
                $webp_file = pathinfo($filenamebb, PATHINFO_FILENAME) . '.webp';
                $webp_image = convertImageInToWebp('uploads', $filenamebb, $webp_file);
                $data['bottom_banner_jpg'] = $filenamebb;
                $data['bottom_banner_webp'] = $webp_image;
                
            }
        }
        $data['package_name'] = trim($post['package_name']);
        $data['url'] = validate_slug(trim($post['url']));
        $data['h1'] = trim($post['h1']);
        $data['description'] = trim($post['package_description']);
        $data['cancellation_terms_conditions'] = trim($post['cancellation_terms_conditions']);
        $data['is_popular'] = trim($post['is_popular']);
        $data['is_home'] = trim($post['is_home']);
        $data['meta_title'] = trim($post['meta_title']);
        $data['meta_description'] = trim($post['meta_description']);
        $data['meta_keyword'] = trim($post['meta_keyword']);
        $data['image_alt'] = trim($post['image_alt']);
        $data['status'] = trim($post['status']);
        $data['priority'] = trim($post['priority']);
        $data['from_city'] = trim($post['from_city']);
        $data['covered_kms'] = trim($post['covered_kms']);
        $data['short_description'] = trim($post['short_description']);
        $data['inclusion'] = trim($post['inclusion']);
        $data['exclusion'] = trim($post['exclusion']);
        $data['to_city'] = !empty($post['to_city'])?implode('|',$post['to_city']):'';
        $data['from_to_city'] = $data['from_city'].'|'.$data['to_city'];
        $data['page_schema'] = empty(($post['page_schema']))?generateProductSchema(trim($post['package_title']),$filename,trim($post['meta_description'])):trim($post['page_schema']);
    //    echo "<pre>";
    //    print_r($data);exit;
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
        $vp_data = [];
        $vpcount = count($post["model_id"]);
        for ($i = 0;$i < $vpcount;$i++) {
            if ($post["model_id"][$i] == "" || $post["fixed_price"][$i] == "" || $post["per_km_price"][$i] == "") {
                continue;
            }
            $arr = [ "taxi_package_id" => $last_id, "model_id" => $post["model_id"][$i], "fixed_price" => $post["fixed_price"][$i],"per_km_price" => $post["per_km_price"][$i], "add_date" => date('Y-m-d H:i:s'),'status'=>'Active' ];
            array_push($vp_data, $arr);
        }
        if (count($vp_data) > 0) {
            $del = $this->c_model->deleteRecords("taxi_package_vehicle_price", ['taxi_package_id' => $last_id]);
            if ($del == true) {
                $this->c_model->insertBatchItems("taxi_package_vehicle_price", $vp_data);
            }
        }
        $itd_data = [];
        $itdcount = count($post["day"]);
        for ($i = 0;$i < $itdcount;$i++) {
            if ($post["day"][$i] == "" || $post["title"][$i] == "" || $post["description"][$i] == "") {
                continue;
            }
            $arr = [ "day" => $post["day"][$i], "title" => $post["title"][$i],"description" => $post["description"][$i]];
            array_push($itd_data, $arr);
        }
        if (count($itd_data) > 0) {
            $data['itenary_description'] = json_encode($itd_data);
            $this->c_model->updateRecords($this->table, $data, ['id' => $last_id]);
            
        }
        return redirect()->to(base_url(ADMINPATH . 'taxi-packages-list'));
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
            $where[" package_name LIKE '%" . $searchString . "%' OR package_title LIKE '%" . $searchString . "%'"] = null;
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
        $url=base_url();
        $select = '*,CONCAT("'.$url.'",url) as slug,DATE_FORMAT(add_date , "%d-%m-%Y %r") AS add_date,DATE_FORMAT(update_date , "%d-%m-%Y %r") AS update_date';
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
