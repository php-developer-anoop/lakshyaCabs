<style>
.datefld {
    position: relative;
}
</style>
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
              <div class="dflexbtwn hdngvwall">
            <h5>1). Calender Booking Condition </h5>
            <a href="<?= base_url(ADMINPATH . 'booking-conditions-list') ?>" class="sitebtn">View</a>
            </div>
            <?=form_open_multipart(ADMINPATH . 'save-calender-booking-conditions'); ?> 
                 
                    <?=form_hidden('id',$id)?>
                    <div class="plusminus">
                    <div class="row mb-3 append_wrap">
                        
                    <div class="col-sm-2">
                      <label class="col-form-label" for="from_date">From Date</label>
                      <input type="date" name="key[0][from_date]" value="<?=$from_date?>" class="form-control datefld" required id="from_date"  />
                    </div>  
                    
                    
                   <div class="col-sm-2">
                      <label class="col-form-label" for="to_date">To Date</label>
                      <input type="date" name="key[0][to_date]" value="<?=$to_date?>" class="form-control datefld" required id="to_date" />
                   </div> 
                       
                       
                      <div class="col-sm-2">
                          <label class="col-form-label" for="state_id">Select State</label>
                          <select name="key[0][state_id]" id="state_id" class="form-control select2" required >
                            <option value="">--Select State--</option>
                            <?php 
                            if(!empty($state_list)){
                              foreach ($state_list as $key => $value) { ?>
                            <option <?php if( $value['id'] == $state_id ){echo 'selected';}?> value="<?=!empty($value['id']) ? $value['id'] : ""?>"><?=!empty($value['state_name']) ? $value['state_name'] : ""?></option>  
                            <?php  } }?>
                          </select>
                      </div>
                      
                      <div class="col-sm-2">
                          <label class="col-form-label" for="trip_type">Trip Type</label>
                          <select name="key[0][trip_type]" id="trip_type" class="form-control select2" required > 
                            <?php if(!empty($trip_type_list)){
                              foreach ($trip_type_list as $key => $value) { ?>
                                 <option <?php if( $value['trip_type'] == $trip_type ){echo 'selected';}?> value="<?=!empty($value['trip_type']) ? $value['trip_type'] : ""?>"><?=!empty($value['trip_type']) ? $value['trip_type'] : ""?></option>  
                            <?php }} ?>
                          </select>
                      </div>
                          
               
              
                        <div class="col-sm-2">
                          <label class="col-form-label" for="charge_type" >Charge Type</label>
                          <select name="key[0][charge_type]" id="charge_type" class="form-control select2" required > 
                             <option <?php if($charge_type == 'increase' ){echo 'selected';}?> value="increase">Increase</option>  
                             <option <?php if($charge_type == 'decrease' ){echo 'selected';}?> value="decrease">Decrease</option> 
                          </select>
                        </div>
                      
                      
                        <div class="col-sm-2">
                          <label class="col-form-label" for="charge_value_type" >Charge Value Type</label>
                          <select name="key[0][charge_value_type]" id="charge_value_type" class="form-control select2" required > 
                             <option <?php if($charge_value_type == 'percent' || $charge_value_type == '' ){echo 'selected';}?> value="percent">Percent</option>  
                             <option <?php if($charge_value_type == 'fixed' ){echo 'selected';}?> value="fixed">Fixed</option> 
                          </select>
                        </div> 
               
              
                      <div class="col-sm-2">
                        <label class="col-form-label" for="charge_value">Charge Value</label>
                        <input type="text" name="key[0][charge_value]" value="<?=$charge_value?>" class="form-control numbersOnly" required id="charge_value" placeholder="enter value" />
                      </div> 
                      
                      <div class="col-sm-2">
                        <label class="col-form-label" for="status">Status</label>
                        <select name="key[0][status]" id="status" class="form-control select2" required > 
                             <option <?php if($status == 'Active' || $status == '' ){echo 'selected';}?> value="Active">Active</option>  
                             <option <?php if($status == 'Inactive' ){echo 'selected';}?> value="Inactive">Inactive</option> 
                          </select>
                      </div>  
                     
                       
                      <?php if(empty($id)){?>
                        <div class="col-sm-2"> 
                            <div style="margin-top: 40px;">
                                <a href="javascript:void(0);" id="addBlock" class="add_button1 btn btn-success" title="Add field"><i class="bx bx-plus"></i></a>
                                <a style="display:none" id="removeBlock" href="javascript:void(0);" class="remove_button1 btn btn-danger" title="Remove field"><i class="bx bx-minus"></i></a>
                            </div>
                        </div>
                      <?php } ?>
                      </div> 
                    </div>
                   
                    <div class="col-sm-3" style="margin-top:40px">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    
           
              
            <?=form_close()?>
          </div>
        </div>
         
        
      </div>
    </div>
  </div>
</div>


<script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
<script>

function fillDate( from, to ){
    alert( from );
    setTimeout( ()=>{
    var fromValue = document.getElementById('from').value;
    alert( fromValue );
    $('#to').val( fromDate );
    }, 200 );
}
document.addEventListener('DOMContentLoaded', function() {
  const addBlockBtn = document.getElementById('addBlock');
  const removeBlockBtn = document.getElementById('removeBlock');
  const fieldsContainer = document.querySelector('.plusminus');

  let fieldIndex = 0;

  addBlockBtn.addEventListener('click', function() {
    fieldIndex++;
    const newField = `<div class="row append_wrap">
    
                    <div class="col-sm-2">
                      <label class="col-form-label" for="from_date${fieldIndex}">From Date</label>
                      <input type="date" name="key[${fieldIndex}][from_date]" value="" class="form-control datefld" required id="from_date${fieldIndex}" placeholder="" />
                    </div>  
                        
                        
                    <div class="col-sm-2">
                      <label class="col-form-label" for="to_date${fieldIndex}">To Date</label>
                      <input type="date" name="key[${fieldIndex}][to_date]" value="" class="form-control datefld" required id="to_date${fieldIndex}" placeholder="" />
                    </div> 
                    
                    <div class="col-sm-2" style="clear:both" >
                          <label class="col-form-label" for="state_id${fieldIndex}" >Select State</label>
                          <select name="key[${fieldIndex}][state_id]" id="state_id${fieldIndex}" class="form-control select2" required >
                            <option value="">--Select State--</option>
                            <?php 
                            if(!empty($state_list)){
                              foreach ($state_list as $key => $value) { ?>
                            <option value="<?=!empty($value['id']) ? $value['id'] : ""?>"><?=!empty($value['state_name']) ? $value['state_name'] : ""?></option>  
                            <?php  } }?>
                          </select>
                    </div>
                      
                    <div class="col-sm-2">
                          <label class="col-form-label" for="trip_type${fieldIndex}" >Trip Type</label>
                          <select name="key[${fieldIndex}][trip_type]" id="trip_type${fieldIndex}" class="form-control select2" required > 
                            <?php if(!empty($trip_type_list)){
                              foreach ($trip_type_list as $key => $value) { ?>
                                 <option value="<?=!empty($value['trip_type']) ? $value['trip_type'] : ""?>"><?=!empty($value['trip_type']) ? $value['trip_type'] : ""?></option>  
                            <?php }} ?>
                          </select>
                    </div> 
              
                    <div class="col-sm-2">
                      <label class="col-form-label" for="charge_type${fieldIndex}">Charge Type</label>
                      <select name="key[${fieldIndex}][charge_type]" id="charge_type${fieldIndex}" class="form-control select2" required > 
                         <option selected value="increase">Increase</option>  
                         <option value="decrease">Decrease</option> 
                      </select>
                    </div>
                      
                      
                    <div class="col-sm-2">
                      <label class="col-form-label" for="charge_value_type${fieldIndex}">Charge Value Type</label>
                      <select name="key[${fieldIndex}][charge_value_type]" id="charge_value_type${fieldIndex}" class="form-control select2" required > 
                         <option selected value="percent">Percent</option>  
                         <option value="fixed">Fixed</option> 
                      </select>
                    </div> 
               
              
                    <div class="col-sm-2">
                        <label class="col-form-label" for="charge_value${fieldIndex}">Charge Value</label>
                        <input type="text" name="key[${fieldIndex}][charge_value]" value="" class="form-control numbersOnly" required id="charge_value${fieldIndex}" placeholder="enter value" />
                    </div> 
                    
                    <div class="col-sm-2">
                    <label class="col-form-label" for="status${fieldIndex}">Status</label>
                    <select name="key[${fieldIndex}][status]" id="status${fieldIndex}" class="form-control select2" required > 
                         <option selected value="Active">Active</option>  
                         <option value="Inactive">Inactive</option> 
                      </select>
                    </div>
            </div> 
    `;
    fieldsContainer.insertAdjacentHTML('beforeend', newField);
    // Initialize Select2 for the newly added dropdown
    $('#state_id' + fieldIndex ).select2();
    $('#trip_type' + fieldIndex ).select2();
    $('#charge_type' + fieldIndex ).select2();
    $('#charge_value_type' + fieldIndex ).select2();
    $('#status' + fieldIndex ).select2();
    if (fieldIndex > 0) {
      removeBlockBtn.style.display = 'inline-block';
    }
  });

  removeBlockBtn.addEventListener('click', function() {
    const lastField = fieldsContainer.lastElementChild;
    console.log(lastField);
    if (lastField && lastField.classList.contains('append_wrap')) {
      fieldsContainer.removeChild(lastField);
      fieldIndex--;
    }
    if (fieldIndex === 0) {
      removeBlockBtn.style.display = 'none';
    }
  });
});

</script>

