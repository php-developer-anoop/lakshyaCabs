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
              <div class="dflexbtwn hdngvwall">
                <h4></h4>
                <a href="<?= base_url(ADMINPATH . 'vendor-master-list') ?>" class="sitebtn">View Vendor List</a>
            </div>
            <?=form_open_multipart(ADMINPATH . 'save-vendor'); ?>
            <?=form_hidden('id',$id)?>
            <?=form_hidden('old_profile_image',$profile_image)?>
            <?=form_hidden('old_business_logo',$business_logo)?>
            <?=form_hidden('old_aadhaar_front',$aadhaar_front)?>
            <?=form_hidden('old_aadhaar_back',$aadhaar_back)?>
            <?=form_hidden('old_pan_image',$pan_image)?>
            <?=form_hidden('old_gst_image',$gst_image)?>
            <h4>Basic Details</h4>
            <div class="row mb-3">
              <div class="col-sm-3">
                <?=form_label('Full Name','full_name',['class'=>'col-form-label'])?>
                <input type="text" class="form-control ucwords restrictedInput" autocomplete="off" required
                  name="full_name" id="full_name" placeholder="Full Name" value="<?=$full_name?>">
              </div>
              <div class="col-sm-3">
                <?=form_label('Mobile Number','mobile_no',['class'=>'col-form-label'])?>
                <input type="text" class="form-control numbersWithZeroOnlyInput" autocomplete="off" required
                  name="mobile_no" id="mobile_no" placeholder="Mobile Number" maxlength="10" minlength="10" value="<?=$mobile_no?>">
              </div>
              <div class="col-sm-3">
                <?=form_label('Email ID','email_id',['class'=>'col-form-label'])?>
                <input type="email" class="form-control emailOnly" required
                  name="email_id" id="email_id" placeholder="Email Id" autocomplete="off" value="<?=$email_id?>">
              </div>
              <div class="col-sm-3">
                <?=form_label('Select State','state',['class'=>'col-form-label'])?>
                <select class="form-select select2" name="state" id="state" aria-label="Default select example" onchange="getCities(this.value,<?=!empty($state_id)?$state_id:''?>)">
                  <option value="">Select State</option>
                  <?php if(!empty($state_list)){foreach($state_list as $slkey=>$slvalue){?>
                  <option value="<?=$slvalue['id'].','.$slvalue['state_name']?>" <?=!empty($stateid) && ($stateid==$slvalue['id'])?"selected":""?>><?=$slvalue['state_name']?></option>
                  <?php }} ?>
                </select>
              </div>
              <div class="col-sm-3">
                <?=form_label('Select City','city',['class'=>'col-form-label'])?>
                <select class="form-select select2" name="city_id" id="city" aria-label="Default select example" >
                  <option value="">Select City</option>
                </select>
              </div>
              <div class="col-sm-3">
                <?=form_label('Address','address',['class'=>'col-form-label'])?>
                <input type="text" class="form-control" required
                  name="address" id="address" placeholder="Address" autocomplete="off" value="<?=$address?>">
              </div>
              <div class="col-sm-3">
                <?=form_label('Pincode','pincode',['class'=>'col-form-label'])?>
                <input type="text" class="form-control numbersWithZeroOnlyInput" required
                  name="pincode" id="pincode" maxlength="6" minlength="6" placeholder="Pincode" autocomplete="off" value="<?=$pincode?>">
              </div>
              <div class="col-sm-3">
                <?=form_label('Profile Image','profile_image',['class'=>'col-form-label'])?>
                <?= form_upload([
                  'name' => 'profile_image',
                  'class' => 'form-control',
                  'accept' => 'image/png, image/jpg, image/jpeg'
                  ]); ?>
              </div>
              <?php if(!empty($profile_image)){?>
              <div class="col-sm-3"></div>
              <div class="col-sm-3"></div>
              <div class="col-sm-3"></div>
              <div class="col-sm-3"> <a href="<?= base_url('uploads/') . $profile_image; ?>" target="_blank"><img src="<?= base_url('uploads/') . $profile_image; ?>" height=70px width=100px></a></div>
              <?php } ?>
            </div>
            <h4>Business Details</h4>
            <div class="row mb-3">
              <div class="col-sm-3">
                <?=form_label('Business name','full_name',['class'=>'col-form-label'])?>
                <input type="text" class="form-control ucwords restrictedInput" autocomplete="off" required
                  name="business_name" id="business_name" placeholder="Business name" value="<?=$business_name?>">
              </div>
              <div class="col-sm-3">
                <?=form_label('Registered As','business_registered_as',['class'=>'col-form-label'])?>
                <select class="form-select select2" name="business_registered_as" aria-label="Default select example" id="business_registered_as">
                  <option value="">Select option</option>
                  <option value="Individual" <?=!empty($business_registered_as) && ($business_registered_as == "Individual")?"selected":''?>>Individual</option>
                  <option value="Private Limited" <?=!empty($business_registered_as) && ($business_registered_as == "Private Limited")?"selected":''?>>Private Limited</option>
                  <option value="Sole Proprietor" <?=!empty($business_registered_as) && ($business_registered_as == "Sole Proprietor")?"selected":''?>>Sole Proprietor</option>
                  <option value="LLP" <?=!empty($business_registered_as) && ($business_registered_as == "LLP")?"selected":''?>>LLP</option>
                </select>
              </div>
              <div class="col-sm-3">
                <?=form_label('Select Business State','business_state_id',['class'=>'col-form-label'])?>
                <select class="form-select select2" name="business_state_id" id="business_state_id" aria-label="Default select example" onchange="getBusinessCities(this.value,<?=!empty($business_state_id)?$business_state_id:''?>)">
                  <option value="">Select State</option>
                  <?php if(!empty($state_list)){foreach($state_list as $slkey=>$slvalue){?>
                  <option value="<?=$slvalue['id'].','.$slvalue['state_name']?>" <?=!empty($business_state_id) && ($business_state_id==$slvalue['id'])?"selected":""?>><?=$slvalue['state_name']?></option>
                  <?php }} ?>
                </select>
              </div>
              <div class="col-sm-3">
                <?=form_label('Select Business City','business_city_id',['class'=>'col-form-label'])?>
                <select class="form-select select2" name="business_city_id" id="business_city_id" aria-label="Default select example" >
                  <option value="">Select Business City</option>
                </select>
              </div>
              <div class="col-sm-3">
                <?=form_label('Business Address','business_address',['class'=>'col-form-label'])?>
                <input type="text" class="form-control" required
                  name="business_address" id="business_address" placeholder="Address" autocomplete="off" value="<?=$business_address?>">
              </div>
              <div class="col-sm-3">
                <?=form_label('Business Pincode','business_pincode',['class'=>'col-form-label'])?>
                <input type="text" class="form-control numbersWithZeroOnlyInput" required
                  name="business_pincode" id="business_pincode" maxlength="6" minlength="6" placeholder="Business Pincode" autocomplete="off" value="<?=$business_pincode?>">
              </div>
              <div class="col-sm-3">
                <?=form_label('Business Pan','business_pincode',['class'=>'col-form-label'])?>
                <input type="text" class="form-control uppercase" autocomplete="off" id="business_pan_no" required name="business_pan_no"
                  placeholder="Enter Business PAN" maxlength="10" minlength="10" value="<?=!empty($business_pan_no)?$business_pan_no:''?>">
              </div>
              <div class="col-sm-3">
                <?=form_label('Business GSTIN','business_gst_no',['class'=>'col-form-label'])?>
                <input type="text" class="form-control uppercase" required
                  name="business_gst_no" id="business_gst_no" maxlength="15" minlength="15" placeholder="Business GSTIN" autocomplete="off" value="<?=$business_gst_no?>">
              </div>
              <div class="col-sm-3">
                <?=form_label('Business Logo','business_logo',['class'=>'col-form-label'])?>
                <?= form_upload([
                  'name' => 'business_logo',
                  'class' => 'form-control',
                  'accept' => 'image/png, image/jpg, image/jpeg'
                  ]); ?>
              </div>
              <?php if(!empty($business_logo)){?>
              <div class="col-sm-3 mt-2"> <a href="<?= base_url('uploads/') . $business_logo; ?>" target="_blank"><img src="<?= base_url('uploads/') . $business_logo; ?>" height=70px width=100px></a></div>
              <?php } ?>
            </div>
            <h4>KYC Details</h4>
            <div class="row mb-3">
              <div class="col-sm-3">
                <?=form_label('Aadhaar Front','aadhaar_front',['class'=>'col-form-label'])?>
                <?= form_upload([
                  'name' => 'aadhaar_front',
                  'class' => 'form-control',
                  'accept' => 'image/png, image/jpg, image/jpeg'
                  ]); ?>
              </div>
              <?php if(!empty($aadhaar_front)){?>
              <div class="col-sm-3 mt-2"> <a href="<?= base_url('uploads/') . $aadhaar_front; ?>" target="_blank"><img src="<?= base_url('uploads/') . $aadhaar_front; ?>" height=70px width=100px></a></div>
              <?php } ?> 
              <div class="col-sm-3">
                <?=form_label('Aadhaar Back','aadhaar_back',['class'=>'col-form-label'])?>
                <?= form_upload([
                  'name' => 'aadhaar_back',
                  'class' => 'form-control',
                  'accept' => 'image/png, image/jpg, image/jpeg'
                  ]); ?>
              </div>
              <?php if(!empty($aadhaar_back)){?>
              <div class="col-sm-3 mt-2"> <a href="<?= base_url('uploads/') . $aadhaar_back; ?>" target="_blank"><img src="<?= base_url('uploads/') . $aadhaar_back; ?>" height=70px width=100px></a></div>
              <?php } ?> 
              <div class="col-sm-3">
                <?=form_label('Pan Image','pan_image',['class'=>'col-form-label'])?>
                <?= form_upload([
                  'name' => 'pan_image',
                  'class' => 'form-control',
                  'accept' => 'image/png, image/jpg, image/jpeg'
                  ]); ?>
              </div>
              <?php if(!empty($pan_image)){?>
              <div class="col-sm-3 mt-2"> <a href="<?= base_url('uploads/') . $pan_image; ?>" target="_blank"><img src="<?= base_url('uploads/') . $pan_image; ?>" height=70px width=100px></a></div>
              <?php } ?>
              <div class="col-sm-3">
                <?=form_label('GST Image','gst_image',['class'=>'col-form-label'])?>
                <?= form_upload([
                  'name' => 'gst_image',
                  'class' => 'form-control',
                  'accept' => 'image/png, image/jpg, image/jpeg'
                  ]); ?>
              </div>
              <?php if(!empty($gst_image)){?>
              <div class="col-sm-3 mt-2"> <a href="<?= base_url('uploads/') . $gst_image; ?>" target="_blank"><img src="<?= base_url('uploads/') . $gst_image; ?>" height=70px width=100px></a></div>
              <?php } ?>
            </div>
            <div class="row mb-3">
              <div class="col-sm-6">
                <?=form_label('Profile Status','profile_status',['class'=>'col-form-label'])?>
                <div class="row mt-2">
                  <div class="col-3">
                    <div class="custom-control custom-checkbox">
                      <input class="custom-control-input checkbox-style " name="profile_status" <?= ($profile_status == 'Active') ? 'checked' : '' ?> type="radio" id="checkStatus1" value="Active">
                      <?=form_label('Active','checkStatus1',['class'=>'custom-control-label'])?>
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="custom-control custom-checkbox">
                      <input class="custom-control-input checkbox-style " name="profile_status" <?= ($profile_status == 'Inactive') ? 'checked' : '' ?> type="radio" id="checkStatus2" value="Inactive">
                      <?=form_label('Inactive','checkStatus2',['class'=>'custom-control-label'])?>
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="custom-control custom-checkbox">
                      <input class="custom-control-input checkbox-style " name="profile_status" <?= ($profile_status == 'Blocked') ? 'checked' : '' ?> type="radio" id="checkStatus3" value="Blocked">
                      <?=form_label('Blocked','checkStatus3',['class'=>'custom-control-label'])?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <?=form_label('KYC Status','kyc_status',['class'=>'col-form-label'])?>
                <div class="row mt-2">
                  <div class="col-3">
                    <div class="custom-control custom-checkbox">
                      <input class="custom-control-input checkbox-style " name="kyc_status" <?= ($kyc_status == 'Pending') ? 'checked' : '' ?> type="radio" id="checkStatus4" value="Pending">
                      <?=form_label('Pending','checkStatus4',['class'=>'custom-control-label'])?>
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="custom-control custom-checkbox">
                      <input class="custom-control-input checkbox-style " name="kyc_status" <?= ($kyc_status == 'Approved') ? 'checked' : '' ?> type="radio" id="checkStatus5" value="Approved">
                      <?=form_label('Approved','checkStatus5',['class'=>'custom-control-label'])?>
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="custom-control custom-checkbox">
                      <input class="custom-control-input checkbox-style " name="kyc_status" <?= ($kyc_status == 'Rejected') ? 'checked' : '' ?> type="radio" id="checkStatus6" value="Rejected">
                      <?=form_label('Rejected','checkStatus6',['class'=>'custom-control-label'])?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row justify-content-start">
              <?php if(!empty($access) || ($user_type != "Role User") ){?>
              <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
              <?php } ?>
            </div>
            <?=form_close()?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
      <?php if(!empty($cityid)){?>
    getCities(<?=!empty($stateid)?$stateid:''?>,<?=$cityid?>)
    <?php } ?>
  function getCities(id,cityvalue){
  $('#city').html('');
  $.ajax({
  url: '<?= base_url('getCities') ?>',
  method: 'POST',
  data: { state_id: id ,city:cityvalue},
  success: function (response) {
      $('#city').html(response);
  }
  });
  }
  
  <?php if(!empty($business_city_id)){?>
    getBusinessCities(<?=!empty($business_state_id)?$business_state_id:''?>,<?=$business_city_id?>)
    <?php } ?> 
    
  function getBusinessCities(id,cityvalue){
  $('#business_city_id').html('');
  $.ajax({
  url: '<?= base_url('getCities') ?>',
  method: 'POST',
  data: { state_id: id ,city:cityvalue},
  success: function (response) {
      $('#business_city_id').html(response);
  }
  });
  }
</script>