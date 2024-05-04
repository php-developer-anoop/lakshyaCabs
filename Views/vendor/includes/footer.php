<footer class="content-footer footer bg-footer-theme">
  <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
    <div class="mb-2 mb-md-0">
      ©
      <?=date('Y')?>
      , All Rights Reserved By 
      <a href="https://duplextech.com/" target="_anoop"  class="footer-link fw-medium">Duplex Technologies</a>
    </div>
  </div>
</footer>

<div class="content-backdrop fade"></div>
</div>
</div>
</div>
<div class="layout-overlay layout-menu-toggle"></div>
</div>
<div class="modal fade" id="confirmModal">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body statusmodal p-0">
        <div class="modal-header">
          <h4>Confirm</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modeltxt">
          <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam.</p>
          <div class="mdlbtns">
            <button class="btn-green btnyes">Yes</button>
            <button class="btn-magenta btnno">No</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--<div class="modal fade" id="addmoney">-->
<!--  <div class="modal-dialog modal-md modal-dialog-centered">-->
<!--    <div class="modal-content">-->
<!--      <div class="modal-body paymodel p-0">-->
<!--        <div class="modal-header p-0">-->
<!--          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
<!--        </div>-->
<!--        <div class="modeltxt mt-4">-->
<!--          <h5>Select The Amount</h5>-->
<!--          <div class="cstmradio">-->
<!--            <ul class="donate-row">-->
<!--              <li><input type="radio" id="ax" name="amount"><label for="ax">500</label></li>-->
<!--              <li><input type="radio" id="au" name="amount"><label for="au">1000</label></li>-->
<!--              <li><input type="radio" id="az" name="amount"><label for="az">2000</label></li>-->
<!--            </ul>-->
<!--          </div>-->
<!--          <div class="custminput">-->
<!--            <label>Or Enter Amount to add</label>-->
<!--            <input type="text" placeholder="Enter amount" name="">-->
<!--          </div>-->
<!--          <div class="mdlbtns">-->
<!--            <button class="sitebtn">Add Amount</button>-->
<!--          </div>-->
<!--        </div>-->
<!--      </div>-->
<!--    </div>-->
<!--  </div>-->
<!--</div>-->
<script type="text/javascript" src="<?=base_url()?>assets/toastr/toastr.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/vendor/libs/popper/popper.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/vendor/js/bootstrap.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/vendor/js/menu.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/vendor/libs/apex-charts/apexcharts.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/main.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/dashboards-analytics.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/select2/js/select2.full.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/sweetalert2/sweetalert2.min.js"></script>
<script type="text/javascript" src="httsp://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/common.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/vendor/js/newjs.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/script.js"></script>
<script>

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
		
        $(document).ready(function() {
            // Function to toggle class on page load
            toggleSidebar();
        
            // Click event handler for toggling class
            $('.togglemenu').click(function() {
                toggleSidebar();
            });
        });
        
        // Function to toggle class
        function toggleSidebar() {
            $('.layout-page').toggleClass('sidebarsmall');
        }

  
  
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
  });
  
  $(document).on('click', function(event) {
  if(!$(event.target).closest('.city-input').length) {
  $('.suggestion-list').hide();
  }
  });
  
  
  
  
  $(document).ready(function(){
  var maxFieldLimit = 10;
  var add_more_button = $('.add_button');
  var Fieldwrapper = $('.input_field_wrapper'); 
  var fieldHTML = '<div><div class="form-group row mb-3"><label for="faq_question" class="col-sm-2 col-form-label">Question</label><div class="col-sm-10"><input type="text" class="form-control" id="faq_question" placeholder="Question" value="" name="faq_question[]" ></div></div><div class="form-group row mb-3"><label for="faq_answer" class="col-sm-2 col-form-label">Answer</label><div class="col-sm-10"><input type="text" class="form-control" id="faq_answer" placeholder="Answer" value="" name="faq_answer[]"></div></div><a href="javascript:void(0);" class="remove_button btn btn-danger btn-sm"  title="Remove field"><i class="bx bx-minus"></i></a></div><br>';
  var x = 1; 
  $(add_more_button).click(function(){ //Once add button is clicked
      if(x < maxFieldLimit){ //Check maximum number of input fields
          x++; //Increment field counter
          $(Fieldwrapper).append(fieldHTML); 
      }
  });
  $(Fieldwrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
      e.preventDefault();
      $(this).parent('div').remove(); 
      x--; 
  });
  });
  
  
  $(document).ready(function() {
      objAdd = $('#addBlock')    
      objRemove = $('#removeBlock')  
     
      objAdd.click(function() {
          clone = $( "#DiskBlock" ).clone(true);
          clone.find('.add_button1').remove();
          clone.find('.remove_button1').show();
          clone.insertAfter( "#DiskBlock" ).html();
      });
      
     objRemove.click(function(event) {
        $(this).parent().remove()
     });  
  });
  
  function printReceipt(booking_id) {
    window.location.href = '<?= base_url("api/v1/generate_pdf/printReceipt?booking_id=") ?>' + booking_id;
  }

//   CKEDITOR.replace('description');
//   CKEDITOR.replace('itenary_description');
//   CKEDITOR.replace('itenary_terms_conditions');
//   CKEDITOR.replace('cancellation_policy');
</script>
</body>
</html>