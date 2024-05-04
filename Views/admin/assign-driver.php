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
                <h4 class="cardhdng">Assign Driver</h4>
            </div>
            <div class="form-bkdtls">
                <div class="drivrform">
                        <div class="row mb-3 mw75">
                          <div class="col-sm-12 mb-3">
                                <div class="row mt-2">
                                    <input type="hidden" id="register_type" value="register" />
                                   <div class="col-5">
                                       <div class="custom-control custom-checkbox">
                                          <input class="custom-control-input" name="status" checked="" type="radio" id="checkStatus1" value="Active" onClick="checkDriverType( 'register' )">
                                          <label for="checkStatus1" class="custom-control-label">Registered User</label>                   
                                       </div>
                                   </div>
                                   <div class="col-5">
                                        <div class="custom-control custom-checkbox">
                                           <input class="custom-control-input" name="status" type="radio" id="checkStatus2" value="Inactive" onClick="checkDriverType( 'non' )">
                                           <label for="checkStatus2" class="custom-control-label">Non registered User</label>                     
                                        </div>
                                   </div>
                                </div>
                          </div>
                          <div class="col-sm-6 mb-3 register">
                            <label class="col-form-label"> Vendor Name</label>
                            <select name="category" id="partner_id" class="form-control select22 " required >
                                <option value="">--Select vendor--</option>
                                <?php if(!empty($vendor_list)){
                                    foreach($vendor_list as $key=>$value ){ $is_selected = $value['id'] == $list['partner_id'] ? 'selected' : '';
                                        echo '<option value="'.$value['id'].'" '.$is_selected.'>'.$value['unique_id'].' | '.$value['mobile_no'].' | '.$value['business_name'].'</option>';
                                    }
                                }?> 
                            </select>
                          </div>
                          <div class="col-sm-6 mb-3 register">
                            <label class="col-form-label"> Driver Name</label>
                            <select name="category" id="category" class="form-control select2" required>
                              <option value="">--Select driver--</option>
                            </select>
                          </div>
                          <div class="col-sm-12 mb-3 register">
                            <div class="dflex">
                               <label class="col-form-label"> Current Status</label>
                               <span class="driverstatus">On Duty</span>
                            </div>
                          </div>
                          
                          <div class="col-sm-6 mb-3 non_register" style="display:none">
                            <label class="col-form-label"> Driver Name</label>
                            <input type="text" name="model_name" autocomplete="off" onkeyup=""  class="form-control" required id="" placeholder="Driver mobile number" />
                          </div> 
                          
                          <div class="col-sm-6 mb-3">
                            <label class="col-form-label"> Contact Number</label>
                            <input type="text" name="model_name" autocomplete="off" onkeyup=""  class="form-control" required id="" placeholder="Driver mobile number" />
                          </div> 
                          
                          <div class="col-sm-6 mb-3">
                            <label class="col-form-label"> Vehicle number</label>
                            <input type="text" name="model_name" autocomplete="off" onkeyup=""  class="form-control" required id="" placeholder="Enter vehicle number" />
                          </div>
                          <div class="col-sm-10">
                            <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                          </div>
                    </div>
                </div>
                
                <div class="bkngdtls">
                    <h4>Booking Details</h4>
                    <div class="bkngtxts">
                        <div class="dflexbtwn bordrbtm">
                            <h6>Booking Number:</h6>
                            <h3><?=$list['booking_id'];?></h3>
                        </div>
                        <div class="dflexbtwn">
                            <h4>Customer Number:</h4>
                            <h4><?=$list['guest_name'];?></h4>
                        </div>
                        <div class="dflexbtwn">
                            <h4>Trip Type:</h4>
                            <h4><?=ucwords($list['trip_type']);?></h4>
                        </div>
                        <div class="dflexbtwn">
                            <h4>Pickup date & time:</h4>
                            <h4><?=date('d/M/Y, h:i A',strtotime($list['pickup_date_time']));?></h4>
                        </div>
                        <div class="dflexbtwn">
                            <h4>Pickup Address:</h4>
                            <h4><?=$list['pickup_city_name'];?></h4>
                        </div>
                        <div class="dflexbtwn">
                            <h4>Drop off/Package:</h4>
                            <h4><?=($list['trip_type']=='Local' ? $list['package_name'] : $list['drop_city_name']);?></h4>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
     function getDriverList(){
         var partner_id = $('#partner_id').val();
         alert( partner_id );
         $.ajax({
             type:'POST',
             url:'<?=base_url('admin/get-driver-drop-down-list')?>',
             data:'',
             success: function( res ){
                 alert( res );
             }
             
         })
     }
     
     function checkDriverType( type ){
         $('#register_type').val( type );
         if(type == 'register'){ 
            $('.register').show(); 
            $('.non_register').hide(); 
         }else if(type =='non'){
            $('.register').hide(); 
            $('.non_register').show();
         }
     }
      
     
     <?php if(!empty($list['driver_mobile_no'])){?>
     var driverType = '<?=($list['driver_id']== 0  ? 'non' : 'register' )?>';
     checkDriverType( driverType );
     <?php } ?> 
</script>