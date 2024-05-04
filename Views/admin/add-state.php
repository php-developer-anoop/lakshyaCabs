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
                        <h4 class="cardhdng">Add State</h4>
                        <a href="<?= base_url(ADMINPATH . 'state-list') ?>" class="sitebtn">View List</a>
                </div>
                <form>
                    <input type="hidden" id="state_id" value="<?=$id?>">
                    <div class="row mb-3">
                      <div class="col-sm-4">
                         <?=form_label('State Name','state_name',['class'=>'col-form-label'])?>
                         <input type="text" name="state_name" autocomplete="off" value="<?=$state_name?>"  class="form-control ucwords restrictedInput" required id="state_name" placeholder="State Name" />
                      </div>
                      <div class="col-sm-4">
                        <?=form_label('State Code','state_code',['class'=>'col-form-label'])?>
                        <input type="text" name="state_code" autocomplete="off" value="<?=$state_code?>"  class="form-control restrictedInput" required id="state_code" placeholder="State Code" />
                      </div>
                    </div>
                    <div class="row mb-3">
                      <?=form_label('Status','status',['class'=>'col-form-label'])?>
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
                        <button type="button" onclick="return validateState()" id="submit" class="btn btn-primary">Submit</button>
                      </div>
                      <?php } ?>
                    </div>
                </form>
                <div class="mt-5">
                   <h4 class="cardhdng">Recent Entry</h4>
                </div>
                <div class="table-responsive text-nowrap">
                  <table id="tabless" class="table mb-0">
                      <thead>
                          <tr>
                              <th>Sr. No.</th>
                              <th>State Name</th>
                              <th>State Code</th>
                              <th>Status</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr>
                              <td>1</td>
                              <td>Delhi</td>
                              <td>DL</td>
                              <td>
                                  <div class="form-check form-switch">
                                      <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                                      <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                  </div>
                              </td>
                              <td>
                                  <a href="javascript:void(0)" class="btn actnbtn btn-orange" title=""><i class="tf-icons bx bx-edit"></i></a>
                                  <a class="btn actnbtn btn-red" href="javascript:void(0)"><i class="tf-icons bx bx-trash"></i></a>
                              </td>
                          </tr>
                          <tr>
                              <td>2</td>
                              <td>Rajasthan</td>
                              <td>RJ</td>
                              <td>
                                  <div class="form-check form-switch">
                                      <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                                      <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                  </div>
                              </td>
                              <td>
                                  <a href="javascript:void(0)" class="btn actnbtn btn-orange" title=""><i class="tf-icons bx bx-edit"></i></a>
                                  <a class="btn actnbtn btn-red" href="javascript:void(0)"><i class="tf-icons bx bx-trash"></i></a>
                              </td>
                          </tr>
                          <tr>
                              <td>3</td>
                              <td>Haryana</td>
                              <td>HR</td>
                              <td>
                                  <div class="form-check form-switch">
                                      <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                                      <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                  </div>
                              </td>
                              <td>
                                  <a href="javascript:void(0)" class="btn actnbtn btn-orange" title=""><i class="tf-icons bx bx-edit"></i></a>
                                  <a class="btn actnbtn btn-red" href="javascript:void(0)"><i class="tf-icons bx bx-trash"></i></a>
                              </td>
                          </tr>
                          <tr>
                              <td>4</td>
                              <td>Uttar Pradesh</td>
                              <td>UP</td>
                              <td>
                                  <div class="form-check form-switch">
                                      <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                                      <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                  </div>
                              </td>
                              <td>
                                  <a href="javascript:void(0)" class="btn actnbtn btn-orange" title=""><i class="tf-icons bx bx-edit"></i></a>
                                  <a class="btn actnbtn btn-red" href="javascript:void(0)"><i class="tf-icons bx bx-trash"></i></a>
                              </td>
                          </tr>
                      </tbody>
                  </table>
                </div>
          </div> 
        </div>
      </div>
    </div>
  </div>
</div>

<script>



   function validateState() {
   var id = $('#state_id').val();
   var stateName =$('#state_name').val();
   var stateCode =$('#state_code').val();
   var status= $('.checkStatus:checked').val();

   if (stateName=="") {
     toastr.error("Please Enter State Name");
     return false;
   } else if (stateCode == "") {
     toastr.error("Please Enter State Code");
     return false;
   } else {
     
         $.ajax({
           url: '<?= base_url(ADMINPATH.'save-state') ?>',
           type: 'POST',
           data: {
             'id': id,
             'state_name': stateName,
             'state_code': stateCode,
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