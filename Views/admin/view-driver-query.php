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
     
      <div class="table-responsive text-nowrap container">
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
            url: '<?= base_url(ADMINPATH . 'driver-queries-data'); ?>?' + qparam,
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
                "url": '<?= base_url(ADMINPATH . 'driver-queries-data'); ?>' + newQueryParam,
                "type": 'POST',
                dataSrc: (res) => {
                    return res.data
                }
            },
            "columns": [{ data: "sr_no", "name": "Sr.No", "title": "Sr.No" },
            { data: "","title": "Driver Details","render":driver_details },
            { data: "","title": "Location","render":location_details },
            { data: "", "title": "Documents Details","render":document_details },
            { data: "add_date", "title": "Added On" },
             <?php if(!empty($access) || ($user_type != "Role User") ){?>
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


var location_details = (data, type, row, meta) => {
  var data = '';
  let city = row.city != null ? row.city : "";
  let state = row.state != null ? row.state : "";
  let address = row.address != null ? row.address : "";
  if (type === 'display') {
    data += '<span class="fotr_10"><b>City : </b>' + city + '</span><br>';
    data += '<span class="fotr_10"><b>State: </b>' + state + '</span><br>';
    data += '<span class="fotr_10"><b>Address: </b>' + address + '</span><br>';

  }
  return data;
}

var driver_details = (data, type, row, meta) => {
  var data = '';
  let driver_name = row.driver_name != null ? row.driver_name : "";
  let driver_phone = row.driver_phone != null ? row.driver_phone : "";
  let driver_email = row.driver_email != null ? row.driver_email : "";
  let driver_alternate_phone = row.driver_alternate_phone != null ? row.driver_alternate_phone : "";

  if (type === 'display') {
    data += '<span class="fotr_10"><b>Pickup Location : </b>' + driver_name + '</span><br>';
    data += '<span class="fotr_10"><b>Phone : </b>' + driver_phone + '</span><br>';
    data += '<span class="fotr_10"><b>Email : </b>' + driver_email + '</span><br>';
    if(driver_alternate_phone!=''){
      data += '<span class="fotr_10"><b>Alternate Phone : </b>' + driver_alternate_phone + '</span>';
    }
  }
  return data;
}

var document_details = (data, type, row, meta) => {
  var data = '';
  let rc_file = row.rc_file != null ? row.rc_file : "";
  let dl_file = row.dl_file != null ? row.dl_file : "";
  let ic_file = row.ic_file != null ? row.ic_file : "";
  let base_url='<?=base_url('uploads/')?>';
  if (type === 'display') {
    
    if (rc_file != null) {
    data += '<span class="fotr_10"><b>RC : </b><a href="' + base_url + rc_file + '" target="_anoop">Click To View</a></span><br>';
}

if (dl_file != null) {
    data += '<span class="fotr_10"><b>DL : </b><a href="' + base_url + dl_file + '" target="_anoop">Click To View</a></span><br>';
}

if (ic_file != null) {
    data += '<span class="fotr_10"><b>IC : </b><a href="' + base_url + ic_file + '" target="_anoop">Click To View</a></span><br>';
}

    
  }
  return data;
}

function action_render(data, type, row, meta) {
  let output = '';
  if (type === 'display') {
    var onclick = "remove('" + row.id + "','dt_driver_query')";
    
    output = '<a class="btn btn-sm btn-danger text-white" onclick="' + onclick + '" title="Delete Query"><i class="tf-icons bx bx-trash"></i></a> ';
  }
  return output;
}

</script>