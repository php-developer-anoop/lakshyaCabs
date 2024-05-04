<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="javascript:void(0);">Home</a>
        </li>
        <li class="breadcrumb-item active"><?=$title?></li>
      </ol>
    </nav>
    <div class="row">
      <div class="col-xxl">
        <div class="card mb-4">
          <div class="card-body">
            <?=form_open_multipart(ADMINPATH . 'save-setting'); ?>
            <?=form_hidden('id',!empty($web['id'])?$web['id']:"")?>
            <?=form_hidden('old_logo',!empty($web['logo'])?$web['logo']:"")?>
            <?=form_hidden('old_favicon',!empty($web['favicon'])?$web['favicon']:"")?>
            <div class="row mb-3">
              <div class="col-sm-3">
                <label class="col-form-label" for="basic-default-name">Company Name</label>
                <input type="text" name="company_name" value="<?=!empty($web['company_name']) ? $web['company_name']:''?>" class="form-control ucwords restrictedInput" required id="basic-default-name" placeholder="Company Name" />
              </div>
              <div class="col-sm-3">
                <label class="col-form-label" for="basic-default-company">Care Mobile No.</label>
                <input type="text" name="care_mobile_no" value="<?=!empty($web['care_mobile']) ? $web['care_mobile']:''?>" class="form-control notzero numbersWithZeroOnlyInput" minlength="10" required  maxlength="10" id="basic-default-company phone-mask" placeholder="Care Mobile No." />
              </div>
              <div class="col-sm-3">
                <label class="col-form-label" for="basic-default-phone">Care Whatsapp No.</label>
                <div class="input-group input-group-merge">
                  <input type="text" name="care_whatsapp_no" value="<?=!empty($web['care_whatsapp_no']) ? $web['care_whatsapp_no']:''?>" id="basic-default-phone" maxlength="10" minlength="10" required class="form-control phone-mask notzero numbersWithZeroOnlyInput" placeholder="Care Whatsapp No." aria-label="Care Whatsapp No." aria-describedby="basic-default-phone" />
                </div>
              </div>
              <div class="col-sm-3">
                <label class="col-form-label" for="basic-default-email">Care Email Id</label>
                <input type="email" name="care_email_id" id="basic-default-email" value="<?=!empty($web['care_email']) ? $web['care_email']:''?>" required class="form-control emailInput" placeholder="Care Email Id" aria-label="Care Email Id" aria-describedby="basic-default-email" />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-3">
                <label class="col-form-label" for="facebook_link">Facebook Link</label>
                <input type="text" name="facebook_link" value="<?=!empty($web['facebook_link']) ? $web['facebook_link']:''?>" class="form-control" required id="facebook_link" placeholder="Facebook Link" />
              </div>
              <div class="col-sm-3">
                <label class="col-form-label" for="twitter_x_link">Twitter Link</label>
                <input type="text" name="twitter_x_link" value="<?=!empty($web['twitter_x_link']) ? $web['twitter_x_link']:''?>" class="form-control" required id="twitter_x_link" placeholder="Twitter Link" />
              </div>
              <div class="col-sm-3">
                <label class="col-form-label" for="youtube_link">Youtube Link</label>
                <input type="text" name="youtube_link" value="<?=!empty($web['youtube_link']) ? $web['youtube_link']:''?>" class="form-control" required id="youtube_link" placeholder="Youtube Link" />
              </div>
              <div class="col-sm-3">
                <label class="col-form-label" for="instagram_link">Instagram Link</label>
                <input type="text" name="instagram_link" value="<?=!empty($web['instagram_link']) ? $web['instagram_link']:''?>" class="form-control" required id="instagram_link" placeholder="Instagram Link" />
              </div>
            </div>
            <div class="row mb-3">
              <!--<div class="col-sm-3">-->
              <!--  <label class="col-form-label" for="user_app_link">User App Link</label>-->
              <!--  <input type="text" name="user_app_link" value="<?php //!empty($web['user_app_link']) ? $web['user_app_link']:''?>" class="form-control" required id="user_app_link" placeholder="User App Link" />-->
              <!--</div>-->
              <div class="col-sm-3">
                <label class="col-form-label" for="gst_no">GST Number</label>
                <input type="text" name="gst_no" value="<?=!empty($web['gst_no']) ? $web['gst_no']:''?>" class="form-control" required id="gst_no" placeholder="GST Number" />
              </div>
              <div class="col-sm-3">
                <label class="col-form-label" for="pan_no">PAN Number</label>
                <input type="text" name="pan_no" value="<?=!empty($web['pan_no']) ? $web['pan_no']:''?>" class="form-control" required id="pan_no" placeholder="PAN Number" />
              </div>
              <div class="col-sm-9">
                <label class="col-form-label" for="office_address">Office Address</label>
                <input type="text" name="office_address" value="<?=!empty($web['office_address']) ? $web['office_address']:''?>" required id="office_address" class="form-control" placeholder="Office Address" aria-label="Office Address" aria-describedby="basic-icon-default-message2"></textarea>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="map_script">Map Script</label>
              <div class="col-sm-10">
                <textarea  name="map_script" required id="map_script" class="form-control" placeholder="Office Address" aria-label="Office Address" aria-describedby="basic-icon-default-message2"><?=!empty($web['map_script']) ? $web['map_script']:''?></textarea>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-4">
                <label class="col-form-label" for="logo">Logo</label>
                <input type="file" name="logo" class="form-control" <?=empty($web['logo'])?"required":""?> id="logo"  accept="image/png, image/jpg, image/jpeg" />
              </div>
              <?php if(!empty($web['logo'])){?>
              <div class="col-sm-2">
                <img src="<?= base_url('uploads/') . $web['logo']; ?>" height="70px" width="100px" alt="Logo">
              </div>
              <?php } ?>
              <div class="col-sm-4">
                <label class="col-form-label" for="favicon">Favicon</label>
                <input type="file" name="favicon" class="form-control" <?php //empty($web['favicon'])?"required":""?> id="favicon" accept="image/png, image/jpg, image/jpeg"  />
              </div>
              <?php if(!empty($web['favicon'])){?>
              <div class="col-sm-2">
                <img src="<?= base_url('uploads/') . $web['favicon']; ?>" height="70px" width="100px" alt="Logo">
              </div>
              <?php } ?>
            </div>
            <div class="row justify-content-start">
              <?php if(!empty($access) || ($user_type!="Role User")){?>
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