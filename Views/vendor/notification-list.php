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
          url: '<?= base_url(VENDORPATH . 'notification-data'); ?>?' + qparam,
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
              "url": '<?= base_url(VENDORPATH . 'notification-data'); ?>' + newQueryParam,
              "type": 'POST',
              dataSrc: (res) => {
                  return res.data
              }
          },
          "columns": [{ data: "sr_no", "name": "Sr.No", "title": "Sr.No" },
          { data: "title", "title": "Title"},
          { data: "description", "title": "Description" },
          { data: "status", "title": "Status" },
          { data: "add_date", "title": "Added On"},
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
  
  
</script>