<?php
if (!function_exists('sendEmail')) {
    function sendEmail($to, $message) {
        $email = \Config\Services::email();
        $email->setTo($to);
        $email->setFrom('info@emailnotify.in', 'Lakshya Cabs');
        $email->setSubject('Lakshya Cabs || New Query');
        $email->setMessage($message);
        if ($email->send()) {
            return true;
        } else {
            $data = $email->printDebugger(['headers']);
        }
    }
}
if (!function_exists('sendEmailForgotPassword')) {
    function sendEmailForgotPassword($to, $username = false, $password = false) {
        $email = \Config\Services::email();
        $email->setTo($to);
        $email->setFrom('info@emailnotify.in', 'Lakshya Cabs');
        $email->setSubject('Lakshya Cabs || New Password');
        $email->setMessage('<html><head>
        <title>Lakshya Cabs || New Password</title></head>
        <body>
        <h3>Dear User</h3>
        <h3>Greetings From Lakshya Cabs !</h3>
        <p>Your New Password is mentioned below.</p>
        <p><strong>Password : ' . $password . '</strong></p> 
        <p><strong>Login URL : </strong><a href="' . base_url(VENDORPATH . 'login') . '">Click Here</a></p> 
        <p>Please do not share this with anyone. </p>
        <p>For any queries/clarifications, please contact
        <a href="mailto:info@lakshyacabs.nshops.in">info@lakshyacabs.nshops.in</a> </p>
        <h3>Regards :- Lakshya Cabs.</h3>
        </body>
        </html>');
        if ($email->send()) {
            return true;
        } else {
            $data = $email->printDebugger(['headers']);
        }
    }
}
if (!function_exists('sendEmailPassword')) {
    function sendEmailPassword($to, $username = false, $password = false) {
        $email = \Config\Services::email();
        $email->setTo($to);
        $email->setFrom('info@emailnotify.in', 'Lakshya Cabs');
        $email->setSubject('Lakshya Cabs || Login Credentials');
        $email->setMessage('<html><head>
        <title>Lakshya Cabs || Login Credentials</title></head>
        <body>
        <h3>Dear User</h3>
        <h3>Greetings From Lakshya Cabs !</h3>
        <p>Your Lakshya Cabs is mentioned below.</p>
        <p><strong>Email : ' . $username . '</strong></p> 
        <p><strong>Password : ' . $password . '</strong></p> 
        <p><strong>Login URL : </strong><a href="' . base_url(ADMINPATH . 'login') . '">Click Here</a></p> 
        <p>Please do not share this with anyone. </p>
        <p>For any queries/clarifications, please contact
        <a href="mailto:info@lakshyacabs.nshops.in">info@lakshyacabs.nshops.in</a> </p>
        <h3>Regards :- Lakshya Cabs</h3>
        </body>
        </html>');
        if ($email->send()) {
            return true;
        } else {
            $data = $email->printDebugger(['headers']);
        }
    }
}
if (!function_exists('sendVendorEmailPassword')) {
    function sendVendorEmailPassword($to, $username = false, $password = false) {
        $email = \Config\Services::email();
        $email->setTo($to);
        $email->setFrom('info@emailnotify.in', 'Lakshya Cabs');
        $email->setSubject('Lakshya Cabs || Login Credentials');
        $email->setMessage('<html><head>
        <title>Lakshya Cabs || Login Credentials</title></head>
        <body>
        <h3>Dear User</h3>
        <h3>Greetings From Lakshya Cabs !</h3>
        <p>Your Lakshya Cabs is mentioned below.</p>
        <p><strong>Email : ' . $username . '</strong></p> 
        <p><strong>Password : ' . $password . '</strong></p> 
        <p><strong>Login URL : </strong><a href="' . base_url(VENDORPATH . 'login') . '">Click Here</a></p> 
        <p>Please do not share this with anyone. </p>
        <p>For any queries/clarifications, please contact
        <a href="mailto:info@lakshyacabs.nshops.in">info@lakshyacabs.nshops.in</a> </p>
        <h3>Regards :- Lakshya Cabs</h3>
        </body>
        </html>');
        if ($email->send()) {
            return true;
        } else {
            $data = $email->printDebugger(['headers']);
        }
    }
}
if (!function_exists('sendUserEmailOtp')) {
    function sendUserEmailOtp($to, $email = false, $otp = false) {
        $email = \Config\Services::email();
        $email->setTo($to);
        $email->setFrom('info@emailnotify.in', 'Lakshya Cabs');
        $email->setSubject('Lakshya Cabs || OTP');
        $email->setMessage('<html><head>
        <title>Lakshya Cabs || OTP</title></head>
        <body>
        <h3>Dear User</h3>
        <h3>Greetings From Lakshya Cabs !</h3>
        <p>Your One Time Password is mentioned below.</p>
        <p><strong>OTP : ' . $otp . '</strong></p> 
    
        <p>Please do not share this with anyone. </p>
        <p>For any queries/clarifications, please contact
        <a href="mailto:info@lakshyacabs.nshops.in">info@lakshyacabs.nshops.in</a> </p>
        <h3>Regards :-  Lakshya Cabs.</h3>
        </body>
        </html>');
        if ($email->send()) {
            return true;
        } else {
            $data = $email->printDebugger(['headers']);
        }
    }
}
function curlApis($url, $method = null, $postarray = null, $header = null, $time = null) {
    $curl = curl_init();
    $timeout = !empty($time) ? $time : 30;
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_POST, false);
    if ($method == 'POST') {
        $jsonpostdata = json_encode($postarray);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonpostdata);
        curl_setopt($curl, CURLOPT_POST, true);
    }
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 5);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    if (!empty($header)) {
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    }
    $jsondata = curl_exec($curl);
    curl_close($curl);
    $data = json_decode($jsondata, true);
    return $data;
}
function sendsms($mobile, $message, $restype = null, $callingcode = null) {
    $str = urlencode($message);
    $mobile = $callingcode . $mobile;
    $apiurl = SMS_API_PATH . "rest/services/sendSMS/sendGroupSms?AUTH_KEY=" . SMSKEY . "&message=$str&senderId=" . SENDERID . "&routeId=" . ROOTID . "&mobileNos=$mobile&smsContentType=english";
    $data = curlApis($apiurl);
    $jsondata = json_encode($data, true);
    // echo $jsondata;die;
    $status = false;
    $datastatus = !empty($data['responseCode']) ? $data['responseCode'] : false;
    if ($datastatus == '3001') {
        $status = true;
    }
    return (!empty($restype) ? $jsondata : $status);
}
function sendOtpPhone($mobile, $otp) {
    $msg = "Your Login OTP " . $otp . " Don't Share with any one Thanks!";
    $sent = sendsms($mobile, $msg);
    return true;
}
?>