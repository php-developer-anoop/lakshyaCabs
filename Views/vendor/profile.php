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
            <div class="form-bkdtls">
              <div class="row mb-3">
                <div class="col-sm-3 mb-3">
                  <label class="col-form-label" for="unique_id">Unique ID</label>
                  <input type="text" name="unique_id" autocomplete="off" value="<?=!empty($profile['unique_id'])?$profile['unique_id']:''?>" readonly  class="form-control ucwords restrictedInput" required id="unique_id" placeholder="Unique ID" />
                </div>
                <div class="col-sm-3 mb-3">
                  <label class="col-form-label" for="full_name">Full Name</label>
                  <input type="text" name="full_name" autocomplete="off" value="<?=!empty($profile['full_name'])?$profile['full_name']:''?>" readonly  class="form-control ucwords restrictedInput" required id="full_name" placeholder="Unique ID" />
                </div>
                <div class="col-sm-3 mb-3">
                  <label class="col-form-label" for="mobile_no">Mobile Number</label>
                  <input type="text" name="mobile_no" autocomplete="off" value="<?=!empty($profile['mobile_no'])?$profile['mobile_no']:''?>" readonly class="form-control numbersWithZeroOnlyInput" maxlength="10" required id="mobile_no" placeholder="Driver Mobile" />
                </div>
                <div class="col-sm-3 mb-3">
                  <label class="col-form-label" for="email_id">Email ID</label>
                  <input type="text" name="email_id" autocomplete="off" value="<?=!empty($profile['email_id'])?$profile['email_id']:''?>" readonly class="form-control alphanum uppercase" maxlength="12" required id="email_id" placeholder="Vehicle No." />
                </div>
                <div class="col-sm-3 mb-3">
                  <label class="col-form-label" for="state_name">State</label>
                  <input type="text" name="state_name" autocomplete="off" value="<?=!empty($profile['state_name'])?$profile['state_name']:''?>" readonly class="form-control alphanum uppercase" maxlength="12" required id="state_name" placeholder="Vehicle No." />
                </div>
                <div class="col-sm-3 mb-3">
                  <label class="col-form-label" for="city_name">City</label>
                  <input type="text" name="city_name" autocomplete="off" value="<?=!empty($profile['city_name'])?$profile['city_name']:''?>" readonly class="form-control alphanum uppercase" maxlength="12" required id="city_name" placeholder="Vehicle No." />
                </div>
                <div class="col-sm-3 mb-3">
                  <label class="col-form-label" for="address">Address</label>
                  <input type="text" name="address" autocomplete="off" value="<?=!empty($profile['address'])?$profile['address']:''?>" readonly class="form-control alphanum uppercase" maxlength="12" required id="address" placeholder="Vehicle No." />
                </div>
                <div class="col-sm-3 mb-3">
                  <label class="col-form-label" for="pincode">Pincode</label>
                  <input type="text" name="pincode" autocomplete="off" value="<?=!empty($profile['pincode'])?$profile['pincode']:''?>" readonly class="form-control alphanum uppercase" maxlength="12" required id="pincode" placeholder="Vehicle No." />
                </div>
                <div class="col-sm-3 mb-3">
                  <label class="col-form-label" for="business_name">Business Name</label>
                  <input type="text" name="business_name" autocomplete="off" value="<?=!empty($profile['business_name'])?$profile['business_name']:''?>" readonly class="form-control alphanum uppercase" maxlength="12" required id="business_name" placeholder="Vehicle No." />
                </div>
                <div class="col-sm-3 mb-3">
                  <label class="col-form-label" for="business_registered_as">Business Type</label>
                  <input type="text" name="business_registered_as" autocomplete="off" value="<?=!empty($profile['business_registered_as'])?$profile['business_registered_as']:''?>" readonly class="form-control alphanum uppercase" maxlength="12" required id="business_registered_as" placeholder="Vehicle No." />
                </div>
                <div class="col-sm-3 mb-3">
                  <label class="col-form-label" for="business_state_name">Business State</label>
                  <input type="text" name="business_state_name" autocomplete="off" value="<?=!empty($profile['business_state_name'])?$profile['business_state_name']:''?>" readonly class="form-control alphanum uppercase" maxlength="12" required id="business_state_name" placeholder="Vehicle No." />
                </div>
                <div class="col-sm-3 mb-3">
                  <label class="col-form-label" for="business_city_name">Business City</label>
                  <input type="text" name="business_city_name" autocomplete="off" value="<?=!empty($profile['business_city_name'])?$profile['business_city_name']:''?>" readonly class="form-control alphanum uppercase" maxlength="12" required id="business_city_name" placeholder="Vehicle No." />
                </div>
                <div class="col-sm-3 mb-3">
                  <label class="col-form-label" for="business_address">Business Address</label>
                  <input type="text" name="business_address" autocomplete="off" value="<?=!empty($profile['business_address'])?$profile['business_address']:''?>" readonly class="form-control alphanum uppercase" maxlength="12" required id="business_name" placeholder="Vehicle No." />
                </div>
                <div class="col-sm-3 mb-3">
                  <label class="col-form-label" for="business_pincode">Business Pincode</label>
                  <input type="text" name="business_pincode" autocomplete="off" value="<?=!empty($profile['business_pincode'])?$profile['business_pincode']:''?>" readonly class="form-control alphanum uppercase" maxlength="12" required id="business_pincode" placeholder="Vehicle No." />
                </div>
                <div class="col-sm-3 mb-3">
                  <label class="col-form-label" for="business_pan_no">Business Pan Number</label>
                  <input type="text" name="business_pan_no" autocomplete="off" value="<?=!empty($profile['business_pan_no'])?$profile['business_pan_no']:''?>" readonly class="form-control alphanum uppercase" maxlength="12" required id="business_pan_no" placeholder="Vehicle No." />
                </div>
                <div class="col-sm-3 mb-3">
                  <label class="col-form-label" for="business_gst_no">Business GST Number</label>
                  <input type="text" name="business_gst_no" autocomplete="off" value="<?=!empty($profile['business_gst_no'])?$profile['business_gst_no']:''?>" readonly class="form-control alphanum uppercase" maxlength="12" required id="business_gst_no" placeholder="Vehicle No." />
                </div>
                <div class="col-sm-3">
                  <label class="col-form-label" for="profile_image">Profile Image</label>
                  <?php if(!empty($profile['profile_image'])){?>
                  <a href="<?=base_url('uploads/'.$profile['profile_image'])?>"><img src="<?=base_url('uploads/'.$profile['profile_image'])?>" height="100px" width="100px"/></a>
                  <?php } ?>
                </div>
                <div class="col-sm-3">
                  <label class="col-form-label" for="business_logo">Business Logo</label>
                  <?php if(!empty($profile['business_logo'])){?>
                  <a href="<?=base_url('uploads/'.$profile['business_logo'])?>"><img src="<?=base_url('uploads/'.$profile['business_logo'])?>" height="100px" width="100px"/></a>
                  <?php } ?>
                </div>
                <div class="col-sm-3">
                  <label class="col-form-label" for="aadhaar_front">Aadhaar Front</label>
                  <?php if(!empty($profile['aadhaar_front'])){?>
                  <a href="<?=base_url('uploads/'.$profile['aadhaar_front'])?>"><img src="<?=base_url('uploads/'.$profile['aadhaar_front'])?>" height="100px" width="100px"/></a>
                  <?php } ?>
                </div>
                <div class="col-sm-3">
                  <label class="col-form-label" for="aadhaar_back">Aadhaar Back</label>
                  <?php if(!empty($profile['aadhaar_back'])){?>
                  <a href="<?=base_url('uploads/'.$profile['aadhaar_back'])?>"><img src="<?=base_url('uploads/'.$profile['aadhaar_back'])?>" height="100px" width="100px"/></a>
                  <?php } ?>
                </div>
                <div class="col-sm-3 mt-2">
                  <label class="col-form-label" for="pan_image">PAN Image</label>
                  <?php if(!empty($profile['pan_image'])){?>
                  <a href="<?=base_url('uploads/'.$profile['pan_image'])?>"><img src="<?=base_url('uploads/'.$profile['pan_image'])?>" height="100px" width="100px"/></a>
                  <?php } ?>
                </div>
                <div class="col-sm-3 mt-2">
                  <label class="col-form-label" for="gst_image">GST Image</label>
                  <?php if(!empty($profile['gst_image'])){?>
                  <a href="<?=base_url('uploads/'.$profile['gst_image'])?>"><img src="<?=base_url('uploads/'.$profile['gst_image'])?>" height="100px" width="100px"/></a>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>