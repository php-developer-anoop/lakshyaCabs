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
        <li class="breadcrumb-item active"><?=$maintitle?></li>
      </ol>
    </nav>
    <div class="row">
      <div class="col-xxl">
        <div class="card mb-4">
          <div class="card-body">
              <div class="dflexbtwn hdngvwall">
                    <h4 class="cardhdng">Add Drive</h4>
                    <a href="<?= base_url(ADMINPATH . 'why-choose-drive') ?>" class="sitebtn">View Reasons</a>
              </div>     
              <form>
                  <input type="hidden" id="drive_id" value="<?=$id?>">
                <div class="row mb-3">
                
                  <div class="col-sm-4">
                    <?=form_label('Title','title',['class'=>'col-form-label'])?>
                    <input type="text" name="title" autocomplete="off" value="<?=$title?>"  class="form-control ucwords" required id="title" placeholder="Title" />
                  </div>
                  
                  <div class="col-sm-8">
                  <?=form_label('Description','description',['class'=>'col-form-label'])?>
                    <input type="text" name="description" autocomplete="off" value="<?=$description?>"  class="form-control" required id="descript" placeholder="Description" />
                  </div>
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
                    </div>
                  </div>
                </div>
                <div class="row justify-content-start">
                     <?php if(!empty($access) || ($user_type != "Role User") ){?>
                  <div class="col-sm-10">
                    <button type="button" onclick="return validateDrive()" id="submit" class="btn btn-primary">Submit</button>
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
   function validateDrive() {
   var id = $('#drive_id').val();
   var title =$('#title').val();
   var description =$('#descript').val();
   var status= $('.checkStatus:checked').val();

   if (title=="") {
     toastr.error("Please Enter Title");
     return false;
   } else if (description == "") {
     toastr.error("Please Enter Description");
     return false;
   } else {
     
         $.ajax({
           url: '<?= base_url(ADMINPATH.'save-drive') ?>',
           type: 'POST',
           data: {
             'id': id,
             'title': title,
             'description': description,
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