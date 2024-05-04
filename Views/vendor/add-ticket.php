<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb" class="d-flex flex-row justify-content-between ">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="javascript:void(0);">Home</a>
        </li>
        <li class="breadcrumb-item">
          <a href="javascript:void(0);">
          <?= $menu ?>
          </a>
        </li>
        <li class="breadcrumb-item active">
          <?= $title ?>
        </li>
      </ol>
    </nav>
    <div class="text-start">
      <h4 class="sitehdng">View Ticket</h4>
    </div>
    <div class="row gy-3">
      <div class="col-lg-12">
        <div class="d-flex flex-column gap-3">
          <div class="card border-0 rounded-3">
            <div class="card-body">
              <?=form_open_multipart(base_url(VENDORPATH.'save-ticket'))?>
              <?=form_hidden('parent_id',$id)?>
              <?=form_hidden('ticket_id',$ticket_id)?>
              <div class="d-flex justify-content-between px-2"  href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                <select name="subject" class="form-control select2" required>
                  <option value="">Select Option</option>
                  <?php if(!empty($subject_list)){foreach($subject_list as $key=>$value){?>
                  <option value="<?=$value['subject_name']?>"><?=$value['subject_name']?></option>
                  <?php }} ?> 
                </select>
              </div>
              <div class="collapse show" id="collapseExample">
                <!--<hr class="line-color mt-4" />-->
                <div class="mt-3 d-flex flex-column gap-3">
                  <div class="d-flex flex-column gap-1">
                    <p class="mb-0">Message</p>
                    <textarea class="form-control" name="description" id="floatingTextarea2"
                      style="height: 140px"></textarea>
                  </div>
                  <div class="">
                    <?=form_label('Urgency','urgency_type',['class'=>'col-form-label'])?>
                    <div class="col-sm-6 mb-3">
                      <div class="row mt-2">
                        <div class="col-3">
                          <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" name="urgency_type" <?= ($urgency_type == 'Normal') ? 'checked' : '' ?> type="radio" id="checkStatus1" value="Normal">
                            <?=form_label('Normal','checkStatus1',['class'=>'custom-control-label'])?>
                          </div>
                        </div>
                        <div class="col-3">
                          <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" name="urgency_type" <?= ($urgency_type == 'Critical') ? 'checked' : '' ?> type="radio" id="checkStatus2" value="Critical">
                            <?=form_label('Critical','checkStatus2',['class'=>'custom-control-label'])?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="">
                    <div class='file-input filer'>
                      <input type='file' name="image" accept="image/jpg,image/png,image/jpeg">
                      <span class='button'>Select File</span>
                      <span class='label' data-js-label>No file selected</label>
                    </div>
                  </div>
                  <div class="d-flex flex-row gap-3">
                    <button class="btn btn-theme px-4">Submit</button>
                    <!--<button class="btn btn-theme-secondary px-4">Cancel</button>-->
                  </div>
                </div>
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
  var inputs = document.querySelectorAll('.file-input')

for (var i = 0, len = inputs.length; i < len; i++) {
  customInput(inputs[i])
}

function customInput(el) {
  const fileInput = el.querySelector('[type="file"]')
  const label = el.querySelector('[data-js-label]')

  fileInput.onchange =
    fileInput.onmouseout = function() {
      if (!fileInput.value) return

      var value = fileInput.value.replace(/^.*[\\\/]/, '')
      el.className += ' -chosen'
      label.innerText = value
    }
}
      
</script>