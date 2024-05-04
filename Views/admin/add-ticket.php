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
              <h4 class="cardhdng"><?=$title?></h4>
              <a href="<?= base_url(ADMINPATH . 'subject-list') ?>" class="sitebtn">View List</a>
            </div>
            <form>
              <input type="hidden" id="ticket_id" value="<?=$id?>">
              <div class="row mb-3">
                <div class="col-sm-4">
                  <?=form_label('Subject Name','subject_name',['class'=>'col-form-label'])?>
                  <input type="text" name="subject_name" autocomplete="off" value="<?=$subject_name?>"  class="form-control ucwords restrictedInput" required id="subject_name" placeholder="Subject Name" />
                </div>
               
              
                
                <div class="col-sm-6">
                    <?=form_label('Status','status',['class'=>'col-form-label'])?>
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
                  </div>
                </div>
              </div>
              <div class="row justify-content-start">
                <?php if(!empty($access) || ($user_type != "Role User") ){?>
                <div class="col-sm-10">
                  <button type="button" onclick="return validateTicket()" id="submit" class="btn btn-primary">Submit</button>
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
  function validateTicket() {
  var id = $('#ticket_id').val();
  var subject_name =$('#subject_name').val();
  var status= $('.checkStatus:checked').val();
  
  if (subject_name=="") {
    toastr.error("Please Enter Subject Name");
    return false;
  } else {
    
        $.ajax({
          url: '<?= base_url(ADMINPATH.'save-ticket') ?>',
          type: 'POST',
          data: {
            'id': id,
            'subject_name': subject_name,
            'status':status
          },
          cache: false,
          dataType: "json",
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