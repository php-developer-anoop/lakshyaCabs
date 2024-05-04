<?php
namespace App\Controllers\Vendor;
use App\Controllers\BaseController;
use App\Models\Common_model;
class Wallet extends BaseController {
    protected $c_model;
    public function __construct() {
        $this->c_model = new Common_model();
    }
    public function index() {
        $data = [];
        $data['title'] = 'My Wallet';
        $data['menu'] = 'My Wallet';
        $data['plan_list'] = $this->c_model->getAllData('recharge_plans', 'amount', ['status' => 'Active']);
        vendorView('wallet', $data);
    }
    public function getToken() {
        $post = $this->request->getVar();
        $vendor = getVendorProfile();
        $vendor_id = isset($vendor['id']) ? trim($vendor['id']) : null;
        if (!$vendor_id && !empty($post['id'])) {
            $vendor_id = $post['id'];
        }
        $amount = !empty($post['amount']) ? trim($post['amount']) : 0;
        $response = [];
        // Check if user ID is empty
        if (empty($vendor_id)) {
            $response['status'] = false;
            $response['message'] = 'No Direct Access Allowed';
            echo json_encode($response);
            exit;
        }
        if ($amount == '' || $amount < 10) {
            $response['status'] = false;
            $response['message'] = 'Amount Should be more than 10 INR';
            echo json_encode($response);
            exit;
        }
        $payLoad = ['user_id' => $vendor_id,'user_type'=>'Vendor', 'amount' => $amount, 'app_type' => 'web'];
        $postUrl = base_url("api/v1/customer/generate_orderid");
        $getdata = curlApis($postUrl, 'POST', $payLoad);
        // echo "<pre>";
        // print_r($getdata);exit;
        if (empty($getdata['status'])) {
            $response['status'] = false;
            $response['message'] = isset($getdata['message']) ? $getdata['message'] : 'Error occurred while processing request';
            echo json_encode($response);
            exit;
        }
        echo json_encode($getdata);
        exit;
    }
    public function cashfree_success() {
        $post = $this->request->getVar();
        $transactionData = $this->c_model->getSingle('transaction_log', '*', ['order_id' => $post['order_id']]);
        if (empty($transactionData)) {
            $this->session->setFlashData('failed', 'No Data Found');
            return redirect()->to(base_url());
        }
        // Check Final Status
        if ($transactionData['final_status'] == 'yes') {
            $this->session->setFlashData('failed', 'Payment Is Already Done');
            return redirect()->to(base_url());
        }
        //Verify Transaction From Cashfree
        $payLoad = ['user_id' => $transactionData['user_id'],'user_type' => $transactionData['user_type'], 'order_id' => $post['order_id']];
        $postUrl = base_url("api/v1/customer/add_amount");
        $getdata = curlApis($postUrl, 'POST', $payLoad);
        
        $this->session->setFlashData('success', $getdata['message']);
        return redirect()->to(base_url(VENDORPATH . 'my-wallet'));
        
    }
    public function my_wallet_data() {
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
            $where[" credit_debit LIKE '%" . $searchString . "%' OR txn_amount LIKE '%" . $searchString . "%' OR reference_id LIKE '%" . $searchString . "%'"] = null;
            $limit = 100;
            $start = 0;
        }
        
        if ($is_count == "yes") {
            $countData = $this->c_model->countRecords('wallet', $where, 'id');
            echo (int)(!empty($countData) ? sizeof($countData) : 0);
            exit();
        }
        if (!empty($get["showRecords"])) {
            $limit = $get["showRecords"];
            $orderby = "DESC";
        }
        $select = '*,DATE_FORMAT(created_date , "%d/%m/%Y %r") AS add_date';
        
        $listData = $this->c_model->getAllData('wallet', $select, $where, $limit, $start, $orderby);
        $result = [];
        if (!empty($listData)) {
            $i = $start + 1;
            foreach ($listData as $key => $value) {
                $push = [];
                $push = $value;
                $push["sr_no"] = $i;
                $push["order_status"] = getPaymentOrderStatus($value['reference_id']);
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
