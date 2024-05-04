<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb" class="d-flex flex-row justify-content-between">
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
              <h4 class="cardhdng">Fare List</h4>
              <a href="<?= base_url(ADMINPATH . 'add-oneway-fare') ?>" class="sitebtn">Add</a>
          </div>
          <div class="table-responsive text-nowrap">
            <input type="hidden" value="0" id="totalRecords"/>
            <table id="responseData" class="table mb-0">
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
            url: '<?= base_url(ADMINPATH . 'fare-data'); ?>?' + qparam,
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

    $(document).ready(function (){
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
                "url": '<?= base_url(ADMINPATH . 'fare-data'); ?>' + newQueryParam,
                "type": 'POST',
                dataSrc: (res) => {
                    return res.data
                }
            },
            "columns": [{ data: "sr_no", "name": "Sr.No", "title": "Sr.No" },
            { data: "", "title": "Fare Details", "render": fare_details },
            { data: "", "title": "Charges", "render": charges },
            { data: "id", "title": "Vehicle","name":"Vehicle", "render": vehicleDetails },
            { data: "", "title": "Pickup/Drop", "render": location_details },
            { data: "", "title": "Dates", "render": dates },
            <?php if(!empty($access) || ($user_type != "Role User") ){?>
            { data: "", "title": "Status", "render": status_render },
            { data: "", "title": "Action", "render": action_render }
            <?php } ?>
            
          ],
            scrollY: false,
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

var vehicleDetails =  (data, type, row, meta) => {
  var data = ''; 
  if (type === 'display') {
    data += '<span class="fotr_10"><b>Model : </b>' + (row.model_name != null ? row.model_name : "") + '</span><br>';
    data += '<span class="fotr_10"><b>Category: </b>' + (row.category_name != null ? row.category_name : "") + '</span>'; 
  }
  return data;
}

var fare_details = (data, type, row, meta) => {
  var data = '';
  let trip_type = row.trip_type != null ? row.trip_type : "";
  let base_fare = row.base_fare != null ? row.base_fare : "";
  let base_covered_km = row.base_covered_km != null ? row.base_covered_km : "";
  let covered_hours = row.covered_hours != null ? row.covered_hours : "";
  if (type === 'display') {
    data += '<span class="fotr_10"><b>Trip Type : </b>' + trip_type + '</span><br>';
    data += '<span class="fotr_10"><b>Base Fare : </b>' + base_fare + '</span><br>';
    data += '<span class="fotr_10"><b>Base Covered KM: </b>' + base_covered_km + '</span><br>';
    data += '<span class="fotr_10"><b>Covered Hours: </b>' + covered_hours + '</span>';
  }
  return data;
}

var charges = (data, type, row, meta) => {
  var data = '';
  let per_minute_charge = row.per_minute_charge != null ? row.per_minute_charge : "";
  let per_km_charge = row.per_km_charge != null ? row.per_km_charge : "";
  let night_charge = row.night_charge != null ? row.night_charge : "";
  let driver_charge = row.driver_charge != null ? row.driver_charge : "";
  if (type === 'display') {
    data += '<span class="fotr_10"><b>Per Minute Charge : </b>' + per_minute_charge + '</span><br>';
    data += '<span class="fotr_10"><b>Per KM Charge : </b>' + per_km_charge + '</span><br>';
    data += '<span class="fotr_10"><b>Night Charge : </b>' + night_charge + '</span><br>';
    data += '<span class="fotr_10"><b>Driver Charge: </b>' + driver_charge + '</span>';

  }
  return data;
}
var location_details = (data, type, row, meta) => {
  var data = '';
  let pickup_city_name = row.pickup_city_name != null ? row.pickup_city_name : "";
  let drop_city_name = row.drop_city_name != null ? row.drop_city_name : "";
  if (type === 'display') {
    data += '<span class="fotr_10"><b>Pickup : </b>' + pickup_city_name + '</span><br>';
    data += '<span class="fotr_10"><b>Drop : </b>' + drop_city_name + '</span>';

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
  let path = '';
  if(row.trip_type === 'Oneway'){
      path = 'update-oneway-fare';
  }
  if(row.trip_type === 'Outstation'){
      path = 'update-outstation-fare';
  }
  if(row.trip_type === 'Local'){
      path = 'update-local-fare';
  }
  if(row.trip_type === 'Airport'){
      path = 'update-airport-fare';
  }
  if (type === 'display') {
    var onclick = "remove('" + row.id + "','dt_fare_configuration')";
    output = '<a href="<?= base_url(ADMINPATH) ?>'+path +'?id=' + row.id +'" class="btn actnbtn btn-orange" title="Edit Fare"><i class="tf-icons bx bx-edit"></i></a> ';
    output += '<a class="btn actnbtn btn-red" onclick="' + onclick + '" title="Delete Fare"><i class="tf-icons bx bx-trash"></i></a> ';
  }
  return output;
}

function status_render(data, type, row, meta) {
  if (type === 'display') {
    const isChecked = row.status === 'Active';
    const label = isChecked ? 'Active' : 'Inactive';
    const id = `tableswitch5${row.id}`;
    const onchange = `change_status(${row.id}, 'dt_fare_configuration')`;

    return `<div class="custom-control custom-switch form-switch">
                <input type="checkbox" onchange="${onchange}" ${isChecked ? 'checked' : ''} class="custom-control-input form-check-input" id="${id}" role="switch">
                <label class="custom-control-label" for="${id}" id="status_label${row.id}">${label}</label>
            </div> `;
  }
  return '';
}


</script>