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
    <div class="d-flex flex-column gap-3">
      <div class="card border-0 rounded-4">
        <div class="card-body">
            <div class="dflexbtwn hdngvwall">
          <h4 class="cardhdng"><?=$title?></h4>
          <a href="<?= base_url(VENDORPATH . 'add-ticket') ?>" class="sitebtn">Add</a>
        </div>
          <div class="table-responsive">
              <input type="hidden" id="totalRecords" value="0">
            <table class="table" id="responseData">
              
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  function getTotalRecordsData(qparam) {
      $.ajax({
          url: '<?= base_url(VENDORPATH . 'ticket-data'); ?>?' + qparam,
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
              "url": '<?= base_url(VENDORPATH . 'ticket-data'); ?>' + newQueryParam,
              "type": 'POST',
              dataSrc: (res) => {
                  return res.data
              }
          },
          "columns": [{ data: "sr_no", "name": "Sr.No", "title": "Sr.No" },
          { data: "id", "title": "Ticked ID","render":ticket_details },
          { data: "id", "title": "Vendor Details","render":vendor_details },
          { data: "subject", "title": "Subject" },
          { data: "status", "title": "Status" },
          { data: "urgency_type", "title": "Urgency" },
          { data: "add_date", "title": "Submitted"},
          { data: "", "title": "Last Updated","render":dates},
        
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
  
  
  var vendor_details = (data, type, row, meta) => {
  var data = '';
  let user_name = row.user_name != null ? row.user_name : "";
  let user_mobile_no = row.user_mobile_no != null ? row.user_mobile_no : "";
    
    // <div class="d-flex-flex-column gap-0">
    //                   <p class="mb-0 text-start">Arun K</p>
    //                   <p class="mb-0 text-start">+91-9101010010</p>
    //                 </div> 
  if (type === 'display') {
  data += '<div class="d-flex-flex-column gap-0">';   
  data += '<p class="mb-0 text-start">'+row.user_name+'</p>';
  data += '<p class="mb-0 text-start">'+row.user_mobile_no+'</p>';
  data += '</div> ';
  }
  return data;
  }
  
  var dates = (data, type, row, meta) => {
    output='';
  let update_date = row.update_date != null ? row.update_date : "N/A";
  if (type === 'display') {

    output += '<span class="fotr_10">' + update_date + '</span>';
  }
  return output;
}

var ticket_details = (data, type, row, meta) => {
    output='';
  let ticket_id = row.ticket_id != null ? row.ticket_id : "N/A";
  if (type === 'display') {

    output += '<span class="fotr_10"><a class="text-primary fw-bold" href="<?=base_url(VENDORPATH.'view-ticket?ticket_id=')?>'+ticket_id+'">' + ticket_id + '</a></span>';
  }
  return output;
}
  
  function action_render(data, type, row, meta) {
  let output = '';
  if (type === 'display') {
  var onclick = "remove('" + row.id + "','dt_ticket_master')";
  output = '<a href="<?= base_url(ADMINPATH . "add-ticket?id=") ?>' + row.id + '" class="btn actnbtn btn-orange" title="Edit Ticket"><i class="tf-icons bx bx-edit"></i></a> ';
  //output += '<a class="btn btn-sm btn-danger text-white" onclick="' + onclick + '" title="Delete State"><i class="tf-icons bx bx-trash"></i></a> ';
  }
  return output;
  }
  
  function status_render(data, type, row, meta) {
  if (type === 'display') {
  const isChecked = row.status === 'Active';
  const label = isChecked ? 'Active' : 'Inactive';
  const id = `tableswitch5${row.id}`;
  const onchange = `change_status(${row.id}, 'dt_states')`;
  
  return `<div class="custom-control custom-switch form-switch">
              <input type="checkbox" onchange="${onchange}" ${isChecked ? 'checked' : ''} class="custom-control-input form-check-input" id="${id}" role="switch">
              <label class="custom-control-label" for="${id}" id="status_label${row.id}">${label}</label>
          </div> `;
  }
  return '';
  }
  
</script>