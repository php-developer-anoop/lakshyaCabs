<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb" class="d-flex flex-row justify-content-between ">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="javascript:void(0);">Home</a>
        </li>
        <li class="breadcrumb-item">
          <a href="javascript:void(0);"><?=$menu?></a>
        </li>
        <li class="breadcrumb-item active"><?=$title?></li>
      </ol>
    </nav>
    <div class="row">
      <div class="col-xxl">
        <div class="card mb-4">
          <div class="card-body">
            <div class="dflexbtwn">
              <nav class="bookingtabs">
               <button class="bktab active <?=!empty($booking_status) && ($booking_status == "new")?"active":""?>" id="new" onclick="goToTab('new','')" >New Booking</button>
                       <button class="bktab <?=!empty($booking_status) && ($booking_status == "pendingdriver")?"active":""?>" id="pendingdriver" onclick="goToTab('pendingdriver',<?=!empty($vendor_profile['id'])?$vendor_profile['id']:''?>)" >Driver Pending</button>
                       <button class="bktab <?=!empty($booking_status) && ($booking_status == "assigneddriver")?"active":""?>" id="assigneddriver" onclick="goToTab('assigneddriver',<?=!empty($vendor_profile['id'])?$vendor_profile['id']:''?>)" >Driver Assigned</button>
                       <button class="bktab <?=!empty($booking_status) && ($booking_status == "inprogress")?"active":""?>" id="inprogress" onclick="goToTab('inprogress',<?=!empty($vendor_profile['id'])?$vendor_profile['id']:''?>)" >In Progress</button>
                       <button class="bktab <?=!empty($booking_status) && ($booking_status == "completed")?"active":""?>" id="completed" onclick="goToTab('completed',<?=!empty($vendor_profile['id'])?$vendor_profile['id']:''?>)" >Completed</button>
                      
              </nav>
              <!--<div class="cstmselect">-->
              <!--  <select class="form-select">-->
              <!--    <option disabled selected>Custom</option>-->
              <!--    <option>One</option>-->
              <!--    <option>Two</option>-->
              <!--  </select>-->
              <!--</div>-->
            </div>
            <div class="dflexbtwn mt-4">
              <div class="bkdate_selct">
                <div class="cstm_bookdate">
                  <i class="fa-regular fa-calendar"></i>
                  <input type="date" class="form-control" id="from_date" onChange="fillDateInto()" placeholder="From date - DD/MM/YYYY">
                </div>
                <div class="cstm_bookdate">
                  <i class="fa-regular fa-calendar"></i>
                  <input type="date" class="form-control" id="to_date" placeholder="To date - DD/MM/YYYY">
                </div>
                <div class="bkselect">
                  <select name="city" id="cityList" class="form-control select2" required>
                    <option value="">Select Operation City</option>
                    <?php if(!empty($city_list)){foreach($city_list as $clkey=>$clvalue){?>
                    <option value="<?=$clvalue['id']?>"><?=$clvalue['city_name'].' , '.$clvalue['state_name']?></option>
                    <?php }} ?>
                  </select>
                </div>
              </div>
              <div class="filtrbtn">
                <button type="submit" onclick="getTotalRecordsData()">Search</button>
              </div>
            </div>
            <div class="mt-4 table-responsive text-nowrap">
                <input type="hidden" value="new" id="booking_type" /> 
                <input type="hidden" value="" id="city_id" />
                <input type="hidden" value="0" id="totalRecords" /> 
              <table id="responseData" class="table bookingtable mb-0">
                
              </table>
            </div>
          </div>
        </div>
      </div> 
    </div>
  </div>
</div>
<script>
<?php if(!empty($booking_status)){?>
    goToTab('<?=$booking_status?>',<?=!empty($vendor_profile['id'])?$vendor_profile['id']:''?>);
<?php }?>
function goToTab( type,vendor_id ){  
    var elements = document.getElementsByClassName("bktab"); 
    for (var i = 0; i < elements.length; i++) {
    elements[i].classList.remove("active");
    }
    document.getElementById( type ).classList.add('active'); 
    document.getElementById('booking_type').value = type; 
    setTimeout( function(){ getTotalRecordsData(vendor_id); },50);
} 
function fillDateInto(){  
    var maxDateString = document.getElementById( 'from_date' ).value; 
    $("#to_date").attr("min", maxDateString );
    document.getElementById( 'to_date' ).value = document.getElementById( 'from_date' ).value;
}
    function makeQueryParam(){
    var params = '';  
    var total_records = document.getElementById( 'totalRecords' ).value;
    var booking_status = document.getElementById( 'booking_type' ).value;
    var from_date = document.getElementById( 'from_date' ).value; 
    var to_date = document.getElementById( 'to_date' ).value; 
    var city_id = document.getElementById( 'city_id' ).value; 
    params = 'total_records='+total_records+'&booking_status='+booking_status+'&from_date='+from_date+'&to_date='+to_date+'&city_id='+city_id;
    return params
}

function getTotalRecordsData(vendor_id){   
        $.ajax({
        url: '<?=$list_url;?>?'+makeQueryParam(),
        type: "POST",
        data: {'is_count':'yes','start':0,'length':10,'vendor_id':vendor_id },
              cache: false,
              success:function(response) {   
                $('#totalRecords' ).val( response );
                if( response ){ 
                  loadAllRecordsData();
                }
              }
            }); 
          }  

$(document).ready(function() { 
        //let qParam = (new URL(location)).searchParams;
        getTotalRecordsData();
    });

function loadAllRecordsData(){
    $('#responseData').html(''); 
    $('#responseData').DataTable({
        "processing" : true,
        "serverSide": true,
        "ajax" : {
            "url" : '<?=$list_url;?>?'+makeQueryParam(),
            "type":'POST',  
            dataSrc : (res)=>{ 
            return res.data
            }
        },
        "columns" : [ 
    { data: "id", "title": "Sr No", "render": srNo  },
    { data: "id", "title": "Booking ID", "render": bookingID }, 
    { data: "id", "title": "Customer","render": customerDetails }, 
    { data: "id", "title": "Trip Details", "render": tripDetails }, 
    { data: "id", "title": "Driver Details", "render": driverDetails },   
    { data: "id", "title": "Vendor Details", "render":vendorDetails },
    { data: "id", "title": "Status", "render": getStatus  }, 
    { data: "id", "name": "Action", "title": "Action", "render": actionRender },],
    //"rowReorder": { selector: 'td:nth-child(2)' },
    "responsive": false, 
    "destroy": true,
    "searchDelay": 1000,
    "searching": true, 
    "pagingType": 'simple_numbers',
    "rowId": (a)=>{ return 'id_' + a.id; }, 
    "iDisplayLength": 10,
    "order": [ 4, "asc"], 
}); 
} 

const srNo = (data, type, row, meta)=>{
    let output = '';
    if(type === 'display'){
            output = row.sr_no;
    }
    return output;
}

const bookingID = (data, type, row, meta)=>{
    let output = '';
    if(type === 'display'){
            output += '<div class="bkid">';
            output += '<p>'+row.booking_id+'</p>';
            output += '<p class="triptype text-purple">'+row.trip_type+'<br/>('+row.trip_mode+')</p>';
            output += '</div>';
    }
    return output;
}

const customerDetails = (data, type, row, meta)=>{
    let output = '';
    if(type === 'display'){
            output += '<div class="cstmrdtl">';
            output += '<p class="uid text-red">UID:'+row.guest_uid+'</p>';
            output += '<p>Name: '+row.guest_name+'</p>';
            output += '<p class="text-purple">Mob: '+row.guest_mobile_no+'</p>';
            output += '<p class="text-blue">Email: '+row.guest_email_id+'</p>';
            output += '<p>GSTNo. : '+(row.guest_gstin ? row.guest_gstin : '-')+'</p>';
            output += '</div>';
    }
    return output;
}

const tripDetails = (data, type, row, meta)=>{
    let output = '';
    if(type === 'display'){
            output += '<div class="trpdtl">';
            output += '<p>Pick up: '+row.pickup_city_name+'</p>';
            if( row.pickup_city_name == 'Local'){
                 output += '<p>Package: '+row.package_name+'</p>';
            }else{
                 output += '<p>Drop: '+row.drop_city_name+'</p>';
            }
           
            output += '<p>Pickup Date: '+row.pickup_date_time+'</p>';
            output += '</div>';
    }
    return output;
}
   
const driverDetails = (data, type, row, meta)=>{
    let output = '';
    if(type === 'display'){
            output += '<div class="drivrdtl">';
            output += '<p>'+row.driver_name+'</p>';
            output += '<p>+91-'+row.driver_mobile_no+'</p>';
            output += '<p>'+row.vehicle_no+'</p>';
            output += '<p>Vehicle type: '+row.category_name+'</p>';
            output += '<p>Model: '+row.model_name+'</p>';
            output += '</div>';
    }
    return output;
} 

const vendorDetails = (data, type, row, meta)=>{
    let output = '';
    if(type === 'display' ){
            output += '<div class="vndrdtl">';
            output += '<p>'+row.partner_name+'</p>';
            output += '<p>+91-'+row.partner_mobile_no+'</p>';
            output += '</div>';
    }
    return output;
} 

const getStatus = (data, type, row, meta)=>{
    let output = '';
    if(type === 'display'){
            output += '<div class="status">';
            output += '<p class="bookingtag active">'+capitalizeFirstLetters(row.booking_status)+'</p>';
            if( ['new','approved','completed'].includes(row.pickup_city_name) ){
            output += '<p>'+(row.driver_mobile_no !=='' ? 'Driver Assigned' : 'Pending')+'</p>';
            }
            output += '</div>';
    }
    return output;
}

const actionRender = (data, type, row, meta)=>{
    let output = '';
    if(type === 'display'){
        var driver_status_title= row.driver_mobile_no == "" ?"Assign Driver":"Change Driver"; 
        
            output += '<div class="actnswrapr" style="width:150px">';
            if( row.booking_status == 'approved' && row.partner_mobile_no == ""){
            output += '<button class="btn actnbtn btn-blue" data-toggle="tooltip" data-placement="top" title="Accept Booking" id="acceptBooking_'+row.id+'" onClick="acceptBooking('+row.id+')">';
            output += '<i class="fa-regular fa-circle-check"></i>';
            output += '</button>';
            }
            
            if (row.booking_status == 'approved') {
                output += '<a class="btn actnbtn btn-voilet" data-toggle="tooltip" data-placement="top" title="'+driver_status_title+'" href="<?=base_url(VENDORPATH.'assign-driver?booking_id=')?>' + row.id + '">';
                output += '<i class="fa-solid fa-user-plus"></i>';
                output += '</a>';
            }

            
            if( ['new','approved'].includes(row.booking_status)){
            output += '<button class="btn actnbtn btn-magenta" data-toggle="tooltip" data-placement="top" title="Cancel Booking" onClick="approveRejectCancelBooking(`cancelled`,`'+row.id+'`)">';
            output += '<i class="fa-regular fa-circle-xmark"></i>';
            output += '</button>';
            output += '<button class="btn actnbtn btn-red" data-toggle="tooltip" data-placement="top" title="Reject Booking" onClick="approveRejectCancelBooking(`rejected`,`'+row.id+'`)">';
            output += '<i class="fa-solid fa-ban"></i>';
            output += '</button>';
            }
            
            // output += '<button class="btn actnbtn btn-green" data-toggle="tooltip" data-placement="top" title="Tooltip on top" title="">';
            // output += '<i class="fa-solid fa-indian-rupee-sign"></i>';
            // output += '</button>';
            // output += '<button class="btn actnbtn btn-orange" data-toggle="tooltip" data-placement="top" title="Tooltip on top" title="">';
            // output += '<i class="fa-regular fa-edit"></i>';
            // output += '</button>';
            // output += '<button class="btn actnbtn btn-lgreen" data-toggle="tooltip" data-placement="top" title="Tooltip on top" onclick="loadBookingDetails(`'+row.id+'`,`'+row.booking_id+'`)">';
            // output += '<i class="fa-regular fa-eye"></i>';
            // output += '</button>';
            output += '<button class="btn actnbtn btn-orange" data-toggle="tooltip" data-placement="top" title="Print Invoice Slip" onclick="return printInvoiceSlip(`'+row.booking_id+'`)">';
            output += '<i class="fa-solid fa-print"></i>';
            output += '</button>';
            output += '<button class="btn actnbtn btn-lgreen" data-toggle="tooltip" data-placement="top" title="Print Payment Slip" onclick="return printPaymentSlip(`'+row.booking_id+'`)">';
            output += '<i class="fa-solid fa-print"></i>';
            output += '</button>'; 
            output += '<button class="btn actnbtn btn-dblue" data-toggle="tooltip" data-placement="top" title="Print Duty Slip" onclick="return printDutySlip(`'+row.booking_id+'`)">';
            output += '<i class="fa-solid fa-print"></i>';
            output += '</button>';
            
            // if( ['completed'].includes(row.booking_status)){
            
            // }
            
            output += '</div>';
    }
    return output;
}

function acceptBooking(booking_id){
    $.ajax({
       type: 'POST',
       url: '<?=base_url(VENDORPATH.'acceptBooking')?>',
       data: {
         booking_id: booking_id,
       },
       dataType: 'json',
       
       success: (res) => {
         if (res.status == true) {
            toastr.success(res.message);
            $('#acceptBooking_'+booking_id).prop('disabled',true);
         } else {
           toastr.error(res.message);
         }
       }
     });
}

function printDutySlip(booking_id){
    window.location.href = '<?= base_url(VENDORPATH . 'printDutySlip?booking_id=') ?>' + booking_id;
}

function printPaymentSlip(booking_id){
    window.location.href = '<?= base_url(VENDORPATH . 'printPaymentSlip?booking_id=') ?>' + booking_id;
}
function printInvoiceSlip(booking_id){
    window.location.href = '<?= base_url(VENDORPATH . 'printInvoiceSlip?booking_id=') ?>' + booking_id;
}

function approveRejectCancelBooking( type , id ){ 
    
        var postUrl = '<?=base_url('admin/approve_reject_cancel_booking');?>'; 
        
        Swal.fire({
        title: "Are you sure?",
        text: "It will "+type+" the Item!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, "+type+" it!",
        }).then((result) => {
           if (result.isConfirmed) {
               
                $.ajax({
                    url: postUrl,
                    type: "POST",
                    data: {'id': id, 'type': type },
                    cache: false,
                    success:function(response) {   
                        var obj = JSON.parse( response );
                        if( obj.status ){ 
                            $('#id_'+id ).hide();
                            alertMsg('success', obj.message );
                        }else{
                            alertMsg('error', obj.message ); 
                        }
                    }
                });  
           }
        });
}

function getCityList(){ 
    var inputText = document.getElementById("cityList").value;
    $.ajax({
        url: 'get_search_city_list',
        method: 'GET',
        data: {search: inputText},
        success: function(response) {
            var select = document.getElementById("cityList");
            select.innerHTML = ""; // Clear existing options
            var defaultOption = document.createElement("option");
            defaultOption.text = "Select operation city";
            defaultOption.value = "";
            select.appendChild(defaultOption);
            response.forEach(function(city) {
                var option = document.createElement("option");
                option.text = city.name;  
                option.value = city.id;  
                select.appendChild(option);
            });
        },
        error: function(xhr, status, error) {
            console.error("Error fetching city list:", error);
        }
    });
}
</script>