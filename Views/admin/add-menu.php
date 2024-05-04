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
                <h4 class="cardhdng">Add Menu</h4>
                <a href="<?= base_url(ADMINPATH . 'menu-list') ?>" class="sitebtn">View List</a>
            </div>
            <?=form_open_multipart(ADMINPATH . 'save-menu'); ?>
            <?=form_hidden('id',$id)?>
            <div class="row mb-3">
              <div class="col-sm-3">
                <?=form_label('Menu Type','type',['class'=>'col-form-label'])?>
                <select name="type" id="type" class="form-control select2" required>
                  <option value="">--Select Menu Type--</option>
                  <option value="Menu" <?=!empty($type) && ($type=="Menu")?"selected":""?>>Menu</option>
                  <option value="Submenu" <?=!empty($type) && ($type=="Submenu")?"selected":""?>>Submenu</option>
                </select>
              </div>
              <div class="col-sm-3">
                <?=form_label('Parent Menu Name','menu_id',['class'=>'col-form-label'])?>
                <select name="menu_id" id="menu_id" class="form-control select2">
                  <option value="">--Select Parent Menu--</option>
                  <?php if(!empty($menu_list)){foreach($menu_list as $key=>$value){?>
                  <option value="<?=$value['id']?>" <?=!empty($menu_id) && ($menu_id==$value['id'])?"selected":""?>><?=$value['menu_name']?></option>
                  <?php }} ?>
                </select>
              </div>
              <div class="col-sm-3">
                <?=form_label('Menu Title','menu_name',['class'=>'col-form-label'])?>
                <div class="input-group input-group-merge">
                  <?= form_input(['name' => 'menu_name','autocomplete'=>'off', 'required' => 'required','onkeyup'=>'getSlug(this.value)','placeholder' => 'Enter Menu Title', 'id' => 'menu_name', 'class' => 'form-control ucwords restrictedInput','value'=>$menu_name]); ?>
                </div>
              </div>
              <div class="col-sm-3">
                <?=form_label('Menu Slug','menu_slug',['class'=>'col-form-label'])?>
                <?= form_input(['name' => 'menu_slug', 'autocomplete'=>'off','required' => 'required', 'placeholder' => 'Enter Menu Slug', 'id' => 'menu_slug', 'class' => 'form-control','value'=>$slug]); ?>
              </div>
              <div class="col-sm-3">
                <?=form_label('Priority','priority',['class'=>'col-form-label'])?>
                <?= form_input(['name' => 'priority', 'autocomplete'=>'off','required' => 'required','maxlength'=>'3', 'placeholder' => 'Enter Priority', 'id' => 'priority', 'class' => 'form-control numbersWithZeroOnlyInput','value'=>$priority]); ?>
              </div>
            </div>
            <div class="row mb-3">
              <?=form_label('Status','status',['class'=>'col-form-label'])?>
              <div class="col-sm-6">
                <div class="row mt-2">
                  <div class="col-3">
                    <div class="custom-control custom-checkbox">
                      <input class="custom-control-input checkbox-style " name="status" <?= ($status == 'Active') ? 'checked' : '' ?> type="radio" id="checkStatus1" value="Active">
                      <?=form_label('Active','checkStatus1',['class'=>'custom-control-label'])?>
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="custom-control custom-checkbox">
                      <input class="custom-control-input checkbox-style " name="status" <?= ($status == 'Inactive') ? 'checked' : '' ?> type="radio" id="checkStatus2" value="Inactive">
                      <?=form_label('Inactive','checkStatus2',['class'=>'custom-control-label'])?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row justify-content-start">
              <?php if(!empty($access) || ($user_type != "Role User") ){?>
              <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Submit</button>
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