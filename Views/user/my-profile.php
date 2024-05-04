<div class="wd_dashcontent">
      <div class="container myprofilepage">
        <div class="row">
          <h3>My Profile</h3>
        </div>
          <?=form_open_multipart(base_url(USERPATH.'save-profile'))?>
          <?=form_hidden('id',$id)?>
          <?=form_hidden('old_profile_image',$profile_image)?>
         <div class="row profile_form mb-5">

            <div class="col-sm-2">
            <div class="uplodpic">
              <div class="imgprw">
                <img src="<?=!empty($profile_pic)?$profile_pic:base_url('assets/frontend/images/camera.svg')?>" width="50" height="50">
              </div>
              <input type="file" name="profile_image" class="upldpic"/>
              <label>Upload Profile Pic</label>
            </div>
          </div>
            <div class="col-sm-10 pt-2">
            <div class="row">
              <div class="col-6">
                <div class="mb-3 position-relative">
                  <label class="form-label" for="name">Full Name</label>
                  <input placeholder="Enter your name" type="text" autocomplete="off" id="name" name="name" required class="form-control ucwords restrictedInput" value="<?=$name?>">
                </div>
              </div>
              <div class="col-6">
                <div class="mb-3 position-relative">
                  <label class="form-label" for="email">Email ID</label>
                  <input placeholder="Enter your email ID" type="email" autocomplete="off" name="email" required id="email" class="form-control emailInput" value="<?=$email?>">
                </div>
              </div>
              <div class="col-6">
                <div class="mb-3 position-relative">
                  <label class="form-label" for="mobile_no">Mobile Number</label>
                  <input placeholder="Enter your mobile number" autocomplete="off" type="text" id="mobile_no" required name="mobile_no" maxlength="10" class="form-control notzero numbersWithZeroOnlyInput" value="<?=$mobile_no?>" <?php echo !empty($mobile_no) ? 'readonly' : ''; ?>>

                </div>
              </div>
              <div class="col-6">
                <div class="mb-3">
                  <label class="form-label" for="state_id">State</label>
                  <select name="state_id" id="state_id" class="form-control select2" required onchange="getCities(this.value,<?=$city_id?>)">
                    <option value="">--Select State--</option>
                    <?php if(!empty($states)){foreach($states as $key=>$value){?>
                    <option value="<?=$value['id']?>" <?=!empty($state_id) && ($state_id==$value['id'])?"selected":""?>><?=$value['state_name']?></option>
                    <?php }} ?>
                  </select>
                </div>
              </div>
              <div class="col-6">
                <div class="mb-3">
                  <label class="form-label" for="city_id">City</label>
                  <select name="city_id" id="city_id" class="form-control select2" >
                    <option value="">--Select City--</option>
                  </select>
                </div>
              </div>
              <div class="col-6">
                <div class="mb-3">
                  <label class="form-label" for="pin_code">Pincode</label>
                  <input placeholder="Enter Pincode" autocomplete="off" name="pin_code" type="text" id="pin_code" maxlength="6" class="form-control notzero numbersWithZeroOnlyInput" value="<?=$pin_code?>">
                </div>
              </div>
              <div class="col-6">
                <div class="mb-3">
                  <label class="form-label" for="exampleForm.ControlTextarea1">Address</label>
                  <textarea placeholder="Enter Complete Address" autocomplete="off" name="address" rows="5" id="exampleForm.ControlTextarea1" class="form-control"><?=$address?></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <div class="mb-3">
                  <label class="form-label" for="company_name">Company Name</label>
                  <input placeholder="Enter Company Name" autocomplete="off" name="company_name" type="text" id="company_name" class="form-control ucwords"  value="<?=$company_name?>">
                </div>
              </div>
              <div class="col-6">
                <div class="mb-3">
                  <label class="form-label" for="company_pan_number">Company Pan Number</label>
                  <input placeholder="Enter pan number" maxlength="10" autocomplete="off" name="company_pan_number" type="text" id="company_pan_number" class="form-control uppercase" value="<?=$company_pan_number?>">
                </div>
              </div>
              <div class="col-6">
                <div class="mb-3">
                  <label class="form-label" for="gstin_number">GSTIN</label>
                  <input placeholder="Enter GST number" maxlength="15" autocomplete="off" name="gstin_number" type="text" id="gstin_number" class="form-control uppercase" value="<?=$gstin_number?>">
                </div>
              </div>
              <div class="col-6">
                <div class="mb-3">
                  <label class="form-label" for="company_state">Company State</label>
                  <select name="company_state" id="company_state" class="form-control select2"  onchange="getCompanyCities(this.value,'<?=$company_city?>')">
                    <option value="">--Select State--</option>
                  <?php if(!empty($states)){foreach($states as $key=>$value){?>
                    <option value="<?=$value['id']?>" <?=!empty($company_state) && ($company_state==$value['id'])?"selected":""?>><?=$value['state_name']?></option>
                    <?php }} ?>
                  </select>
                </div>
              </div>
              <div class="col-6">
                <div class="mb-3">
                  <label class="form-label" for="company_city">Company City</label>
                  <select name="company_city" id="company_city" class="form-control select2" >
                    <option value="">--Select City--</option>
                  </select>
                </div>
              </div>
              <div class="col-6">
                <div class="mb-3">
                  <label class="form-label" for="company_pin_code">Pincode</label>
                  <input placeholder="Enter pincode" autocomplete="off" name="company_pin_code" type="text" id="company_pin_code" maxlength="6" class="form-control notzero numbersWithZeroOnlyInput" value="<?=$company_pin_code?>">
                </div>
              </div>
              <div class="col-6">
                <div class="mb-3">
                  <label class="form-label" for="company_address">Company Address</label>
                  <textarea placeholder="Enter Company Address" autocomplete="off" name="company_address" rows="5" id="company_address" class="form-control"><?=$company_address?></textarea>
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary sbmtbtnprf">Save</button>
          </div>
        </div>
      </div>
    </div>

      <?=form_close()?>
      
      <script>
     <?php 
if(!empty($city_id) && !empty($state_id)){?>
  getCities(<?=!empty($state_id) ? $state_id : "" ?>,<?=!empty($city_id) ? $city_id : "" ?>);
<?php }?>

  function getCities(id,cityvalue){
  $('#city_id').html('');
  $.ajax({
    url: '<?= base_url('getCities') ?>',
    method: 'POST',
    data: { state_id: id ,city:cityvalue},
    success: function (response) {
        $('#city_id').html(response);
    }
  });
}

<?php 
if(!empty($company_city) && !empty($company_state)){?>
  getCompanyCities(<?=!empty($company_state) ? $company_state : "" ?>,<?=!empty($company_city) ? $company_city : "" ?>);
<?php }?>
function getCompanyCities(id,cityvalue){
  $('#company_city').html('');
  $.ajax({
    url: '<?= base_url('getCities') ?>',
    method: 'POST',
    data: { state_id: id ,city:cityvalue},
    success: function (response) {
        $('#company_city').html(response);
    }
  });
}
</script>