<div class="col-sm-5 pos-relative p-0">
  <div class="side_booking">
    <div class="formcontainer farebox">
      <h2 class="formhdng"> Get in Touch </h2>
      <form>
        <?php $captua_token = random_alphanumeric_string(6); ?>
        <input type="hidden" id="csrf" class="csrf" name="csrf_token" value="<?= $captua_token ?>">
        <div class="row">
          <div class="col-sm-12 form-floating mb-2">
            <input type="text" name ="name" required class="form-control ucwords restrictedInput" id="name" placeholder="Enter Name" autocomplete="off">
            <label for="floatingInput">Enter Name</label>
            <img src="<?=base_url('assets/frontend/')?>images/user.png">
          </div>
          <div class="col-sm-12 form-floating mb-2">
            <input type="text" name="email" required class="form-control emailInput" id="email" placeholder="Enter Email" autocomplete="off">
            <label for="">Enter Email</label>
            <img src="<?=base_url('assets/frontend/')?>images/email.png">
          </div>
          <div class="col-sm-12 form-floating mb-2">
            <input type="text" name="phone" required class="form-control notzero numbersWithZeroOnlyInput" id="phone" maxlength="10" minlength="10" placeholder="Enter Contact Number" autocomplete="off">
            <label for="">Enter Contact Number</label>
            <img src="<?=base_url('assets/frontend/')?>images/ci2.png">
          </div>
          <?php if($url!='attach-taxi'){?>
          <div class="col-sm-12 form-floating mb-2">
            <textarea class="form-control" required name="query" id="query" placeholder="Write Your Query" style="height: 100px;"></textarea>
            <label for="">Write Your Query</label>
          </div>
          <?php }else{ ?>
          <div class="col-sm-12 mb-2 form-floating">
            <select name="vehicle_type" id="vehicle_type" required class="form-control form-select">
              <?php $models=getModelName(); if(!empty($models)){foreach($models as $key=>$value){?>
              <option value="<?=$value['model_name']?>"><?=$value['model_name']?></option>
              <?php }} ?>
            </select>
            <label for="vehicle_type">Choose Vehicle Type</label>									
          </div>
          <?php } ?>
          <div class="row py-2 px-4">
            <div class="bgreprat col-lg-5 col-11">
              <?= $captua_token; ?>
            </div>
            <div class="col-lg-2 col-1 py-2 py-lg-1 ps-0 ps-lg-1">
              <span class="bgreprat-refesh ps-0" style="cursor:pointer;" onclick="getRandomCaptcha()"><img
                src="<?= base_url('assets') ?>/refresh.png"></span>
            </div>
            <div class="col-lg-5 ps-0 ps-lg-1">
              <div class="form-group">
                <input type="text" name="match_captcha" maxlength="6" class="form-control" id="match_captcha"
                  autocomplete="off" placeholder="Enter Captcha" />
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 formbtnrow">
            <button type="button" id="submit" onclick="return validateForm()" class="form_btn">
              Send Now
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

<script>
  $('#loader').hide();
    function validateForm() {
   var name = $('#name').val();
   var email =$('#email').val();
   var phone =$('#phone').val();
   var csrf= $('#csrf').val();
   var query = $('#query').val() ? $('#query').val() : '';
   var vehicle_type = $('#vehicle_type').val() ? $('#vehicle_type').val() : '';
   var match_captcha= $('#match_captcha').val();
   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
   if (name=="") {
     toastr.error("Please Enter Name");
     return false;
   } else if (email == "") {
     toastr.error("Please Enter Email");
     return false;
   } else if(reg.test(email) == false){
      toastr.error("Please Enter A Valid Email");
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
           url: '<?= base_url('save-form') ?>',
           type: 'POST',
           data: {
             'name': name,
             'email': email,
             'phone': phone,
             'match_captcha':match_captcha,
             'csrf':csrf,
             'query':query,
             'vehicle_type':vehicle_type
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
</script>