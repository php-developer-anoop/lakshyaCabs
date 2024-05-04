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
    <div class="card pt-2">
        <div class="card-body">
          <div class="dflexbtwn hdngvwall d-none">
               <h4 class="cardhdng">Vehicle Model List</h4>
               <a href="<?= base_url(ADMINPATH . 'add-vehicle-model') ?>" class="sitebtn">Add</a>
          </div>
          <div class="table-responsive text-nowrap">
            <input type="hidden" value="0" id="totalRecords" />
            <table id="responseData" class="table  mb-0 ">
            </table>
          </div>
        </div>
    </div>
  </div>
  <div class="content-backdrop fade"></div>
</div>
<script>
    function getTotalRecordsData(qparam) {
        $.ajax({
            url: '<?= base_url(ADMINPATH . 'vendor-data'); ?>?' + qparam,
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
                "url": '<?= base_url(ADMINPATH . 'vendor-data'); ?>' + newQueryParam,
                "type": 'POST',
                dataSrc: (res) => {
                    return res.data
                }
            },
            "columns": [{ data: "sr_no", "name": "Sr.No", "title": "Sr.No" },
            { data: "id", "title": "Vendor Details", "render": vendor_details },
            { data: "id", "title": "Location Details", "render": vendor_location },
            { data: "id", "title": "Dates","render":dates },
            { data: "kyc_status", "title": "KYC Status" },
          <?php if(!empty($access) || ($user_type != "Role User") ){?>
            { data: "id",  "title": "Profile Status", "render": status_render },
           
            { data: "id",  "title": "Action", "render": action_render }
            <?php } ?>
          ],
             
            "rowReorder": { selector: 'td:nth-child(2)' },
            "responsive": false,
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
  let update_date = row.update_date != null ? row.update_date : "";
  if (type === 'display') {
    data += '<span class="fotr_10"><b>Added On : </b>' + add_date + '</span><br>';
    data += '<span class="fotr_10"><b>Updated On: </b>' + update_date + '</span>';

  }
  return data;
}

  

var vendor_details = (data, type, row, meta) => {
  var data = '';
  let unique_id = row.unique_id != null ? row.unique_id : "N/A";
  let full_name = row.full_name != null ? row.full_name : "N/A";
  let mobile_no = row.mobile_no != null ? row.mobile_no : "N/A";
  let email_id = row.email_id != null ? row.email_id : "N/A";
  let raw_password = row.raw_password != null ? row.raw_password : "N/A";
  let otp = row.otp != "" ? row.otp : "N/A";
  if (type === 'display') {
    data += '<span class="fotr_10"><b>Unique ID : </b>' + unique_id + '</span><br>';
    data += '<span class="fotr_10"><b>Full Name: </b>' + full_name + '</span><br>';
    data += '<span class="fotr_10"><b>Mobile No.: </b>' + mobile_no + '</span><br>';
    data += '<span class="fotr_10"><b>Email: </b>' + email_id + '</span><br>';
    data += '<span class="fotr_10"><b>Password: </b>' + raw_password + '</span><br>';
    data += '<span class="fotr_10"><b>OTP:  </b>' + otp + '</span>';
  }
  return data;
}

var vendor_location = (data, type, row, meta) => {
  var data = '';
  let state_name = row.state_name != null ? row.state_name : "N/A";
  let city_name = row.city_name != null ? row.city_name : "N/A";
  let pincode = row.pincode != null ? row.pincode : "N/A";

  if (type === 'display') {
    data += '<span class="fotr_10"><b>State : </b>' + state_name + '</span><br>';
    data += '<span class="fotr_10"><b>City : </b>' + city_name + '</span><br>';
    data += '<span class="fotr_10"><b>Pincode : </b>' + pincode + '</span>';


  }
  return data;
}

function action_render(data, type, row, meta) {
  let output = '';
  if (type === 'display') {
    var onclick = "remove('" + row.id + "','dt_vendor_list')";
    output = '<a href="<?= base_url(ADMINPATH . "edit-vendor?id=") ?>' + row.id + '" class="btn actnbtn btn-orange btn-sm" title="Edit Vendor Details"><i class="tf-icons bx bx-edit"></i></a> ';
    output += '<a class="btn actnbtn btn-red btn-sm" onclick="' + onclick + '" title="Delete Vendor"><i class="tf-icons bx bx-trash"></i></a> ';
  }
  return output;
}

function status_render(data, type, row, meta) {
  if (type === 'display') {
    const isChecked = row.profile_status === 'Active';
    const label = isChecked ? 'Active' : 'Inactive';
    const id = `tableswitch5${row.id}`;
    const onchange = `change_profile_status(${row.id}, 'dt_vendor_list')`;

    return `<div class="custom-control custom-switch form-switch">
                <input type="checkbox" onchange="${onchange}" ${isChecked ? 'checked' : ''} class="custom-control-input form-check-input" id="${id}" role="switch">
                <label class="custom-control-label" for="${id}" id="status_label${row.id}">${label}</label>
            </div> `;
  }
  return '';
}

 function change_profile_status(id, table) {
    $.ajax({
      url: '<?= base_url(ADMINPATH.'changeProfileStatus') ?>',
      type: "POST",
      data: { 'id': id, 'table': table },
      cache: false,
      success: function (response) {
       $('#status_label'+id).html(response);
      }
    });
  }

</script>