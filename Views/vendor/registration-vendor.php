<?=view(VENDORPATH.'includes/top-links')?>
<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme customtopnav" id="layout-navbar">
  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
    <i class="bx bx-menu bx-sm"></i>
    </a>
  </div>
  <div class="navbar-nav-right d-flex align-items-center justify-content-between" id="navbar-collapse">
    <div class="logotoggle">
      <div class="hdrlogo">
        <a href="<?=base_url()?>">
        <img src="<?=$logo?>">
        </a>
      </div>
    </div>
  </div>
</nav>
<section class="tutorPage-Mainsec">
  <?php if(!empty($vendor['kyc_status']) && ($vendor['pan_image']!="") && ($vendor['gst_image']!="") && ($vendor['aadhaar_front']!="") && ($vendor['aadhaar_back']!="") && ($vendor['kyc_status']!="Approved")){?>
  <div class="alert alert-warning w-100 " role="alert">
    <h4>Thank you for submitting your KYC. Once your KYC is approved, we will notify you via email or sms.</h4>
  </div>
  <?php } ?>
  <div class="card">
    <div class="col-md-12 col-lg-12 row mx-auto">
      <div class="col-md-2 col-lg-2">
        <div class="col-md-12 col-lg-12 mx-auto side-forminfo">
          <div class="tab tutortabs">
            <button class="tablinks tutor-btn <?=!empty($vendor['form_step']) && ($vendor['form_step'] == "1")?"active":""?>" id="personal" <?= !empty($vendor) && (($vendor['form_step']>=1) || ($vendor['form_step']==''))?'':'disabled'?> onclick="return formStep(<?=!empty($vendor['form_step'])?$vendor['form_step']:''?>,1,'upload','personal','business')">
              <span class="icon">
              <i class="fa-solid fa-id-card"></i>
              </span>
              <span class="Information">
                Basic Info<br />
                <p class="tutors">Enter Basic Details</p>
              </span>
            </button>
            <button class="tablinks tutor-btn <?=!empty($vendor['form_step']) && ($vendor['form_step'] == "2")?"active":""?>" id="business" <?=!empty($vendor) && (($vendor['form_step']>=2) || ($vendor['form_step']==''))?'':'disabled'?> onclick="return formStep(<?=!empty($vendor['form_step'])?$vendor['form_step']:''?>,2,'personal','business','upload')">
              <span class="icon">
              <i class="fa-solid fa-car"></i>
              </span>
              <span class="Information">
                Business Info<br />
                <p class="tutors">Enter Business Details</p>
              </span>
            </button>
            <button class="tablinks tutor-btn <?=!empty($vendor['form_step']) && ($vendor['form_step'] == "3")?"active":""?>" id="upload" <?=!empty($vendor) && (($vendor['form_step']>=3) || ($vendor['form_step']==''))?'':'disabled'?> onclick="return formStep(<?=!empty($vendor['form_step'])?$vendor['form_step']:''?>,3,'business','upload','personal')">
              <span class="icon">
              <i class="fa-regular fa-address-card"></i>
              </span>
              <span class="Information">
                Upload KYC <br />
                <p class="tutors">Upload Document</p>
              </span>
            </button>
          </div>
        </div>
      </div>
      <div class="col-md-10 col-lg-10 mx-auto  m-0 p-0">
        <div id="form" class="registersect">
          <div id="Personal" class="tabcontent <?=!empty($vendor['form_step']) && ($vendor['form_step'] == "1")?"active":""?>">
            <h3>Basic Info</h3>
            <div class="mb-3">
              <div class="row">
                <div class="col-md-6 col-lg-4">
                  <label>Full Name</label>
                  <input type="text" class="form-control ucwords restrictedInput" autocomplete="off" required
                    name="full_name" id="full_name" placeholder="Full Name" value="<?=!empty($vendor['full_name'])?$vendor['full_name']:''?>">
                </div>
                <div class="col-md-6 col-lg-4">
                  <label>Mobile Number</label>
                  <input type="text" class="form-control numbersWithZeroOnlyInput" autocomplete="off" required
                    name="mobile_no" id="mobile_no" placeholder="Mobile Number" maxlength="10" minlength="10" value="<?=!empty($vendor['mobile_no'])?$vendor['mobile_no']:''?>">
                </div>
                <div class="col-md-6 col-lg-4">
                  <div class="wrapper-section">
                    <div class="col-md-12 row">
                      <div class="col-md-5">
                        <div class="image-preview" id="imagePreview">
                          <img src="<?=empty($vendor['profile_image'])?base_url('assets/vendor/images/imgdemo.png'):base_url('uploads/'.$vendor['profile_image'])?>" class="img-fluid">
                        </div>
                      </div>
                      <div class="col-md-7 p-0 Imgupload-section">
                        <div class="my-3 uploadPic">
                          <h3>Upload Profile Pic</h3>
                          <p class="lastlable">Max 1 mb. JPEG , JPG or PNG format.</p>
                          <input type="file" class="file-browser" id="fileInput" accept="image/jpg,image/jpeg,image/png" >
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-lg-4">
                  <label>Email ID</label>
                  <input type="email" class="form-control emailOnly" required
                    name="email_id" id="email_id" placeholder="Email Id" autocomplete="off" value="<?=!empty($vendor['email_id'])?$vendor['email_id']:''?>">
                </div>
                <div class="row p-0 m-0 mt-4 mb-1">
                  <div class="col-md-6 col-lg-4">
                    <label>State</label>
                    <select class="form-select select2" id="state" aria-label="Default select example" onchange="getCities(this.value,<?=!empty($vendor['state_id'])?$vendor['state_id']:''?>)">
                      <option value="">Select State</option>
                      <?php if(!empty($state_list)){foreach($state_list as $slkey=>$slvalue){?>
                      <option value="<?=$slvalue['id'].','.$slvalue['state_name']?>" <?=!empty($vendor['state_id']) && ($vendor['state_id']==$slvalue['id'])?"selected":""?>><?=$slvalue['state_name']?></option>
                      <?php }} ?>
                    </select>
                  </div>
                  <div class="col-md-6 col-lg-4">
                    <label>City</label>
                    <select class="form-select select2" aria-label="Default select example" id="city">
                      <option value="">Select City</option>
                    </select>
                  </div>
                </div>
                <div class="row p-0 m-0  mt-4">
                  <div class="col-md-6 col-lg-4">
                    <label>Full Address</label>
                    <textarea class="form-control" name="address" placeholder="Full Address" id="address" rows="4" style="resize:none"><?=!empty($vendor['address'])?$vendor['address']:''?></textarea>
                  </div>
                  <div class="col-md-6 col-lg-4">
                    <label>Pincode</label>
                    <input type="text" class="form-control numbersWithZeroOnlyInput" required
                      name="pincode" autocomplete="off" id="pincode" placeholder="Pincode" maxlength="6" minlength="6" value="<?=!empty($vendor['pincode'])?$vendor['pincode']:''?>">
                  </div>
                </div>
                <div class="col-md-12 col-lg-12 d-flex justify-content-end">
                  <p>
                    <a class="Forminfo-btn btnNext" href="javascript:void(0)" onclick="return saveBasicDetails('Business','Personal')">Save</a>
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div id="Business" class="tabcontent <?=!empty($vendor['form_step']) && ($vendor['form_step'] == "2")?"active":""?>">
            <h3>Business Information</h3>
            <div class="mb-3">
              <div class="row">
                <div class="col-md-6 col-lg-4">
                  <label>Business name</label>
                  <input type="text" class="form-control ucwords restrictedInput" required
                    name="business_name" placeholder="Business name" id="business_name" autocomplete="off" value="<?=!empty($vendor['business_name'])?$vendor['business_name']:''?>">
                </div>
                <div class="col-md-6 col-lg-4">
                  <label>Registered As</label>
                  <select class="form-select select2" aria-label="Default select example" id="business_registered_as">
                    <option value="">Select option</option>
                    <option value="Individual" <?=!empty($vendor['business_registered_as']) && ($vendor['business_registered_as'] == "Individual")?"selected":''?>>Individual</option>
                    <option value="Private Limited" <?=!empty($vendor['business_registered_as']) && ($vendor['business_registered_as'] == "Private Limited")?"selected":''?>>Private Limited</option>
                    <option value="Sole Proprietor" <?=!empty($vendor['business_registered_as']) && ($vendor['business_registered_as'] == "Sole Proprietor")?"selected":''?>>Sole Proprietor</option>
                    <option value="LLP" <?=!empty($vendor['business_registered_as']) && ($vendor['business_registered_as'] == "LLP")?"selected":''?>>LLP</option>
                  </select>
                </div>
                <div class="col-md-6 col-lg-4">
                  <div class="wrapper-section ">
                    <div class="col-md-12 row">
                      <div class="col-md-6">
                        <div class="image-preview" id="imagePreview2">
                          <img src="<?=empty($vendor['business_logo'])?base_url('assets/vendor/images/imgdemo.png'):base_url('uploads/'.$vendor['business_logo'])?>" class="img-fluid"> 
                        </div>
                      </div>
                      <div class="col-md-6 Imgupload-section">
                        <div class="my-3 uploadPic">
                          <h3>Upload Business Logo</h3>
                          <p class="lastlable">Max 1 mb. JPEG , JPG or PNG format.</p>
                          <input type="file" class="file-browser-2" id="fileInput2" accept="image/jpg,image/jpeg,image/png">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row p-0 m-0 mb-1">
                  <div class="col-md-6 col-lg-4">
                    <label>State</label>
                    <select class="form-select select2" aria-label="Default select example" id="business_state" onchange="getBusinessCities(this.value,<?=!empty($vendor['business_state_id'])?$vendor['business_state_id']:''?>)">
                      <option value="">Select State</option>
                      <?php if(!empty($state_list)){foreach($state_list as $slkey=>$slvalue){?>
                      <option value="<?=$slvalue['id'].','.$slvalue['state_name']?>" <?=!empty($vendor['business_state_id']) && ($vendor['business_state_id']==$slvalue['id'])?"selected":""?>><?=$slvalue['state_name']?></option>
                      <?php }} ?>
                    </select>
                  </div>
                  <div class="col-md-6 col-lg-4" >
                    <label>City</label>
                    <select class="form-select select2" aria-label="Default select example" id="business_city_id">
                      <option value="">Select City</option>
                    </select>
                  </div>
                </div>
                <div class="row p-0 m-0 mt-4">
                  <div class="col-md-6 col-lg-4">
                    <label>Registered Business Address</label>
                    <div class="">
                      <textarea class="form-control" placeholder="Registered Business Address" id="business_address" style="resize:none"><?=!empty($vendor['business_address'])?$vendor['business_address']:''?></textarea>
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-4">
                    <label>Pincode</label>
                    <input type="text" class="form-control numbersWithZeroOnlyInput" required
                      name="Pincode" id="business_pincode" placeholder="Pincode" maxlength="6" minlength="6" autocomplete="off" value="<?=!empty($vendor['business_pincode'])?$vendor['business_pincode']:''?>">
                  </div>
                </div>
                <div class="row p-0 m-0 mt-4">
                  <div class="col-md-6 col-lg-4">
                    <label>Pan</label>
                    <input type="text" class="form-control uppercase" autocomplete="off" id="business_pan_no" required name="Pan"
                      placeholder="Enter PAN" maxlength="10" minlength="10" value="<?=!empty($vendor['business_pan_no'])?$vendor['business_pan_no']:''?>">
                  </div>
                  <div class="col-md-6 col-lg-4">
                    <label>GST IN</label>
                    <input type="text" class="form-control uppercase" required
                      name="Enter GSTID" maxlength="15" minlength="15" placeholder="Enter GSTID" autocomplete="off" id="business_gst_no" value="<?=!empty($vendor['business_gst_no'])?$vendor['business_gst_no']:''?>">
                  </div>
                </div>
                <div class="row my-4 mx-auto responsive-btn">
                  <div class="d-flex justify-content-between">
                    <a class="priv-btniwin" href="javascript:void(0)" onclick="return previousStep(<?=!empty($vendor['form_step'])?$vendor['form_step']:''?>,2,'personal','business','upload')">
                    Previous</a>
                    <a class="Forminfo-btn btnNext" href="javascript:void(0)" id="savebusiness" onclick="return saveBusinessDetails('Upload','Business')">     Save  </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="Upload" class="tabcontent <?=!empty($vendor['form_step']) && ($vendor['form_step'] == "3")?"active":""?>">
            <h3>Upload KYC Document</h3>
            <div class="mb-3  mt-5 row justify-content-between">
              <div class="col-md-12 ">
                <div class="wrapper-section ">
                  <div class="row">
                    <div class="col-md-12 col-lg-6">
                      <div class="col-md-6">
                        <div class="my-3  uploadPic">
                          <h3>Upload Aadhar front</h3>
                          <p class="lastlable">Max 1 mb. JPEG , JPG or PNG format.</p>
                          <input type="file" class="file-browser-3" id="fileInput3" accept="image/jpg,image/jpeg,image/png" onchange="return imageUpload(event,<?=!empty($vendor['id'])?$vendor['id']:''?>,'aadhaar_front','<?=!empty($vendor['aadhaar_front'])?$vendor['aadhaar_front']:''?>')">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="image-preview mt-4" id="imagePreview3">
                          <img src="<?=empty($vendor['aadhaar_front'])?base_url('assets/vendor/images/imgdemo.png'):base_url('uploads/'.$vendor['aadhaar_front'])?>" class="img-fluid"> 
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                      <div class="col-md-6">
                        <div class="my-3  uploadPic">
                          <h3>Upload Aadhar back</h3>
                          <p class="lastlable">Max 1 mb. JPEG , JPG or PNG format.</p>
                          <input type="file" class="file-browser-4" id="fileInput4" accept="image/jpg,image/jpeg,image/png" onchange="return imageUpload(event,<?=!empty($vendor['id'])?$vendor['id']:''?>,'aadhaar_back','<?=!empty($vendor['aadhaar_back'])?$vendor['aadhaar_back']:''?>')">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="image-preview " id="imagePreview4">
                          <img src="<?=empty($vendor['aadhaar_back'])?base_url('assets/vendor/images/imgdemo.png'):base_url('uploads/'.$vendor['aadhaar_back'])?>" class="img-fluid"> 
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row mt-5">
                    <div class="col-md-12 col-lg-6">
                      <div class="col-md-6">
                        <div class="my-3  uploadPic">
                          <h3>Upload PAN</h3>
                          <p class="lastlable">Max 1 mb. JPEG , JPG or PNG format.</p>
                          <input type="file" class="file-browser-5" id="fileInput5" accept="image/jpg,image/jpeg,image/png" onchange="return imageUpload(event,<?=!empty($vendor['id'])?$vendor['id']:''?>,'pan_image','<?=!empty($vendor['pan_image'])?$vendor['pan_image']:''?>')">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="image-preview mt-4" id="imagePreview5" >
                          <img src="<?=empty($vendor['pan_image'])?base_url('assets/vendor/images/imgdemo.png'):base_url('uploads/'.$vendor['pan_image'])?>" class="img-fluid"> 
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                      <div class="col-md-6">
                        <div class="my-3  uploadPic">
                          <h3>Upload GST</h3>
                          <p class="lastlable">Max 1 mb. JPEG , JPG or PNG format.</p>
                          <input type="file" class="file-browser-6" id="fileInput6" accept="image/jpg,image/jpeg,image/png" onchange="return imageUpload(event,<?=!empty($vendor['id'])?$vendor['id']:''?>,'gst_image','<?=!empty($vendor['gst_image'])?$vendor['gst_image']:''?>')">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="image-preview " id="imagePreview6">
                          <img src="<?=empty($vendor['gst_image'])?base_url('assets/vendor/images/imgdemo.png'):base_url('uploads/'.$vendor['gst_image'])?>" class="img-fluid"> 
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row my-4 mx-auto responsive-btn">
                  <div class="d-flex justify-content-between">
                    <a class="priv-btniwin" href="javascript:void(0)" onclick="return previousStep(<?=!empty($vendor['form_step'])?$vendor['form_step']:''?>,3,'business','upload','personal')">
                    Previous</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-12 col-md-12 pb-5 px-3 row mx-auto responsive-btn d-none">
            <div class="col-md-6 col-sm-6 d-flex justify-content-start previous-btn">
              <div class="col-md-12 col-lg-12 d-flex justify-content-start">
                <p>
                  <a class="priv-btniwin btnPrevious" href="javascript:void(0)">
                  Previous</a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
    <?php if(!empty($vendor['city_id'])){?>
    getCities(<?=!empty($vendor['state_id'])?$vendor['state_id']:''?>,<?=$vendor['city_id']?>)
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
  
  <?php if(!empty($vendor['business_city_id'])){?>
    getBusinessCities(<?=!empty($vendor['business_state_id'])?$vendor['business_state_id']:''?>,<?=$vendor['business_city_id']?>)
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
  
  function saveBasicDetails(nextTab, previousTab) {
    var full_name = $('#full_name').val().trim();
    var mobile_no = $('#mobile_no').val().trim();
    var email_id = $('#email_id').val().trim();
    var state = $('#state').val();
    var city = $('#city').val();
    var address = $('#address').val().trim();
    var pincode = $('#pincode').val().trim();
    var profile_image = $('#fileInput')[0].files[0];

    // Validation
    if (full_name === "") {
        toastr.error("Please Enter Your Full Name");
        return false;
    }
    if (mobile_no === "") {
        toastr.error("Please Enter Your Mobile Number");
        return false;
    }
    if (mobile_no.length !== 10 || isNaN(mobile_no)) {
        toastr.error("Please Enter A Valid 10-Digit Mobile Number");
        return false;
    }
    if (email_id === "") {
        toastr.error("Please Enter Your Email Address");
        return false;
    }
    if (state === "") {
        toastr.error("Please Select Your State");
        return false;
    }
    if (city === "") {
        toastr.error("Please Select Your City");
        return false;
    }
    if (address === "") {
        toastr.error("Please Enter Your Full Address");
        return false;
    }
    if (pincode === "") {
        toastr.error("Please Enter Your Pincode");
        return false;
    }
    if (profile_image) {
       
        var fileName = profile_image.name;
        var fileExtension = fileName.split('.').pop().toLowerCase();
        var allowedExtensions = ['jpg', 'jpeg', 'png'];
        var maxSize = 1 * 1024 * 1024;

        if ($.inArray(fileExtension, allowedExtensions) === -1) {
            toastr.error('Invalid file type! Please select a JPG, JPEG or PNG file.');
            return false;
        } else if (profile_image.size > maxSize) {
            toastr.error('Please Select A File Less Than 1 Mb');
            return false;
        }
    }

    var formData = new FormData();
    formData.append('profile_image', profile_image);
    formData.append('full_name', full_name);
    formData.append('mobile_no', mobile_no);
    formData.append('email_id', email_id);
    formData.append('state', state);
    formData.append('city', city);
    formData.append('address', address);
    formData.append('pincode', pincode);
    // AJAX Submission
    $.ajax({
        url: '<?= base_url(VENDORPATH.'saveBasicDetails') ?>',
        method: 'POST',
        dataType: 'json',
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: () => {
            $('#savebasic').prop('disabled',true).text('Please Wait...');
         },
        success: function(response) {
            if (response.status == true) {
                toastr.success(response.message);
                
                $('#' + nextTab).addClass('active');
                $('#' + firstLetterToLowerCase(nextTab)).addClass('active');
                $('#' + previousTab).removeClass('active');
                $('#' + firstLetterToLowerCase(previousTab)).removeClass('active');
                 $('#savebasic').prop('disabled',true).text('Please Wait...');
                 setTimeout(function() {
                    window.location.reload();
                }, 1000);
            } else {
                toastr.error(response.message);
                return false;
            }
        },
        error: function(xhr, status, error) {
            toastr.error("Error occurred while processing your request. Please try again later.");
        }
    });
}

  
  function firstLetterToLowerCase(str) {
    return str.replace(/\b\w/g, function(char) {
        return char.toLowerCase();
    });
} 
 function firstLetterToUpperCase(str) {
    return str.replace(/\b\w/g, function(char) {
        return char.toUpperCase();
    });
}

   function imageUpload(e, vendor_id, type, old_image) {
    var file = e.target.files[0];
    if (file) {
        var fileName = file.name;
        var fileExtension = fileName.split('.').pop().toLowerCase();
        var allowedExtensions = ['jpg', 'jpeg', 'png'];
        var maxSize = 1 * 1024 * 1024; 

        if ($.inArray(fileExtension, allowedExtensions) === -1) {
            toastr.error('Invalid file type! Please select a JPG, JPEG or PNG file.');
            $(e.target).val('');
            return;
        } else if (file.size > maxSize) {
            toastr.error('Please Select A File Less Than 1 Mb');
            $(e.target).val('');
            return;
        }
    } else {
        toastr.error('No file selected.');
        return;
    }

    var formData = new FormData();
    formData.append('image', file);
    formData.append('vendor_id', vendor_id);
    formData.append('type', type);
    formData.append('old_image', old_image);

    $.ajax({
        url: '<?= base_url(VENDORPATH.'save-image') ?>',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            toastr.success('Image Uploaded successfully');
             $(e.target).val('');
        },
        error: function (xhr, status, error) {
            console.log('Upload error: ' + error);
        }
    });
}

function saveBusinessDetails(nextTab, previousTab){
    var business_name = $('#business_name').val().trim();
    var business_registered_as = $('#business_registered_as').val();
    var business_state = $('#business_state').val();
    var business_city_id = $('#business_city_id').val();
    var business_address = $('#business_address').val().trim();
    var business_pincode = $('#business_pincode').val().trim();
    var business_pan_no = $('#business_pan_no').val().trim();
    var business_gst_no = $('#business_gst_no').val().trim();
    var business_logo = $('#fileInput2')[0].files[0];

    // Validation
    if (business_name === "") {
        toastr.error("Please Enter Your Business Name");
        return false;
    }
    if (business_registered_as === "") {
        toastr.error("Please Select Business Registered Type");
        return false;
    }
    if (business_state === "") {
        toastr.error("Please Select Your Business State");
        return false;
    }
    if (business_city_id === "") {
        toastr.error("Please Select Your Business City");
        return false;
    }
    if (business_address === "") {
        toastr.error("Please Enter Your Full Business Address");
        return false;
    }
    if (business_pincode === "") {
        toastr.error("Please Enter Your Business Pincode");
        return false;
    }
    if (business_pan_no == "") {
        toastr.error("Please Enter Business Pan Number");
        return false;
    }
    if (business_gst_no === "") {
        toastr.error("Please Enter Your Business GST Number");
        return false;
    }
    if (business_logo) {
        var fileName = business_logo.name;
        var fileExtension = fileName.split('.').pop().toLowerCase();
        var allowedExtensions = ['jpg', 'jpeg', 'png'];
        var maxSize = 1 * 1024 * 1024;

        if ($.inArray(fileExtension, allowedExtensions) === -1) {
            toastr.error('Invalid file type! Please select a JPG, JPEG or PNG file.');
            return false;
        } else if (business_logo.size > maxSize) {
            toastr.error('Please Select A File Less Than 1 Mb');
            return false;
        }
    }

    var formData = new FormData();
    formData.append('business_logo', business_logo);
    formData.append('business_name', business_name);
    formData.append('business_registered_as', business_registered_as);
    formData.append('business_state', business_state);
    formData.append('business_city_id', business_city_id);
    formData.append('business_address', business_address);
    formData.append('business_pincode', business_pincode);
    formData.append('business_pan_no', business_pan_no);
    formData.append('business_gst_no', business_gst_no);
    // AJAX Submission
    $.ajax({
        url: '<?= base_url(VENDORPATH.'saveBusinessDetails') ?>',
        method: 'POST',
        dataType: 'json',
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: () => {
            $('#savebusiness').prop('disabled',true).text('Please Wait...');
         },
        success: function(response) {
            if (response.status == true) {
                toastr.success(response.message);
                $('#' + nextTab).addClass('active');
                $('#' + firstLetterToLowerCase(nextTab)).addClass('active');
                $('#' + previousTab).removeClass('active');
                $('#' + firstLetterToLowerCase(previousTab)).removeClass('active');
                $('#savebusiness').prop('disabled',false).text('Save');
                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            } else {
                $('#savebusiness').prop('disabled',false).text('Save');
                toastr.error(response.message);
                return false;
            }
        },
        error: function(xhr, status, error) {
            toastr.error("Error occurred while processing your request. Please try again later.");
        }
    });
}

function formStep(form_step_id, current_id, previous_tab,current_tab, next_tab) {
    //previous_tab = previous_tab == "" ?current_tab:previous_tab;
    if (form_step_id >= current_id) {
        $('#' + previous_tab).removeClass('active');
        $('#' + firstLetterToUpperCase(previous_tab)).removeClass('active');
        $('#' + current_tab).addClass('active');
        $('#' + firstLetterToUpperCase(current_tab)).addClass('active');
        $('#' + next_tab).removeClass('active');
        $('#' + firstLetterToUpperCase(next_tab)).removeClass('active');
    }
}

function previousStep(form_step_id, current_id, previous_tab,current_tab, next_tab) {
    previous_tab = previous_tab == "" ?current_tab:previous_tab;
    if (form_step_id >= current_id) {
        $('#' + previous_tab).addClass('active');
        $('#' + firstLetterToUpperCase(previous_tab)).addClass('active');
        $('#' + current_tab).removeClass('active');
        $('#' + firstLetterToUpperCase(current_tab)).removeClass('active');
        $('#' + next_tab).removeClass('active');
        $('#' + firstLetterToUpperCase(next_tab)).removeClass('active');
    }
}


</script>
<?=view(VENDORPATH.'includes/footer')?>