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
              <h4 class="cardhdng">Route list </h4>
              <a href="<?= base_url(ADMINPATH . 'add-route') ?>" class="sitebtn">Add Route</a>
        </div>
        <div class="table-responsive text-nowrap container">
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
            url: '<?= base_url(ADMINPATH . 'route-data'); ?>?' + qparam,
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
                "url": '<?= base_url(ADMINPATH . 'route-data'); ?>' + newQueryParam,
                "type": 'POST',
                dataSrc: (res) => {
                    return res.data
                }
            },
            "columns": [{ data: "sr_no", "name": "Sr.No", "title": "Sr.No" },
            { data: "", "title": "Route Details","render": route_details  },
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

var route_details = (data, type, row, meta) => {
  var data = '';
  let page_name = row.page_name != null ? row.page_name : "";  
  let page_url = row.page_url != null ? row.page_url : "";
  let slug = row.page_slug != null ? row.page_slug : "";
  if (type === 'display') {
    data += '<span class="fotr_10"><b>Display Name : </b>' + page_name + '</span><br>'; 
    data += '<span class="fotr_10"><b>Slug: </b><a href="' + page_url + '" target="_anoop">' + slug + '</a></span>'; 
  }
  return data;
}

function action_render(data, type, row, meta) {
  let output = '';
  if (type === 'display') {
    var onclick = "remove('" + row.id + "','dt_all_cms_data')";
    output = '<a href="<?= base_url(ADMINPATH . "add-route?id=") ?>' + row.id + '" class="btn actnbtn btn-orange btn-sm" title="Edit Route"><i class="tf-icons bx bx-edit"></i></a> ';
    output += '<a class="btn actnbtn btn-red btn-sm" onclick="' + onclick + '" title="Delete Route"><i class="tf-icons bx bx-trash"></i></a> ';
  }
  return output;
}

function status_render(data, type, row, meta) {
  if (type === 'display') {
    const isChecked = row.status === 'Active';
    const label = isChecked ? 'Active' : 'Inactive';
    const id = `tableswitch5${row.id}`;
    const onchange = `change_status(${row.id}, 'dt_all_cms_data')`; 


    return `<div class="d-flex flex-row gap-2"><b>Status : </b><div class="custom-control custom-switch form-switch pointer">
                <input type="checkbox" onchange="${onchange}" ${isChecked ? 'checked' : ''} class="custom-control-input form-check-input" id="${id}" role="switch">
                <label class="custom-control-label" for="${id}" id="status_label${row.id}">${label}</label>
            </div><br/>${row.is_updated}</div> 
             `;
  }
  return '';
}

</script>