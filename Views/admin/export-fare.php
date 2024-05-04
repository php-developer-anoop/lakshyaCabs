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
          <ul class="nav nav-pills" role="tablist">
            <li class="nav-item">
              <button 
                type="button"
                class="nav-link active"
                role="tab"
                data-bs-toggle="tab"
                data-bs-target="#navs-pills-top-export"
                aria-controls="navs-pills-top-export"
                aria-selected="true">
              Export
              </button>
            </li>
            <li class="nav-item">
              <button
                type="button"
                class="nav-link"
                role="tab"
                data-bs-toggle="tab"
                data-bs-target="#navs-pills-top-import"
                aria-controls="navs-pills-top-import"
                aria-selected="false">
              Import
              </button>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade show active" id="navs-pills-top-export" role="tabpanel">
              <?=form_open(ADMINPATH.'exportFile')?>
              <div class="row mb-3">
                <div class="col-sm-3">
                  <?=form_label('Select Trip Type','triptype',['class'=>'col-form-label'])?>
                  <select name="triptype" id="exporttriptypeid" class="form-control select2" >
                    <option value="">--Select Trip Type--</option>
                    <!-- <option value="Oneway">Oneway</option> -->
                    <option value="Outstation">Outstation</option>
                    <option value="Local">Local</option>
                    <option value="Airport">Airport</option>
                  </select>
                </div>
                <div class="col-sm-3">
                  <?=form_label('Select State','state',['class'=>'col-form-label'])?>
                  <select name="stateid" id="exportstateid" class="form-control select2" required onchange="getCities(this.value)">
                    <option value="">--Select State--</option>
                    <?php if(!empty($states)){foreach($states as $key=>$value){?>
                    <option value="<?=$value['id'].','.$value['state_name']?>" <?=!empty($state_id) && ($state_id==$value['id'])?"selected":""?>><?=$value['state_name']?></option>
                    <?php }} ?>
                  </select>
                </div>
                <div class="col-sm-3">
                  <?=form_label('Select City','city',['class'=>'col-form-label'])?>
                  <select name="cityid" id="city" class="form-control select2" onchange="getPacks(this.value)">
                    <option value="">--Select City--</option>
                  </select>
                </div>
                <div class="col-sm-3" id="localpackage">
                  <?=form_label('Select Package','package',['class'=>'col-form-label'])?>
                  <select name="package" id="package" class="form-control select2" >
                    <option value="">--Select Package--</option>
                  </select>
                </div>
              </div>
              <div class="row justify-content-start">
                  <?php if(!empty($access) || ($user_type != "Role User") ){?>
                <div class="col-sm-10">
                  <button type="submit" id="export" class="btn btn-primary" onclick="return validateExport()">Get File</button>
                </div>
                <?php } ?>
              </div>
              <?=form_close()?>
            </div>
            <div class="tab-pane fade " id="navs-pills-top-import" role="tabpanel">
              <?=form_open_multipart(ADMINPATH.'importFile')?>
              <div class="row mb-3">
                <div class="col-sm-4">
                  <label for="banner_image" class="col-form-label">CSV File</label>
                  <?= form_upload([
                    'name' => 'csv_file',
                    'class' => 'form-control',
                    'accept' => '.csv',
                    'required'=>'required'
                    ]); ?>
                </div>
              </div>
              <div class="row justify-content-start">
                  <?php if(!empty($access) || ($user_type != "Role User") ){?>
                <div class="col-sm-10">
                  <button type="submit" id="import" class="btn btn-primary" >Upload</button>
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
</div>
<script>
   $('#localpackage').hide();
$(document).ready(function() {
 
  
  $('#exporttriptypeid').change(function() {
    var triptype = $(this).val();
    if (triptype.trim() === "Local") {
      $('#localpackage').show();
    } else {
      $('#localpackage').hide();
    }
  });
  
 // validateExport();
});
$('#exportstateid').change(function() {
  var stateId = $('#exportstateid').val();
  var cityId = $('#city').val();
  getPacks(cityId,stateId);
});
function validateExport() {
    var stateId = $('#exportstateid').val();
    var cityId = $('#city').val();
    var triptype = $('#exporttriptypeid').val();

    if (triptype.trim() === "") {
      toastr.error("Please Select Trip Type");
      return false;
    } else if (stateId.trim() === "") {
      toastr.error("Please Select State");
      return false;
    }
    return true;
  }


function getPacks(city_id,state_id=null) {
  var stateId = $('#exportstateid').val();
  if(state_id==null){
    state_id = stateId;
  }
  var triptype = $('#exporttriptypeid').val();
  if (triptype.trim() != "" && triptype == "Local") {
    
    $('#package').html('');

    $.ajax({
      url: '<?= base_url(ADMINPATH.'getPacksFromAjax') ?>',
      method: 'POST',
      data: {
        city_id: city_id,
        state_id :state_id
      },
      success: function(response) {
        $('#package').html(response);
      }
    });
  }
}
</script>