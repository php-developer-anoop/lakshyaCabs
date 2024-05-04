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
                   <nav class="botabs" id="tabButtons">
                       <button class="bktab" id="Pending" onclick="goToTab('Pending')" >Pending KYC</button>
                       <button class="bktab" id="Approved" onclick="goToTab('Approved')" >Approved KYC</button>
                       <button class="bktab" id="Rejected" onclick="goToTab('Rejected')" >Rejcted KYC</button>
                       <button class="bktab" id="Active" onclick="goToTab('Active')" >Active Profile</button>
                       <button class="bktab" id="Inactive" onclick="goToTab('Inactive')" >Inactive Profile</button>
                       <button class="bktab active" id="totaldriver" onclick="goToTab('totaldriver')" >All</button>
                   </nav> 
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
                          <select name="" id="city_id" class="form-control select2" required >
                            <option value="">Select operation city</option>
                            <?php if(!empty($city_list)){foreach($city_list as $slkey=>$slvalue){?>
                            <option value="<?=$slvalue['id']?>"><?=$slvalue['city_name'].', '.$slvalue['state_name']?></option>
                            <?php }} ?>
                          </select>
                      </div>
                  </div>
                  <div class="filtrbtn">
                      <button type="submit" onclick="getTotalRecordsData()">Search</button>
                  </div>
               </div>
               
               <div class="mt-4 table-responsive text-nowrap">
                <input type="hidden" value="all" id="status_type" />  
                <input type="hidden" value="0" id="totalRecords" /> 
                <table id="responseData" class="table bookingtable mb-0"></table> 
               </div>
               
          </div>
        </div>
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
    document.getElementById('status_type').value = type; 
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
    var status_type = document.getElementById( 'status_type' ).value;
    var from_date = document.getElementById( 'from_date' ).value; 
    var to_date = document.getElementById( 'to_date' ).value; 
    var city_id = document.getElementById( 'city_id' ).value; 
    params = 'total_records='+total_records+'&status_type='+status_type+'&from_date='+from_date+'&to_date='+to_date+'&city_id='+city_id;
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
    { data: "id", "title": "Profile","render": driverDetails }, 
    { data: "id", "title": "Login Details", "render": loginDetails },    
    { data: "id", "title": "Vendor Details", "render":vendorDetails },
    { data: "id", "title": "Add/Update Details", "render":addDetails },
    { data: "id", "title": "Profile/KYC Status", "render": getStatus  }, 
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
 

const driverDetails = (data, type, row, meta)=>{
    let output = '';
    if(type === 'display'){
            output += '<div class="cstmrdtl">';
            output += '<p class="uid text-red">UID:'+row.unique_code+'</p>';
            output += '<p>Name: '+row.full_name+'</p>';
            output += '<p class="text-purple">Mob: '+row.mobile_no+'</p>';
            output += '<p class="text-purple">Alt Mob: '+row.alt_mobile_no+'</p>';
            output += '<p class="text-blue">Email: '+row.email_id+'</p>'; 
            output += '</div>';
    }
    return output;
}

const loginDetails = (data, type, row, meta)=>{
    let output = '';
    if(type === 'display'){
            output += '<div class="cstmrdtl">';
            output += '<p class="uid text-red">LoginID:'+row.login_id+'</p>';
            output += '<p>Password: '+row.password+'</p>';
            output += '<p class="text-purple">OTP: '+row.otp+'</p>'; 
            output += '</div>';
    }
    return output;
}
  
const vendorDetails = (data, type, row, meta)=>{
    let output = '';
    if(type === 'display' ){
            output += '<div class="vndrdtl">';
            output += '<p>'+row.partner_business_name+'</p>'; 
            output += '</div>';
    }
    return output;
} 

const addDetails = (data, type, row, meta)=>{
    let output = '';
    if(type === 'display' ){
            output += '<div class="vndrdtl">';
            output += '<p>Add : '+row.add_date+'</p>'; 
            output += '<p>Update : '+row.updated_on+'</p>'; 
            output += '</div>';
    }
    return output;
}

const getStatus = (data, type, row, meta)=>{
    let output = '';
    if(type === 'display'){
            output += '<div class="status">';
            output += '<p class="bookingtag active">'+row.profile_status+'</p>'; 
            output += '<p class="bookingtag">KYC: '+row.kyc_status+'</p>'; 
            output += '</div>';
    }
    return output;
}

const actionRender = (data, type, row, meta)=>{
    let output = '';
    if(type === 'display'){
            output += '<div class="actnswrapr" style="width:150px">'; 
             
            output += '<button class="btn actnbtn btn-orange" onClick="jumpTo(`'+row.en_hash+'`)" data-toggle="tooltip" data-placement="top" title="Tooltip on top" title="">';
            output += '<i class="fa-regular fa-edit"></i>';
            output += '</button>'; 
           
            output += '<button class="btn actnbtn btn-red" data-toggle="tooltip" data-placement="top" title="Delete Account" onClick="deleteDriverAccount(`'+row.id+'`)">';
            output += '<i class="fa-solid fa-trash"></i>';
            output += '</button>';
             
            
            output += '</div>';
    }
    return output;
}


function jumpTo( id ){
    window.location.href='<?=base_url('admin/add-driver?id=')?>'+id;
}
/************   Delete Account Funtions ***************/
function deleteDriverAccount( id ){ 
        var type = 'Delete';
        var postUrl = '<?=base_url('admin/delete-driver-account');?>'; 
        
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


</script>