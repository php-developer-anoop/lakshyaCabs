<?php
namespace App\Controllers\Vendor;
use App\Controllers\BaseController;
use App\Models\Common_model;
class Authentication extends BaseController {
    protected $c_model;
    protected $session;
    protected $cookieName;
    public function __construct() {
        $this->session = session();
        $this->c_model = new Common_model();
    }
    public function index() {
        $data = [];
        $data["title"] = "Vendor Panel - Login";
        $company = websetting('*');
        $data['favicon'] = !empty($company['favicon']) ? base_url('uploads/') . $company['favicon'] : "";
        $data['logo'] = !empty($company['logo']) ? base_url('uploads/') . $company['logo'] : "";
        echo view(VENDORPATH . "login", $data);
    }
    public function checkLogin() {
        $post = $this->request->getVar();
        $response = [];
        $email = !empty($post["email"]) ? trim($post["email"]) : "";
        $password = !empty($post["password"]) ? trim($post["password"]) : "";
        if (empty($email) || empty($password)) {
            $response['status'] = false;
            $response['message'] = 'Please Enter Valid Email Address and Password';
            echo json_encode($response);
            exit;
        }
        $where = ["email_id" => $email, "enc_password" => md5($password) ];
        $select = "kyc_status,profile_status";
        $vendor = $this->c_model->getSingle('vendor_list', $select, $where);
        if (empty($vendor)) {
            $response['status'] = false;
            $response['message'] = 'Invalid Email or Password';
            echo json_encode($response);
            exit;
        } else if (!empty($vendor) && ($vendor['profile_status'] != "Active")) {
            $response = ['status' => false, 'message' => 'Your Profile Is Currently ' . $vendor['profile_status']];
            echo json_encode($response);
            exit;
        } else if (!empty($vendor) && ($vendor['kyc_status'] != "Approved")) {
            $response = ['status' => false, 'message' => 'Your KYC Status Is ' . $vendor['kyc_status']];
            echo json_encode($response);
            exit;
        }
        $otp = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        $this->c_model->updateRecords('vendor_list', ['otp' => $otp, 'otp_sent_at' => date('Y-m-d H:i:s')],['email_id' => $email]);
        sendUserEmailOtp($email, $email, $otp);
        $response['status'] = true;
        $response['message'] = '4 Digit OTP has been sent on the registered Email ID';
        $response['otp'] = $otp;
        echo json_encode($response);
        exit;
    }
    public function validateOtp() {
        $post = $this->request->getVar();
        $entered_otp = !empty($post['entered_otp']) ? trim($post['entered_otp']) : '';
        $sent_otp = !empty($post['sent_otp']) ? trim($post['sent_otp']) : '';
        $email = !empty($post['email']) ? trim($post['email']) : '';
        $response = [];
        if (empty($entered_otp)) {
            $response['status'] = false;
            $response['message'] = 'Otp Is Blank';
            echo json_encode($response);
            exit;
        }
        if ((strlen($entered_otp) !== 4) || ($entered_otp !== $sent_otp)) {
            $response['status'] = false;
            $response['message'] = 'Incorrect OTP';
            echo json_encode($response);
            exit;
        }
        $check = $this->c_model->getSingle('vendor_list', 'id,otp_sent_at', ['email_id' => $email]);
        if (!empty($check)) {
            $currenttime = strtotime(date('Y-m-d H:i:s'));
            $validtill = strtotime($check['otp_sent_at'] . ' + 5 minutes');
            if ($currenttime > $validtill) {
                $response['status'] = false;
                $response['message'] = 'OTP expired!';
                echo json_encode($response);
                exit;
            }
        }
        $this->c_model->updateRecords('vendor_list', ['otp' => ''], ['email_id' => $email]);
        $vendor_session=['id'=>$check['id'],'email_id'=>$email,'logged_in'=>"true"];
        session()->set('vendor_login_data',$vendor_session);
        
        $response['status'] = true;
        $response['message'] = 'OTP Verified Successfully';
        $response['goto'] = base_url(VENDORPATH.'dashboard');
        echo json_encode($response);
        exit;
    }
    function resendOtp() {
        $post = $this->request->getVar();
        $email = isset($post['email']) ? trim($post['email']) : '';
        $response = [];
        if (empty($email)) {
            $response['status'] = false;
            $response['message'] = 'Email ID Is Empty';
            echo json_encode($response);
            exit;
        }
        $otp = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        $data['otp'] = $otp;
        $data['otp_sent_at'] = date('Y-m-d H:i:s');
        $this->c_model->updateRecords('vendor_list', ['otp' => $otp, 'otp_sent_at' => date('Y-m-d H:i:s') ], ['email_id' => $email]);
        sendUserEmailOtp($email, $email, $otp);
        $response['status'] = true;
        $response['message'] = 'Resent Otp';
        $response['otp'] = $otp;
        echo json_encode($response);
        exit;
    }
    public function logout() {
        $this->session->remove('vendor_login_data');
        return redirect()->to(base_url(VENDORPATH . "login"));
    }
    function forgot_password() {
        $data["title"] = "Forgot Password";
        $company = websetting('*');
        $data['favicon'] = !empty($company['favicon']) ? base_url('uploads/') . $company['favicon'] : "";
        $data['logo'] = !empty($company['logo']) ? base_url('uploads/') . $company['logo'] : "";
        echo view(VENDORPATH . "forgot-password", $data);
    }
    public function forgotPassword() {
        $email = !empty($this->request->getVar('email')) ? trim($this->request->getVar('email')) : "";
        if (empty($email)) {
            $response = ['status' => false, 'message' => 'Enter Email'];
            echo json_encode($response);
            exit;
        }
        $valid = $this->c_model->getSingle("vendor_list", 'kyc_status,profile_status', ['email_id' => $email]);
        if (empty($valid)) {
            $response = ['status' => false, 'message' => 'This Email Is Not Registered'];
            echo json_encode($response);
            exit;
        } else if (!empty($valid) && ($valid['profile_status'] != "Active")) {
            $response = ['status' => false, 'message' => 'Your Profile Is Currently ' . $valid['profile_status']];
            echo json_encode($response);
            exit;
        } else if (!empty($valid) && ($valid['kyc_status'] != "Approved")) {
            $response = ['status' => false, 'message' => 'Your KYC Status Is ' . $valid['kyc_status']];
            echo json_encode($response);
            exit;
        }
        $password = generate_password(10);
        sendEmailForgotPassword($email, $email, $password);
        $this->c_model->updateRecords("vendor_list", ['enc_password' => md5($password),'raw_password'=>$password ], ['email_id' => $email]);
        $response = ['status' => true, 'message' => 'New Password Has Been Sent To The Registered Email ID'];
        echo json_encode($response);
        exit;
    }
}
?>
