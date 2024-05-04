<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Common_model;
class Popular_route extends BaseController {
    protected $c_model;
    protected $session;
    protected $table;
    protected $page_type;
    public function __construct() {
        $this->c_model = new Common_model();
        $this->session = session();
        $this->table = 'dt_all_cms_data';
        $this->page_type = 'route';
    }
    function index() {
        $data = [];
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data["menu"] = "Route CMS Master";
        $data["title"] = "Route CMS List";
        $data['access'] = checkWriteMenus(getUri(2));
        adminview('view-popular-route', $data);
    }
    function add_route() {
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $data = [];
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data['access'] = checkWriteMenus(getUri(2));
        $data["menu"] = "Route CMS Master";
        $data["title"] = !empty($id) ? "Edit Route CMS" : "Add Route CMS";
        $savedData = $this->c_model->getSingle($this->table, '*', ['id' => $id]);
        $data['id'] = !empty($savedData['id']) ? $savedData['id'] : '';
        $data['page_type'] = $this->page_type;
        $data['page_name'] = !empty($savedData['page_name']) ? $savedData['page_name'] : '';
        $data['trip_type'] = !empty($savedData['trip_type']) ? $savedData['trip_type'] : '';
        $data['meta_title'] = !empty($savedData['meta_title']) ? $savedData['meta_title'] : '';
        $data['meta_keywords'] = !empty($savedData['meta_keywords']) ? $savedData['meta_keywords'] : '';
        $data['meta_description'] = !empty($savedData['meta_description']) ? $savedData['meta_description'] : '';
        $data['h_one_heading'] = !empty($savedData['h_one_heading']) ? $savedData['h_one_heading'] : '';
        $data['content_data'] = !empty($savedData['content_data']) ? $savedData['content_data'] : '';
        $data['short_content'] = !empty($savedData['short_content']) ? $savedData['short_content'] : '';
        $data['parent_id'] = !empty($savedData['parent_id']) ? $savedData['parent_id'] : '';
        $data['from_city_id'] = !empty($savedData['from_city_id']) ? $savedData['from_city_id'] : '';
        $data['to_city_id'] = !empty($savedData['to_city_id']) ? $savedData['to_city_id'] : '';
        $data['days'] = !empty($savedData['days']) ? $savedData['days'] : '';
        $data['nights'] = !empty($savedData['nights']) ? $savedData['nights'] : '';
        $data['distance_km'] = !empty($savedData['distance_km']) ? $savedData['distance_km'] : '';
        $data['covered_city'] = !empty($savedData['covered_city']) ? $savedData['covered_city'] : '';
        $data['page_slug'] = !empty($savedData['page_slug']) ? $savedData['page_slug'] : '';
        $data['banner_image_jpg'] = !empty($savedData['banner_image_jpg']) ? $savedData['banner_image_jpg'] : '';
        $data['banner_image_webp'] = !empty($savedData['banner_image_webp']) ? $savedData['banner_image_webp'] : '';
        $data['banner_image_alt'] = !empty($savedData['banner_image_alt']) ? $savedData['banner_image_alt'] : '';
        $data['mrp_price'] = !empty($savedData['mrp_price']) ? $savedData['mrp_price'] : '';
        $data['offer_price'] = !empty($savedData['offer_price']) ? $savedData['offer_price'] : '';
        $data['banner_cdn_image_jpg'] = !empty($savedData['banner_cdn_image_jpg']) ? $savedData['banner_cdn_image_jpg'] : '';
        $data['banner_cdn_image_webp'] = !empty($savedData['banner_cdn_image_webp']) ? $savedData['banner_cdn_image_webp'] : '';
        $data['no_of_person'] = !empty($savedData['no_of_person']) ? $savedData['no_of_person'] : '';
        $data['cab_id'] = !empty($savedData['cab_id']) ? $savedData['cab_id'] : '';
        $data['page_schema'] = !empty($savedData['page_schema']) ? $savedData['page_schema'] : '';
        $data['faq_schema'] = !empty($savedData['faq_schema']) ? $savedData['faq_schema'] : '';
        $data['status'] = !empty($savedData['status']) ? $savedData['status'] : 'Active';
        $data['faqs'] = !empty($id) ? $this->c_model->getAllData("faqs", 'question,answer', ["table_name" => $this->table, 'table_list_id' => $id]) : [];
        $data['trip_type_list'] = dropDownList('dt_trip_type_master', ['status' => 'Active'], 'trip_type', 'trip_type', 'Select Trip Type');
        $data['view_page_link'] = 'routes-list';
        $data['post_data_url'] = 'save-route';
        adminview('add-popular-route', $data);
    }
    public function save_route() {
        $post = $this->request->getVar();
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        //echo '<pre>';
        //print_r( $post ); exit;
        $saveData = [];
        $saveData['page_name'] = ucwords(trim($post['page_name']));
        $duplicate = $this->c_model->getSingle($this->table, 'id', $saveData);
        if ($duplicate && empty($id)) {
            $this->session->setFlashdata('failed', 'Duplicate Entry');
            return redirect()->to(base_url(ADMINPATH . 'routes-list'));
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
        $saveData['from_city_id'] = trim($post['from_city_id']);
        $saveData['from_city_name'] = trim(explodeMe($post['from_city'], ',', 0));
        $saveData['to_city_id'] = trim($post['to_city_id']);
        $saveData['to_city_name'] = trim(explodeMe($post['drop_city'], ',', 0));
        $saveData['content_data'] = trim($post['content_data']);
        $saveData['meta_title'] = trim($post['meta_title']);
        $saveData['meta_description'] = trim($post['meta_description']);
        $saveData['meta_keywords'] = trim($post['meta_keywords']);
        $saveData['banner_image_alt'] = trim($post['banner_image_alt']);
        $saveData['status'] = trim($post['status']);
        $saveData['page_schema'] = empty(($post['page_schema'])) ? generateProductSchema(trim($post['page_name']), $filename, trim($post['meta_description'])) : trim($post['page_schema']);
        $saveData['page_type'] = $this->page_type;
        $saveData['trip_type'] = trim($post['trip_type']);
        $saveData['is_updated'] = 'updated';
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
        return redirect()->to(base_url(ADMINPATH . 'add-route' . ($id ? '?id=' . $id : '')));
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
        $where['page_type'] = $this->page_type;
        $searchString = null;
        if (!empty($get["search"]["value"])) {
            $searchString = trim($get["search"]["value"]);
            $where["(page_name LIKE '%" . $searchString . "%' OR page_slug LIKE '%" . $searchString . "%' OR from_city_name LIKE '%" . $searchString . "%' OR to_city_name LIKE '%" . $searchString . "%' ) "] = null;
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
        $url = base_url();
        $select = 'id,page_name,status,page_slug,CONCAT("' . base_url('') . '",page_slug) as page_url,DATE_FORMAT(add_date , "%d-%m-%Y %r") AS add_date,DATE_FORMAT(updated_on , "%d-%m-%Y %r") AS update_date,banner_image_jpg,banner_image_webp,footer_image_jpg,footer_image_webp,is_updated';
        $listData = $this->c_model->getAllData($this->table, $select, $where, $limit, $start, $orderby);
        $result = [];
        if (!empty($listData)) {
            $i = $start + 1;
            foreach ($listData as $key => $value) {
                $push = [];
                $push = $value;
                $push["sr_no"] = $i;
                // $imageList = [];
                // if(!empty($value['banner_image_jpg'])){
                //     $imageList[] = $value['banner_image_jpg'];
                // }
                // if(!empty($value['banner_image_webp'])){
                //     $imageList[] = $value['banner_image_webp'];
                // }
                // if(!empty($value['footer_image_webp'])){
                //     $imageList[] = $value['footer_image_webp'];
                // }
                // if(!empty($value['footer_image_jpg'])){
                //     $imageList[] = $value['footer_image_jpg'];
                // }
                // $this->copyAndConvertImages( 'https://lakshyacabs.com/uploads' , 'uploads/', $imageList );
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
    protected function copyAndConvertImages($sourceUrl, $destinationPath, $imageFiles) {
        // Create directory if it doesn't exist
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        // Get list of image files from source server
        //$imageFiles = scandir($sourceUrl);
        // Loop through each image file
        foreach ($imageFiles as $imageFile) {
            // Check if it's a valid image file (you might want to add more checks here)
            if (preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $imageFile)) {
                // Construct source and destination paths
                $sourceImagePath = $sourceUrl . '/' . $imageFile;
                $destinationImagePath = $destinationPath . '/' . $imageFile;
                // Check if the image already exists in the destination directory
                if (!file_exists($destinationImagePath)) {
                    // Copy the image file
                    copy($sourceImagePath, $destinationImagePath);
                }
            }
        }
    }
}
