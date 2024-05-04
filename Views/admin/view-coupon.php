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
          <div class="dflexbtwn hdngvwall">
                 <h4 class="cardhdng">Coupon List</h4>
                 <a href="<?= base_url(ADMINPATH . 'add-coupon') ?>" class="sitebtn">Add Coupon</a>
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
            url: '<?= base_url(ADMINPATH . 'coupon-data'); ?>?' + qparam,
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
                "url": '<?= base_url(ADMINPATH . 'coupon-data'); ?>' + newQueryParam,
                "type": 'POST',
                dataSrc: (res) => {
                    return res.data
                }
            },
            "columns": [{ data: "sr_no", "name": "Sr.No", "title": "Sr.No" },
            { data: "id", "title": "Coupon Detail","render":coupon_detail },
            { data: "id", "title": "Location Detail","render":location_type },
            { data: "id", "title": "Validity","render":valid_details },
            { data: "", "title": "Dates","render":dates },
           <?php if(!empty($access) || ($user_type != "Role User") ){?>
            { data: "", "name": "Status", "title": "Status", "render": status_render },
           
            { data: "id", "name": "Action", "title": "Action", "render": action_render }
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

   var coupon_detail = (data, type, row, meta) => {
  var data = '';
  let coupon_code = row.coupon_code != null ? row.coupon_code : "";
  let coupon_type = row.coupon_type != null ? row.coupon_type : "";
  let coupon_value = row.coupon_value !== null ? parseInt(row.coupon_value) : "";

  if (type === 'display') {
    data += '<span class="fotr_10"><b>Coupon Code : </b>' + coupon_code + '</span><br>';
    data += '<span class="fotr_10"><b>Coupon Type: </b>' + capitalizeFirstLetters(coupon_type) + '</span><br>';
    data += '<span class="fotr_10"><b>Coupon Value: </b>' + coupon_value + '</span>';
  }
  return data;
}

  var location_type = (data, type, row, meta) => {
  var data = '';
  let trip_type = row.trip_type != null ? row.trip_type : "";
  let city_name = row.city_name != "" ? row.city_name : "N/A";
  if (type === 'display') {
    data += '<span class="fotr_10"><b>Trip Type : </b>' + trip_type + '</span><br>';
    data += '<span class="fotr_10"><b>City: </b>' + city_name + '</span>';
  }
  return data;
}

   var valid_details = (data, type, row, meta) => {
  var data = '';
  let valid_from = row.valid_from != null ? row.valid_from : "";
  let valid_till = row.valid_till != null ? row.valid_till : "";
  if (type === 'display') {
    data += '<span class="fotr_10"><b>Valid From : </b>' + valid_from + '</span><br>';
    data += '<span class="fotr_10"><b>Valid Till : </b>' + valid_till + '</span>';
  }
  return data;
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

function action_render(data, type, row, meta) {
  let output = '';
  if (type === 'display') {
    var onclick = "remove('" + row.id + "','dt_coupon_list')";
    output = '<a href="<?= base_url(ADMINPATH . "add-coupon?id=") ?>' + row.id + '" class="btn actnbtn btn-orange btn-sm" title="Edit Reason"><i class="tf-icons bx bx-edit"></i></a> ';
    //output += '<a class="btn btn-sm btn-danger text-white" onclick="' + onclick + '" title="Delete State"><i class="tf-icons bx bx-trash"></i></a> ';
  }
  return output;
}

function status_render(data, type, row, meta) {
  if (type === 'display') {
    const isChecked = row.status === 'Active';
    const label = isChecked ? 'Active' : 'Inactive';
    const id = `tableswitch5${row.id}`;
    const onchange = `change_status(${row.id}, 'dt_coupon_list')`;

    return `<div class="custom-control custom-switch form-switch">
                <input type="checkbox" onchange="${onchange}" ${isChecked ? 'checked' : ''} class="custom-control-input form-check-input" id="${id}" role="switch">
                <label class="custom-control-label" for="${id}" id="status_label${row.id}">${label}</label>
            </div> `;
  }
  return '';
}

</script>