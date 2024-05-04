<?php
namespace App\Controllers;
use App\Models\Common_model;
class Query extends BaseController {
    public $c_model;
    public function __construct() {
        $this->c_model = new Common_model();
    }
    public function index() {
        $response = [];
        $post = $this->request->getVar();
        $saveData = [];
        $saveData['name'] = testInput($post['name']);
        $saveData['email'] = testInput($post['email']);
        $saveData['phone'] = testInput($post['phone']);
        $saveData['query'] = testInput($post['query']);
        $saveData['vehicle_type'] = testInput($post['vehicle_type']);
        $saveData['add_date'] = date('Y-m-d H:i:s');
        $label = !empty($saveData['query']) ? "Query" : "Vehicle";
        $value = !empty($saveData['query']) ? $saveData['query'] : $saveData['vehicle_type'];
        $last_id = $this->c_model->insertRecords('queries', $saveData);
        if ($last_id) {
            $company = websetting('logo');
            $logo = !empty($company['logo']) ? base_url('uploads/') . $company['logo'] : "";
            // echo $logo;die;
            $subject = 'New Query';
            $message = '<!DOCTYPE HTML>
<html>
<head>
 <title>Lakshya Cabs</title>
 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">


 <!--[if !mso]>
<!-->
 <style type="text/css">
   @media only screen and (max-width:480px) {
     @-ms-viewport {
       width: 320px;
     }
     @viewport {
       width: 320px;
     }
   }
 </style>

 <!--<![endif]-->

 <!--[if mso]>
<xml>
<o:OfficeDocumentSettings>
 <o:AllowPNG/>
 <o:PixelsPerInch>96</o:PixelsPerInch>
</o:OfficeDocumentSettings>
</xml>
<![endif]-->

 <!--[if !mso]>
<!-->
 <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,700" rel="stylesheet" type="text/css">
 <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet" type="text/css">
 <style type="text/css">
   @import url(https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,700);
   @import url(https://fonts.googleapis.com/css?family=Roboto:300,400,500,700);
 </style>

 <!--<![endif]-->
 <style type="text/css">
   @media only screen and (min-width:480px) {
     .mj-column-per-100,
     * [aria-labelledby="mj-column-per-100"] {
       width: 100% !important;
     }
   }
 </style>
</head>
<body style="background: #f5f5f5;">
 <div style="background-color:#f5f5f5; padding-top: 80px;">

   <!--[if mso | IE]>
   <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600" align="center" style="width:600px;">
     <tr>
       <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
   <![endif]-->
   <div style="margin:0 auto;max-width:600px;background:#FFFFFF;">
     <table role="presentation" cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;background:#FFFFFF; border-top: 3px solid #000" align="center" border="0">
       <tbody>
         <tr>
           <td style="text-align:center;vertical-align:top;font-size:0px;padding:40px 30px 30px 30px;">

             <!--[if mso | IE]>
   <table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td style="vertical-align:top;width:600px;">
   <![endif]-->
             <div aria-labelledby="mj-column-per-100" class="mj-column-per-100" style="vertical-align:top;display:inline-block;font-size:13px;text-align:left;width:100%;">
               <table role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
                 <tbody>
                   <tr>
                     <td style="word-break:break-word;font-size:0px;padding:0px;padding-bottom:30px;" align="center">
                       <div style="cursor:auto;color:#55575d;font-family:Open Sans, Helvetica, Arial, sans-serif;font-size:22px;font-weight:700;line-height:22px;">
                       ' . $subject . '
                       </div>
                     </td>
                   </tr>
                 
                   <tr style="display:grid;">
                     <td style="font-size:0px;padding:0px;padding-bottom:10px;" align="left">
                       <div style="cursor:auto;color:#8c8c8c;font-family:Roboto, Helvetica, Arial, sans-serif;font-size:14px;line-height:22px;"><b>Name : </b> ' . $saveData['name'] . '</div></td>
                  
                     <td style="font-size:0px;padding:0px;padding-bottom:10px;" align="left">
                       <div style="cursor:auto;color:#8c8c8c;font-family:Roboto, Helvetica, Arial, sans-serif;font-size:14px;line-height:22px;"><b>Email : </b>' . $saveData['email'] . '</div></td>
                   
                     <td style="font-size:0px;padding:0px;padding-bottom:10px;" align="left">
                       <div style="cursor:auto;color:#8c8c8c;font-family:Roboto, Helvetica, Arial, sans-serif;font-size:14px;line-height:22px;"><b>Phone : </b>' . $saveData['phone'] . '</div></td>
                   
                    
                     <td style="font-size:0px;padding:0px;padding-bottom:10px;" align="left">
                       <div style="cursor:auto;color:#8c8c8c;font-family:Roboto, Helvetica, Arial, sans-serif;font-size:14px;line-height:22px;"><b>' . $label . ' : </b>' . $value . '</div></td>
                   </tr>
                   <tr>
                     <td style="word-break:break-word;font-size:0px;padding:0px;padding-bottom:40px;" align="center">
                       <table role="presentation" cellpadding="0" cellspacing="0" style="border-collapse:separate;" align="center" border="0">
                         <tbody>
                           <tr>
                             <td style="border-radius:2px;color:#fff;cursor:auto;padding:10px 25px;" align="center" valign="middle" bgcolor="#000">
                               <a href="' . base_url() . '" style="display:inline-block;text-decoration:none;background:#000;color:#fff;font-family:Roboto, Helvetica, Arial, sans-serif, Helvetica, Arial, sans-serif;font-size:14px;font-weight:normal;margin:0px;" target="_blank">
                                 Go To Home
                               </a>
                             </td>
                           </tr>
                         </tbody>
                       </table>
                     </td>
                   </tr>
                   <tr>
                     <td style="word-break:break-word;font-size:0px;padding:0px;padding-bottom:8px;" align="center">
                       <div style="cursor:auto;color:#8c8c8c;font-family:Roboto, Helvetica, Arial, sans-serif;font-size:14px;line-height:22px;">
                         If the link doesn’t work, copy this URL into your browser:
                       </div>
                     </td>
                   </tr>
                   <tr>
                     <td style="word-break:break-word;font-size:0px;padding:0px;padding-bottom:35px;" align="center">
                       <div style="cursor:auto;color:#3586ff;font-family:Roboto, Helvetica, Arial, sans-serif;font-size:14px;line-height:22px;">
                         <a href="' . base_url() . '" target="_blank" style="text-decoration: none; color: inherit;">' . base_url() . '</a>
                       </div>
                     </td>
                   </tr>
                   <tr>
                     <td style="word-break:break-word;font-size:0px;padding:0px;" align="center">
                       <div style="cursor:auto;color:#8c8c8c;font-family:Roboto, Helvetica, Arial, sans-serif;font-size:14px;line-height:22px;">
                         Welcome!
                       </div>
                     </td>
                   </tr>
                   
             </div>
           </td>
         </tr>
         <tr>
           <td style="word-break:break-word;font-size:0px;padding:0px;" align="center">
             <div style="cursor:auto;color:#8c8c8c;font-family:Roboto, Helvetica, Arial, sans-serif;font-size:14px;line-height:22px;">
               &nbsp;
             </div>
           </td>
         </tr>
       </tbody>
     </table>
   </div>

   <!--[if mso | IE]>
   </td></tr></table>
   <![endif]-->
   </td>
   </tr>
   </tbody>
   </table>
 </div>

 <!--[if mso | IE]>
   </td></tr></table>
   <![endif]-->

 <!--[if mso | IE]>
   <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600" align="center" style="width:600px;">
     <tr>
       <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
   <![endif]-->
 <div style="margin:0 auto;max-width:600px;">
   <table role="presentation" cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;" align="center" border="0">
     <tbody>
       <tr>
         <td style="text-align:center;vertical-align:top;font-size:0px;padding:30px;">

           <!--[if mso | IE]>
   <table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td style="vertical-align:top;width:600px;">
   <![endif]-->
           <div aria-labelledby="mj-column-per-100" class="mj-column-per-100" style="vertical-align:top;display:inline-block;font-size:13px;text-align:left;width:100%;">
             <table role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
               <tbody>
                 <tr>
                   <td style="word-break:break-word;font-size:0px;padding:0px;padding-bottom:10px;" align="center">
                     <div style="cursor:auto;color:#8c8c8c;font-family:Roboto, Helvetica, Arial, sans-serif;font-size:12px;line-height:22px;">

                     </div>
                   </td>
                 </tr>
                 
                 <tr>
                   <td style="word-break:break-word;font-size:0px;padding:0px;padding-bottom:10px;" align="center">
                     <div style="cursor:auto;color:#8c8c8c;font-family:Roboto, Helvetica, Arial, sans-serif;font-size:12px;line-height:22px;">
                       <a href="' . base_url('about-us') . '" style="color: inherit; padding: 0 7px;">About Us</a>
                       <a href="' . base_url('privacy-policy') . '" style="color: inherit; padding: 0 7px;">Privacy Policy</a>
                       <a href="' . base_url('faqs') . '" style="color: inherit; padding: 0 7px;">FAQ</a>
                     </div>
                   </td>
                 </tr>
                 <tr>
                 
                 </tr>
               </tbody>
             </table>
           </div>

           <!--[if mso | IE]>
   </td></tr></table>
   <![endif]-->
         </td>
       </tr>
     </tbody>
   </table>
 </div>

 <!--[if mso | IE]>
   </td></tr></table>
   <![endif]-->
 </div>
 <br />
 </body>
</html>';
            sendEmail('dts.anoopphp@gmail.com', $message);
            $response['status'] = true;
            $response['message'] = 'Query Submitted Successfully!';
            echo json_encode($response);
            exit;
        } else {
            $response['status'] = false;
            $response['message'] = 'Something Went Wrong!';
            echo json_encode($response);
            exit;
        }
    }

    public function save_pack_form() {
      $response = [];
      $post = $this->request->getVar();
      $sanitizedDate = !empty($post['date'])?testInput($post['date']):'';
      $sanitizedTime = !empty($post['time'])?testInput($post['time']):'';

      // Format the date to 'Y-m-d' and time to 'H:i:s'
      $formattedDate = date('Y-m-d', strtotime($sanitizedDate));
      $formattedTime = date('H:i:s', strtotime($sanitizedTime));

      $concatenatedDateTime = $formattedDate . ' ' . $formattedTime;
      $saveData = [];
      $saveData['pickup_location'] = !empty($post['pickup_location'])?testInput($post['pickup_location']):'';
      $saveData['no_of_days'] = !empty($post['days'])?testInput($post['days']):'';
      $saveData['phone'] = !empty($post['phone'])?testInput($post['phone']):'';
      $saveData['no_of_people'] =  !empty($post['people'])?testInput($post['people']):'';
      $saveData['travel_datetime'] = $concatenatedDateTime;
      $saveData['add_date'] = date('Y-m-d H:i:s');
      $package = !empty($post['package']) ? explode(',', $post['package']) : [];
      $saveData['package_id'] = $package[0]??'';
      $saveData['package_name'] = $package[1]??'';

      // echo "<pre>";
      // print_r($saveData);exit;
      $last_id = $this->c_model->insertRecords('package_query', $saveData);
      if ($last_id) {
          $company = websetting('logo');
          $logo = !empty($company['logo']) ? base_url('uploads/') . $company['logo'] : "";
    
          $subject = 'New Query';
          $message = '<!DOCTYPE HTML>
<html>
<head>
<title>Lakshya Cabs</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">


<!--[if !mso]>
<!-->
<style type="text/css">
 @media only screen and (max-width:480px) {
   @-ms-viewport {
     width: 320px;
   }
   @viewport {
     width: 320px;
   }
 }
</style>

<!--<![endif]-->

<!--[if mso]>
<xml>
<o:OfficeDocumentSettings>
<o:AllowPNG/>
<o:PixelsPerInch>96</o:PixelsPerInch>
</o:OfficeDocumentSettings>
</xml>
<![endif]-->

<!--[if !mso]>
<!-->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,700" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet" type="text/css">
<style type="text/css">
 @import url(https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,700);
 @import url(https://fonts.googleapis.com/css?family=Roboto:300,400,500,700);
</style>

<!--<![endif]-->
<style type="text/css">
 @media only screen and (min-width:480px) {
   .mj-column-per-100,
   * [aria-labelledby="mj-column-per-100"] {
     width: 100% !important;
   }
 }
</style>
</head>
<body style="background: #f5f5f5;">
<div style="background-color:#f5f5f5; padding-top: 80px;">

 <!--[if mso | IE]>
 <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600" align="center" style="width:600px;">
   <tr>
     <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
 <![endif]-->
 <div style="margin:0 auto;max-width:600px;background:#FFFFFF;">
   <table role="presentation" cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;background:#FFFFFF; border-top: 3px solid #000" align="center" border="0">
     <tbody>
       <tr>
         <td style="text-align:center;vertical-align:top;font-size:0px;padding:40px 30px 30px 30px;">

           <!--[if mso | IE]>
 <table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td style="vertical-align:top;width:600px;">
 <![endif]-->
           <div aria-labelledby="mj-column-per-100" class="mj-column-per-100" style="vertical-align:top;display:inline-block;font-size:13px;text-align:left;width:100%;">
             <table role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
               <tbody>
                 <tr>
                   <td style="word-break:break-word;font-size:0px;padding:0px;padding-bottom:30px;" align="center">
                     <div style="cursor:auto;color:#55575d;font-family:Open Sans, Helvetica, Arial, sans-serif;font-size:22px;font-weight:700;line-height:22px;">
                     ' . $subject . '
                     </div>
                   </td>
                 </tr>
               
                 <tr style="display: grid;">
    <td style="font-size: 0px; padding: 0px; padding-bottom: 10px;" align="left">
        <div style="cursor: auto; color: #8c8c8c; font-family: Roboto, Helvetica, Arial, sans-serif; font-size: 14px; line-height: 22px;">
            <b>Pickup Location : </b> ' . $saveData['pickup_location'] . '
        </div>
    </td>' . (!empty($saveData['no_of_days']) ? '
    <td style="font-size: 0px; padding: 0px; padding-bottom: 10px;" align="left">
        <div style="cursor: auto; color: #8c8c8c; font-family: Roboto, Helvetica, Arial, sans-serif; font-size: 14px; line-height: 22px;">
            <b>No. Of Days : </b>' . $saveData['no_of_days'] . '
        </div>
    </td>' : '') . '
    ' . (!empty($saveData['package_name']) ? '
    <td style="font-size: 0px; padding: 0px; padding-bottom: 10px;" align="left">
        <div style="cursor: auto; color: #8c8c8c; font-family: Roboto, Helvetica, Arial, sans-serif; font-size: 14px; line-height: 22px;">
            <b>Package : </b>' . $saveData['package_name'] . '
        </div>
    </td>' : '') . '
    <td style="font-size: 0px; padding: 0px; padding-bottom: 10px;" align="left">
        <div style="cursor: auto; color: #8c8c8c; font-family: Roboto, Helvetica, Arial, sans-serif; font-size: 14px; line-height: 22px;">
            <b>Phone : </b>' . $saveData['phone'] . '
        </div>
    </td>
    <td style="font-size: 0px; padding: 0px; padding-bottom: 10px;" align="left">
        <div style="cursor: auto; color: #8c8c8c; font-family: Roboto, Helvetica, Arial, sans-serif; font-size: 14px; line-height: 22px;">
            <b>No. of People : </b>' . $saveData['no_of_people'] . '
        </div>
    </td>' . (!empty($saveData['no_of_days']) ?'
    <td style="font-size: 0px; padding: 0px; padding-bottom: 10px;" align="left">
        <div style="cursor: auto; color: #8c8c8c; font-family: Roboto, Helvetica, Arial, sans-serif; font-size: 14px; line-height: 22px;">
            <b> Travel Date/Time : </b>' . $saveData['travel_datetime'] . '
        </div>
    </td>' : '') . '
</tr>

                 <tr>
                   <td style="word-break:break-word;font-size:0px;padding:0px;padding-bottom:40px;" align="center">
                     <table role="presentation" cellpadding="0" cellspacing="0" style="border-collapse:separate;" align="center" border="0">
                       <tbody>
                         <tr>
                           <td style="border-radius:2px;color:#fff;cursor:auto;padding:10px 25px;" align="center" valign="middle" bgcolor="#000">
                             <a href="' . base_url() . '" style="display:inline-block;text-decoration:none;background:#000;color:#fff;font-family:Roboto, Helvetica, Arial, sans-serif, Helvetica, Arial, sans-serif;font-size:14px;font-weight:normal;margin:0px;" target="_blank">
                               Go To Home
                             </a>
                           </td>
                         </tr>
                       </tbody>
                     </table>
                   </td>
                 </tr>
                 <tr>
                   <td style="word-break:break-word;font-size:0px;padding:0px;padding-bottom:8px;" align="center">
                     <div style="cursor:auto;color:#8c8c8c;font-family:Roboto, Helvetica, Arial, sans-serif;font-size:14px;line-height:22px;">
                       If the link doesn’t work, copy this URL into your browser:
                     </div>
                   </td>
                 </tr>
                 <tr>
                   <td style="word-break:break-word;font-size:0px;padding:0px;padding-bottom:35px;" align="center">
                     <div style="cursor:auto;color:#3586ff;font-family:Roboto, Helvetica, Arial, sans-serif;font-size:14px;line-height:22px;">
                       <a href="' . base_url() . '" target="_blank" style="text-decoration: none; color: inherit;">' . base_url() . '</a>
                     </div>
                   </td>
                 </tr>
                 <tr>
                   <td style="word-break:break-word;font-size:0px;padding:0px;" align="center">
                     <div style="cursor:auto;color:#8c8c8c;font-family:Roboto, Helvetica, Arial, sans-serif;font-size:14px;line-height:22px;">
                       Welcome!
                     </div>
                   </td>
                 </tr>
                 
           </div>
         </td>
       </tr>
       <tr>
         <td style="word-break:break-word;font-size:0px;padding:0px;" align="center">
           <div style="cursor:auto;color:#8c8c8c;font-family:Roboto, Helvetica, Arial, sans-serif;font-size:14px;line-height:22px;">
             &nbsp;
           </div>
         </td>
       </tr>
     </tbody>
   </table>
 </div>

 <!--[if mso | IE]>
 </td></tr></table>
 <![endif]-->
 </td>
 </tr>
 </tbody>
 </table>
</div>

<!--[if mso | IE]>
 </td></tr></table>
 <![endif]-->

<!--[if mso | IE]>
 <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600" align="center" style="width:600px;">
   <tr>
     <td style="line-height:0px;font-size:0px;mso-line-height-rule:exactly;">
 <![endif]-->
<div style="margin:0 auto;max-width:600px;">
 <table role="presentation" cellpadding="0" cellspacing="0" style="font-size:0px;width:100%;" align="center" border="0">
   <tbody>
     <tr>
       <td style="text-align:center;vertical-align:top;font-size:0px;padding:30px;">

         <!--[if mso | IE]>
 <table role="presentation" border="0" cellpadding="0" cellspacing="0"><tr><td style="vertical-align:top;width:600px;">
 <![endif]-->
         <div aria-labelledby="mj-column-per-100" class="mj-column-per-100" style="vertical-align:top;display:inline-block;font-size:13px;text-align:left;width:100%;">
           <table role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
             <tbody>
               <tr>
                 <td style="word-break:break-word;font-size:0px;padding:0px;padding-bottom:10px;" align="center">
                   <div style="cursor:auto;color:#8c8c8c;font-family:Roboto, Helvetica, Arial, sans-serif;font-size:12px;line-height:22px;">

                   </div>
                 </td>
               </tr>
               
               <tr>
                 <td style="word-break:break-word;font-size:0px;padding:0px;padding-bottom:10px;" align="center">
                   <div style="cursor:auto;color:#8c8c8c;font-family:Roboto, Helvetica, Arial, sans-serif;font-size:12px;line-height:22px;">
                     <a href="' . base_url('about-us') . '" style="color: inherit; padding: 0 7px;">About Us</a>
                     <a href="' . base_url('privacy-policy') . '" style="color: inherit; padding: 0 7px;">Privacy Policy</a>
                     <a href="' . base_url('faqs') . '" style="color: inherit; padding: 0 7px;">FAQ</a>
                   </div>
                 </td>
               </tr>
               <tr>
               
               </tr>
             </tbody>
           </table>
         </div>

         <!--[if mso | IE]>
 </td></tr></table>
 <![endif]-->
       </td>
     </tr>
   </tbody>
 </table>
</div>

<!--[if mso | IE]>
 </td></tr></table>
 <![endif]-->
</div>
<br />
</body>
</html>';
          sendEmail('dts.anoopphp@gmail.com', $message);
          $response['status'] = true;
          $response['message'] = 'Query Submitted Successfully!';
          echo json_encode($response);
          exit;
      } else {
          $response['status'] = false;
          $response['message'] = 'Something Went Wrong!';
          echo json_encode($response);
          exit;
      }
  }

  function save_driver(){
    $post=$this->request->getVar();

    // echo "<pre>";
    // print_r($post);exit;
    $saveData=[];
    $saveData['driver_name'] = !empty(testInput($post['driver_name']))?testInput(trim($post['driver_name'])):'';
    $saveData['driver_email'] = !empty(testInput($post['driver_email']))?testInput(trim($post['driver_email'])):'';
    $saveData['driver_phone'] = !empty(testInput($post['driver_phone']))?testInput(trim($post['driver_phone'])):'';
    $saveData['driver_alternate_phone'] = !empty(testInput($post['driver_alternate_phone']))?testInput(trim($post['driver_alternate_phone'])):'';
    $saveData['state'] = !empty(testInput($post['state']))?testInput(trim($post['state'])):'';
    $saveData['city'] = !empty(testInput($post['city']))?testInput(trim($post['city'])):'';
    $saveData['address'] = !empty(testInput($post['address']))?testInput(trim($post['address'])):'';
    $saveData['add_date'] = date('Y-m-d H:i:s');

    if ($file = $this->request->getFile('upload_rc')) {
      if ($file->isValid() && !$file->hasMoved()) {
          $filename = $file->getRandomName();
          $ext = $file->guessExtension();
          if (in_array($ext, ['jpg', 'png', 'jpeg'])) {
            $image = \Config\Services::image()->withFile($file)->save(ROOTPATH . 'uploads/' . $filename);
            $saveData['rc_file'] = $filename;
            
        } else if($ext=="pdf") {
            $file->move(ROOTPATH . 'uploads/', $filename);
            $saveData['rc_file'] = $filename;
        }
      }
    }
    if ($file = $this->request->getFile('upload_dl')) {
      if ($file->isValid() && !$file->hasMoved()) {
        $filename = $file->getRandomName();
        $ext = $file->guessExtension();
          if (in_array($ext, ['jpg', 'png', 'jpeg'])) {
            $image = \Config\Services::image()->withFile($file)->save(ROOTPATH . 'uploads/' . $filename);
            $saveData['dl_file'] = $filename;
            
        } else if($ext=="pdf") {
            $file->move(ROOTPATH . 'uploads/', $filename);
            $saveData['dl_file'] = $filename;
        }
      }
    }
    if ($file = $this->request->getFile('upload_ic')) {
      if ($file->isValid() && !$file->hasMoved()) {
      $filename = $file->getRandomName();
      $ext = $file->guessExtension();
          if (in_array($ext, ['jpg', 'png', 'jpeg'])) {
            $image = \Config\Services::image()->withFile($file)->save(ROOTPATH . 'uploads/' . $filename);
            $saveData['ic_file'] = $filename;
            
        } else if($ext=="pdf") {
            $file->move(ROOTPATH . 'uploads/', $filename);
            $saveData['ic_file'] = $filename;
        }
      }
    }
    if($post['csrf_token']===$post['match_captcha']){
      $last_id = $this->c_model->insertRecords('driver_query', $saveData);
      if($last_id){
        $this->session->setFlashdata('success', 'Data Added Successfully ');
        return redirect()->to(base_url('drive-with-us'));
      }
    }else{
      $this->session->setFlashdata('failed', 'Something Went Wrong');
        return redirect()->to(base_url('drive-with-us'));
    }
    
    }

}
