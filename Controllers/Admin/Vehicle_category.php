<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Common_model;
class Vehicle_category extends BaseController {
    protected $c_model;
    protected $session;
    protected $table;
    public function __construct() {
        $this->c_model = new Common_model();
        $this->session = session();
        $this->table = "dt_vehicle_category";
    }
    function index() {
        $data = [];
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data["menu"] = "Vehicle Category Master";
        $data["title"] = "Vehicle Category List";
        $data['access']=checkWriteMenus(getUri(2));
        adminview('view-vehicle-category', $data);
    }
    function add_vehicle_category() {
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $data = [];
        $loginData = $this->session->get('admin_login_data');
        $data['user_type'] = $loginData['role'];
        $data['access']=checkWriteMenus(getUri(2));
        $data["menu"] = "Vehicle Category Master";
        $data["title"] = !empty($id) ? "Edit Vehicle Category" : "Add Vehicle Category";
       
        $savedData = $this->c_model->getSingle($this->table, '*', ['id' => $id]);
        $data['id'] = !empty($savedData['id']) ? $savedData['id'] : $id;
        $data['category_name'] = !empty($savedData['category_name']) ? $savedData['category_name'] : '';
        $data['priority'] = !empty($savedData['priority']) ? $savedData['priority'] : '';
        $data['jpg_image'] = !empty($savedData['jpg_image']) ? $savedData['jpg_image'] : '';
        $data['webp_image'] = !empty($savedData['webp_image']) ? $savedData['webp_image'] : '';
        $data['image_alt'] = !empty($savedData['image_alt']) ? $savedData['image_alt'] : '';
        $data['status'] = !empty($savedData['status']) ? $savedData['status'] : 'Active';
        adminview('add-vehicle-category', $data);
    }
    public function save_vehicle_category() {
        $post = $this->request->getVar();
        $id = !empty($this->request->getVar('id')) ? $this->request->getVar('id') : '';
        $data = [];
        $data['category_name'] = ucwords(trim($post['category_name']));
        $duplicate = $this->c_model->getSingle($this->table, 'id', $data);
        if ($duplicate && empty($id)) {
            $this->session->setFlashdata('failed', 'Duplicate Entry');
            return redirect()->to(base_url(ADMINPATH . 'vehicle-category-list'));
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
        $data['priority'] = trim($post['priority']);
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

       
        return redirect()->to(base_url(ADMINPATH . 'vehicle-category-list'));
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
            $where["category_name LIKE '%" . $searchString . "%'"] = null;
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
