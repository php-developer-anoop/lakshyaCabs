<style>
    .modelPost{   z-index: 99999; }
    .modal-title{ color: #ffffff; margin-bottom: 1px;}
    /*.select2-container { z-index: 99999 !important;}*/
</style>
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
                   <nav class="bookingtabs" id="tabButtons">
                       <button class="bktab active" id="new" onclick="goToTab('new')" >New Booking</button>
                       <button class="bktab" id="pendingdriver" onclick="goToTab('pendingdriver')" >Driver Pending</button>
                       <button class="bktab" id="assigneddriver" onclick="goToTab('assigneddriver')" >Driver Assign</button>
                       <button class="bktab" id="inprogress" onclick="goToTab('inprogress')" >In progress</button>
                       <button class="bktab" id="completed" onclick="goToTab('completed')" >Completed</button>
                       <button class="bktab" id="totalbooking" onclick="goToTab('totalbooking')" >All</button>
                   </nav>
                   <div class="cstmselect">
                       <select class="form-select">
                           <option disabled selected>Custom</option>
                           <option>One</option>
                           <option>Two</option>
                       </select>
                   </div>
               </div>
               <div class="dflexbtwn mt-4">
                  <div class="bkdate_selct">
                      <div class="cstm_bookdate">
                          <i class="fa-regular fa-calendar"></i>
                          <input type="date" class="form-control" id="from_date" onChange="fillDateInto()" placeholder="From date - DD/MM/YYYY">
                      </div>
                      <div class="cstm_bookdate">
                          <i class="fa-regular fa-calendar"></i>
                          <input type="date" class="form-control" min="" id="to_date" placeholder="To date - DD/MM/YYYY">
                      </div>
                      <div class="bkselect"> 
                          <select name="" id="cityList" class="form-control select2" required >
                              <option value="">Select operation city</option>
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
                <table id="responseData" class="table bookingtable mb-0"></table> 
               </div>
               
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!--  open booking details modal box---->
<div class="modal fade modelPost" id="bookingDetails" tabindex="-1" aria-labelledby="exampleModalFullscreenLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen" style="transform: rotateY(45deg); color: #111111; font-weight: 500;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title h4" id="exampleModalFullscreenLabel">Booking Details for Query Number: <span id="bookingModelTitle"></span> </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="pageContent">
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

<input type="hidden" id="booking_table_id" value="">
 
<!--  Open Broadcast Booking modal box  ---->
<div class="modal fade modelPost" id="broadcastModelDetails" tabindex="-1" aria-labelledby="broadcastModelDetails" aria-hidden="true">
    <div class="modal-dialog" style="transform: rotateY(45deg); color: #111111; font-weight: 500;">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title h4" id="broadcastModelDetails">Booking Details for Query Number: <span id="broadcastTitle"></span> </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body"> 
        <div class="row">
            <div class="col-lg-12">
                <label for="partner_id">Choose Vendor:</label>
                <select id="partner_id" class="form-control" onChange="checkBtnValue();">
                    <option value="" selected >--Choose Vendor--</option>
                </select>
            </div>
            <div class="col-lg-12 mt-3">
                <label>Broadcast Vendor Amount:</label>
                <input id="broadcast_amount" class="form-control" value="0"> 
            </div>
            <div class="col-lg-12 mt-3">
                <label>Broadcast Rate Per/Km:</label>
                <input id="broadcast_rate_perkm" class="form-control" value="0" > 
            </div>
             
            
            <div class="col-lg-12 mt-3"> 
                <button id="broadcast_btn" class="btn btn-primary" onClick="broadcastBooking();" >Broadcast</button> 
            </div>
            
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
   

<input type="hidden" name="<?=csrf_token()?>" value="<?=csrf_hash()?>" />
 
 
<script>
function fillDateInto(){  
    var maxDateString = document.getElementById( 'from_date' ).value; 
    $("#to_date").attr("min", maxDateString );
    document.getElementById( 'to_date' ).value = document.getElementById( 'from_date' ).value;
}

function goToTab( type ){  
    var elements = document.getElementsByClassName("bktab"); 
    for (var i = 0; i < elements.length; i++) {
    elements[i].classList.remove("active");
    }
    document.getElementById( type ).classList.add('active'); 
    document.getElementById('booking_type').value = type; 
    setTimeout( function(){ getTotalRecordsData(); },50);
} 

//not working below function pending work
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

function getTotalRecordsData(){  
        $.ajax({
            url: '<?=$list_url;?>?'+makeQueryParam(),
            type: "POST",
            data: {'is_count':'yes','start':0,'length':10 },
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
            output += '<p class="bookingtag active">'+row.booking_status+'</p>';
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
            output += '<div class="actnswrapr" style="width:150px">';
            
            if( row.booking_status == 'new'){
            output += '<button class="btn actnbtn btn-blue" data-toggle="tooltip" data-placement="top" title="Approve Booking" onClick="approveRejectCancelBooking(`approved`,`'+row.id+'`)">';
            output += '<i class="fa-regular fa-circle-check"></i>';
            output += '</button>';
            }
            
            if( row.booking_status == 'approved' && row.broadcast_status == 'no' ){
            output += '<button class="btn actnbtn btn-blue" data-toggle="tooltip" data-placement="top" title="Broadcast Booking" onClick="broadcastBookingModel(`'+row.id+'`,`'+row.booking_id+'`,`'+row.pickup_city_id+'`,`'+row.partner_id+'`)">';
            output += '<i class="fa fa-wifi"></i>';
            output += '</button>';
            }
            
            if( row.booking_status == 'approved'){
            output += '<button class="btn actnbtn btn-voilet" data-toggle="tooltip" data-placement="top" title="'+(row.driver_mobile_no =='' ? 'Assign Driver' : 'Change Driver')+'" onClick="AssignDriver(`'+row.en_id+'`)">';
            output += '<i class="fa-solid fa-user-plus"></i>';
            output += '</button>';
            }
            
            if( ['new','approved'].includes(row.booking_status)){
            output += '<button class="btn actnbtn btn-magenta" data-toggle="tooltip" data-placement="top" title="Cancel Booking" onClick="approveRejectCancelBooking(`cancelled`,`'+row.id+'`)">';
            output += '<i class="fa-regular fa-circle-xmark"></i>';
            output += '</button>';
            }
            
            // output += '<button class="btn actnbtn btn-green" data-toggle="tooltip" data-placement="top" title="Tooltip on top" title="">';
            // output += '<i class="fa-solid fa-indian-rupee-sign"></i>';
            // output += '</button>';
            // output += '<button class="btn actnbtn btn-orange" data-toggle="tooltip" data-placement="top" title="Tooltip on top" title="">';
            // output += '<i class="fa-regular fa-edit"></i>';
            // output += '</button>';
            output += '<button class="btn actnbtn btn-lgreen" data-toggle="tooltip" data-placement="top" title="Tooltip on top" onclick="loadBookingDetails(`'+row.id+'`,`'+row.booking_id+'`)">';
            output += '<i class="fa-regular fa-eye"></i>';
            output += '</button>';
            output += '<button class="btn actnbtn btn-orange" data-toggle="tooltip" data-placement="top" title="Print Invoice Slip" onclick="return printInvoiceSlip(`'+row.booking_id+'`)">';
            output += '<i class="fa-solid fa-print"></i>';
            output += '</button>';
            output += '<button class="btn actnbtn btn-lgreen" data-toggle="tooltip" data-placement="top" title="Print Payment Slip" onclick="return printPaymentSlip(`'+row.booking_id+'`)">';
            output += '<i class="fa-solid fa-print"></i>';
            output += '</button>'; 
            output += '<button class="btn actnbtn btn-dblue" data-toggle="tooltip" data-placement="top" title="Tooltip on top" onclick="return printDutySlip(`'+row.booking_id+'`)">';
            output += '<i class="fa-solid fa-print"></i>';
            output += '</button>';
            
            if( ['new','approved'].includes(row.booking_status)){
            output += '<button class="btn actnbtn btn-red" data-toggle="tooltip" data-placement="top" title="Reject Booking" onClick="approveRejectCancelBooking(`rejected`,`'+row.id+'`)">';
            output += '<i class="fa-solid fa-ban"></i>';
            output += '</button>';
            }
            
            output += '</div>';
    }
    return output;
}

/************   Add Booking Activity Funtions ***************/
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

/************  Open Booking Details Popup ***************/
function loadBookingDetails( id, booking_id){ 
      
      $('#bookingDetails').modal('show');
      $('#bookingModelTitle').html( booking_id ); 
       
       $.ajax({
          type:'POST',
          url: '<?=base_url('admin/booking_details')?>',
          data: {'id': id },
          beforeSend: ()=>{  $('#pageContent').html( '<center><img src="http://lookbookcabs.com/img/loader.gif"></center>' );  },
          success: (res)=>{
            $('#pageContent').html( res ); 
          }
       });
      
}
    
  
/************   Broadcast Booking Model ***************/
function broadcastBookingModel( id, booking_id, pickup_city_id, partner_id ){
    $('#broadcastModelDetails').modal('show');
    $('#broadcastTitle').html( booking_id );
    $('#booking_table_id').val( id ); 
    
    $.ajax({
        url: '<?=base_url('admin/vendor-drop-down-list');?>',
        type: "POST",
        data: {'id': id,'pickup_city_id': pickup_city_id },
        cache: false,
        success:function(response) {
            $('#partner_id' ).html( response );  
            setTimeout( ()=>{ $('#partner_id').val( partner_id ).change(); },100);
        }
    }); 
} 

function checkBtnValue(){
    var vendor_id = $('#partner_id option:selected').val(); 
    if( vendor_id !== '' ){
        $('#broadcast_btn').html('Assign Vendor');
    }else{
         $('#broadcast_btn').html('Broadcast');
    }
}

function broadcastBooking(){
    var id = $('#booking_table_id').val();
    var broadcast_amount = $('#broadcast_amount').val();
    var broadcast_rate_perkm = $('#broadcast_rate_perkm').val();
    var partner_id = $('#partner_id option:selected').val();
     
    $.ajax({
        url: '<?=base_url('admin/broadcast-booking');?>',
        type: "POST",
        data: { id, partner_id,  broadcast_amount, broadcast_rate_perkm },
        cache: false,
        success:function(resp) {
            var obj = JSON.parse( resp );
            if( !obj.status ){
              alertMsg('error', obj.message );    
            }else{
              $('#id_'+id ).hide();
              $('#booking_table_id').val('');
              $('#broadcast_rate_perkm').val(0);
              $('#broadcast_amount').val(0);
              alertMsg('success', obj.message ); 
              $('#broadcastModelDetails').modal('hide');
              return;
            }
                
        }
    });
}


/************   Assign Driver  ***************/
function AssignDriver( id ){
    var urlJump = '<?=base_url('admin/assign-driver?id=')?>'+id;
    window.open( urlJump , "_blank");
}
 

</script>



