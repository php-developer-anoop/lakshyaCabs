<?php
namespace App\Controllers\Api\V1;
use App\Controllers\BaseController;
use App\Models\Common_model;
class Generate_pdf extends BaseController {
    protected $c_model;
    public function __construct() {
        $this->c_model = new Common_model();
    }
    public function index() {
        while (ob_get_level()) {
            ob_end_clean();
        }
        require_once APPPATH . '/ThirdParty/mpdf/vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf();
        $id = $this->request->getVar('id');
        $filename = $id . '-' . date('Y-m-d H:i:s') . ".pdf";
        $txndata = $this->c_model->getSingle('wallet', '*', ['reference_id' => $id]);
        if (empty($txndata)) {
            echo 'No Direct Access Allowed';
            exit;
        }
        if ($txndata['user_type'] == "Vendor") {
            $userdata = $this->c_model->getSingle('vendor_list', '*,full_name as fullname', ['id' => $txndata['user_id']]);
        } else {
            $userdata = $this->c_model->getSingle('customer_list', '*,name as fullname', ['id' => $txndata['user_id']]);
        }
        $company = websetting('*');
        $html = $this->printrp($txndata, $userdata, $filename, $company);
        $mpdf->SetTitle($filename);
        $mpdf->setAutoTopMargin = 'pad';
        $mpdf->autoMarginPadding = 10;
        $mpdf->WriteHTML($html);
        $mpdf->Output($filename, "I");
        exit;
    }
    public function printrp($txndata, $userdata, $filename, $company) {
        $html = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . $company['company_name'] . '</title>
        <link href="https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    </head>
    <body style="font-family: Urbanist;">
        <table style="padding: 0px 10px; width: 600px; border-spacing: 0; margin: 0px auto; border: 1px solid #f1ecec;">
         
            <tbody>
            <tr>
            <td scope="col" colspan="8" style="text-align: start; padding: 10px 0px;"><img src="' . base_url('uploads/' . $company['logo']) . '"></td>
                <td scope="col" colspan="3" style="text-align: end; padding: 10px 0px;">
                    <p style="margin: 5px 0px; font-weight: 500;">' . date('d M Y', strtotime($txndata['created_date'])) . '</p>
                    <p style="margin: 0px; font-weight: 500;">' . date('h:i a', strtotime($txndata['created_date'])) . '</p>
                </td>
                </tr>
                <tr>
                    <td scope="col" colspan="12" style="text-align: center; padding: 8px 0px;"><img src="' . base_url('assets/correct.png') . '"></td>
                </tr>
                <tr>
                    <td style="text-align: center; border-bottom: 1px solid #dee0e0; padding: 10px 0px;" scope="col" colspan="6">
                        <span>
                            <span style="color: #555; font-size: 15px;">Amount ' . ucfirst($txndata['credit_debit'] . 'ed') . '</span>
                            <p style="font-size: 36px; margin: 0px; font-weight: 800;"><b>₹ ' . $txndata['txn_amount'] . '</b></p>
                        </span>
                    </td>
                    <td style="border-bottom: 1px solid #dee0e0; padding: 10px 0px;" scope="col" colspan="6">
                        <span>
                            <span style="color: #555; font-size: 15px;">Wallet Balance</span>
                            <p style="font-size: 36px; margin: 0px; font-weight: 800;"><b>₹ ' . $userdata['wallet_balance'] . '</b></p>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td scope="col" colspan="12" style="text-align: center; border-bottom: 1px solid #dee0e0; padding: 14px 0px;"><span style="color: #555; font-size: 17px;">Transaction ID
                            &nbsp;&nbsp; ' . $txndata['reference_id'] . '</span>
                    </td>
                </tr>
                <tr>
                    <td scope="col" colspan="12" style="text-align: center; padding: 20px 0px 14px;"><span style="color: #555; font-size: 17px;">' . ucwords($txndata['remark']) . ' <b style="padding: 0px 8px; color: black;">₹ ' . $txndata['txn_amount'] . ' </b></span></td>
                </tr>
                <tr>
                    <td scope="col" colspan="12" style="text-align: center; padding: 14px 0px;"><span style="color: black; font-size: 17px; font-weight:500;">If any concern, please reach out to us</span></td>
                </tr>
                <tr>
                    <td scope="col" colspan="6" style="text-align: center; padding: 14px 0px;"><span style="color: #2562C2; font-size: 18px; font-weight:500; display: flex; align-items: center; justify-content: center; gap: 6px;"> <img src="' . base_url('assets/mail.png') . '"> <span><a href="mailto:' . $company['care_email'] . '">' . $company['care_email'] . '</a></span></span></td>
                    <td scope="col" colspan="6" style="text-align: center; padding: 14px 0px;"><span style="color: #2562C2; font-size: 18px; font-weight:500; display: flex; align-items: center; gap: 6px;"> <img src="' . base_url('assets/telephone.png') . '"> <span>+91' . $company['care_mobile'] . '</span></span></td>
                </tr>
                <tr>
                    <td scope="col" colspan="12" style="text-align: center; padding: 12px 0px 24px;">
                        <span style="color: #555; font-size: 15px;">All customers are advised to notify Lakshya Cabs of any unauthorized electronic payment transaction at the earliest. All customers please note that the longer the time taken to notify Lakshya Cabs, higher will be the risk of loss to the customer. For a detailed course of action, the customer can view the Customer Grievance Redressal Policy which is made available at this <a href="#" style="color: #2562C2;">Link.</a>
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
    </html>';
        return $html;
    }
    public function printDutySlip() {
        while (ob_get_level()) {
            ob_end_clean();
        }
        require_once APPPATH . '/ThirdParty/mpdf/vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf(['format' => 'A4-L']);
        $id = $this->request->getVar('booking_id');
        $filename = $id . '-Duty Slip -' . date('d/m/Y h:i:s') . ".pdf";
        $booking = $this->c_model->getSingle('bookings', '*', ['booking_id' => $id]);
     
        $company = websetting('*');
        if (empty($booking)) {
            echo 'No Direct Access Allowed';
            exit;
        }
        $html = dutySlipHtml($booking, $id, $company);
        $mpdf->SetTitle($filename);
        $mpdf->setAutoTopMargin = 'pad';
        $mpdf->autoMarginPadding = 5;
        $mpdf->WriteHTML($html);
        $mpdf->Output($filename, "I");
        exit;
    }
    public function printPaymentSlip() {
        while (ob_get_level()) {
            ob_end_clean();
        }
        require_once APPPATH . '/ThirdParty/mpdf/vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf(['format' => 'A4-L']);
        $id = $this->request->getVar('booking_id');
        $payment_slip_no = rand(1111111,9999999);
        $filename = $id . '- Payment Slip -' . $payment_slip_no . ".pdf";
        
        $joinArray=[];
        
        $joinArray[0]['table'] = 'dt_customer_list';
        $joinArray[0]['join_on'] = 'dt_bookings.user_id =dt_customer_list.id';
        $joinArray[0]['join_type'] = 'INNER';
        $booking = getSingle('bookings', 'dt_bookings.*,dt_customer_list.*', ['booking_id' => $id],null,null,null,$joinArray);
     
        $company = websetting('*');
        if (empty($booking)) {
            echo 'No Direct Access Allowed';
            exit;
        }
        $html = paymentSlipHtml($booking, $id, $company,$payment_slip_no);
        $mpdf->SetTitle($filename);
        $mpdf->setAutoTopMargin = 'pad';
        $mpdf->autoMarginPadding = 10;
        $mpdf->WriteHTML($html);
        $mpdf->Output($filename, "I");
        exit;
    }
    public function printInvoiceSlip() {
        while (ob_get_level()) {
            ob_end_clean();
        }
        require_once APPPATH . '/ThirdParty/mpdf/vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf(['format' => 'A4-L']);
        $id = $this->request->getVar('booking_id');
        $invoice_no = rand(1111111,9999999);
        $filename = $id . '- Payment Slip -' . $invoice_no . ".pdf";
        
        $joinArray=[];
        
        $joinArray[0]['table'] = 'dt_customer_list';
        $joinArray[0]['join_on'] = 'dt_bookings.user_id =dt_customer_list.id';
        $joinArray[0]['join_type'] = 'INNER';
        $booking = getSingle('bookings', 'dt_bookings.*,dt_customer_list.*', ['booking_id' => $id],null,null,null,$joinArray);
     
        $company = websetting('*');
        if (empty($booking)) {
            echo 'No Direct Access Allowed';
            exit;
        }
        $html = invoiceHtml($booking, $id, $company,$invoice_no);
        $mpdf->SetTitle($filename);
        $mpdf->setAutoTopMargin = 'pad';
        $mpdf->autoMarginPadding = 10;
        $mpdf->WriteHTML($html);
        $mpdf->Output($filename, "I");
        exit;
    }
}
