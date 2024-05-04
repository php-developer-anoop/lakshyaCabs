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
              <a href="<?= base_url(ADMINPATH . 'customer-master-list') ?>" class="sitebtn">View Customer List</a>
            </div>
            <?=form_open_multipart(ADMINPATH . 'save-customer'); ?>
            <?=form_hidden('id',$id)?>
            <?=form_hidden('old_profile_image',$profile_image)?>
            <h4>Basic Details</h4>
            <div class="row mb-3">
              <div class="col-sm-3">
                <?=form_label('Full Name','name',['class'=>'col-form-label'])?>
                <input type="text" class="form-control ucwords restrictedInput" autocomplete="off" required
                  name="name" id="name" placeholder="Full Name" value="<?=$name?>">
              </div>
              <div class="col-sm-3">
                <?=form_label('Mobile Number','mobile_no',['class'=>'col-form-label'])?>
                <input type="text" class="form-control numbersWithZeroOnlyInput" autocomplete="off" required
                  name="mobile_no" id="mobile_no" placeholder="Mobile Number" maxlength="10" minlength="10" value="<?=$mobile_no?>">
              </div>
              <div class="col-sm-3">
                <?=form_label('Email ID','email_id',['class'=>'col-form-label'])?>
                <input type="email" class="form-control emailOnly" required
                  name="email" id="email" placeholder="Email Id" autocomplete="off" value="<?=$email?>">
              </div>
              <div class="col-sm-3">
                <?=form_label('Select State','state_id',['class'=>'col-form-label'])?>
                <select class="form-select select2" name="state_id" id="state_id" aria-label="Default select example" onchange="getCities(this.value,<?=!empty($stateid)?$stateid:''?>)">
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
                <?=form_label('Pincode','pin_code',['class'=>'col-form-label'])?>
                <input type="text" class="form-control numbersWithZeroOnlyInput" required
                  name="pin_code" id="pin_code" maxlength="6" minlength="6" placeholder="Pincode" autocomplete="off" value="<?=$pin_code?>">
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
            <h4>Company Details</h4>
            <div class="row mb-3">
              <div class="col-sm-3">
                <?=form_label('Company name','full_name',['class'=>'col-form-label'])?>
                <input type="text" class="form-control ucwords restrictedInput" autocomplete="off"
                  name="company_name" id="company_name" placeholder="Company name" value="<?=$company_name?>">
              </div>
              <div class="col-sm-3">
                <?=form_label('Company Pan Number','company_pan_number',['class'=>'col-form-label'])?>
                <input type="text" class="form-control uppercase" 
                  name="company_pan_number" id="company_pan_number" maxlength="10" placeholder="Company Pan Number" autocomplete="off" value="<?=$company_pan_number?>">
              </div>
              <div class="col-sm-3">
                <?=form_label('Company GST Number','gstin_number',['class'=>'col-form-label'])?>
                <input type="text" class="form-control uppercase" 
                  name="gstin_number" id="gstin_number" maxlength="15" placeholder="Company GST Number" autocomplete="off" value="<?=$gstin_number?>">
              </div>
              <div class="col-sm-3">
                <?=form_label('Select Company State','company_state',['class'=>'col-form-label'])?>
                <select class="form-select select2" name="company_state" id="company_state" aria-label="Default select example" onchange="getCompanyCities(this.value,<?=!empty($company_state)?$company_state:''?>)">
                  <option value="">Select State</option>
                  <?php if(!empty($state_list)){foreach($state_list as $slkey=>$slvalue){?>
                  <option value="<?=$slvalue['id'].','.$slvalue['state_name']?>" <?=!empty($company_state) && ($company_state==$slvalue['id'])?"selected":""?>><?=$slvalue['state_name']?></option>
                  <?php }} ?>
                </select>
              </div>
              <div class="col-sm-3">
                <?=form_label('Select Company City','company_city',['class'=>'col-form-label'])?>
                <select class="form-select select2" name="company_city" id="company_city" aria-label="Default select example" >
                  <option value="">Select Company City</option>
                </select>
              </div>
              <div class="col-sm-3">
                <?=form_label('Company Address','company_address',['class'=>'col-form-label'])?>
                <input type="text" class="form-control" 
                  name="company_address" id="company_address" placeholder="Company Address" autocomplete="off" value="<?=$company_address?>">
              </div>
              
              <div class="col-sm-3">
                <?=form_label('Company Pincode','company_pin_code',['class'=>'col-form-label'])?>
                <input type="text" class="form-control numbersWithZeroOnlyInput" 
                  name="company_pin_code" id="company_pin_code" maxlength="6" minlength="6" placeholder="Company Pincode" autocomplete="off" value="<?=$company_pin_code?>">
              </div>
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
<?php if(!empty($cityid)){ ?>
    getCities(<?= !empty($stateid) ? $stateid : '' ?>, <?= $cityid ?>)
<?php } ?>

function getCities(id, cityvalue){
    $('#city').html('');
    $.ajax({
        url: '<?= base_url('getCities') ?>',
        method: 'POST',
        data: { state_id: id, city: cityvalue },
        success: function (response) {
            $('#city').html(response);
        }
    });
}

<?php if(!empty($company_city)){ ?>
    getCompanyCities(<?= !empty($company_state) ? $company_state : '' ?>, <?= $company_city ?>)
<?php } ?>

function getCompanyCities(id, cityvalue){
    $('#company_city').html('');
    $.ajax({
        url: '<?= base_url('getCities') ?>',
        method: 'POST',
        data: { state_id: id, city: cityvalue },
        success: function (response) {
            $('#company_city').html(response);
        }
    });
}

</script>