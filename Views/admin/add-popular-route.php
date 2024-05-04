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
                <h4 class="cardhdng">Add Route</h4>
                <a href="<?= base_url(ADMINPATH . 'routes-list') ?>" class="sitebtn">View List</a>
            </div>  
            <?=form_open_multipart(ADMINPATH . 'save-route'); ?>
            <?=form_hidden('id',$id)?>
            
            <input type="hidden" name="old_banner_image_jpg" value="<?= !empty($banner_image_jpg) ? $banner_image_jpg : ''; ?>">
            <input type="hidden" name="old_banner_image_webp"value="<?= !empty($banner_image_webp) ? $banner_image_webp : ''; ?>">
            
            <div class="row mb-3">
                
              <div class="col-sm-3">
                <?=form_label('From City','from_city',['class'=>'col-form-label'])?>
                <input type="text" name="from_city" autocomplete="off" onkeyup="getCityList(this.value,'from')" value="<?=!empty($from_city_id)?getCityStateName($from_city_id):''?>"  class="form-control ucwords restrictedInput " required id="from_city_name" placeholder="From City Name" />
                <input type="hidden" name="from_city_id" id="from_city_id" value="<?=$from_city_id?>">
                <ul class="from-autocomplete-list list-unstyled list-color" id="from-suggestion-list" onclick="return selectCityNameData('from')"></ul>
              </div>
              
              <div class="col-sm-3">
                <?=form_label('To City','drop_city',['class'=>'col-form-label'])?> 
                <input type="text" name="drop_city" autocomplete="off" onkeyup="getCityList(this.value,'drop')" value="<?=!empty($to_city_id)?getCityStateName($to_city_id):''?>"  class="form-control ucwords restrictedInput " id="drop_city_name" placeholder="To City Name" />
                <input type="hidden" name="to_city_id" id="drop_city_id" value="<?=$to_city_id?>">
                <ul class="drop-autocomplete-list list-unstyled list-color" id="drop-suggestion-list" onclick="return selectCityNameData('drop')"></ul>
              </div>
              
              <div class="col-sm-3">
                <?=form_label('Trip Type','trip_type',['class'=>'col-form-label'])?>
                <?=form_dropdown(['name'=>'trip_type','class'=>'form-control select2', 'required' => 'required', 'id'=>'trip_type','onchange'=>"toSeoUrl()"],$trip_type_list,set_value('trip_type',$trip_type) ); ?> 
              </div> 
              
              <div class="col-sm-3">
                <?=form_label('Route Display Name','page_name',['class'=>'col-form-label'])?>
                <input type="text" name="page_name" autocomplete="off"  value="<?=$page_name?>"  class="form-control ucwords restrictedInput" required id="page_name" placeholder="Route Name" />
              </div>
              
              </div>
              
              <div class="row mb-3">
              <div class="col-sm-3">
                <?=form_label('Page Slug(URL)','page_slug',['class'=>'col-form-label'])?>
                <input type="text" name="page_slug" autocomplete="off" value="<?=$page_slug?>"  class="form-control restrictedInput" required id="page_slug" placeholder="URL" />
              </div>
              
               <div class="col-sm-3">
                <label for="banner_image_alt" class="col-form-label">Banner Image Alt</label>
                <?= form_input(['name' => 'banner_image_alt', 'required' => 'required', 'placeholder' => 'Enter Image Alt', 'id' => 'banner_image_alt', 'class' => 'form-control','value'=>$banner_image_alt]); ?>
              </div>
              
              <div class="col-sm-3">
              <label for="banner_image_jpg" class="col-form-label">Banner Image</label> 
                <?= form_upload([
                  'name' => 'banner_image_jpg',
                  'class' => 'form-control',
                  'accept' => 'image/png, image/jpg, image/jpeg'
                  ]); ?>
              </div> 
              <div class="col-sm-2">
                <?php if (!empty($banner_image_jpg)) { ?>
                    <img src="<?= base_url('uploads/') . $banner_image_jpg; ?>" height="70px" width="100px" >
                <?php } ?>
              </div> 
            </div>
            
            
            <div class="row mb-3">
              <div class="col-sm-12">
                <?=form_label('Heading H1','h_one_heading',['class'=>'col-form-label'])?>
                <input type="text" name="h_one_heading" autocomplete="off" value="<?=$h_one_heading?>"  class="form-control" required id="h_one_heading" placeholder="H1 Heading" />
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-12">
                <?=form_label('Description','content_data',['class'=>'col-form-label'])?>
                <textarea  name="content_data" autocomplete="off" class="form-control" required id="description" placeholder="Description"><?=$content_data?></textarea>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-12">
                <?=form_label('Meta Title','meta_title',['class'=>'col-form-label'])?>
                <textarea name="meta_title" autocomplete="off" class="form-control" required id="meta_title" placeholder="Meta Title"><?=$meta_title?></textarea>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-12">
                <?=form_label('Meta Description','meta_description',['class'=>'col-form-label'])?>
                <textarea name="meta_description" autocomplete="off" class="form-control" required id="meta_description" placeholder="Meta Description"><?=$meta_description?></textarea>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-12">
                <?=form_label('Meta Keywords','meta_keywords',['class'=>'col-form-label'])?>
                <textarea name="meta_keywords" autocomplete="off" class="form-control" required id="meta_keywords" placeholder="Meta Keywords"><?=$meta_keywords?></textarea>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-sm-12">
                <?=form_label('Page Business Schema','page_schema',['class'=>'col-form-label'])?>
                <textarea name="page_schema" autocomplete="off" class="form-control"  id="page_schema" placeholder="Page Schema"><?=$page_schema?></textarea>
              </div>
            </div>
            
            <div class="row mb-3">
              <div class="col-sm-12">
                <?=form_label('FAQ Schema','faq_schema',['class'=>'col-form-label'])?>
                <textarea name="faq_schema" autocomplete="off" class="form-control"  id="faq_schema" placeholder="FAQ Schema"><?=$faq_schema?></textarea>
              </div>
            </div>
            
            <div class="input_field_wrapper">
              <?php if(!empty($faqs)){
                $i=1;
                foreach($faqs as $key=>$value){
                ?>
              <div id="faq_<?=$i?>">
                <div class="row mb-3">
                  <label for="faq_question" class="col-sm-2 col-form-label">Question</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="faq_question" placeholder="Question" value="<?=$value['question']?>" name="faq_question[]" >
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="faq_answer" class="col-sm-2 col-form-label">Answer</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="faq_answer" placeholder="Answer" value="<?=$value['answer']?>" name="faq_answer[]">
                  </div>
                </div>
              </div>
              <?php if($i==1){?>
              <a href="javascript:void(0);" class="add_button btn btn-success btn-sm" title="Add field"><i class="bx bx-plus"></i></a>
              <?php }else{?>
              <a href="javascript:void(0);" class="btn btn-danger btn-sm"  title="Remove field" id="bt_<?=$i?>" onclick="del_faq(<?=$i?>)"><i class="bx bx-minus"></i></a>
              <?php } ?>
              <?php $i++;} }else{ ?>
              <div class="row mb-3">
                <label for="faq_question" class="col-sm-2 col-form-label">Question</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="faq_question" placeholder="Question" value="" name="faq_question[]" >
                </div>
              </div>
              <div class="row mb-3">
                <label for="faq_answer" class="col-sm-2 col-form-label">Answer</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="faq_answer" placeholder="Answer" value="" name="faq_answer[]">
                </div>
              </div>
              <a href="javascript:void(0);" class="add_button btn btn-success btn-sm" title="Add field"><i class="bx bx-plus"></i></a>
              <?php } ?>
            </div>
            
            
             
            <div class="row mt-3">
              <?=form_label('Status','status',['class'=>'col-sm-2 col-form-label'])?>
              <div class="col-sm-6">
                <div class="row mt-2">
                  <div class="col-3">
                    <div class="custom-control custom-checkbox">
                      <input class="custom-control-input" name="status" <?= ($status == 'Active') ? 'checked' : '' ?> type="radio" id="checkStatus1" value="Active">
                      <?=form_label('Active','checkStatus1',['class'=>'custom-control-label'])?>
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="custom-control custom-checkbox">
                      <input class="custom-control-input" name="status" <?= ($status == 'Inactive') ? 'checked' : '' ?> type="radio" id="checkStatus2" value="Inactive">
                      <?=form_label('Inactive','checkStatus2',['class'=>'custom-control-label'])?>
                    </div>
                  </div>
                </div>
              </div>
            </div> 
             
            <div class="row justify-content-start mt-3">
                <?php if(!empty($access) || ($user_type != "Role User") ){?>
              <div class="col-sm-10">
                <button type="submit" id="submit" class="btn btn-primary">Submit</button>
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
<script>
    function getCityList(val, type ){
      //  alert(val);
      $('.'+type+'-autocomplete-list').html(''); 
  if (val !== "" && val.length > 2) {
       $.ajax({
      url: '<?= base_url(ADMINPATH.'getCity') ?>',
      type: "POST",
      data: { 'val': val},
      cache: false,
      dataType:"html",
      success: function (response) {
        if (response.length < 20) {
          toastr.error(response);
          return false;
        } else if (response.length > 20) {
            $('.'+type+'-autocomplete-list').show(); 
            $('.'+type+'-autocomplete-list').html(response);
        }
      }
    }); 
  }
    }
    
function selectCityNameData( type ) {
  var selectedItem = $(event.target);
  var itemValue = selectedItem.text();
  var itemId = selectedItem.val();
  var stateId = selectedItem.attr('data-stateid');

  if (itemValue !== "" && itemId !== "") {
    $('#'+type+'_city_name').val(itemValue);
    $('#'+type+'_city_id').val(itemId);
    // $('#drop_state_id').val(stateId);
    $('.'+type+'-autocomplete-list').hide();
  }
  
  setTimeout( ()=>{ toSeoUrl(); }, 100 );
}

function toSeoUrl() {
    <?php if(empty($id)){ ?>
    var firstStr = ''; var secondStr = ''; var thirdStr = '';
    if( $('#from_city_name').val() ){
        firstStr = $('#from_city_name').val().split(",")[0].trim();
    } 
    if( $('#drop_city_name').val() ){
        secondStr = $('#drop_city_name').val().split(",")[0].trim();
    } 
    if( $('#trip_type option:selected').val() ){
        thirdStr = $('#trip_type option:selected').val().split(",")[0].trim();
    }
    var url = firstStr+' '+secondStr+' '+thirdStr;
    $('#page_name').val( url );
    
    var seoUrl = url.toString()               // Convert to string
        .normalize('NFD')               // Change diacritics
        .replace(/[\u0300-\u036f]/g,'') // Remove illegal characters
        .replace(/\s+/g,'-')            // Change whitespace to dashes
        .toLowerCase()                  // Change to lowercase
        .replace(/&/g,'-and-')          // Replace ampersand
        .replace(/[^a-z0-9\-]/g,'')     // Remove anything that is not a letter, number or dash
        .replace(/-+/g,'-')             // Remove duplicate dashes
        .replace(/^-*/,'')              // Remove starting dashes
        .replace(/-*$/,'');             // Remove trailing dashes
        
        $('#page_slug').val( seoUrl );
    <?php } ?>
}
</script>