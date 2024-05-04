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
              <a href="<?= base_url(ADMINPATH . 'driver-list') ?>" class="sitebtn">View Driver List</a>
            </div>
            <?=form_open_multipart( $post_url ); ?>
            <?=form_hidden('id',$id)?>
            <?=form_hidden('login_id',$login_id)?>
            <?=form_hidden('old_profile_image',$profile_image)?>
            <?=form_hidden('old_rc_file',$rc_file)?>
            <?=form_hidden('old_dl_file',$dl_file)?>
            <?=form_hidden('old_ic_file',$ic_file)?> 
            <?=form_hidden('old_aadhaar_front_file',$aadhaar_front_file)?> 
            <?=form_hidden('old_aadhaar_back_file',$aadhaar_back_file)?> 
            <h4>Basic Details</h4>
            <div class="row mb-3">
              <div class="col-sm-3">
                <?=form_label('Select Vendor','partner_id',['class'=>'col-form-label'])?>
                <select class="form-select select2" name="partner_id" id="partner_id" required aria-label="Default select example">
                  <option value="">Select Vendor</option>
                  <?php if(!empty($vendor_list)){foreach($vendor_list as $slkey=>$slvalue){?>
                  <option value="<?=$slvalue['id'].','.$slvalue['business_name']?>" <?=!empty($partner_id) && ($partner_id==$slvalue['id'])?"selected":""?>><?=$slvalue['mobile_no'].', '.$slvalue['full_name'].', '.$slvalue['business_name']?></option>
                  <?php }} ?>
                </select>
              </div>
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
                <?=form_label('Alt. Mobile Number','alt_mobile_no',['class'=>'col-form-label'])?>
                <input type="text" class="form-control numbersWithZeroOnlyInput" autocomplete="off" required
                  name="alt_mobile_no" id="alt_mobile_no" placeholder="Alt. Mobile Number" maxlength="10" minlength="10" value="<?=$alt_mobile_no?>">
              </div>
              <div class="col-sm-3">
                <?=form_label('Email ID','email_id',['class'=>'col-form-label'])?>
                <input type="email" class="form-control emailOnly" required
                  name="email_id" id="email_id" placeholder="Email Id" autocomplete="off" value="<?=$email_id?>">
              </div>
              <div class="col-sm-3">
                <?=form_label('Select State','state',['class'=>'col-form-label'])?>
                <select class="form-select select2" name="state_id" id="state" aria-label="Default select example" onchange="getCities(this.value,<?=!empty($state_id)?$state_id:''?>)">
                  <option value="">Select State</option>
                  <?php if(!empty($state_list)){foreach($state_list as $slkey=>$slvalue){?>
                  <option value="<?=$slvalue['id'].','.$slvalue['state_name']?>" <?=!empty($state_id) && ($state_id==$slvalue['id'])?"selected":""?>><?=$slvalue['state_name']?></option>
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
                <?=form_label('Aadhaar Number','aadhaar_no',['class'=>'col-form-label'])?>
                <input type="text" class="form-control numbersWithZeroOnlyInput" autocomplete="off" id="aadhaar_no" required name="aadhaar_no"
                  placeholder="Enter Aadhaar Number" maxlength="12" minlength="12" value="<?=$aadhaar_no?>">
              </div>
              <div class="col-sm-6">
                <?=form_label('Address','address',['class'=>'col-form-label'])?>
                <input type="text" class="form-control" required
                  name="address" id="address" placeholder="Address" autocomplete="off" value="<?=$address?>">
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
            <h4>Login Details</h4>
            <div class="row mb-3">
              <div class="col-sm-3">
                <?=form_label('Login ID','login_id',['class'=>'col-form-label'])?>
                <input type="text" class="form-control" autocomplete="off" required
                  name="login_id" id="login_id" placeholder="Enter Login ID" maxlength="50" value="<?=$login_id?>">
              </div>
              <div class="col-sm-3">
                <?=form_label('Password','password',['class'=>'col-form-label'])?>
                <input type="text" class="form-control emailOnly" required
                  name="password" id="password" placeholder="Password" autocomplete="off" value="<?=$password?>">
              </div>
            </div>
            <h4>Document Details</h4>
            <div class="row mb-3">
              <div class="col-sm-3">
                <?=form_label('Aadhaar Front','aadhaar_front_file',['class'=>'col-form-label'])?>
                <?= form_upload([
                  'name' => 'aadhaar_front_file',
                  'class' => 'form-control',
                  'accept' => 'image/png, image/jpg, image/jpeg'
                  ]); ?>
              </div>
              <?php if(!empty($aadhaar_front_file)){?>
              <div class="col-sm-3 mt-2"> <a href="<?= base_url('uploads/') . $aadhaar_front_file; ?>" target="_blank"><img src="<?= base_url('uploads/') . $aadhaar_front_file; ?>" height=70px width=100px></a></div>
              <?php } ?>
              <div class="col-sm-3">
                <?=form_label('Aadhaar Back','aadhaar_back_file',['class'=>'col-form-label'])?>
                <?= form_upload([
                  'name' => 'aadhaar_back_file',
                  'class' => 'form-control',
                  'accept' => 'image/png, image/jpg, image/jpeg'
                  ]); ?>
              </div>
              <?php if(!empty($aadhaar_back_file)){?>
              <div class="col-sm-3 mt-2"> <a href="<?= base_url('uploads/') . $aadhaar_back_file; ?>" target="_blank"><img src="<?= base_url('uploads/') . $aadhaar_back_file; ?>" height=70px width=100px></a></div>
              <?php } ?>
            </div>
            <div class="row mb-3">
              <div class="col-sm-3">
                <?=form_label('Registration Certificate','rc_file',['class'=>'col-form-label'])?>
                <?= form_upload([
                  'name' => 'rc_file',
                  'class' => 'form-control',
                  'accept' => 'image/png, image/jpg, image/jpeg'
                  ]); ?>
              </div>
              <?php if(!empty($rc_file)){?>
              <div class="col-sm-3 mt-2"> <a href="<?= base_url('uploads/') . $rc_file; ?>" target="_blank"><img src="<?= base_url('uploads/') . $rc_file; ?>" height=70px width=100px></a></div>
              <?php } ?> 
              <div class="col-sm-3">
                <?=form_label('Driving Licence','dl_file',['class'=>'col-form-label'])?>
                <?= form_upload([
                  'name' => 'dl_file',
                  'class' => 'form-control',
                  'accept' => 'image/png, image/jpg, image/jpeg'
                  ]); ?>
              </div>
              <?php if(!empty($dl_file)){?>
              <div class="col-sm-3 mt-2"> <a href="<?= base_url('uploads/') . $dl_file; ?>" target="_blank"><img src="<?= base_url('uploads/') . $dl_file; ?>" height=70px width=100px></a></div>
              <?php } ?> 
              <div class="col-sm-3">
                <?=form_label('Insurance Certificate','ic_file',['class'=>'col-form-label'])?>
                <?= form_upload([
                  'name' => 'ic_file',
                  'class' => 'form-control',
                  'accept' => 'image/png, image/jpg, image/jpeg'
                  ]); ?>
              </div>
              <?php if(!empty($ic_file)){?>
              <div class="col-sm-3 mt-2"> <a href="<?= base_url('uploads/') . $ic_file; ?>" target="_blank"><img src="<?= base_url('uploads/') . $ic_file; ?>" height=70px width=100px></a></div>
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
  <?php if (!empty($cityid)) { ?>
    getCities(<?= !empty($stateid) ? $stateid : '' ?>, <?= $cityid ?>)
<?php } ?>

function getCities(id, cityvalue) {
    $('#city').html('');
    $.ajax({
        url: '<?= base_url('getCities') ?>',
        method: 'POST',
        data: { state_id: id, city: cityvalue },
        success: function(response) {
            $('#city').html(response);
        }
    });
}

<?php if (!empty($business_city_id)) { ?>
    getBusinessCities(<?= !empty($business_state_id) ? $business_state_id : '' ?>, <?= $business_city_id ?>)
<?php } ?>

function getBusinessCities(id, cityvalue) {
    $('#business_city_id').html('');
    $.ajax({
        url: '<?= base_url('getCities') ?>',
        method: 'POST',
        data: { state_id: id, city: cityvalue },
        success: function(response) {
            $('#business_city_id').html(response);
        }
    });
}

</script>