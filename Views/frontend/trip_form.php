<div class="col-sm-5 order-mbl-1 pos-relative p-0">
  <div class="side_booking">
    <div class="searchsoftware os-animation" data-os-animation="fadeInUp" data-os-animation-delay="0.5s">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="Outstation-tab" data-bs-toggle="tab" data-bs-target="#Outstation-tab-pane" type="button" role="tab" aria-controls="Outstation-tab-pane" aria-selected="true">Outstation </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#City-tab-pane" type="button" role="tab" aria-controls="City-tab-pane" aria-selected="false">City Taxi</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="book-tour" data-bs-toggle="tab" data-bs-target="#Book-tab-pane" type="button" role="tab" aria-controls="Book-tab-pane" aria-selected="false">Book Tour</button>
        </li>
      </ul>
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="Outstation-tab-pane" role="tabpanel" aria-labelledby="Outstation-tab" tabindex="0">
          <ul class="nav nav-tabs" id="innrtabs" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#round-tab-pane" type="button" role="tab" aria-controls="round-tab-pane" aria-selected="false">Round Trip</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#oneway-tab-pane" type="button" role="tab" aria-controls="oneway-tab-pane" aria-selected="true">One Way</button>
            </li>
          </ul>
          
          
          <div class="tab-content" id="innrtab_content">
            <div class="tab-pane fade show active" id="round-tab-pane" role="tabpanel" aria-labelledby="round-tab" tabindex="0">
              <div class="formcontainer">
                <form action="<?=base_url('cab-list')?>" method="get">
                  <input type="hidden" name="trip_type" value="Outstation">
                  <input type="hidden" name="trip_mode" value="roundtrip">
                  <div class="row">
                    <div class="fieldwrap col-sm-12 mb-3">
                      <input type="text" class="form-control" autocomplete="off" required onkeyup="return getAddress(this.value,'outstation_roundtrip_pickup')" name="pickup" id="outstation_roundtrip_pickup" placeholder="Pick Up Location">
                      <img src="<?=base_url('assets/frontend/')?>images/fi1.png">
                      <ul class="append_searches" id="append_outstation_roundtrip_pickup"></ul>
                    </div>
                    <div class="fieldwrap col-sm-12 mb-3">
                      <input type="text" class="form-control" autocomplete="off" required onkeyup="return getAddress(this.value,'outstation_roundtrip_drop')" name="drop" id="outstation_roundtrip_drop"  placeholder="Drop Location">
                      <img src="<?=base_url('assets/frontend/')?>images/fi1.png">
                      <div class="extra-fieldss">
                        <a class="extra-fields-city heading-add" href="#" id="airids" style="color:blue;">  
                        <span class="material-icons f-16">add</span> 
                        </a>
                      </div>
                      <ul class="append_searches" id="append_outstation_roundtrip_drop"></ul>
                    </div>
                    <div class="col-sm-12">
                      <div class="city_records_dynamic"> </div>
                    </div>
                    <div class="fieldwrap col-sm-4 mb-3">
                      <input type="text" class="form-control datepicker" autocomplete="off" required name="pickup_date" id="roundtrip_pickup_date" placeholder="Select Date">
                      <img src="<?=base_url('assets/frontend/')?>images/fi2.png">
                    </div>
                    <div class="fieldwrap col-sm-4 mb-3">
                      <input type="text" class="form-control timepicker" autocomplete="off" required name="pickup_time" id="roundtrip_pickup_time" placeholder="Select Time">
                      <img src="<?=base_url('assets/frontend/')?>images/fi3.png">
                    </div>
                    <div class="fieldwrap col-sm-4 mb-3">
                      <input type="text" class="form-control datepicker" autocomplete="off" required id="outstation_roundtrip_return_pickup_date" name="return_date" placeholder="Return Date">
                      <img src="<?=base_url('assets/frontend/')?>images/fi2.png">
                    </div>
                    <div class="fieldwrap col-sm-12 mb-3">
                      <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">+91</span>
                        <input type="text" required class="form-control notzero numbersWithZeroOnlyInput" autocomplete="off" name="phone_no" maxlength="10" placeholder="Enter Mobile number" aria-label="Username" aria-describedby="basic-addon1">
                        <img src="<?=base_url('assets/frontend/')?>images/ci2.png">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 formbtnrow">
                      <button type="submit" class="form_btn">Search Cabs</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            
            
            <div class="tab-pane fade" id="oneway-tab-pane" role="tabpanel" aria-labelledby="oneway-tab" tabindex="0">
              <div class="formcontainer">
                <form action="<?=base_url('cab-list')?>" method="get">
                  <input type="hidden" name="trip_type" value="Oneway">
                  <input type="hidden" name="trip_mode" value="Oneway">
                  <div class="row">
                    <div class="fieldwrap col-sm-12 mb-3">
                      <input type="text" class="form-control" autocomplete="off" required onkeyup="return getAddress(this.value,'outstation_oneway_pickup')" name="pickup" id="outstation_oneway_pickup" placeholder="Pick Up Location">
                      <img src="<?=base_url('assets/frontend/')?>images/fi1.png">
                      <ul class="append_searches" id="append_outstation_oneway_pickup"></ul>
                    </div>
                    <div class="fieldwrap col-sm-12 mb-3">
                      <input type="text" class="form-control" autocomplete="off" required onkeyup="return getAddress(this.value,'outstation_oneway_drop')" name="drop" id="outstation_oneway_drop" placeholder="Drop Location">
                      <img src="<?=base_url('assets/frontend/')?>images/fi1.png">
                      <ul class="append_searches" id="append_outstation_oneway_drop"></ul>
                    </div>
                    <div class="fieldwrap col-sm-6 mb-3">
                      <input type="text" class="form-control datepicker" autocomplete="off" required id="pickup_date" name="pickup_date" placeholder="Select Date">
                      <img src="<?=base_url('assets/frontend/')?>images/fi2.png">
                    </div>
                    <div class="fieldwrap col-sm-6 mb-3">
                      <input type="text" class="form-control timepicker" autocomplete="off" required id="drop_date" name="drop_date" placeholder="Select Time">
                      <img src="<?=base_url('assets/frontend/')?>images/fi3.png">
                    </div>
                    <div class="fieldwrap col-sm-12 mb-3">
                      <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">+91</span>
                        <input type="text" class="form-control notzero numbersWithZeroOnlyInput" autocomplete="off" required name="phone" maxlength="10" placeholder="Enter Mobile number" aria-label="Username" aria-describedby="basic-addon1">
                        <img src="<?=base_url('assets/frontend/')?>images/ci2.png">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 formbtnrow">
                      <button type="submit" class="form_btn">Search Cabs</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        
        
        <div class="tab-pane fade" id="City-tab-pane" role="tabpanel" aria-labelledby="City-tab" tabindex="0">
          <ul class="nav nav-tabs" id="innrtabs" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#local-tab-pane1" type="button" role="tab" aria-controls="local-tab-pane1" aria-selected="true">Local</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="profile-tab1" data-bs-toggle="tab" data-bs-target="#airport-tab-pane1" type="button" role="tab" aria-controls="airport-tab-pane1" aria-selected="false">Airport</button>
            </li>
          </ul>
          
          
          <div class="tab-content" id="innrtab_content">
            <div class="tab-pane fade show active" id="local-tab-pane1" role="tabpanel" aria-labelledby="local-tab1" tabindex="0">
              <div class="formcontainer">
                <form action="<?=base_url('cab-list')?>" method="get">
                  <input type="hidden" name="trip_type" value="Local">
                  <input type="hidden" name="trip_mode" value="Local" id="local_trip_mode">
                  <input type="hidden" name="drop" value="">
                  <div class="row">
                    <div class="fieldwrap col-sm-12 mb-3">
                      <input type="text" class="form-control" autocomplete="off" required onkeyup="return getAddress(this.value,'city_taxi_local_pickup')" id="city_taxi_local_pickup" name="pickup" placeholder="Pick Up Location">
                      <img src="<?=base_url('assets/frontend/')?>images/fi1.png">
                      <ul class="append_searches" id="append_city_taxi_local_pickup"></ul>
                    </div>
                    <div class="fieldwrap col-sm-12 mb-3">
                      <select class="form-select select2" aria-label="Default select example" required name="package_id" id="local_package_list" onchange="getPackageName();" >
                        <option value="">Select Package</option> 
                      </select>
                    </div>
                    <div class="fieldwrap col-sm-6 mb-3">
                      <input type="text" class="form-control datepicker" autocomplete="off" required id="" name="pickup_date"  placeholder="Select Date">
                      <img src="<?=base_url('assets/frontend/')?>images/fi2.png">
                    </div>
                    <div class="fieldwrap col-sm-6 mb-3">
                      <input type="text" class="form-control timepicker" autocomplete="off" required id="" name="pickup_time"  placeholder="Select Time">
                      <img src="<?=base_url('assets/frontend/')?>images/fi3.png">
                    </div>
                    <div class="fieldwrap col-sm-12 mb-3">
                      <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">+91</span>
                        <input type="text" class="form-control notzero numbersWithZeroOnlyInput" autocomplete="off" required placeholder="Enter Mobile number" name="phone" maxlength="10"  aria-label="Username" aria-describedby="basic-addon1">
                        <img src="<?=base_url('assets/frontend/')?>images/ci2.png">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 formbtnrow">
                      <button type="submit" class="form_btn">Search Cabs</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            
            
            <div class="tab-pane fade" id="airport-tab-pane1" role="tabpanel" aria-labelledby="airport-tab1" tabindex="0">
              <div class="formcontainer">
                <form action="<?=base_url('cab-list')?>" method="get">
                  <input type="hidden" name="trip_type" value="Airport"> 
                  <div class="row"> 
                  
                  
                  <div class="fieldwrap col-sm-12 mb-3">
                      <select class="form-select select2" aria-label="Default select example" required name="trip_mode" onchange="changeAirportPlaceHolder( this.value)">
                        <option value="">Select Pickup or Drop</option>
                        <option value="Pickup">Pickup</option>
                        <option value="Drop">Drop</option>
                      </select>
                    </div>
                    
                    <div class="fieldwrap col-sm-12 mb-3">
                      <input type="text" class="form-control" autocomplete="off" required onkeyup="return getAddress(this.value,'city_taxi_airport_pickup_name')" id="city_taxi_airport_pickup_name" name="pickup" placeholder="Enter Pickup Airport Name">
                      <img src="<?=base_url('assets/frontend/')?>images/fi1.png">
                      <ul class="append_searches" id="append_city_taxi_airport_pickup_name"></ul>
                    </div>
                    
                    
                    <div class="fieldwrap col-sm-12 mb-3">
                      <input type="text" class="form-control" autocomplete="off" required onkeyup="return getAddress(this.value,'city_taxi_airport_name')" id="city_taxi_airport_name" name="drop" placeholder="Enter Drop Location">
                      <img src="<?=base_url('assets/frontend/')?>images/fi1.png">
                      <ul class="append_searches" id="append_city_taxi_airport_name"></ul>
                    </div>
                    
                    
                    <div class="fieldwrap col-sm-6 mb-3">
                      <input type="text" class="form-control datepicker" autocomplete="off" required id="" name="pickup_date"  placeholder="Select Date">
                      <img src="<?=base_url('assets/frontend/')?>images/fi2.png">
                    </div>
                    <div class="fieldwrap col-sm-6 mb-3">
                      <input type="text" class="form-control timepicker" autocomplete="off" required id="" name="pickup_time"  placeholder="Select Time">
                      <img src="<?=base_url('assets/frontend/')?>images/fi3.png">
                    </div>
                    
                    
                    <div class="fieldwrap col-sm-12 mb-3">
                      <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">+91</span>
                        <input type="text" class="form-control notzero numbersWithZeroOnlyInput" autocomplete="off" required placeholder="Enter Mobile number" name="phone" maxlength="10" aria-label="Username" aria-describedby="basic-addon1">
                        <img src="<?=base_url('assets/frontend/')?>images/ci2.png">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 formbtnrow">
                      <button type="submit" class="form_btn">Search Cabs</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        
        
        <div class="tab-pane fade" id="Book-tab-pane" role="tabpanel" aria-labelledby="Book-tab" tabindex="0">
          <div class="tab-content" id="innrtab_content">
            <div class="tab-pane fade show active" id="oneway-tab-pane1" role="tabpanel" aria-labelledby="oneway-tab1" tabindex="0">
              <div class="formcontainer">
                <form>
                  <?php $captua_token = random_alphanumeric_string(6); ?>
                  <input type="hidden" id="csrf" class="csrf" name="csrf_token" value="<?= $captua_token ?>">
                  <div class="row">
                    <div class="fieldwrap col-sm-12 mb-3">
                      <input type="text" class="form-control" required name="destination_name" autocomplete="off" id="destination_name"  onkeyup="getDestination(this.value)" placeholder="Pick Up Location">
                      <input type="hidden" name="destination_id" id="destination_id" value="">
                      <ul class="from-autocomplete-list list-unstyled list-color" id="from-suggestion-list" onclick="return selectDestination()"></ul>
                      <img src="<?=base_url('assets/frontend/')?>images/fi1.png">
                    </div>
                    <div class="fieldwrap col-sm-12 mb-3">
                      <select class="form-select" aria-label="Default select example" required id="appendpacks">
                        <option value="">Select Package</option>
                      </select>
                    </div>
                    <div class="fieldwrap col-sm-6 mb-3">
                      <input type="text" class="form-control datepicker" required id="tour_date" autocomplete="off" placeholder="Select Date">
                      <img src="<?=base_url('assets/frontend/')?>images/fi2.png">
                    </div>
                    <div class="fieldwrap col-sm-6 mb-3">
                      <input type="text" class="form-control timepicker" required id="tour_time" autocomplete="off" placeholder="Select Time">
                      <img src="<?=base_url('assets/frontend/')?>images/fi3.png">
                    </div>
                    <div class="fieldwrap col-sm-12 mb-3">
                      <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">+91</span>
                        <input type="text" required class="form-control notzero numbersWithZeroOnlyInput" autocomplete="off" id="phone" maxlength="10"  placeholder="Enter Mobile number" aria-label="Username" aria-describedby="basic-addon1">
                        <img src="<?=base_url('assets/frontend/')?>images/ci2.png">
                      </div>
                    </div>
                  </div>
                  <div class="row py-2 px-4 d-none">
                    <div class="bgreprat col-lg-5 col-11">
                      <?= $captua_token; ?>
                    </div>
                    <div class="col-lg-2 col-1 py-2 py-lg-1 ps-0 ps-lg-1">
                      <span class="bgreprat-refesh ps-0" style="cursor:pointer;" onclick="getRandomCaptcha()"><img
                        src="<?= base_url('assets') ?>/refresh.png"></span>
                    </div>
                    <div class="col-lg-5 ps-0 ps-lg-1">
                      <div class="form-group">
                        <input type="text" name="match_captcha" required maxlength="6" class="form-control" id="match_captcha"
                          autocomplete="off" placeholder="Enter Captcha" />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 formbtnrow">
                      <button type="button" class="form_btn" id="submit" onclick="return validateTourForm()">
                        Submit 
                        <div class="spinner-border spinner-border-sm text-white" id="loader" role="status">
                          <span class="visually-hidden">Loading...</span>
                        </div>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(".from-autocomplete-list").hide();
    function getDestination(val){
      //  alert(val);
        $('.from-autocomplete-list').show();
  $('.from-autocomplete-list').html('');
  if (val !== "" && val.length > 2) {
       $.ajax({
      url: '<?= base_url('getDestination') ?>',
      type: "POST",
      data: { 'val': val},
      cache: false,
      dataType:"html",
      success: function (response) {
        $(".from-autocomplete-list").show();
        if (response.length < 20) {
          toastr.error(response);
          return false;
        } else if (response.length > 20) {
          $('.from-autocomplete-list').html(response);
        }
      }
    }); 
  }
}

function changeAirportPlaceHolder( type ){
    if( type == 'Pickup' || type == '' ){
        $('#city_taxi_airport_pickup_name').attr("placeholder", "Enter Pickup Airport Name");
        $('#city_taxi_airport_name').attr("placeholder", "Enter Drop Location");
    }
    else if( type == 'Drop' ){
         $('#city_taxi_airport_pickup_name').attr("placeholder", "Enter Pickup Location");
         $('#city_taxi_airport_name').attr("placeholder", "Enter Drop Airport Name");
    }
}
    
 function selectDestination() {
  var selectedItem = $(event.target);
  var itemValue = selectedItem.text();
  var itemId = selectedItem.val();
  
  var stateId = selectedItem.attr('data-stateid');

  if (itemValue !== "" && itemId !== "") {
    $('#destination_name').val(itemValue);
    $('#destination_id').val(itemId);
    // $('#drop_state_id').val(stateId);
    getPackages(itemId);
    $('.from-autocomplete-list').hide();
  }
}

$(".from-suggestion-list").on("click", "li", selectDestination);


function getPackages(destination_id){
  $('#appendpacks').html('');
  $.ajax({
      url: '<?= base_url('getPackages') ?>',
      type: "POST",
      data: { 'destination_id': destination_id},
      cache: false,
      dataType:"html",
      success: function (response) {
        //alert(response);
        $('#appendpacks').html(response);
      }
    });
}

function getPackageName(){ 
    $('#local_trip_mode').val( $('#local_package_list option:selected').text() );
}

$('#loader').hide();
    function validateTourForm() {
   var pickup_location = $('#destination_name').val();
   var phone =$('#phone').val();
   var csrf= $('#csrf').val();
   var package = $('#appendpacks').val();
  //  alert(package);
   var date = $('#tour_date').val();
   var time = $('#tour_time').val();
   var match_captcha= $('#match_captcha').val();
   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
   if (pickup_location=="") {
     toastr.error("Please Enter Pickup Location");
     return false;
   } else if (package == "") {
     toastr.error("Please Select Package");
     return false;
   }  else if (date == "") {
     toastr.error("Please Select Date");
     return false;
   } else if (time == "") {
     toastr.error("Please Select Time");
     return false;
   } else if (phone == "") {
     toastr.error("Please Enter Phone");
     return false;
   } else if (phone.length < 10) {
     toastr.error("Please Enter A Valid Phone Number");
     return false;
   } else if (match_captcha == "") {
     toastr.error("Please Enter Captcha");
     return false;
   } else if (match_captcha !== csrf) {
     toastr.error("Captcha Not Match");
     return false;
   } else {
     
         $.ajax({
           url: '<?= base_url('save-pack-form') ?>',
           type: 'POST',
           data: {
             'package': package,
             'pickup_location': pickup_location,
             'phone': phone,
             'match_captcha':match_captcha,
             'csrf':csrf,
             'date':date,
             'time':time,
           },
           cache: false,
           dataType: "json",
           beforeSend: function () {
        $('#submit').prop('disabled', true);
        $('#loader').show();
        toastr.warning('Please wait! The form is being submitted.');
    },
           success: function(response) {
             if (response.status === false) {
               toastr.error(response.message);
             } else if (response.status === true) {
               $('#submit').prop('disabled',true);
               toastr.success(response.message);
               setTimeout(function() {
              window.location.reload();
              }, 500);

             }
           },
           error: function() {
             console.log('Error occurred during AJAX request');
           }
         });
   }
 }
 
function getAddress(val, selector_id) {
    $('#append_'+selector_id).html(''); 
     
    if (val.trim() !== "") {
        $('#append_searches').html('');
        $.ajax({
            url: '<?= base_url('get-address') ?>',
            type: 'POST',
            data: {
                'address': val,
                'selector_id': selector_id,
            },
            cache: false,
            dataType: 'html',
            success: function(response) {
                
                if (response === "") {
                    //$('#append_'+selector_id).html(''); 
                    initAutocomplete(selector_id); 
                } else {
                    $('#append_' + selector_id).html(response);
                    $('#' + selector_id).removeClass('pac-target-input');
                }
            },
            error: function() {
                console.log('Error occurred during AJAX request');
            }
        });
    }
}


function getVal(val,selector){
    $('#'+selector).val(val);
    $('#append_'+selector).html('');
    if(['city_taxi_local_pickup'].includes(selector)){
        setTimeout( function(){ getLocalPackage( val ); }, 200 ); 
    } 
}

function getLocalPackage( cityName ){  
        //alert( cityName ); 
        $.ajax({
        url: '<?=base_url('get-local-package')?>',
        type: 'POST',
        data: { city_name: cityName }, 
        success: function(response) {
            $('#local_package_list').html( response);
            $('#local_package_list').select2();
        }
    });
}



function initAutocomplete(selector_id) {
    var input = document.getElementById(selector_id);
    var autocomplete = new google.maps.places.Autocomplete(input, {
        types: ['geocode'],
        componentRestrictions: { country: 'IN' },
        strictBounds: true
    });

    autocomplete.addListener('place_changed', function() {
        var place = autocomplete.getPlace();
        
        if (place.geometry) {
            var lat = place.geometry.location.lat(), lng = place.geometry.location.lng();
            saveAddressToDatabase(place.formatted_address, lat, lng, selector_id ); 
        } else {
            console.error('Place details not available for the input:', input.value);
        }
    });
}

function saveAddressToDatabase(address, lat, lng, selector_id ) {
    $.ajax({
        url: '<?=base_url('save-address')?>',
        type: 'POST',
        data: {
            action: 'save',
            address: address,
            lat: lat,
            lng: lng
        },
        dataType: 'json',
        success: function(response) {
            if( selector_id ){ 
            removeAutocompleteInstance(selector_id);
            }
            /**********Add Local Package Conditions ************/
            if(['city_taxi_local_pickup'].includes(selector_id)){
                setTimeout( function(){ getLocalPackage( val ); }, 200 ); 
            }
            /* Handle success response here if needed*/ 
        },
        error: function(xhr, status, error) {
            console.error('Failed to save address:', error);
        }
    });
}

function removeAutocompleteInstance(selector_id) {
    var input = document.getElementById(selector_id);
     
    var suggestions = document.getElementsByClassName('pac-container');
    
    // Loop through all suggestion boxes and hide them
    for (var i = 0; i < suggestions.length; i++) {
        suggestions[i].style.display = 'none';
    }

}
// &callback=initAutocomplete
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?=GOOGLE_MAP_API_KEY?>&libraries=places" defer="defer" async></script>