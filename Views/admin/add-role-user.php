<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb" class="d-flex flex-row justify-content-between ">
      <ol class="breadcrumb" >
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
                <h4 class="cardhdng">Add Role Users</h4>
                <a href="<?= base_url(ADMINPATH . 'role-user-list') ?>" class="sitebtn">View Role Users</a>
            </div>   
            <form>
              <input type="hidden" id="role_user_id" value="<?=$id?>">
              <div class="row mb-3">
                <div class="col-sm-4">
                  <?=form_label('User Name','user_name',['class'=>'col-form-label'])?>
                  <input type="text" name="user_name" autocomplete="off" value="<?=$user_name?>"  class="form-control ucwords restrictedInput" required id="user_name" placeholder="User Name" />
                </div>
                <div class="col-sm-4">
                  <?=form_label('User Email','user_email',['class'=>'col-form-label'])?>
                  <input type="email" name="user_email" autocomplete="off" value="<?=$user_email?>"  class="form-control emailInput" required id="user_email" placeholder="User Email" />
                </div>
                <div class="col-sm-4">
                  <?=form_label('User Phone','user_phone',['class'=>'col-form-label'])?>
                  <input type="text" name="user_phone" autocomplete="off" value="<?=$user_phone?>" maxlength="10"  class="form-control numbersWithZeroOnlyInput" required id="user_phone" placeholder="User Phone" />
                </div>
                <?php  /*
                <div class="col-sm-3">
                  <?=form_label('Password','enc_password',['class'=>'col-form-label'])?>
                  <input type="password" name="enc_password" autocomplete="off" value="<?=$enc_password?>"   class="form-control" required id="enc_password" placeholder="Password" />
                </div>
                */ ?>
                
              </div>
              <div class="row mb-3">
                <?=form_label('Status','status',['class'=>'col-sm-2 col-form-label'])?>
                <div class="col-sm-6">
                  <div class="row mt-2">
                    <div class="col-3">
                      <div class="custom-control custom-checkbox">
                        <input class="custom-control-input checkStatus" name="status" <?= ($status == 'Active') ? 'checked' : '' ?> type="radio" id="checkStatus1" value="Active">
                        <?=form_label('Active','checkStatus1',['class'=>'custom-control-label'])?>
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="custom-control custom-checkbox">
                        <input class="custom-control-input checkStatus" name="status" <?= ($status == 'Inactive') ? 'checked' : '' ?> type="radio" id="checkStatus2" value="Inactive">
                        <?=form_label('Inactive','checkStatus2',['class'=>'custom-control-label'])?>
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="custom-control custom-checkbox">
                        <input class="custom-control-input checkStatus" name="status" <?= ($status == 'Blocked') ? 'checked' : '' ?> type="radio" id="checkStatus3" value="Blocked">
                        <?=form_label('Blocked','checkStatus3',['class'=>'custom-control-label'])?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row justify-content-start">
                  <?php if(!empty($access) || ($user_type != "Role User") ){?>
                <div class="col-sm-10">
                  <button type="button" onclick="return validateUser()" id="submit" class="btn btn-primary">Submit</button>
                </div>
                <?php } ?>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
   function validateUser() {
   var id = $('#role_user_id').val();
   var user_name =$('#user_name').val();
   var user_email =$('#user_email').val();
   var user_phone =$('#user_phone').val();
   var status= $('.checkStatus:checked').val();

   if (user_name=="") {
     toastr.error("Please Enter User Name");
     return false;
   } else if (user_email == "") {
     toastr.error("Please Enter User Email");
     return false;
   } else if (user_phone == "") {
     toastr.error("Please Enter User Phone");
     return false;
   } else if (user_phone.length < 10) {
     toastr.error("Please Enter A Valid 10 Digit Number");
     return false;
   } else {
     
         $.ajax({
           url: '<?= base_url(ADMINPATH.'save-role-user') ?>',
           type: 'POST',
           data: {
             'id': id,
             'user_name': user_name,
             'user_email': user_email,
             'user_phone': user_phone,
             'status':status
           },
           cache: false,
           dataType: "json",
           beforeSend: function() {
              $('#submit').prop('disabled', true).text('Please Wait...');
           },
           success: function(response) {
             if (response.status === false) {
               toastr.error(response.message);
             } else if (response.status === true) {
               $('#submit').addClass('disabled');
               toastr.success(response.message);
               setTimeout(function() {
                 window.location.href = response.url;
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