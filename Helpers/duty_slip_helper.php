<?php 

function dutySlipHtml($booking,$id,$company){
    $package_name=$booking['trip_type']=="Local"?$booking['package_name']:$booking['drop_city_name'];
   $html = '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Duty Slip For Booking Id '.$id.'</title>
  </head>
  <body>
    <table class="table table2" style=" margin: auto!important;width:1000px;
      border-spacing: 0; 
      border-collapse: separate;font-family: system-ui; border: 1px solid #e2e2e2; border-radius: 5px" ;>
     
      <tbody class="content">
      <tr>
          <td colspan="10"
            style=" text-align:center; background: rgb(90, 154, 255); color: white; font-size: 24px; padding:20px 0px; border-top-left-radius: 5px" ;>
        <span style="font-weight:bold">
        
            Duty Slip
     </span>
          </td>
          <td colspan="2">
           <span style="display:flex; justify-content:end">
            <img src="'.base_url("uploads/".$company['logo']).'" class="img-fluid" style="width: 130px;">
          <span>
         </td>
          
           
        </tr>
      
        <tr scope="col" style="color: rgb(90, 154, 255);
          font-size: 18px;
          font-weight: 500;
          background: rgb(242, 247, 255);">
          <td colspan="5" style="padding: 10px 0px 10px 1.5rem;font-size: 14px;">Customer Detail</td>
          <td colspan="6" style="padding: 10px 0px 10px 1.5rem; font-size: 14px; text-align:start;">Car Detail</td>
        </tr>
        <tr scope="col" colspan="12">
          <td style="padding: 6px 1.5rem 6px; border:0px" colspan="3"><span style="font-size:12px" ;><b>Full Name:
            </b>&nbsp;&nbsp;'.$booking['guest_name'].'</span>
          </td>
          <td style="padding-right: 1.5rem !important;
            padding-left: 1.5rem !important;
            border-right: 1px solid rgb(236, 228, 228);
            border-bottom: none;" colspan="2"> <span style="font-size:12px" ;><b>Moblie</b>&nbsp;&nbsp; +91-'.$booking['guest_mobile_no'].'</span>
          </td>
          <td style="
            padding: 6px 1.5rem 6px; border:0px" colspan="3"><span style="font-size:12px" ;><b>Driver Name:
            </b>&nbsp;'.$booking['driver_name'].'</span>
          </td>
          <td style="
            padding-left: 1.5rem !important;
            padding-top:6px; border:0px" colspan="3"><span style="font-size:12px"
            ;><b>Moblie</b>&nbsp;&nbsp; +91-'.$booking['driver_mobile_no'].'</span></td>
        </tr>
        <tr scope="col" colspan="12">
          <td style="padding: 0px 1.5rem 6px;border:0px" colspan="3"> <span style="font-size:12px"
            ;><b>City:</b>&nbsp;&nbsp;'.$booking['guest_name'].'</span></td>
          <td style="padding-right: 1.5rem !important;
            padding-left: 1.5rem !important;
            border-right: 1px solid rgb(236, 228, 228);
            border-bottom: none;" colspan="2"></td>
          <td style="    padding: 0px 1.5rem 6px;border:0px" colspan="3"><span style="font-size:12px" ;><b>Car
            No:</b>&nbsp;&nbsp; '.$booking['vehicle_no'].'</span>
          </td>
          <td style="padding-right: 1.5rem !important;
            padding-left: 1.5rem !important; border:0px" colspan="3"></td>
        </tr>
        <tr scope="col" style="color: rgb(90, 154, 255);
          font-size: 18px;
          font-weight: 500;
          background: rgb(242, 247, 255);">
          <td colspan="5" style="padding: 10px 1.5rem; font-size: 14px;">Booking Detail</td>
        <td colspan="6" style="padding: 10px 0px 10px 1.5rem; font-size: 14px; text-align:start;">Payment Detail</td>
        </tr>
        
      
        <tr scope="col" colspan="12">
          <td style="padding: 0px 1.5rem 6px; border:0px" colspan="3"><span style="font-size:12px" ;><b>Travel
            Type:</b>&nbsp;'.$package_name.'</span></span>
          </td>
          <td style="padding-right: 1.5rem !important;
            padding-left: 1.5rem !important;
            padding-top:6px;
            border-right: 1px solid rgb(236, 228, 228);
            border-bottom: none;" colspan="2"><span style="font-size:12px" ;><b>Pickup date time:</b>&nbsp;'.date('d/m/Y h:i a',strtotime($booking['pickup_date_time'])).'</span>
          </td>
          <td style=" padding: 0px 1.5rem 0px; border:0px" colspan="3"><span style="font-size:12px" ;><b>Extra charges
            detail below</b></span>
          </td>
          <td style="padding-right: 1.5rem !important;
            padding-left: 1.5rem !important; border:0px" colspan="3"><span style="font-size:12px" ;><b>Estimated Price:</b>&nbsp; Rs '.$booking['total_trip_amount_with_gst'].' per km</span>
          </td>
        </tr>
        <tr scope="col" colspan="12">
          <td style="padding: 0px 1.5rem 6px; border:0px" colspan="3"><span style="font-size:12px" ;><b>No. of
            days:</b>&nbsp; '.$booking['total_driver_days'].'</span>
          </td>
          <td style="padding-right: 1.5rem !important;
            padding-left: 1.5rem !important;
            border-right: 1px solid rgb(236, 228, 228);
            border-bottom: none;" colspan="2"><span style="font-size:12px" ;><b>Pickup Address:</b> &nbsp; '.$booking['pickup_address'].'</span>
          </td>
          
          <td style=" padding: 0px 1.5rem 6px; border:0px" colspan="3"><span style="font-size:12px" ;><b>After '.(int)$booking['base_covered_km'].'
            km:</b>&nbsp;Rs '.(int)$booking['per_km_charge'].' per km</span>
          </td>
          <td style="padding: 0px 1.5rem 6px 0px; border:0px" colspan="3"><span style="font-size:12px" ;><b>Advance
            Amount:</b>&nbsp; Rs '.$booking['booking_amount'].'</span>
          </td>
        </tr>
        <tr scope="col" colspan="12">
          
          <td style="padding-right: 1.5rem !important;
            padding-left: 1.5rem !important;
          
            border-bottom: none;" colspan="3"><span style="font-size:12px" ;></span></td>
          <td style="padding-right: 1.5rem !important;
            padding-left: 1.5rem !important;
            border-right: 1px solid rgb(236, 228, 228);
            border-bottom: none;" colspan="2"><span style="font-size:12px" ;></span></td>
          <td style="padding: 0px 1.5rem 8px; border:0px" colspan="3"><span style="font-size:12px" ;><b>After '.(int)$booking['covered_hours'].'
            hrs:</b>&nbsp;Rs '.(int)$booking['per_hour_charge'].' per hour</span>
          </td>
          <td style="padding: 0px 1rem 8px 0px; border:0px;" colspan="3"><span style="font-size:12px" ;><b>Rest
            Amount:</b>&nbsp;Rs '.$booking['rest_amount'].'</span>
          </td>
        </tr>
        <tr scope="col" style="color: rgb(90, 154, 255);
          font-size: 18px;
          font-weight: 500;
          background: rgb(242, 247, 255);">
          <td colspan="12" style="padding: 10px 1.5rem;     font-size: 14px;">Duty Particulars (Km / Days)</td>
        </tr>
        <tr colspan="12" style="    background: #5a9aff;
          border-top-right-radius: 25px;
          border-top-left-radius: 25px;
          color: white;
          font-weight: 500;
          border: 1px solid rgb(230, 222, 222) !important;">
          <th scope="col" colspan="2" style="font-size: 14px;
            padding: 8px 1.5rem; color: white;">Start date & time</th>
          <th scope="col" colspan="2" style="font-size: 14px; color: white;">Opening kms</th>
          <th scope="col" colspan="2" style="font-size: 14px;color: white;">End date/time</th>
          <th scope="col" colspan="3" style="font-size: 14px;color: white;">Closing kms</th>
          <th scope="col" colspan="2" style="font-size: 14px;color: white;">Total kms</th>
          <th scope="col" colspan="3" style="font-size: 14px;color: white;">Extra hours</th>
        </tr>
        <tr colspan="12">
          <td scope="col" colspan="2"
            style="border-right:  1px solid rgb(230, 222, 222); text-align: center; padding: 8px 1.5rem;font-size: 11px;">
            
          </td>
          <td scope="col" colspan="2"
            style="border-right:  1px solid rgb(230, 222, 222); text-align: center;font-size: 11px; "></td>
          <td scope="col" colspan="2"
            style="border-right:  1px solid rgb(230, 222, 222); text-align: center;font-size: 11px;  ">
          </td>
          <td scope="col" colspan="3"
            style="border-right:  1px solid rgb(230, 222, 222); text-align: center;font-size: 11px; "></td>
          <td scope="col" colspan="2"
            style="border-right:  1px solid rgb(230, 222, 222); text-align: center;font-size: 11px; "></td>
          <td scope="col" colspan="3"
            style="border-right:  1px solid rgb(230, 222, 222); text-align: center;font-size: 11px; "></td>
        </tr>
        <tr>
          <td colspan="6" style="border-top:  1px solid rgb(230, 222, 222); padding: 2rem 1.5rem 1rem" ;>
            <span style="font-size:12px" ;>
              <h5 style="margin: 0px; margin: 0px;
                font-size: 14px;
                font-weight: 400;
                color: #2a2525;">Customer Signature</h5>
              <p style="font-size: 10px; margin: 0px;">After checking the opening KM</p>
            </span>
          </td>
          <td colspan="6" style="border-top:  1px solid rgb(230, 222, 222);  padding: 2rem 1.5rem 1rem" ;>
            <span style="text-align: end;">
              <h5 style=" margin: 0px;
                font-size: 14px;
                font-weight: 400;
                color: #2a2525;">Customer Signature</h5>
              <p style="font-size: 10px; margin: 0px;">After checking the closing KM</p>
            </span>
          </td>
        </tr>
      </tbody>
    </table>
  </body>
</html>'; 
return $html;
}