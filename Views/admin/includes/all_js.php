<?=script_tag(base_url('assets/toastr/toastr.min.js')). "\n" ?>
<?= script_tag(base_url('assets/vendor/libs/popper/popper.js')) . "\n" ?>
<?= script_tag(base_url('assets/vendor/js/bootstrap.js')) . "\n" ?>
<?= script_tag(base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')) . "\n" ?>
<?= script_tag(base_url('assets/vendor/js/menu.js')) . "\n" ?>
<?= script_tag(base_url('assets/vendor/libs/apex-charts/apexcharts.js')) . "\n" ?>
<?= script_tag(base_url('assets/js/main.js')) . "\n" ?>
<?= script_tag(base_url('assets/js/dashboards-analytics.js')) . "\n" ?>

<?= script_tag(base_url('assets/select2/js/select2.full.min.js')) . "\n" ?>
<?= script_tag('https://buttons.github.io/buttons.js') . "\n" ?>

<?= script_tag(base_url('assets/sweetalert2/sweetalert2.min.js')) . "\n" ?>

<?= script_tag('//cdn.ckeditor.com/4.16.2/standard/ckeditor.js') . "\n" ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

<?= script_tag(base_url('assets/common.js')) . "\n" ?>

<script src="<?=base_url('assets/vendor/js/newjs.js')?>"></script>
<script>
    $('document').ready(function(){
         $('input.timepicker').timepicker({});
    });
    $('document').ready(function(){
        $('.togglemenu').click(function(){
           $('.layout-page').toggleClass('sidebarsmall') 
        });
    });
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
    $(function () {
		var Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 500
		});
  
		<?php if (session()->getFlashdata('success')) { ?>
      
			setTimeout(function () {
        
				toastr.success('<?php echo session()->getFlashdata('success'); ?>')
			}, 1000);
		<?php } ?>
		<?php if (session()->getFlashdata('failed')) { ?>
			setTimeout(function () {
				toastr.error('<?php echo session()->getFlashdata('failed'); ?>')
			}, 1000);
		<?php } ?>
	});
      function getSlug(val){
        $.ajax({
      url: '<?= base_url(ADMINPATH.'getSlug') ?>',
      type: 'POST',
      data: {
        'keyword': val
      },
      cache: false,
      success: function (response) {
       $('#url').val(response);
       $('#menu_slug').val(response);
      }
    });
    }
    
    function getCity(val){
      //  alert(val);
        $('.autocomplete-list').show();
  $('.autocomplete-list').html('');
  if (val !== "" && val.length > 2) {
       $.ajax({
      url: '<?= base_url(ADMINPATH.'getCity') ?>',
      type: "POST",
      data: { 'val': val},
      cache: false,
      dataType:"html",
      success: function (response) {
        if (response.length < 20) {
          toastr.error(response);
          return false;
        } else if (response.length > 20) {
          $('.autocomplete-list').html(response);
        }
      }
    }); 
  }
    }
    
    function selectCityName() {
  var selectedItem = $(event.target);
  var itemValue = selectedItem.text();
  var itemId = selectedItem.val();

  if (itemValue !== "" && itemId !== "") {
    $('#city_name').val(itemValue);
    $('#cityid').val(itemId);
    $('.autocomplete-list').hide();
  }
}

 function getPickupCity(inputVal,formId=null){
 
  if (inputVal !== '' && inputVal.length > 2) {
    $.ajax({
      url: '<?= base_url(ADMINPATH . 'getCity') ?>',
      type: 'POST',
      data: { 'val': inputVal },
      dataType: 'html',
      success: function(response) {
       
        var suggestionList = $('#suggestion-list-' + formId);
        suggestionList.empty(); // Clear previous suggestions

        if (response.trim() !== '') {
          suggestionList.html(response);

          // Handle click on suggested item
          suggestionList.on('click', 'li', function() {
            var selectedCity = $(this).text();
          //  alert($(this).val());
            $('#' + formId + ' .city-input').val(selectedCity);
            $('#' + formId + ' .pickup-city-id').val($(this).val());
            $('#' + formId + ' .pickup-state-id').val($(this).attr('data-stateid'));
            suggestionList.empty(); // Clear suggestions on selection
            suggestionList.hide(); // Hide suggestion list after selection
            getPacks($(this).val(),<?=!empty($local_package_id)?$local_package_id:null?>);
            return false; // Prevent default behavior
          });

          suggestionList.show(); // Show suggestions
        } else {
          suggestionList.hide(); // Hide suggestions if no results
        }
      },
      error: function(xhr, status, error) {
        console.error('Error:', error);
      }
    });
  } else {
    $('#suggestion-list-' + formId).hide(); // Hide suggestions if input is empty
  }
}

// Hide suggestions when clicking outside the input
$(document).on('click', function(event) {
  if (!$(event.target).closest('.city-input').length) {
    $('.suggestion-list').hide();
  }
});


function getDropCity(val){
      //  alert(val);
        $('.drop-autocomplete-list').show();
  $('.drop-autocomplete-list').html('');
  if (val !== "" && val.length > 2) {
       $.ajax({
      url: '<?= base_url(ADMINPATH.'getCity') ?>',
      type: "POST",
      data: { 'val': val},
      cache: false,
      dataType:"html",
      success: function (response) {
        if (response.length < 20) {
          toastr.error(response);
          return false;
        } else if (response.length > 20) {
          $('.drop-autocomplete-list').html(response);
        }
      }
    }); 
  }
    }
    
    function selectDropCityName() {
  var selectedItem = $(event.target);
  var itemValue = selectedItem.text();
  var itemId = selectedItem.val();
  var stateId = selectedItem.attr('data-stateid');

  if (itemValue !== "" && itemId !== "") {
    $('#drop_city_name').val(itemValue);
    $('#drop_city_id').val(itemId);
    $('#drop_state_id').val(stateId);
    $('.drop-autocomplete-list').hide();
  }
}

$(".drop-suggestion-list").on("click", "li", selectDropCityName);

    function change_status(id, table) {
    $.ajax({
      url: '<?= base_url(ADMINPATH.'changeStatus') ?>',
      type: "POST",
      data: { 'id': id, 'table': table },
      cache: false,
      success: function (response) {
       $('#status_label'+id).html(response);
      }
    });
  }

  function change_popular(id, table) {
    $.ajax({
      url: '<?= base_url(ADMINPATH.'changePopular') ?>',
      type: "POST",
      data: { 'id': id, 'table': table },
      cache: false,
      success: function (response) {
         // alert(response);
       $('#popular_label'+id).html(response);
      }
    });
  }

  function change_menu(id, table) {
    $.ajax({
      url: '<?= base_url(ADMINPATH.'changeMenu') ?>',
      type: "POST",
      data: { 'id': id, 'table': table },
      cache: false,
      success: function (response) {
       $('#menu_label'+id).html(response);
      }
    });
  }

  function change_special(id, table) {
    $.ajax({
      url: '<?= base_url(ADMINPATH.'changeSpecial') ?>',
      type: "POST",
      data: { 'id': id, 'table': table },
      cache: false,
      success: function (response) {
       $('#special_label'+id).html(response);
      }
    });
  }

  function change_home(id, table) {
    $.ajax({
      url: '<?= base_url(ADMINPATH.'changeHome') ?>',
      type: "POST",
      data: { 'id': id, 'table': table },
      cache: false,
      success: function (response) {
       $('#home_label'+id).html(response);
      }
    });
  }

  function checkDuplicate(val, table, column) {
      getSlug(val);
  if (val !== "" && val.length > 4) {
    $.ajax({
      url: '<?= base_url(ADMINPATH . 'checkDuplicate') ?>',
      type: 'POST',
      data: {
        'val': val,
        'table': table,
        'column': column
      },
      cache: false,
      success: function (response) {
        if (response && response === "yes") {
            toastr.error("Duplicate Entry");
          $('#submit').prop('disabled', true); 
          return false;
        } else {
          $('#submit').prop('disabled', false);
          return true;
        }
      },
      error: function (xhr, status, error) {
        console.error(error);
      }
    });
  }
}

function deleteRecord(id, table) {
    $.ajax({
      url: '<?= base_url(ADMINPATH .'deleteRecords'); ?>',
      type: "POST",
      data: { 'id': id, 'table': table },
      cache: false,
      success: function (response) {
        $(document).ready(function () {
          let qparam = (new URL(location)).searchParams;
          getTotalRecordsData(qparam);
        });
      }
    });
  }

  <?php 
if(!empty($city_id) && !empty($city_name) && !empty($state_id)){
  $cit = (!empty($city_id) ? $city_id : '') . ',' . (!empty($city_name) ? $city_name : '');
?>
  getCities(<?= !empty($state_id) ? $state_id : "" ?>,'<?=$cit?>');
<?php 
}
?>

  function getCities(id,cityvalue){
  $('#city').html('');
  $.ajax({
    url: '<?= base_url(ADMINPATH.'getCitiesFromAjax') ?>',
    method: 'POST',
    data: { state_id: id ,city:cityvalue},
    success: function (response) {
    //  alert(response);
        $('#city').html(response);
    }
  });
}

  function del_faq(a) {
    $('#faq_' + a).remove(); 
    $('#bt_' + a).remove(); 
}



$(document).ready(function(){
    var maxFieldLimit = 10; //Input fields increment limitation
    var add_more_button = $('.add_button'); //Add button selector
    var Fieldwrapper = $('.input_field_wrapper'); //Input field wrapper
    var fieldHTML = '<div><div class="form-group row mb-3"><label for="faq_question" class="col-sm-2 col-form-label">Question</label><div class="col-sm-10"><input type="text" class="form-control" id="faq_question" placeholder="Question" value="" name="faq_question[]" ></div></div><div class="form-group row mb-3"><label for="faq_answer" class="col-sm-2 col-form-label">Answer</label><div class="col-sm-10"><input type="text" class="form-control" id="faq_answer" placeholder="Answer" value="" name="faq_answer[]"></div></div><a href="javascript:void(0);" class="remove_button btn btn-danger btn-sm"  title="Remove field"><i class="bx bx-minus"></i></a></div><br>'; //New input field html 
    var x = 1; //Initial field counter is 1
    $(add_more_button).click(function(){ //Once add button is clicked
        if(x < maxFieldLimit){ //Check maximum number of input fields
            x++; //Increment field counter
            $(Fieldwrapper).append(fieldHTML); // Add field html
        }
    });
    $(Fieldwrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});





// $(document).ready(function(){
//     var maxFieldLimit = 10; //Input fields increment limitation
//     var add_more_button1 = $('.add_button1'); //Add button selector
//     var Fieldwrapper1 = $('.input_field_wrapper1'); //Input field wrapper
//     var fieldHTML1 = '<div class="cstmfld_wrap my-2">'+
//     '<div class="col-sm-3"><label for="Airport_model_id" class="col-form-label">Select Vehicle Model</label>'+   
//     '<select name="model_id" id="Airport_model_id" class="form-control select2" required><option value="">--Select Vehicle Model--</option></select></div>'+
//     '<div class="custom_fields"><label class="col-form-label">Base Fare</label><input type="text" placeholder="Enter fare" class="form-control"></div>'+
//     '<div class="custom_fields"><label class="col-form-label">Rate per KM</label><input type="text" placeholder="Enter rate" class="form-control"></div>'+
//     '<div class="custom_fields"><label class="col-form-label">Minimum  KM</label><input type="text" placeholder="Enter value" class="form-control"></div>'+
//     '<div class="custom_fields"><label class="col-form-label">Driver Charge </label><input type="text" placeholder="Enter value" class="form-control"></div>'+
//     '<div class="custom_fields"><label class="col-form-label">Night Charge </label><input type="text" placeholder="Enter value" class="form-control"></div>'+
//     '<a href="javascript:void(0);" class="remove_button1 btn btn-danger" title="Remove field"><i class="bx bx-minus"></i></a></div>'; //New input field html 
    
//     var x = 1; //Initial field counter is 1
//     $(add_more_button1).click(function(){ //Once add button is clicked
//         if(x < maxFieldLimit){ //Check maximum number of input fields
//             x++; //Increment field counter
//             $(Fieldwrapper1).append(fieldHTML1); // Add field html
//         }
//     });
//     $(Fieldwrapper1).on('click', '.remove_button1', function(e){ //Once remove button is clicked
//         e.preventDefault();
//         $(this).parent('div').remove(); //Remove field html
//         x--; //Decrement field counter
//     });
       
    
// });
    
    // $(document).ready(function() {
    //     objAdd = $('#addBlock')    
    //     objRemove = $('#removeBlock')  
       
    //     objAdd.click(function() {
    //         clone = $( "#DiskBlock" ).clone(true);
    //         clone.find('.add_button1').remove();
    //         clone.find('.remove_button1').show();
    //         clone.insertAfter( "#DiskBlock" ).html();
    //     });
        
    //   objRemove.click(function(event) {
    //       $(this).parent().remove()
    //   });  
    // });
 



      // create a function to update the date and time
      function updateDateTime() {
        
        let currentDate = new Date();

        // Extract components of the date
        let year = currentDate.getFullYear();
        let month = (currentDate.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-indexed, so add 1
        let day = currentDate.getDate().toString().padStart(2, '0');
        
        // Extract components of the time
        let hours = currentDate.getHours().toString().padStart(2, '0');
        let minutes = currentDate.getMinutes().toString().padStart(2, '0');
        
        // Construct the date and time string
        let dateTimeWithoutSeconds = `${year}-${month}-${day}, ${hours}:${minutes}`;


        // update the `textContent` property of the `span` element with the `id` of `datetime`
        document.querySelector('#datetime').textContent = dateTimeWithoutSeconds;
      }

      // call the `updateDateTime` function every second
      setInterval(updateDateTime, 1000);
 


function printDutySlip(booking_id){
    window.location.href = '<?= base_url(ADMINPATH . 'printDutySlip?booking_id=') ?>' + booking_id;
}

function printPaymentSlip(booking_id){
    window.location.href = '<?= base_url(ADMINPATH . 'printPaymentSlip?booking_id=') ?>' + booking_id;
}
function printInvoiceSlip(booking_id){
    window.location.href = '<?= base_url(ADMINPATH . 'printInvoiceSlip?booking_id=') ?>' + booking_id;
}

CKEDITOR.replace('description');
CKEDITOR.replace('itenary_description');
CKEDITOR.replace('itenary_terms_conditions');
CKEDITOR.replace('cancellation_terms_conditions');
CKEDITOR.replace('inclusion');
CKEDITOR.replace('exclusion');
CKEDITOR.replace('cancellation_policy');




</script>
</body>
</html>