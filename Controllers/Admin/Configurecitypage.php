<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Common_model;
class Configurecitypage extends BaseController {
    protected $c_model;
    protected $session;
    protected $table;
    public function __construct() {
        $this->c_model = new Common_model();
        $this->session = session();
        $this->table = "dt_all_cms_data";
        $this->page_type = 'seo';
    }
    function index() {
        $data = [];
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data["menu"] = "Configure City Page";
        $data["title"] = "Configure City Page";
        $data['access'] = checkWriteMenus(getUri(2));
        $data['tab_list'] = $this->c_model->getAllData('cms_tab_master', 'id,tab_name', ['status' => 'Active']);
        $data['city_list'] = $this->c_model->getAllData('cities', 'id,city_name,state_name', ['status' => 'Active'], null, null, 'ASC', 'city_name');
        $data['page_list'] = $this->c_model->getAllData($this->table, 'id,from_city_name,parent_id', ['status' => 'Active','page_type'=>'seo','parent_id'=>0], null, null, 'DESC', 'id');
        adminview('configure-city-page', $data);
    }
    function edit_city_seo_page() {
        $data = [];
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data["menu"] = "Edit City Seo Page";
        $data["title"] = "Edit City Seo Page";
        $data['access'] = checkWriteMenus(getUri(2));
        $savedData = $this->c_model->getSingle($this->table, '*', ['id' => $id]);
        $data['id'] = !empty($savedData['id']) ? $savedData['id'] : '';
        $data['page_type'] = $this->page_type;
        $data['page_name'] = !empty($savedData['page_name']) ? $savedData['page_name'] : '';
        $data['meta_title'] = !empty($savedData['meta_title']) ? $savedData['meta_title'] : '';
        $data['meta_keywords'] = !empty($savedData['meta_keywords']) ? $savedData['meta_keywords'] : '';
        $data['meta_description'] = !empty($savedData['meta_description']) ? $savedData['meta_description'] : '';
        $data['h_one_heading'] = !empty($savedData['h_one_heading']) ? $savedData['h_one_heading'] : '';
        $data['content_data'] = !empty($savedData['content_data']) ? $savedData['content_data'] : '';
        $data['page_slug'] = !empty($savedData['page_slug']) ? $savedData['page_slug'] : '';
        $data['banner_image_jpg'] = !empty($savedData['banner_image_jpg']) ? $savedData['banner_image_jpg'] : '';
        $data['banner_image_webp'] = !empty($savedData['banner_image_webp']) ? $savedData['banner_image_webp'] : '';
        $data['banner_image_alt'] = !empty($savedData['banner_image_alt']) ? $savedData['banner_image_alt'] : '';
        $data['page_schema'] = !empty($savedData['page_schema']) ? $savedData['page_schema'] : '';
        $data['faq_schema'] = !empty($savedData['faq_schema']) ? $savedData['faq_schema'] : '';
        $data['status'] = !empty($savedData['status']) ? $savedData['status'] : 'Active';
        $data['faqs'] = !empty($id) ? $this->c_model->getAllData("faqs", 'question,answer', ["table_name" => $this->table, 'table_list_id' => $id]) : [];
        adminview('add-city-seo-page', $data);
    }
    public function createPage() {
        $city = !empty($this->request->getPost('city')) ? explode(',', $this->request->getPost('city')) : [];
        $response = [];
        if (empty($city)) {
            $response['status'] = false;
            $response['message'] = 'Select City';
            echo json_encode($response);
            exit;
        }
        $checkCity=$this->c_model->getSingle($this->table,'id',['from_city_id'=>$city[0],'page_type'=>'seo']);
        
         if ($checkCity) {
            $response['status'] = false;
            $response['message'] = 'Duplicate Entry';
            echo json_encode($response);
            exit;
        }
        $tab_data = [];
        $tab_list = $this->c_model->getAllData('cms_tab_master', 'id, tab_name', ['status' => 'Active']);
        if (!empty($tab_list)) {
            foreach ($tab_list as $tlkey => $tlvalue) {
                $tabdata = ['tab_id' => $tlvalue['id'], 'cms_id' => ''];
                $tab_data[] = $tabdata;
            }
        }
        $data = ['from_city_id' => $city[0], 'from_city_name' => $city[1], 'page_type' => 'seo', 'tab_records' => json_encode($tab_data) ];
        $parent_id = $this->c_model->insertRecords($this->table, $data);
        if ($parent_id) {
            $response['status'] = true;
            $response['message'] = 'City Page Added Successfully';
            echo json_encode($response);
            exit;
        }
        $response['status'] = false;
        $response['message'] = 'Something Went Wrong';
        echo json_encode($response);
        exit;
    }
    public function save_city_seo_page() {
        $post = $this->request->getVar();
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        //echo '<pre>';
        //print_r( $post ); exit;
        $saveData = [];
        $saveData['page_name'] = ucwords(trim($post['page_name']));
        $duplicate = $this->c_model->getSingle($this->table, 'id', $saveData);
        if ($duplicate && empty($id)) {
            $this->session->setFlashdata('failed', 'Duplicate Entry');
            return redirect()->to(base_url(ADMINPATH . 'configure-city-page'));
        }
        /*Image image */
        $filename = $post['old_banner_image_jpg'];
        if ($fileImage = $this->request->getFile('banner_image_jpg')) {
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
                /** cloudianiry cdn upload**/
                if (!empty($fileDataImage['cdn_jpg'])) {
                    $saveData['banner_cdn_image_jpg'] = $fileDataImage['cdn_jpg'];
                }
                if (!empty($fileDataImage['cdn_webp'])) {
                    $saveData['banner_cdn_image_webp'] = $fileDataImage['cdn_webp'];
                }
                /** shivam cdn upload**/
            }
        }
        $saveData['page_slug'] = validate_slug(trim($post['page_slug']));
        $saveData['h_one_heading'] = trim($post['h_one_heading']);
        $saveData['content_data'] = trim($post['content_data']);
        $saveData['meta_title'] = trim($post['meta_title']);
        $saveData['meta_description'] = trim($post['meta_description']);
        $saveData['meta_keywords'] = trim($post['meta_keywords']);
        $saveData['banner_image_alt'] = trim($post['banner_image_alt']);
        $saveData['status'] = trim($post['status']);
        $saveData['page_schema'] = empty(($post['page_schema'])) ? generateProductSchema(trim($post['page_name']), $filename, trim($post['meta_description'])) : trim($post['page_schema']);
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
        $faq_data = [];
        $count = !empty($post["faq_question"]) ? count($post["faq_question"]) : 0;
        for ($i = 0;$i < $count;$i++) {
            if ($post["faq_question"][$i] == "" || $post["faq_answer"][$i] == "") {
                continue;
            }
            $arr = ["table_name" => $this->table, "table_list_id" => $last_id, "question" => $post["faq_question"][$i], "answer" => $post["faq_answer"][$i], "add_date" => date('Y-m-d H:i:s') ];
            array_push($faq_data, $arr);
        }
        if (!empty($faq_data) && count($faq_data) > 0) {
            $del = $this->c_model->deleteRecords("dt_faqs", ['table_list_id' => $last_id, "table_name" => $this->table]);
            if ($del == true) {
                $saveData = [];
                $saveData['faq_schema'] = generateFaqSchema($faq_data);
                $this->c_model->updateRecords($this->table, $saveData, ['id' => $last_id]);
                $this->c_model->insertBatchItems("dt_faqs", $faq_data);
            }
        }
        return redirect()->to(base_url(ADMINPATH . 'edit-city-seo-page' . ($id ? '?id=' . $id : '')));
    }
    function edit_tab_city_seo_page() {
        $data = [];
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $tab_id = !empty($this->request->getVar('tab_id')) ? $this->request->getVar('tab_id') : '';
        $parent_id = !empty($this->request->getVar('parent_id')) ? $this->request->getVar('parent_id') : '';
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data["menu"] = "Edit Tab City Seo Page";
        $data["title"] = "Edit Tab City Seo Page";
        $data['access'] = checkWriteMenus(getUri(2));
        $savedData = $this->c_model->getSingle($this->table, '*', ['cms_tab_id' => $tab_id,'parent_id'=>$parent_id]);
        $parentData = $this->c_model->getSingle($this->table, 'from_city_id,from_city_name', ['id' => $parent_id]);
        $data['id'] = !empty($savedData['id']) ? $savedData['id'] : '';
        $data['parent_id'] = $parent_id;
        $data['tab_id'] = $tab_id;
        $page_name= !empty($tab_id) ? str_replace('{City}',$parentData['from_city_name'],getTabName($tab_id)) : '';
        $data['page_type'] = $this->page_type;
        $data['from_city_id'] = !empty($parentData['from_city_id']) ? $parentData['from_city_id'] : '';
        $data['from_city_name'] = !empty($parentData['from_city_name']) ? $parentData['from_city_name'] : '';
        $data['page_name'] = !empty($savedData['page_name']) ? $savedData['page_name'] : $page_name;
        $data['meta_title'] = !empty($savedData['meta_title']) ? $savedData['meta_title'] : '';
        $data['meta_keywords'] = !empty($savedData['meta_keywords']) ? $savedData['meta_keywords'] : '';
        $data['meta_description'] = !empty($savedData['meta_description']) ? $savedData['meta_description'] : '';
        $data['h_one_heading'] = !empty($savedData['h_one_heading']) ? $savedData['h_one_heading'] : '';
        $data['content_data'] = !empty($savedData['content_data']) ? $savedData['content_data'] : '';
        $data['page_slug'] = !empty($savedData['page_slug']) ? $savedData['page_slug'] : '';
        $data['banner_image_jpg'] = !empty($savedData['banner_image_jpg']) ? $savedData['banner_image_jpg'] : '';
        $data['banner_image_webp'] = !empty($savedData['banner_image_webp']) ? $savedData['banner_image_webp'] : '';
        $data['banner_image_alt'] = !empty($savedData['banner_image_alt']) ? $savedData['banner_image_alt'] : '';
        $data['page_schema'] = !empty($savedData['page_schema']) ? $savedData['page_schema'] : '';
        $data['faq_schema'] = !empty($savedData['faq_schema']) ? $savedData['faq_schema'] : '';
        $data['status'] = !empty($savedData['status']) ? $savedData['status'] : 'Active';
        $data['faqs'] = !empty($savedData['id']) ? $this->c_model->getAllData("faqs", 'question,answer', ["table_name" => $this->table, 'table_list_id' => $savedData['id']]) : [];
        adminview('add-tab-city-seo-page', $data);
    }
    public function save_tab_city_seo_page() {
        $post = $this->request->getVar();
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $parent_id = !empty($this->request->getVar('parent_id')) ? $this->request->getVar('parent_id') : '';
        //echo '<pre>';
        //print_r( $post ); exit;
        $saveData = [];
        $saveData['page_name'] = ucwords(trim($post['page_name']));
        $saveData['page_type'] = 'seo';
        $duplicate = $this->c_model->getSingle($this->table, 'id', $saveData);
        if ($duplicate && empty($id)) {
            $this->session->setFlashdata('failed', 'Duplicate Entry');
            return redirect()->to(base_url(ADMINPATH . 'configure-city-page'));
        }
        /*Image image */
        $filename = $post['old_banner_image_jpg'];
        if ($fileImage = $this->request->getFile('banner_image_jpg')) {
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
                /** cloudianiry cdn upload**/
                if (!empty($fileDataImage['cdn_jpg'])) {
                    $saveData['banner_cdn_image_jpg'] = $fileDataImage['cdn_jpg'];
                }
                if (!empty($fileDataImage['cdn_webp'])) {
                    $saveData['banner_cdn_image_webp'] = $fileDataImage['cdn_webp'];
                }
                /** shivam cdn upload**/
            }
        }
        $saveData['page_slug'] = validate_slug(trim($post['page_slug']));
        $saveData['cms_tab_id'] = trim($post['tab_id']);
        $saveData['cms_tab_name'] = !empty($post['tab_id'])?getTabName($post['tab_id']):'';
        $saveData['parent_id'] = trim($post['parent_id']);
        $saveData['from_city_id'] = trim($post['from_city_id']);
        $saveData['from_city_name'] = trim($post['from_city_name']);
        $saveData['h_one_heading'] = trim($post['h_one_heading']);
        $saveData['content_data'] = trim($post['content_data']);
        $saveData['meta_title'] = trim($post['meta_title']);
        $saveData['meta_description'] = trim($post['meta_description']);
        $saveData['meta_keywords'] = trim($post['meta_keywords']);
        $saveData['banner_image_alt'] = trim($post['banner_image_alt']);
        $saveData['status'] = trim($post['status']);
        $saveData['page_schema'] = empty(($post['page_schema'])) ? generateProductSchema(trim($post['page_name']), $filename, trim($post['meta_description'])) : trim($post['page_schema']);
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
        $faq_data = [];
        $count = !empty($post["faq_question"]) ? count($post["faq_question"]) : 0;
        for ($i = 0;$i < $count;$i++) {
            if ($post["faq_question"][$i] == "" || $post["faq_answer"][$i] == "") {
                continue;
            }
            $arr = ["table_name" => $this->table, "table_list_id" => $last_id, "question" => $post["faq_question"][$i], "answer" => $post["faq_answer"][$i], "add_date" => date('Y-m-d H:i:s') ];
            array_push($faq_data, $arr);
        }
        if (!empty($faq_data) && count($faq_data) > 0) {
            $del = $this->c_model->deleteRecords("dt_faqs", ['table_list_id' => $last_id, "table_name" => $this->table]);
            if ($del == true) {
                $saveData = [];
                $saveData['faq_schema'] = generateFaqSchema($faq_data);
                $this->c_model->updateRecords($this->table, $saveData, ['id' => $last_id]);
                $this->c_model->insertBatchItems("dt_faqs", $faq_data);
            }
        }
        return redirect()->to(base_url(ADMINPATH . 'edit-tab-city-seo-page' . ('?parent_id=' . $post['parent_id'].'&tab_id='.$post['tab_id'])));
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
        $where['page_type'] = 'seo';
        $searchString = null;
        if (!empty($get["search"]["value"])) {
            $searchString = trim($get["search"]["value"]);
            //$where["package_name LIKE '%" . $searchString . "%'"] = null;
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
                $tab_records = json_decode($value['tab_records'], true);
                if (!empty($tab_records)) {
                    $tab_ids = [];
                    foreach ($tab_records as $trkey => $trvalue) {
                        $tab_ids[] = $trvalue['tab_id'];
                    }
                    $push['tab_id'] = $tab_ids;
                }
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
