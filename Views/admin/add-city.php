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
                <h4 class="cardhdng">Add City</h4>
                <a href="<?= base_url(ADMINPATH . 'city-list') ?>" class="sitebtn">View List</a>
            </div>
            <?=form_open(ADMINPATH . 'save-city'); ?>
            <?=form_hidden('id',$id)?>
            <div class="row">
              <div class="col-sm-3 mb-3">
                <?=form_label('Select State','state',['class'=>'col-form-label'])?>
                <select name="state" id="state" class="form-control select2" required>
                  <option value="">--Select State--</option>
                  <?php if(!empty($states)){foreach($states as $key=>$value){?>
                  <option value="<?=$value['id'].','.$value['state_name']?>" <?=!empty($state_id) && ($state_id==$value['id'])?"selected":""?>><?=$value['state_name']?></option>
                  <?php }} ?>
                </select>
              </div>
              <div class="col-sm-3 mb-3">
                <?=form_label('City Name','city_name',['class'=>'col-form-label'])?>
                <input type="text" name="city_name" autocomplete="off"  value="<?=$city_name?>" onkeyup="return checkDuplicate(this.value,'cities','city_name')"  class="form-control ucwords restrictedInput" required id="city_name" placeholder="City Name" />
              </div>
              
              <div class="col-sm-3 mb-3">
                <?=form_label('Latitude','latitude',['class'=>'col-form-label'])?>
                <input type="text" name="latitude" autocomplete="off" value="<?=$latitude?>"  class="form-control" required id="latitude" placeholder="Latitude" />
              </div>
              <div class="col-sm-3 mb-3">
                <?=form_label('Longitude','longitude',['class'=>'col-form-label'])?>
                <input type="text" name="longitude" autocomplete="off" value="<?=$longitude?>"  class="form-control" required id="longitude" placeholder="Longitude" />
              </div>
              
              
            </div>
            <div class="row mb-3">
              <?=form_label('Status','status',['class'=>'col-form-label'])?>
              <div class="col-sm-6 mb-3">
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
            <div class="row justify-content-start">
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

<script src="https://maps.googleapis.com/maps/api/js?key=<?=GOOGLE_MAP_API_KEY?>&libraries=places&callback=initAutocomplete" defer="defer" async></script>
<script type="text/javascript">  
function fillInAddress() {
  var place = autocomplete.getPlace();
  //  console.log(place);
   var address = place.address_components[0].short_name;

  getCitySlug(address);
  document.getElementById('city_name').value = address;
  var lat = place.geometry.location.lat(), lng = place.geometry.location.lng();
  document.getElementById('latitude').value = lat;
  document.getElementById('longitude').value = lng;

}

var placeSearch, autocomplete;

function initAutocomplete() {
  $("input[id*='city_name']").each(function() {
    autocomplete = new google.maps.places.Autocomplete(this);
    
    autocomplete.setComponentRestrictions({ 'country': 'IN' });
    google.maps.event.addListener(autocomplete, 'place_changed', function() {
      fillInAddress();
    });
  });
}


function getCitySlug(val){
        $.ajax({
      url: '<?= base_url(ADMINPATH.'getSlug') ?>',
      type: 'POST',
      data: {
        'keyword': val
      },
      cache: false,
      success: function (response) {
       // alert(response);
       $('#cityurl').val(response);
       
      }
    });
    }

</script>