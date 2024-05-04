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
      </ol>
    </nav>
    <div class="card pt-2">
      <div class="table-responsive text-nowrap container">
        <div class="row mb-3">
          <?=form_open(ADMINPATH . 'save-office'); ?>
          <?=form_hidden('id',$id)?>
          <div class="row mb-3">
            <div class="col-sm-3">
              <?=form_label('Select Office Type','office_type',['class'=>'col-form-label'])?>
              <select name="office_type" id="office_type" class="form-control select2" required>
                <option value="">--Select Office Type--</option>
                <option value="Head Office" <?=!empty($office_type) && ($office_type=="Head Office")?"selected":""?>>Head Office</option>
                <option value="Branch Office" <?=!empty($office_type) && ($office_type=="Branch Office")?"selected":""?>>Branch Office</option>
              </select>
            </div>
            <div class="col-sm-3">
              <?=form_label('Select State','state',['class'=>'col-form-label'])?>
              <select name="state" id="state" class="form-control select2" required onchange="getCities(this.value,'<?=$city_id.','.$city_name?>')">
                <option value="">--Select State--</option>
                <?php if(!empty($states)){foreach($states as $key=>$value){?>
                <option value="<?=$value['id'].','.$value['state_name']?>" <?=!empty($state_id) && ($state_id==$value['id'])?"selected":""?>><?=$value['state_name']?></option>
                <?php }} ?>
              </select>
            </div>
            <div class="col-sm-3">
              <?=form_label('Select City','city',['class'=>'col-form-label'])?>
              <select name="city" id="city" class="form-control select2" required>
                <option value="">--Select City--</option>
              </select>
            </div>
            <div class="col-sm-3">
              <?=form_label('Address','address',['class'=>'col-form-label'])?>
              <input type="text" name="address" autocomplete="off" value="<?=$address?>"  class="form-control ucwords restrictedInput" required id="address" placeholder="Address" />
            </div>
            <div class="col-sm-3">
              <label class="col-form-label" for="basic-default-phone">Email</label>
              <input type="email" name="email" id="basic-default-phone" value="<?=$email?>" required class="form-control emailInput" placeholder="Email Id" aria-label="Email Id" aria-describedby="basic-default-email" />
            </div>
            <div class="col-sm-3">
              <label class="col-form-label" for="basic-default-company">Mobile No.</label>
              <input type="text" name="phone" value="<?=$phone?>" class="form-control notzero numbersWithZeroOnlyInput" minlength="10" required  maxlength="10" id="basic-default-company phone-mask" placeholder="Mobile No." />
            </div>
          </div>
          <div class="row justify-content-start">
              <?php if(!empty($access) || ($user_type != "Role User") ){?>
            <div class="col-sm-10">
              <button type="submit" id="submit" class="btn btn-primary">Submit</button>
            </div>
            <?php } ?>
          </div>
          <?=form_close();?>
        </div>
        <input type="hidden" value="0" id="totalRecords" />
        <table id="responseData" class="table  mb-0 ">
        </table>
      </div>
    </div>
  </div>
  <div class="content-backdrop fade"></div>
</div>
<script>
    function getTotalRecordsData(qparam) {
        $.ajax({
            url: '<?= base_url(ADMINPATH . 'office-data'); ?>?' + qparam,
            type: "POST",
            data: { 'is_count': 'yes', 'start': 0, 'length': 10 },
            cache: false,
            success: function (response) {
                $('#totalRecords').val(response);
                //if (response) {
                    loadAllRecordsData(qparam);
                //}
            }
        });
    }

    $(document).ready(function () {
        let qparam = (new URL(location)).searchParams;
        getTotalRecordsData(qparam);
    });

    function loadAllRecordsData(qparam) {
       // alert(qparam);
        $('#responseData').html('');
        var newQueryParam = '?'+qparam + '&recordstotal=' + $('#totalRecords').val();
        $('#responseData').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": '<?= base_url(ADMINPATH . 'office-data'); ?>' + newQueryParam,
                "type": 'POST',
                dataSrc: (res) => {
                    return res.data
                }
            },
            "columns": [{ data: "sr_no", "name": "Sr.No", "title": "Sr.No" },
            { data: "", "title": "Office Details","render":office_details },
            { data: "", "title": "Location Details","render":location_details },
            { data: "", "title": "Dates","render":dates },
            <?php if(!empty($access) || ($user_type != "Role User") ){?>
            { data: "", "name": "Status", "title": "Status", "render": status_render },
           
            { data: "id", "name": "Action", "title": "Action", "render": action_render }
            <?php } ?>
          ],
            scrollY: false,
            "rowReorder": { selector: 'td:nth-child(2)' },
            "responsive": true,
            "autoWidth": false,
            "destroy": true,
            "searchDelay": 500,
            "searching": true,
            "pagingType": 'simple_numbers',
            "rowId": (a) => { return 'id_' + a.id; },
            "iDisplayLength": 10,
            "order": [2, "asc"],
        });
    }

    var dates = (data, type, row, meta) => {
  var data = '';
  let add_date = row.add_date != null ? row.add_date : "";
  let upd_date = row.upd_date != null ? row.upd_date : "";
  if (type === 'display') {
    data += '<span class="fotr_10"><b>Added On : </b>' + add_date + '</span><br>';
    data += '<span class="fotr_10"><b>Updated On: </b>' + upd_date + '</span>';

  }
  return data;
}

var location_details = (data, type, row, meta) => {
  var data = '';
  let city_name = row.city_name != null ? row.city_name : "";
  let state_name = row.state_name != null ? row.state_name : "";
  let address = row.address != null ? row.address : "";
  if (type === 'display') {
    data += '<span class="fotr_10"><b>City : </b>' + city_name + '</span><br>';
    data += '<span class="fotr_10"><b>State : </b>' + state_name + '</span><br>';
    data += '<span class="fotr_10"><b>Address : </b>' + address + '</span><br>';
  }
  return data;
}

var office_details = (data, type, row, meta) => {
  var data = '';
  let office_type = row.office_type != null ? row.office_type : "";
  let phone = row.phone != null ? row.phone : "";
  let email = row.email != null ? row.email : "";
  if (type === 'display') {
    data += '<span class="fotr_10"><b>Office Type : </b>' + office_type + '</span><br>';
    data += '<span class="fotr_10"><b>Phone : </b>' + phone + '</span><br>';
    data += '<span class="fotr_10"><b>Email : </b>' + email + '</span><br>';
  }
  return data;
}

function action_render(data, type, row, meta) {
  let output = '';
  if (type === 'display') {
    var onclick = "remove('" + row.id + "','dt_offices')";
    output = '<a href="<?= base_url(ADMINPATH . "office-list?id=") ?>' + row.id + '" class="btn actnbtn btn-orange" title="Edit Office"><i class="tf-icons bx bx-edit"></i></a> ';
    output += '<a class="btn actnbtn btn-red" onclick="' + onclick + '" title="Delete Office"><i class="tf-icons bx bx-trash"></i></a> ';
  }
  return output;
}

function status_render(data, type, row, meta) {
  if (type === 'display') {
    const isChecked = row.status === 'Active';
    const label = isChecked ? 'Active' : 'Inactive';
    const id = `tableswitch5${row.id}`;
    const onchange = `change_status(${row.id}, 'dt_offices')`;

    return `<div class="custom-control custom-switch">
                <input type="checkbox" onchange="${onchange}" ${isChecked ? 'checked' : ''} class="custom-control-input" id="${id}">
                <label class="custom-control-label" for="${id}" id="status_label${row.id}">${label}</label>
            </div> `;
  }
  return '';
}

</script>