<?php 

function paymentSlipHtml($booking,$id,$company,$payment_slip_no){
    $package=$booking['trip_type']=="Local"?$booking['package_name']:$booking['drop_city_name'];
    $rest_amount= (int)$booking['rest_amount'] != 0? ucwords(convertAmountToWords($booking['rest_amount'])):'';
    $total_gst=0;
   $html = '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Payment Slip For Booking ID '.$id.'</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  </head>
  <body>
    <table class="table" style="margin: auto; border-spacing: 0; border-collapse: separate; font-family: Urbanist; border: 1px solid #e2e2e2; border-radius: 25px;">
      
      <tbody>
        <tr style="border-top-right-radius: 25px; border-top-left-radius: 25px;">
          <td scope="col" colspan="2" style="padding: 10px 0px;">
            <span><img src="'.base_url("uploads/".$company['logo']).'" style="border-right: 1px solid rgb(230, 222, 222);" /></span>
          </td>
          <td scope="col" colspan="10" style="text-align: start;">
            <span style="font-weight: 400; font-size: 13px; margin: 0px; padding: 6px 6px; line-height: 32px;"><b style="font-weight: bold; padding-right: 6px;font-size:15px;">Company Name :</b>'.$company['company_name'].'</span>
            &nbsp;&nbsp;&nbsp;&nbsp; <span style="font-weight: 400; font-size: 13px; margin: 0px; padding: 6px 6px;"><b style="font-weight: bold; padding-right: 6px;font-size:15px;">Email ID :</b>'.$company['care_email'].'</span><br>
            <span style="font-weight: 400; font-size: 13px; margin: 0px; padding: 6px 6px;"><b style="font-weight: bold; padding-right: 6px;font-size:15px;">Contact no :</b>+91-'.$company['care_mobile'].'</span>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight: 400; font-size: 13px; margin: 0px; padding: 6px 6px;"><b style="font-weight: bold; padding-right: 6px;font-size:15px;">GSTID :</b>'.$company['gst_no'].'</span>
            <br><span style="font-weight: 400; font-size: 13px; margin: 0px; padding: 6px 6px;">
            <b style="font-weight: bold; padding-right: 6px;font-size:15px;">Office Address :</b> '.$company['office_address'].'
            </span>
          </d>
        </tr>
    
        <tr>
          <td colspan="4" style="border-top: 1px solid rgb(230, 222, 222); padding: 6px 1.5rem; border-right: 1px solid rgb(230, 222, 222);">
            <h6 style="font-weight: 400; font-size: 13px; margin: 0px; padding: 2px 0px;">
              <b style="font-weight: bold; padding-right: 6px;font-size:15px;">Customer Name:</b>
              &nbsp; '.$booking['guest_name'].'
            </h6>
            <h6 style="font-weight: 400; font-size: 13px; margin: 0px; padding: 2px 0px;">
              <b style="font-weight: bold; padding-right: 6px;font-size:15px;">Mobile number:</b>
               &nbsp;+91-'.$booking['guest_mobile_no'].'
            </h6>
            <h6 style="font-weight: 400; font-size: 13px; margin: 0px; padding: 2px 0px;">
              <b style="font-weight: bold; padding-right: 6px;font-size:15px;">Company name:</b>
               &nbsp;'.$booking['company_name'].'
            </h6>
            <h6 style="font-weight: 400; font-size: 13px; margin: 0px; padding: 2px 0px;">
              <b style="font-weight: bold; padding-right: 6px;font-size:15px;">GST No:</b>
             &nbsp;  '.$booking['gstin_number'].'
            </h6>
          </td>
          <td colspan="4" style="border-top: 1px solid rgb(230, 222, 222);  padding: 6px 1.5rem;">
            <span>
              <span style="font-size: 13px; font-weight: 600;">
                <span style="font-weight: bold; font-size: 15px; margin: 0px; padding: 6px 10px;">
                  Booking no:
                </span>
                <span style="padding: 2px 6px;"> &nbsp;'.$booking['booking_id'].'</span>
              </span>
              <br>
              <span style="padding: 6px 6px; font-size: 13px; font-weight: 600;">
                <span style="font-weight: bold; font-size: 15px; margin: 0px; padding: 2px 6px;">
                  Payment Slip no:
                </span>
                <span style="padding: 2px 6px;"> &nbsp;'.$payment_slip_no.'</span>
              </span>
               <br>
              <span style="padding: 6px 6px; font-size: 13px; font-weight: 600;">
                <span style="font-weight: bold; font-size: 15px; margin: 0px; padding: 2px 6px;">
                  Payment date:
                </span>
                <span style="padding: 2px 6px;"> &nbsp;02/01/2024</span>
              </span>
            </span>
            <span style="line-height: 25px;">
            <span>
            </span>
            <br />
            <span>
            <span style="font-weight: 400; font-size: 13px; margin: 0px; padding: 2px 10px 2px 20px;"><b style="font-weight: bold;font-size: 15px;">Trip Type :</b> &nbsp; '.$booking['trip_type'].'</span>
            </span>
            </span>
            
            </td>
             <td colspan="4" style="border-top: 1px solid rgb(230, 222, 222);">
            <span>
           </span>
           
           <span>
                       <span style="font-weight: 400; font-size: 13px; margin: 0px; padding: 2px 20px 2px 10px;"><b style="font-weight: bold;font-size: 15px;">Drop Address :</b> '.$booking['drop_address'].'</span><br>
          <span style="font-weight: 400; font-size: 13px; margin: 0px; padding: 2px 10px 2px 20px;"><b style="font-weight: bold;font-size: 15px;">Pickup Date & Time:</b> '.date('d/m/Y h:i a',strtotime($booking['pickup_date_time'])).'</span>
          <span style="font-weight: 400; font-size: 13px; margin: 0px; padding: 2px 10px 2px 20px;"><b style="font-weight: bold;font-size: 15px;">Pickup Date & Time:</b> '.date('d/m/Y h:i a',strtotime($booking['pickup_date_time'])).'</span>

           </span>
           
            </td>
          
          </td>
        </tr>
        <tr style="background: #f2f7ff; text-align: left;">
          <th colspan="2" style="padding: 6px 1.5rem; font-size: 14px; font-style: normal; font-weight: 500;">
            Used Date
          </th>
          <th colspan="2" style="padding: 6px 1.5rem; font-size: 14px; font-style: normal; font-weight: 500;">
            Vehicle
          </th>
          <th colspan="3" style="padding: 6px 1.5rem; font-size: 14px; font-style: normal; font-weight: 500;">
            Description
          </th>
          <th style="padding: 6px 1.5rem; font-size: 14px; font-style: normal; font-weight: 500;">
            Quantity
          </th>
          <th style="padding: 6px 1.5rem; font-size: 14px; font-style: normal; font-weight: 500;">
            Tariff
          </th>
          <th colspan="3" style="padding: 6px 1.5rem; font-size: 14px; font-style: normal; font-weight: 500;">
            Amount
          </th>
        </tr>
        <tr>
          <td colspan="2" style="padding: 6px 1.5rem; border-right: 1px solid rgb(230, 222, 222);">
            <span style="font-weight: 500; font-size: 14px;">'.date('d/m/Y',strtotime($booking['pickup_date_time'])).'</span>
          </td>
          <td colspan="2" style="padding: 6px 1.5rem; border-right: 1px solid rgb(230, 222, 222);">
            <span style="font-weight: 500; font-size: 14px;">
            '.$booking['model_name'].'<br />
            ('.$booking['category_name'].')<br />
            <span style="font-weight: 500; font-size: 14px;">'.$booking['vehicle_no'].'</span>
            </span>
          </td>
          <td colspan="3" style="padding: 6px 1.5rem; border-right: 1px solid rgb(230, 222, 222);">
            <span style="font-weight: 500; font-size: 14px;">'.$package.' <br>Estimated fare (km): '.(int)$booking['base_covered_km'].'</span>
          </td>
          <td style="padding: 6px 1.5rem; border-right: 1px solid rgb(230, 222, 222);">
            <span style="font-weight: 500; font-size: 14px;">'.(int)$booking['base_covered_km'].' KM</span>
          </td>
          <td style="border-right: 1px solid rgb(230, 222, 222);"></td>
          <td colspan="2" style="padding: 6px 1.5rem; border-right: 1px solid rgb(230, 222, 222);">
            <span style="font-weight: 500; font-size: 14px;">'.$booking['base_fare'].'</span>
          </td>
        </tr>
        <tr>
          <td colspan="2" style="padding: 6px 1.5rem; border-right: 1px solid rgb(230, 222, 222);"></td>
          <td colspan="2" style="padding: 6px 1.5rem; border-right: 1px solid rgb(230, 222, 222);"></td>
          <td colspan="3" style="padding: 6px 1.5rem; border-right: 1px solid rgb(230, 222, 222);">
            <span style="font-weight: 500; font-size: 14px;"></span>
          </td>
          <td style="border-right: 1px solid rgb(230, 222, 222);"></td>
          <td style="padding: 6px 1.5rem; border-right: 1px solid rgb(230, 222, 222);">
            <span style="font-weight: 500; font-size: 14px;"></span>
          </td>
          <td colspan="2" style="padding: 6px 1.5rem; border-right: 1px solid rgb(230, 222, 222);">
            <span style="font-weight: 500; font-size: 14px;"></span>
          </td>
        </tr>';
        if($booking['state_id']==COMPANY_STATE){
        $sgst = $cgst = (9 / 100) * $booking['total_trip_amount'];
        $total_gst= ($sgst*2);
        $html.='
        <tr>
          <td colspan="2" style="padding: 6px 1.5rem; border-right: 1px solid rgb(230, 222, 222);"></td>
          <td colspan="2" style="padding: 6px 1.5rem; border-right: 1px solid rgb(230, 222, 222);"></td>
          <td colspan="3" style="padding: 6px 1.5rem; border-right: 1px solid rgb(230, 222, 222);">
            <span style="font-weight: 500; font-size: 14px;">SGST:</span>
          </td>
          <td style="border-right: 1px solid rgb(230, 222, 222);"></td>
          <td style="padding: 6px 1.5rem; border-right: 1px solid rgb(230, 222, 222);">
            <span style="font-weight: 500; font-size: 14px;">9%</span>
          </td>
          <td colspan="2" style="padding: 6px 1.5rem; border-right: 1px solid rgb(230, 222, 222);">
            <span style="font-weight: 500; font-size: 14px;">'.$sgst.'</span>
          </td>
        </tr>
        <tr>
          <td colspan="2" style="border-right: 1px solid rgb(230, 222, 222);"></td>
          <td colspan="2" style="border-right: 1px solid rgb(230, 222, 222);"></td>
          <td colspan="3" style="padding: 6px 1.5rem; border-right: 1px solid rgb(230, 222, 222);">
            <span style="font-weight: 500; font-size: 14px;">CGST:</span>
          </td>
          <td style="border-right: 1px solid rgb(230, 222, 222);"></td>
          <td style="padding: 6px 1.5rem; border-right: 1px solid rgb(230, 222, 222);">
            <span style="font-weight: 500; font-size: 14px;">9%</span>
          </td>
          <td colspan="2" style="padding: 6px 1.5rem; border-right: 1px solid rgb(230, 222, 222);">
            <span style="font-weight: 500; font-size: 14px;">'.$cgst.'</span>
          </td>
        </tr>
        ';}else{
            
            $total_gst = $igst = (18 / 100) * $booking['total_trip_amount'];
            
           $html.='
        <tr>
          <td colspan="2" style="padding: 6px 1.5rem; border-right: 1px solid rgb(230, 222, 222);"></td>
          <td colspan="2" style="padding: 6px 1.5rem; border-right: 1px solid rgb(230, 222, 222);"></td>
          <td colspan="3" style="padding: 6px 1.5rem; border-right: 1px solid rgb(230, 222, 222);">
            <span style="font-weight: 500; font-size: 14px;">IGST:</span>
          </td>
          <td style="border-right: 1px solid rgb(230, 222, 222);"></td>
          <td style="padding: 6px 1.5rem; border-right: 1px solid rgb(230, 222, 222);">
            <span style="font-weight: 500; font-size: 14px;">18%</span>
          </td>
          <td colspan="2" style="padding: 6px 1.5rem; border-right: 1px solid rgb(230, 222, 222);">
            <span style="font-weight: 500; font-size: 14px;">'.$igst.'</span>
          </td>
        </tr>
        
        '; 
        }
        $html.='
        <tr>
          <td colspan="2" style="border-right: 1px solid rgb(230, 222, 222);"></td>
          <td colspan="2" style="border-right: 1px solid rgb(230, 222, 222);"></td>
          <td colspan="3" style="padding: 6px 1.5rem; border-right: 1px solid rgb(230, 222, 222);">
            <span style="font-weight: 500; font-size: 14px;">Sub Total:</span>
          </td>
          <td style="border-right: 1px solid rgb(230, 222, 222);"></td>
          <td style="border-right: 1px solid rgb(230, 222, 222);"></td>
          <td colspan="2" style="padding: 6px 1.5rem; border-right: 1px solid rgb(230, 222, 222);">
            <span style="font-weight: 500; font-size: 14px;">'.($booking['total_trip_amount']+$total_gst).'</span>
          </td>
        </tr>
        <tr>
          <td colspan="2" style="border-right: 1px solid rgb(230, 222, 222);"></td>
          <td colspan="2" style="border-right: 1px solid rgb(230, 222, 222);"></td>
          <td colspan="3" style="padding: 6px 1.5rem; border-right: 1px solid rgb(230, 222, 222);">
            <span style="font-weight: 500; font-size: 14px;">Total Amount:</span>
          </td>
          <td style="border-right: 1px solid rgb(230, 222, 222);"></td>
          <td style="border-right: 1px solid rgb(230, 222, 222);"></td>
          <td colspan="2" style="padding: 6px 1.5rem; border-right: 1px solid rgb(230, 222, 222);">
            <span style="font-weight: 500; font-size: 14px;">'.$booking['total_trip_amount_with_gst'].'</span>
          </td>
        </tr>
        <tr>
          <td colspan="2" style="border-right: 1px solid rgb(230, 222, 222);"></td>
          <td colspan="2" style="border-right: 1px solid rgb(230, 222, 222);"></td>
          <td colspan="3" style="padding: 6px 1.5rem; border-right: 1px solid rgb(230, 222, 222);">
            <span style="font-weight: 500; font-size: 14px;">Discount:</span>
          </td>
          <td style="border-right: 1px solid rgb(230, 222, 222);"></td>
          <td style="border-right: 1px solid rgb(230, 222, 222);"></td>
          <td colspan="2" style="padding: 6px 1.5rem; border-right: 1px solid rgb(230, 222, 222);">
            <span style="font-weight: 500; font-size: 14px;">'.$booking['discount'].'</span>
          </td>
        </tr>
        <tr>
          <td colspan="2" style="border-right: 1px solid rgb(230, 222, 222);"></td>
          <td colspan="2" style="border-right: 1px solid rgb(230, 222, 222);"></td>
          <td colspan="3" style="padding: 4px 1.5rem 8px; border-right: 1px solid rgb(230, 222, 222);">
            <span style="font-weight: 500; font-size: 14px;">Cash Collection:</span>
          </td>
          <td style="border-right: 1px solid rgb(230, 222, 222);"></td>
          <td style="border-right: 1px solid rgb(230, 222, 222);"></td>
          <td colspan="2" style="padding: 6px 1.5rem; border-right: 1px solid rgb(230, 222, 222);">
            <span style="font-weight: 500; font-size: 14px;">'.$booking['booking_amount'].'</span>
          </td>
        </tr>
        <tr class="bg-blue" style="background: #5a9aff; color: white;">
          <td colspan="5" style="padding-right: 1.5rem !important; padding-left: 1.5rem !important; border: 0px; text-align: end; padding: 6px 1.5rem;">
            <span style="font-weight: 500; font-size: 15px; color:white;">For Booking ID: '.$id.'</span>
          </td>
          <td colspan="7" style="border-right: 1px solid rgb(230, 222, 222);">
            <span style="font-weight: 500; font-size: 15px;color:white;">'.$rest_amount.'</span>
          </td>
        </tr>
        <tr>
          <td colspan="8" style="padding: 1rem 0px 1rem 1.5rem;">
            <span>
              <h5 style="font-size: 15px; margin: 0px;">Please note:</h5>
              <p style="margin-bottom: 0px; font-weight: 500; font-size: 14px;">
                1: Please check.......signed duty vouchers attached.
              </p>
              <p style="margin-bottom: 0px; font-weight: 500; font-size: 14px;">
                2: Mileage and time in charged from garage to garage.
              </p>
            </span>
          </td>
          <td colspan="8" style="text-align: center; padding-bottom: 8px;">
            <span>
              <p style="margin-bottom: 0px; font-weight: 500; font-size: 14px;">
                <b style="font-weight: 500;">For,Cab Pvt.Ltd.</b>
              </p>
              <span><img src="cab.png" /></span>
              <p style="margin: 0px; font-weight: 500; font-size: 14px;">
                <b style="font-weight: 500;">Auth.Signatory</b>
              </p>
            </span>
          </td>
        </tr>
      </tbody>
    </table>
  </body>
</html>'; 
return $html;
}