<?php
namespace App\Controllers\Vendor;
use App\Controllers\BaseController;
use App\Models\Common_model;
class Notification extends BaseController {
    protected $c_model;
    public function __construct() {
        $this->c_model = new Common_model();
    }
    public function index() {
        $data = [];
        $data['title'] = 'My Notifications';
        $data['menu'] = 'My Notifications';
        vendorView('notification-list', $data);
    }
    public function my_notification_data() {
        $post = $this->request->getVar();
        $get = $this->request->getVar();
        $limit = (int)(!empty($get["length"]) ? $get["length"] : 1);
        $start = (int)!empty($get["start"]) ? $get["start"] : 0;
        $is_count = !empty($post["is_count"]) ? $post["is_count"] : "";
        $totalRecords = !empty($get["recordstotal"]) ? $get["recordstotal"] : 0;
        $orderby = "DESC";
        $where = [];
        $user = getVendorProfile();
        $where['user_id'] = $user['id'];
        $where['user_type'] = 'Vendor';
        $searchString = null;
        if (!empty($get["search"]["value"])) {
            $searchString = trim($get["search"]["value"]);
            $where[" title LIKE '%" . $searchString . "%' OR description LIKE '%" . $searchString . "%'"] = null;
            $limit = 100;
            $start = 0;
        }
        
        if ($is_count == "yes") {
            $countData = $this->c_model->countRecords('notification_list', $where, 'id');
            echo (int)(!empty($countData) ? sizeof($countData) : 0);
            exit();
        }
        if (!empty($get["showRecords"])) {
            $limit = $get["showRecords"];
            $orderby = "DESC";
        }
        $select = '*,DATE_FORMAT(add_date , "%d/%m/%Y %r") AS add_date';
        
        $listData = $this->c_model->getAllData('notification_list', $select, $where, $limit, $start, $orderby);
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