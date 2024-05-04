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
          
          <?php
          $p_id = '';
          $p_condition_type = '';
          $p_from_value = '';
          $p_to_value = '';
          $p_apply_type = '';
          $p_apply_value_type = '';
          $p_apply_value = '';
          $p_status = '';
          if(!empty($list)){
              foreach($list as $key=>$value ){
                  if($value['condition_type']=='2hour_prior'){
                    $p_id = $value['id'];
                    $p_condition_type = $value['condition_type'];
                    $p_from_value = $value['from_value'];
                    $p_to_value = $value['to_value'];
                    $p_apply_type = $value['apply_type'];
                    $p_apply_value_type = $value['apply_value_type'];
                    $p_apply_value = $value['apply_value'];
                    $p_status = $value['status']; 
                    break;
                  }
              }
          }
          ?>
          
        <div class="card mb-4">
          <div class="card-body">
            <h5>1). Prior Booking Condition </h5>
            <?=form_open_multipart(ADMINPATH . 'save-booking-conditions'); ?>
            <?=form_hidden('id', $p_id );?>
            <?=form_hidden('condition_type', $p_condition_type );?>
            <?=form_hidden('from_value', 0 );?> 
            
            <div class="row mb-3">
              <div class="col-sm-3">
                <label class="col-form-label" for="basic-default-name">Prior Hours</label>
                <input type="text" name="to_value" value="<?=$p_to_value?>" class="form-control numbersOnly" required id="to_value" placeholder="prior hours" />
              </div>  
              
              <div class="col-sm-3">
                <?=form_label('Status','status',['class'=>'col-form-label'])?>
                <?=form_dropdown(['name'=>'status','class'=>'form-control select2'],['Active'=>'Active','Inactive'=>'Inactive'],set_value('status',$p_status));?>
              </div>
              
              <div class="col-sm-3" style="margin-top:40px">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div> 
              
            </div>
            <?=form_close()?>
          </div>
        </div>
        
        
        <?php
          $sm_id = '';
          $sm_condition_type = '';
          $sm_from_value = '';
          $sm_to_value = '';
          $sm_apply_type = '';
          $sm_apply_value_type = '';
          $sm_apply_value = '';
          $sm_status = '';
          if(!empty($list)){
              foreach($list as $key=>$value ){
                  if($value['condition_type']=='2h_to_24h'){
                    $sm_id = $value['id'];
                    $sm_condition_type = $value['condition_type'];
                    $sm_from_value = $value['from_value'];
                    $sm_to_value = $value['to_value'];
                    $sm_apply_type = $value['apply_type'];
                    $sm_apply_value_type = $value['apply_value_type'];
                    $sm_apply_value = $value['apply_value'];
                    $sm_status = $value['status']; 
                    break;
                  }
              }
          }
          ?>
        
        <div class="card mb-4">
          <div class="card-body">
            <h5>2). Same Date Booking Condition </h5>
            <?=form_open_multipart(ADMINPATH . 'save-booking-conditions'); ?>
            <?=form_hidden('id', $sm_id );?>
            <?=form_hidden('condition_type', $sm_condition_type );?> 
            
            <div class="row mb-3">
              <div class="col-sm-3">
                <label class="col-form-label" for="basic-default-name">From Hours</label>
                <input type="text" name="from_value" value="<?=$sm_from_value?>" class="form-control numbersOnly" required id="from_value" placeholder="valid from hours" />
              </div> 
              
              <div class="col-sm-3">
                <label class="col-form-label" for="basic-default-name">To Hours</label>
                <input type="text" name="to_value" value="<?=$sm_to_value?>" class="form-control numbersOnly" required id="to_value" placeholder="valid till hours" />
              </div> 
              
              <div class="col-sm-3">
                <?=form_label('Charge Type','apply_type',['class'=>'col-form-label'])?>
                <?=form_dropdown(['name'=>'apply_type','class'=>'form-control select2'],['extra'=>'Increase','less'=>'Decrease'],set_value('apply_type',$sm_apply_type));?>
              </div>
              
              <div class="col-sm-3">
                <?=form_label('Charge Value Type','apply_value_type',['class'=>'col-form-label'])?>
                <?=form_dropdown(['name'=>'apply_value_type','class'=>'form-control select2'],['percent'=>'Percent','fixed'=>'Fixed'],set_value('apply_value_type',$sm_apply_value_type));?>
              </div>
              
              <div class="col-sm-3">
                <label class="col-form-label" for="basic-default-name">Charge Value</label>
                <input type="text" name="apply_value" value="<?=$sm_apply_value?>" class="form-control numbersOnly" required id="apply_value" placeholder="enter value" />
              </div> 
              
              <div class="col-sm-3">
                <?=form_label('Status','status',['class'=>'col-form-label'])?>
                <?=form_dropdown(['name'=>'status','class'=>'form-control select2'],['Active'=>'Active','Inactive'=>'Inactive'],set_value('status',$sm_status));?>
              </div>
              
              <div class="col-sm-3" style="margin-top:40px">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            
            </div>
            <?=form_close()?>
          </div>
        </div>
        
        
        
        
        <?php
          $nxt_id = '';
          $nxt_condition_type = '';
          $nxt_from_value = '';
          $nxt_to_value = '';
          $nxt_apply_type = '';
          $nxt_apply_value_type = '';
          $nxt_apply_value = '';
          $nxt_status = '';
          if(!empty($list)){
              foreach($list as $key=>$value ){
                  if($value['condition_type']=='next3days'){
                    $nxt_id = $value['id'];
                    $nxt_condition_type = $value['condition_type'];
                    $nxt_from_value = $value['from_value'];
                    $nxt_to_value = $value['to_value'];
                    $nxt_apply_type = $value['apply_type'];
                    $nxt_apply_value_type = $value['apply_value_type'];
                    $nxt_apply_value = $value['apply_value'];
                    $nxt_status = $value['status']; 
                    break;
                  }
              }
          }
          ?>
        
        <div class="card mb-4">
          <div class="card-body">
            <h5>3). Future Pickup Date Booking Condition </h5>
            <?=form_open_multipart(ADMINPATH . 'save-booking-conditions'); ?>
            <?=form_hidden('id', $nxt_id );?>
            <?=form_hidden('condition_type', $nxt_condition_type );?> 
            
            <div class="row mb-3">
              <div class="col-sm-3">
                <label class="col-form-label" for="basic-default-name">Enter Apply Days</label>
                <input type="text" name="from_value" value="<?=$nxt_from_value?>" class="form-control numbersOnly" required id="from_value" placeholder="enter days" />
              </div>  
               
              
              <div class="col-sm-3">
                <?=form_label('Charge Type','apply_type',['class'=>'col-form-label'])?>
                <?=form_dropdown(['name'=>'apply_type','class'=>'form-control select2'],['extra'=>'Increase','less'=>'Decrease'],set_value('apply_type',$nxt_apply_type));?>
              </div>
              
              <div class="col-sm-3">
                <?=form_label('Charge Value Type','apply_value_type',['class'=>'col-form-label'])?>
                <?=form_dropdown(['name'=>'apply_value_type','class'=>'form-control select2'],['percent'=>'Percent','fixed'=>'Fixed'],set_value('apply_value_type',$nxt_apply_value_type));?>
              </div>
              
              <div class="col-sm-3">
                <label class="col-form-label" for="basic-default-name">Charge Value</label>
                <input type="text" name="apply_value" value="<?=$nxt_apply_value?>" class="form-control numbersOnly" required id="apply_value" placeholder="enter value" />
              </div> 
              
              <div class="col-sm-3">
                <?=form_label('Status','status',['class'=>'col-form-label'])?>
                <?=form_dropdown(['name'=>'status','class'=>'form-control select2'],['Active'=>'Active','Inactive'=>'Inactive'],set_value('status',$nxt_status));?>
              </div>
              
              <div class="col-sm-3" style="margin-top:40px">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            
            </div>
            <?=form_close()?>
          </div>
        </div>
        
         
        
      </div>
    </div>
  </div>
</div>