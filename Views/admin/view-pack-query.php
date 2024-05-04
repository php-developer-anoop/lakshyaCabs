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
            url: '<?= base_url(ADMINPATH . 'package-queries-data'); ?>?' + qparam,
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
                "url": '<?= base_url(ADMINPATH . 'package-queries-data'); ?>' + newQueryParam,
                "type": 'POST',
                dataSrc: (res) => {
                    return res.data
                }
            },
            "columns": [{ data: "sr_no", "name": "Sr.No", "title": "Sr.No" },
            { data: "","title": "Contact Details","render":contact_details },
            { data: "", "title": "Travel Details","render":travel_details },
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

var contact_details = (data, type, row, meta) => {
  var data = '';
  let pickup_location = row.pickup_location != null ? row.pickup_location : "";
  let phone = row.phone != null ? row.phone : "";
  let package_name = row.package_name != null ? row.package_name : "";

  if (type === 'display') {
    data += '<span class="fotr_10"><b>Pickup Location : </b>' + pickup_location + '</span><br>';
    data += '<span class="fotr_10"><b>Phone : </b>' + phone + '</span><br>';
    if(package_name!=''){
      data += '<span class="fotr_10"><b>Package : </b>' + package_name + '</span>';
    }
  }
  return data;
}

var travel_details = (data, type, row, meta) => {
  var data = '';
  let travel_datetime = row.travel_datetime != null ? row.travel_datetime : "";
  let no_of_days = row.no_of_days != null ? row.no_of_days : "";
  let no_of_people = row.no_of_people != null ? row.no_of_people : "";
  if (type === 'display') {
    data += '<span class="fotr_10"><b>Travel Date : </b>' + travel_datetime + '</span><br>';
    if(no_of_days!=0){
      data += '<span class="fotr_10"><b>Days : </b>' + no_of_days + '</span><br>';
    }
    if(no_of_people!=0){
      data += '<span class="fotr_10"><b>People : </b>' + no_of_people + '</span>';
    }
    
  }
  return data;
}

function action_render(data, type, row, meta) {
  let output = '';
  if (type === 'display') {
    var onclick = "remove('" + row.id + "','dt_package_query')";
    
    output = '<a class="btn actnbtn btn-red" onclick="' + onclick + '" title="Delete Query"><i class="tf-icons bx bx-trash"></i></a> ';
  }
  return output;
}

</script>