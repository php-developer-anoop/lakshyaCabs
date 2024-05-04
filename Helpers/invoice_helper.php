<?php 

function invoiceHtml($booking,$id,$company,$invoice_no){
    $package_name=$booking['trip_type']=="Local"?$booking['package_name']:$booking['drop_city_name'];
    $rest_amount= (int)$booking['rest_amount'] != 0? ucwords(convertAmountToWords($booking['rest_amount'])):'';
    $total_gst=0;
   $html = '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Invoice For Booking ID '.$id.'</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  </head>
  <body>
    <table class="table" style="margin: auto;
      border-spacing: 0; 
      border-collapse: separate;font-family: Urbanist;  border: 1px solid #e2e2e2; border-radius: 25px;">
      <thead >
        <tr style="
          background: #5a9aff;
          color: white;
          border-top-right-radius: 25px;
          border-top-left-radius: 25px;
          border: 1px solid #e2e2e2;
          " ;>
          <th colspan="8" style="padding-left: 26px;border-top-left-radius: 25px; text-align: start;
            ">
            <h5 style="font-size: 20px; margin: 0px;padding: 10px 0px;">Tax Invoice</h5>
          </th>
          <th colspan="4" style="border-top-right-radius: 25px;">
            <p  style=" margin: 0px;
              font-size: 13px;
              font-weight: 500;";>Thanks for booking at '.$company['company_name'].'</p>
          </th>
        </tr>
      </thead>
      <thead>
        <tr>
          <th scope="col" colspan="3" style="padding-right: 1.5rem !important;
            padding-left: 1.5rem !important; border:0px; text-align: start; font-size: 22px;">
            <span 
              ><img src="'.base_url("uploads/".$company['logo']).'"></span>
          </th>
          <th scope="col"  colspan="2">
            <p style="margin: 0px;
              font-size: 11px;">Booking no</p>
            <h6  style="margin: 0px;
              font-size: 16px;
              font-weight: 500";>'.$booking['booking_id'].'</h6>
          </th>
          <th scope="col" colspan="2" >
            <p  style="margin: 0px;
              font-size:11px";>Invoice no</p>
            <h6  style="margin: 0px;
              font-size:16px;
              font-weight:500;";>'.$invoice_no.'</h6>
          </th>
          <th scope="col"  colspan="2">
            <p  style="margin: 0px;
              font-size: 11px";>Invoice date</p>
            <h6  style="margin: 0px;
              font-size: 16px;
              font-weight: 500;";>'.date('d/m/Y').'</h6>
          </th>
          <th scope="col" colspan="2" >
            <p  style="margin: 0px;
              font-size: 11px";>Invoice Period</p>
            <h6  style="margin: 0px;
              font-size: 16px;
              font-weight: 500;";>02/01/2024 - 04/01/2024</h6>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr scope="col"  style="background: #f2f7ff;
          color: #5a9aff;
          font-size: 18px;
          font-weight: 500;">
          <td colspan="6" style="padding: 4px 1.5rem; border-right: 1px solid rgb(230, 222, 222);">Invoice By</td>
          <td colspan="6" style="padding-right: 1.5rem !important;
            padding-left: 1.5rem !important">Invoice to</td>
        </tr>
        <tr scope="col">
          <td colspan="6" class="midsec" style="padding-right: 1.5rem !important;
            padding-left: 1.5rem !important; border-right: 1px solid rgb(230, 222, 222)";>
            <h6 style=" font-weight: 400; font-size: 14px; margin: 0px; padding: 2px 0px;"><b style="font-weight: 500;">'.$company['company_name'].'</b></h6>
            <h6 style=" font-weight: 400; font-size: 14px; margin: 0px; padding: 2px 0px;"><b style="font-weight: 500;">Email ID:</b>'.$company['care_email'].'</h6>
            <h6 style=" font-weight: 400; font-size: 14px; margin: 0px; padding: 2px 0px;"><b style="font-weight: 500;">Contact:</b> +91-'.$company['care_mobile'].'</h6>
            <h6 style=" font-weight: 400; font-size: 14px; margin: 0px; padding: 2px 0px;"><b style="font-weight: 500;">Office Address:</b> '.$company['office_address'].'
            </h6>
            <h6 style=" font-weight: 400; font-size: 14px; margin: 0px; padding: 2px 0px;"><b style="font-weight: 500;">GSTID:</b> '.$company['gst_no'].'</h6>
            <h6 style=" font-weight: 400; font-size: 14px; margin: 0px; padding: 2px 0px;"><b style="font-weight: 500;">PAN No.:</b> '.$company['pan_no'].'</h6>
          </td>
          <td colspan="6" style="padding-right: 1.5rem !important;
            padding-left: 1.5rem !important">
            <h6 style=" font-weight: 400; font-size: 14px; margin: 0px; padding: 2px 0px;"><b style="font-weight: 500;">'.$booking['name'].'</b></h6>
            <h6 style=" font-weight: 400; font-size: 14px; margin: 0px; padding: 2px 0px;"><b style="font-weight: 500;">Email ID:</b> '.$booking['email'].'</h6>
            <h6 style=" font-weight: 400; font-size: 14px; margin: 0px; padding: 2px 0px;"><b style="font-weight: 500;">Contact:</b> +91-'.$booking['mobile_no'].'</h6>
            <h6 style=" font-weight: 400; font-size: 14px; margin: 0px; padding: 2px 0px;"><b style="font-weight: 500;">Office Address:</b> '.$booking['address'].'
            </h6>';
            if(!empty($booking['gstin_number'])){
            $html.='
            <h6 style=" font-weight: 400; font-size: 14px; margin: 0px; padding: 2px 0px;"><b style="font-weight: 500;">GSTID:</b> '.$booking['gstin_number'].'</h6>';
            }
            if(!empty($booking['company_pan_number'])){
            $html.='
            <h6 style=" font-weight: 400; font-size: 14px; margin: 0px; padding: 2px 0px;"><b style="font-weight: 500;">PAN No.:</b>'.$booking['company_pan_number'].'</h6>';
            }
            $html.='
          </td>
        </tr>
        <tr  style="background: #5a9aff; color:white;">
          <td colspan="3" style="
            padding-left: 1.5rem !important; border:0px; font-size: 18px;
            font-style: normal;
            font-weight: 600;">
            <span class="h4">Trip Detail</span>
          </td>
          <td colspan="4" style="padding: 6px 0px;">
            <h6 style="margin: 0px; font-size:14px;font-weight: 500;">
              Pickup Address: <span  style="font-weight: 400;">
              '.$booking['pickup_address'].'
              </span>
            </h6>
            <h6 style="margin: 0px; font-size:14px; font-weight: 500;">
              Pickup D Time.<span style="font-weight: 400;">'.date('d/m/Y h:i a',strtotime($booking['pickup_date_time'])).'</span> 
            </h6>
          </td>
          <td colspan="3" style="text-align: center;">
            <h6 style="margin: 0px; font-size:14px;font-weight: 500;">
              Drop Address:
              <span style="font-weight: 400;">
              '.$booking['drop_address'].'
              </span>
            </h6>
          </td>
        </tr>
        <tr style="background: #F2F7FF; text-align: left;">
          <th colspan="2" style="padding: 4px 1.5rem; font-size: 14px;
            font-style: normal;
            font-weight: 500;">Used Date</th>
          <th colspan="2" style=" padding: 4px 1.5rem;   font-size: 14px;
            font-style: normal;
            font-weight: 500;">Vehicle</th>
          <th colspan="3" style="padding: 4px 1.5rem;   font-size: 14px;
            font-style: normal;
            font-weight: 500;">Description</th>
          <th style="padding: 4px 1.5rem;   font-size: 14px;
            font-style: normal;
            font-weight: 500;">Quantity</th>
          <th style="padding: 4px 1.5rem;    font-size: 14px;
            font-style: normal;
            font-weight: 500;">Tariff</th>
          <th colspan="3" style="padding: 4px 1.5rem;    font-size: 14px;
            font-style: normal;
            font-weight: 500;">Amount</th>
        </tr>
        <tr>
          <td colspan="2" style="padding: 4px 1.5rem;border-right: 1px solid rgb(230, 222, 222);">
            <span style=" font-weight: 500;font-size: 14px;">'.date('d/m/Y',strtotime($booking['pickup_date_time'])).'</span>
          </td>
          <td colspan="2" style="padding: 4px 1.5rem;border-right: 1px solid rgb(230, 222, 222);">
            <span style=" font-weight: 500;font-size: 14px;">'.$booking['model_name'].'<br />
            (Sedan)<br>
            <span style="font-weight: 500;font-size: 14px;">'.$booking['vehicle_no'].'</span>
            </span>
          </td>
          <td colspan="3" style="padding: 4px 1.5rem;border-right: 1px solid rgb(230, 222, 222);">
            <span style=" font-weight: 500;font-size: 14px;">'.$package_name.' <br>Estimated fare (km): '.(int)$booking['base_covered_km'].'</span>
          </td>
          <td style="padding: 4px 1.5rem;border-right: 1px solid rgb(230, 222, 222);"> <span style="font-weight: 500;font-size: 14px;">'.(int)$booking['base_covered_km'].' KM</span></td>
          <td  style="border-right: 1px solid rgb(230, 222, 222);" ></td>
          <td colspan="2" style="padding: 4px 1.5rem;border-right: 1px solid rgb(230, 222, 222);"> <span style="font-weight: 500;font-size: 14px;">'.$booking['base_fare'].'</span></td>
        </tr>
        <tr>
          <td colspan="2" style="padding: 4px 1.5rem;border-right: 1px solid rgb(230, 222, 222);"></td>
          <td colspan="2" style="padding: 4px 1.5rem;border-right: 1px solid rgb(230, 222, 222);"> </td>
          <td colspan="3" style="padding: 4px 1.5rem;border-right: 1px solid rgb(230, 222, 222);"> <span style="font-weight: 500;font-size: 14px;"></span></td>
          <td  style="border-right: 1px solid rgb(230, 222, 222);" ></td>
          <td style="padding: 4px 1.5rem;border-right: 1px solid rgb(230, 222, 222);"> <span style="font-weight: 500;font-size: 14px;"></span></td>
          <td colspan="2" style="padding: 4px 1.5rem;border-right: 1px solid rgb(230, 222, 222);"> <span style="font-weight: 500;font-size: 14px;"></span></td>
        </tr>';
        if($booking['state_id']==COMPANY_STATE){
        $sgst = $cgst = (9 / 100) * $booking['total_trip_amount'];
        $total_gst= ($sgst*2);
        $html.='
        <tr >
          <td colspan="2" style="padding: 4px 1.5rem;border-right: 1px solid rgb(230, 222, 222);"></td>
          <td colspan="2" style="padding: 4px 1.5rem;border-right: 1px solid rgb(230, 222, 222);"> </td>
          <td colspan="3" style="padding: 4px 1.5rem;border-right: 1px solid rgb(230, 222, 222);"> <span style="font-weight: 500;font-size: 14px;">SGST:</span></td>
          <td  style="border-right: 1px solid rgb(230, 222, 222);" ></td>
          <td style="padding: 4px 1.5rem;border-right: 1px solid rgb(230, 222, 222);"> <span style="font-weight: 500;font-size: 14px;">9%</span></td>
          <td colspan="2" style="padding: 4px 1.5rem;border-right: 1px solid rgb(230, 222, 222);"> <span style="font-weight: 500;font-size: 14px;">'.$sgst.'</span></td>
        </tr>
        <tr >
          <td colspan="2" style="border-right: 1px solid rgb(230, 222, 222);" ></td>
          <td colspan="2"  style="border-right: 1px solid rgb(230, 222, 222);" ></td>
          <td colspan="3" style="padding: 4px 1.5rem;border-right: 1px solid rgb(230, 222, 222);"> <span style="font-weight: 500;font-size: 14px;">CGST:</span></td>
          <td  style="border-right: 1px solid rgb(230, 222, 222);" ></td>
          <td style="padding: 4px 1.5rem;border-right: 1px solid rgb(230, 222, 222);"> <span style="font-weight: 500;font-size: 14px;">9%</span></td>
          <td colspan="2" style="padding: 4px 1.5rem;border-right: 1px solid rgb(230, 222, 222);"> <span style="font-weight: 500;font-size: 14px;">'.$cgst.'</span></td>
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
        <tr >
          <td colspan="2"  style="border-right: 1px solid rgb(230, 222, 222);" ></td>
          <td colspan="2"  style="border-right: 1px solid rgb(230, 222, 222);" ></td>
          <td colspan="3" style="padding: 4px 1.5rem;border-right: 1px solid rgb(230, 222, 222);"> <span style="font-weight: 500;font-size: 14px;">Sub total:</span></td>
          <td  style="border-right: 1px solid rgb(230, 222, 222);" ></td>
          <td  style="border-right: 1px solid rgb(230, 222, 222);" ></td>
          <td colspan="2" style="padding: 4px 1.5rem;border-right: 1px solid rgb(230, 222, 222);"> <span style="font-weight: 500;font-size: 14px;">'.($booking['total_trip_amount']+$total_gst).'</span></td>
        </tr>
        <tr >
          <td colspan="2"  style="border-right: 1px solid rgb(230, 222, 222);" ></td>
          <td colspan="2"  style="border-right: 1px solid rgb(230, 222, 222);" ></td>
          <td colspan="3" style="padding: 4px 1.5rem;border-right: 1px solid rgb(230, 222, 222);"> <span style="font-weight: 500;font-size: 14px;">Total Amount:</span></td>
          <td  style="border-right: 1px solid rgb(230, 222, 222);" ></td>
          <td  style="border-right: 1px solid rgb(230, 222, 222);" ></td>
          <td colspan="2" style="padding: 4px 1.5rem;border-right: 1px solid rgb(230, 222, 222);"> <span style="font-weight: 500;font-size: 14px;">'.$booking['total_trip_amount_with_gst'].'</span></td>
        </tr>
        <tr>
          <td colspan="2" style="border-right: 1px solid rgb(230, 222, 222);"></td>
          <td colspan="2" style="border-right: 1px solid rgb(230, 222, 222);"></td>
          <td colspan="3" style="padding: 4px 1.5rem; border-right: 1px solid rgb(230, 222, 222);">
            <span style="font-weight: 500; font-size: 14px;">Discount:</span>
          </td>
          <td style="border-right: 1px solid rgb(230, 222, 222);"></td>
          <td style="border-right: 1px solid rgb(230, 222, 222);"></td>
          <td colspan="2" style="padding: 4px 1.5rem; border-right: 1px solid rgb(230, 222, 222);">
            <span style="font-weight: 500; font-size: 14px;">'.$booking['discount'].'</span>
          </td>
        </tr>
        <tr >
          <td colspan="2"  style="border-right: 1px solid rgb(230, 222, 222);" ></td>
          <td colspan="2"  style="border-right: 1px solid rgb(230, 222, 222);" ></td>
          <td colspan="3" style="padding: 4px 1.5rem;border-right: 1px solid rgb(230, 222, 222);"> <span style="font-weight: 500; font-size: 14px;">Cash Collection:</span></td>
          <td  style="border-right: 1px solid rgb(230, 222, 222);" ></td>
          <td  style="border-right: 1px solid rgb(230, 222, 222);" ></td>
          <td colspan="2" style="padding: 4px 1.5rem;border-right: 1px solid rgb(230, 222, 222);"> <span style="font-weight: 500; font-size: 14px;">'.$booking['booking_amount'].'</span></td>
        </tr>
        <tr class="bg-blue" style="background: #5a9aff; color: white;">
          <td colspan="5" style="padding-right: 1.5rem !important;
            padding-left: 1.5rem !important; border:0px; text-align: end;    padding: 4px 1.5rem;">
            <span style=" font-weight: 500; font-size: 15px;">For Booking ID: CAB1234455</span>
          </td>
          <td colspan="7"  style="border-right: 1px solid rgb(230, 222, 222);" >
            <span style=" font-weight: 500; font-size: 15px;">'.$rest_amount.'</span>
          </td>
        </tr>
        <tr>
          <td colspan="8" style="    padding: 0.5rem 0px 0.5rem 1.5rem;">
            <span >
              <h5 style="font-size: 15px;
                margin: 0px;">Please note:</h5>
              <p style="margin: 0px;
                font-weight: 500;
                font-size: 14px;">1: Please check.......signed duty vouchers attached.</p>
              <p style="margin: 0px;
                font-weight: 500;
                font-size: 14px;">2: Mileage and time in charged from garage to garage.</p>
            </span>
          </td>
          <td colspan="8" style="    text-align: center;
            padding-bottom: 4px;">
            <span>
              <p style="margin: 0px;
                font-weight: 500;
                font-size: 14px;"><b style="font-weight: 500;">For,Cab Pvt.Ltd.</b></p>
              <span
                ><img src="cab.png"></span>
              <p style="margin: 0px;
                font-weight: 500;
                font-size: 14px;"><b style="font-weight: 500;">Auth.Signatory</b></p>
            </span>
          </td>
        </tr>
      </tbody>
    </table>
  </body>
</html>'; 
return $html;
}