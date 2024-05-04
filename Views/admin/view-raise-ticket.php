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
 		url: '<?= base_url(ADMINPATH . 'raised-ticket-data'); ?>?' + qparam,
 		type: "POST",
 		data: {
 			'is_count': 'yes',
 			'start': 0,
 			'length': 10
 		},
 		cache: false,
 		success: function(response) {
 			$('#totalRecords').val(response);
 			loadAllRecordsData(qparam);
 		}
 	});
 }
 $(document).ready(function() {
 	let qparam = (new URL(location)).searchParams;
 	getTotalRecordsData(qparam);
 });

 function loadAllRecordsData(qparam) {
 	$('#responseData').html('');
 	var newQueryParam = '?' + qparam + '&recordstotal=' + $('#totalRecords').val();
 	$('#responseData').DataTable({
 		"processing": true,
 		"serverSide": true,
 		"ajax": {
 			"url": '<?= base_url(ADMINPATH . 'raised-ticket-data'); ?>' + newQueryParam,
 			"type": 'POST',
 			dataSrc: (res) => {
 				return res.data
 			}
 		},
 		"columns": [{
 			data: "sr_no",
 			"name": "Sr.No",
 			"title": "Sr.No"
 		}, {
 			data: "id",
 			"title": "Ticked ID",
 			"render": ticket_details
 		}, {
 			data: "id",
 			"title": "Vendor Details",
 			"render": vendor_details
 		}, {
 			data: "subject",
 			"title": "Subject"
 		}, {
 			data: "status",
 			"title": "Status"
 		}, {
 			data: "urgency_type",
 			"title": "Urgency"
 		},  {
 			data: "id",
 			"title": "Dates",
 			"render": dates
 		}, {
 			data: "id",
 			"title": "Action",
 			"render": action_render
 		}, ],
 		"rowReorder": {
 			selector: 'td:nth-child(2)'
 		},
 		"responsive": false,
 		"autoWidth": false,
 		"destroy": true,
 		"searchDelay": 500,
 		"searching": true,
 		"pagingType": 'simple_numbers',
 		"rowId": (a) => {
 			return 'id_' + a.id;
 		},
 		"iDisplayLength": 10,
 		"order": [2, "asc"],
 	});
 }
 var vendor_details = (data, type, row, meta) => {
 	var data = '';
 	let user_name = row.user_name != null ? row.user_name : "N/A";
 	let user_mobile_no = row.user_mobile_no != null ? row.user_mobile_no : "N/A";
 	if (type === 'display') {
 		data += '<div class="d-flex-flex-column gap-0">';
 		data += '<p class="mb-0 text-start">' + row.user_name + '</p>';
 		data += '<p class="mb-0 text-start">' + row.user_mobile_no + '</p>';
 		data += '</div> ';
 	}
 	return data;
 }
 var dates = (data, type, row, meta) => {
 	output = '';
 	let add_date = row.add_date != null ? row.add_date : "N/A";
 	let update_date = row.update_date != null ? row.update_date : "N/A";
 	if (type === 'display') {
 	    output += '<span class="fotr_10"><b> Added On : </b>' + add_date + '</span><br>';
 		output += '<span class="fotr_10"><b> Updated On : </b>' + update_date + '</span>';
 	}
 	return output;
 }
 var ticket_details = (data, type, row, meta) => {
 	output = '';
 	let ticket_id = row.ticket_id != null ? row.ticket_id : "N/A";
 	if (type === 'display') {
 		output += '<span class="fotr_10"><a class="text-primary fw-bold" href="<?=base_url(ADMINPATH.'view-raised-ticket?ticket_id=')?>'+ticket_id+'">' + ticket_id + '</a></span>';
 	}
 	return output;
 }

 function action_render(data, type, row, meta) {
 	let output = '';
 	if (type === 'display') {
 		var onclick = "finalClose('" + row.id + "','dt_ticket_list')";
 		var disabledbutton = (row.is_final_closed == "yes") || (row.status == "Pending") ? "disabled" : "";
 		output = '<button onclick="' + onclick + '" id="finalClose' + row.id + '" ' + disabledbutton + '  class="btn actnbtn btn-success btn-sm" title="Final Close Ticket"><i class="tf-icons bx bx-check"></i></button>';
 	}
 	return output;
 }

 

 function finalClose(id, table) {
 	$.ajax({
 		url: '<?=base_url(ADMINPATH.'finalClose');?>',
 		type: "POST",
 		data: {
 			id: id,
 			table: table
 		},
 		cache: false,
 		dataType: 'json',
 		success: function(response) {
 			if (response.status == true) {
 				toastr.success(response.message);
 				$('#finalClose' + id).prop('disabled', true);
 			} else {
 				toastr.error(response.message);
 			}
 		}
 	});
 }
</script>