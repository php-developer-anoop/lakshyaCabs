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
                <h5 class="cardhdng"><?=$menu?> List</h5>
                <a href="<?= base_url(ADMINPATH . 'calender-booking-conditions') ?>" class="sitebtn">Add</a>
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
            url: '<?= base_url(ADMINPATH . 'get-record-booking-conditions'); ?>?' + qparam,
            type: "POST",
            data: { 'is_count': 'yes', 'start': 0, 'length': 10 },
            cache: false,
            success: function (response) {
                $('#totalRecords').val(response); 
                    loadAllRecordsData(qparam); 
            }
        });
    }

    $(document).ready(function () {
        let qparam = (new URL(location)).searchParams;
        getTotalRecordsData(qparam);
    });

    function loadAllRecordsData(qparam) { 
        $('#responseData').html('');
        var newQueryParam = '?'+qparam + '&recordstotal=' + $('#totalRecords').val();
        $('#responseData').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": '<?= base_url(ADMINPATH . 'get-record-booking-conditions'); ?>' + newQueryParam,
                "type": 'POST',
                dataSrc: (res) => {
                    return res.data
                }
            },
            "columns": [{ data: "sr_no", "name": "Sr.No", "title": "Sr.No" },
            { data: "id", "title": "State/Trip Type","render": state_trip_detail},
            { data: "id", "title": "Date Range","render": date_range },
            { data: "id", "title": "Charge Details","render":charge_detail },
            { data: "id", "title": "Dates","render": dates },
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

var charge_detail = ( data, type, row, meta )=>{
  var data = ''; 
  if(type === 'display'){
        data += '<span class="fotr_10"><b>Charge Type : </b>'+row.charge_type+'</span><br>'; 
        data += '<span class="fotr_10"><b>Charge Value Type : </b>'+row.charge_value_type+'</span><br>'; 
         data += '<span class="fotr_10"><b>Charge Value : </b>'+row.charge_value+'</span>';
  }
return data;
}


var date_range = ( data, type, row, meta )=>{
  var data = ''; 
  if(type === 'display'){
        data += '<span class="fotr_10"><b>From : </b>'+row.from_date+'</span><br>' ;
        data += '<span class="fotr_10"><b>To : </b>'+row.to_date+'</span>' ;
      
  }
  return data;
}


var state_trip_detail = (data, type, row, meta) => {
  var data = ''; 
  if (type === 'display') {
    data += '<span class="fotr_10"><b>State: </b>' + row.state_name + '</span><br>';
    data += '<span class="fotr_10"><b>Trip: </b>' + row.display_name + '</span>'; 
  }
  return data;
}

var dates = (data, type, row, meta) => {
  var data = '';
  let add_date = row.add_date != null ? row.add_date : "";
  let update_date = row.update_date != null ? row.update_date : "";
  if (type === 'display') {
    data += '<span class="fotr_10"><b> Added On : </b>' + add_date + '</span><br>';
    data += '<span class="fotr_10"><b>Updated On: </b>' + update_date + '</span>';

  }
  return data;
}

function action_render(data, type, row, meta) {
  let output = '';
  if (type === 'display') {
    var onclick = "remove('" + row.id + "','dt_calender_booking_conditions')";
    output = '<a href="<?= base_url(ADMINPATH . "calender-booking-conditions?id=") ?>' + row.id + '" class="btn actnbtn btn-orange" title="Edit Record"><i class="tf-icons bx bx-edit"></i></a> ';
    output += '<a class="btn actnbtn btn-red" onclick="' + onclick + '" title="Delete Record"><i class="tf-icons bx bx-trash"></i></a> ';
  }
  return output;
}

function status_render(data, type, row, meta) {
  if (type === 'display') {
    const isChecked = row.status === 'Active';
    const label = isChecked ? 'Active' : 'Inactive';
    const id = `tableswitch5${row.id}`;
    const onchange = `change_status(${row.id}, 'dt_calender_booking_conditions')`;

    return `<div class="custom-control custom-switch form-switch">
                <input type="checkbox" onchange="${onchange}" ${isChecked ? 'checked' : ''} class="custom-control-input form-check-input" id="${id}" role="switch">
                <label class="custom-control-label" for="${id}" id="status_label${row.id}">${label}</label>
            </div> `;
  }
  return '';
}

</script>