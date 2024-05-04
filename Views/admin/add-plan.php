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
                <h4 class="cardhdng">Add Plan</h4>
                <a href="<?= base_url(ADMINPATH . 'plan-list') ?>" class="sitebtn">View Plans</a>
            </div>    
            <form>
              <input type="hidden" id="amount_id" value="<?=$id?>">
              <div class="row mb-3">
                <?=form_label('Amount','amount',['class'=>'col-sm-2 col-form-label'])?>
                <div class="col-sm-3">
                  <input type="text" name="amount" autocomplete="off" value="<?=$amount?>" maxlength="5" class="form-control numbersWithZeroOnlyInput" required id="amount" placeholder="Amount" />
                </div>
                <?=form_label('Cashback Amount','cashback_amount',['class'=>'col-sm-2 col-form-label'])?>
                <div class="col-sm-3">
                  <input type="text" name="cashback_amount" autocomplete="off" value="<?=$cashback_amount?>" maxlength="5"  class="form-control numbersWithZeroOnlyInput" required id="cashback_amount" placeholder="Cashback Amount" />
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
                  <button type="button" onclick="return validatePlan()" id="submit" class="btn btn-primary">Submit</button>
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
   function validatePlan() {
   var id = $('#amount_id').val();
   var amount =$('#amount').val();
   var cashback_amount =$('#cashback_amount').val();
   var status= $('.checkStatus:checked').val();

   if (amount=="") {
     toastr.error("Please Enter Amount");
     return false;
   } else {
     
         $.ajax({
           url: '<?= base_url(ADMINPATH.'save-plan') ?>',
           type: 'POST',
           data: {
             'id': id,
             'amount': amount,
             'cashback_amount': cashback_amount,
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