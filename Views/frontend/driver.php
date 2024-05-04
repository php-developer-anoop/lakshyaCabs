<div class="container-fluid">
  <div class="row">
    <div class="col-sm-7 pl-0 pr-0">
      <section class="cablist sec_padd pl-60 pr-30">
        <div class="norml_hdng">
          <h1><?=!empty($page['h_one_heading'])?$page['h_one_heading']:""?></h1>
          <?=!empty($page['content_data'])?$page['content_data']:""?>
        </div>
        <div class="passenger-info">
          <div class="infoform driverform">
            <?=form_open_multipart(base_url('save-driver'))?> 
            <?php $captua_token = random_alphanumeric_string(6); ?>
        <input type="hidden" id="csrf" class="csrf" name="csrf_token" value="<?= $captua_token ?>">
              <div class="row">
                <div class="col-sm-6 form-floating mb-3">
                  <input type="text" class="form-control ucwords restrictedInput" autocomplete="off" id="driver_name" name="driver_name" placeholder="Enter Driver Name">
                  <label for="floatingInput">Driver Name</label>
                  <img src="<?=base_url('assets/frontend/')?>images/licon.png">
                </div>
                <div class="col-sm-6 form-floating mb-3">
                  <input type="email" class="form-control emailInput" autocomplete="off" id="email" name="driver_email" placeholder="Enter Email ID">
                  <label for="floatingInput">Enter Email ID</label>
                  <i class="fa-regular fa-envelope"></i>
                </div>
                <div class="col-sm-6 form-floating mb-3">
                  <input type="text" class="form-control notzero numbersWithZeroOnlyInput" name="driver_phone" id="driver_phone"  autocomplete="off" id="phone" maxlength="10" placeholder="Enter Phone Number">
                  <label for="floatingInput">Enter Phone Number</label>
                  <i class="fa-solid fa-phone"></i>
                </div>
                <div class="col-sm-6 form-floating mb-3">
                  <input type="text" class="form-control notzero numbersWithZeroOnlyInput" id="driver_alternate_phone" name="driver_alternate_phone" autocomplete="off" id="" placeholder="Enter Alternate Number">
                  <label for="floatingInput">Enter Alternate Number</label>
                  <i class="fa-solid fa-phone"></i>
                </div>
                <div class="col-sm-6 form-floating mb-3">
                  <input type="text" class="form-control ucwords restrictedInput" name="state"  autocomplete="off" id="state" placeholder="State">
                  <label for="floatingInput">State</label>
                  <img src="<?=base_url('assets/frontend/')?>images/fi1.png">
                </div>
                <div class="col-sm-6 form-floating mb-3">
                  <input type="text" class="form-control ucwords restrictedInput" name="city" autocomplete="off" id="city" placeholder="City">
                  <label for="floatingInput">City</label>
                  <img src="<?=base_url('assets/frontend/')?>images/fi1.png">
                </div>
               
                <div class="col-sm-12 form-floating mb-3">
                  <input type="text" class="form-control" id="address" name="address" autocomplete="off" placeholder="Full Address">
                  <label for="floatingInput">Full Address</label>
                </div>
                <div class="col-sm-4 form-floating mb-3">
                  <input type="file" class="form-control file" id="upload_rc" name="upload_rc" placeholder="Upload R/C">
                  <label for="">Upload R/C</label>
                  <i class="fa-solid fa-arrow-up-from-bracket"></i>
                </div>
                <div class="col-sm-4 form-floating mb-3">
                  <input type="file" class="form-control file" id="upload_dl" name="upload_dl" placeholder="Upload DL">
                  <label for="">Upload DL</label>
                  <i class="fa-solid fa-arrow-up-from-bracket"></i>
                </div>
                <div class="col-sm-4 form-floating mb-3">
                  <input type="file" class="form-control file" id="upload_ic" name="upload_ic" placeholder="Upload I/C">
                  <label for="">Upload I/C</label>
                  <i class="fa-solid fa-arrow-up-from-bracket"></i>
                </div>
              </div>
              <!--<div class="row py-2 px-4" >-->
              <!--  <div class="bgreprat col-lg-5 col-11">-->
              <!--    <?= $captua_token; ?>-->
              <!--  </div>-->
              <!--  <div class="col-lg-2 col-1 py-2 py-lg-1 ps-0 ps-lg-1">-->
              <!--    <span class="bgreprat-refesh ps-0" style="cursor:pointer;" onclick="getRandomCaptcha()"><img-->
              <!--      src="<?= base_url('assets') ?>/refresh.png"></span>-->
              <!--  </div>-->
              <!--  <div class="col-lg-5 ps-0 ps-lg-1">-->
              <!--    <div class="form-group">-->
              <!--      <input type="text" name="match_captcha" maxlength="6" class="form-control" id="match_captcha"-->
              <!--        autocomplete="off" placeholder="Enter Captcha" />-->
              <!--    </div>-->
              <!--  </div>-->
              <!--</div>-->
              <div class="row">
                <div class="col-sm-12 formbtnrow">
                  <button type="submit" class="form_btn" onclick="return validateDriver()">Submit<div class="spinner-border spinner-border-sm text-white" id="loader" role="status">
                      <span class="visually-hidden">Loading...</span>
                    </div>
                  </button>
                </div>
              </div>
            <?=form_close()?>
          </div>
        </div>
      </section>
      <section class="drivrfeatr sec_padd pl-60 pr-30">
        <div class="norml_hdng">
          <h2>Why Choose Drive? </h2>
          <p class="sub_hdng">Make money on your schedule</p>
        </div>
        <?php if(!empty($why_choose)){?>
        <div class="featrs row">
          <?php foreach($why_choose as $key=>$value){?>
          <div class="col-sm-4">
            <div class="ftrbox">
              <h4><?=!empty($value['title'])?$value['title']:""?></h4>
              <p><?=!empty($value['description'])?$value['description']:""?></p>
            </div>
          </div>
          <?php } ?>
        </div>
        <?php } ?>
      </section>
      <?=view('frontend/popular-city-taxi')?>
    </div>
    <div class="col-sm-5 pos-relative p-0">
      <div class="side_booking sidefare">
        <div class="drvr-img">
          <?php $bgimage = !empty($page['banner_image_jpg'] || $page['banner_image_webp']) ? base_url('uploads/') . imgExtension($page['banner_image_jpg'],$page['banner_image_webp']) : ""; ?>
          <img src="<?=$bgimage?>">
        </div>
      </div>
    </div>
  </div>
</div>

<script>
   $('#loader').hide();
  function validateDriver() {
    var driver_name = $('#driver_name').val();
    var driver_email = $('#email').val();
    var driver_phone = $('#driver_phone').val();
    var driver_alternate_phone = $('#driver_alternate_phone').val();
    var state = $('#state').val();
    var city = $('#city').val();
    var address = $('#address').val();
    var upload_rc = $("#upload_rc");
    var upload_dl = $("#upload_dl");
    var upload_ic = $("#upload_ic");
    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    var csrf= $('#csrf').val();
    var match_captcha= $('#match_captcha').val();

    if (driver_name === "") {
        toastr.error("Please Enter Name");
        return false;
    } else if (driver_email === "") {
        toastr.error("Please Enter Email");
        return false;
    } else if (reg.test(driver_email) == false) {
        toastr.error("Please Enter A Valid Email");
        return false;
    } else if (driver_phone === "") {
        toastr.error("Please Enter Phone");
        return false;
    } else if (driver_phone.length < 10) {
        toastr.error("Please Enter A Valid Phone Number");
        return false;
    } else if (driver_alternate_phone.length > 0 && driver_alternate_phone.length < 10) {
        toastr.error("Please Enter A Valid Alternate Phone Number");
        return false;
    } else if (state === "") {
        toastr.error("Please Enter State");
        return false;
    } else if (city === "") {
        toastr.error("Please Enter City");
        return false;
    } else if (address === "") {
        toastr.error("Please Enter Full Address");
        return false;
    } else if (upload_rc[0].files.length === 0) {
        toastr.error("Please Select RC File");
        return false;
    } else if (upload_dl[0].files.length === 0) {
        toastr.error("Please Select DL File");
        return false;
    } else if (upload_ic[0].files.length === 0) {
        toastr.error("Please Select I/C File");
        return false;
    } else if (match_captcha == "") {
        toastr.error("Please Enter Captcha");
        return false;
    } else if (match_captcha !== csrf) {
        toastr.error("Captcha Not Match");
        return false;
    }
    $('#loader').show();
    return true;
}

</script>