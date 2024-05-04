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
            url: '<?= base_url(ADMINPATH . 'recharge-data'); ?>?' + qparam,
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
                "url": '<?= base_url(ADMINPATH . 'recharge-data'); ?>' + newQueryParam,
                "type": 'POST',
                dataSrc: (res) => {
                    return res.data
                }
            },
            "columns": [{ data: "sr_no", "name": "Sr.No", "title": "Sr.No" },
            { data: "customer_name", "title": "Customer Name" },
            { data: "", "title": "Order Detail","render":order_detail },
            { data: "", "title": "Amount Detail","render":amount_detail },
            { data: "add_date", "title": "Transaction Date" },
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

    
    var order_detail = (data, type, row, meta) => {
      var data = '';
      let order_id = row.order_id != null ? row.order_id : "";
      let order_status = row.order_status != null ? row.order_status : "";
      let cf_order_id = row.cf_order_id != null ? row.cf_order_id : "";
      if (type === 'display') {
        data += '<span class="fotr_10"><b>Order ID : </b>' + order_id + '</span><br>';
        data += '<span class="fotr_10"><b>Order Status: </b>' + order_status + '</span><br>';
        data += '<span class="fotr_10"><b>Cashfree Order ID: </b>' + cf_order_id + '</span>';
      }
      return data;
    }
    
    var amount_detail = (data, type, row, meta) => {
      var data = '';
      let order_amount = row.order_amount != null ? row.order_amount : "";
      let order_currency = row.order_currency != null ? row.order_currency : "";
      if (type === 'display') {
        data += '<span class="fotr_10"><b>Order Amount : </b>' + order_amount + '</span><br>';
        data += '<span class="fotr_10"><b>Order Currency : </b>' + order_currency + '</span>';
    
      }
      return data;
    }
</script>