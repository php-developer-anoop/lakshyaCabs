<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb" class="d-flex flex-row justify-content-between ">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="javascript:void(0);">Home</a>
        </li>
        <li class="breadcrumb-item">
          <a href="javascript:void(0);"><?=$menu ?></a>
        </li>
        <li class="breadcrumb-item active"><?=$title ?></li>
      </ol>
    </nav>
    <div class="card pt-2">
        <div class="card-body">
          <div class="dflexbtwn hdngvwall">
                 <h4 class="cardhdng">User Role </h4>
                 <a href="<?= base_url(ADMINPATH . 'add-role-user') ?>" class="sitebtn">Add Role User</a>
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
            url: '<?= base_url(ADMINPATH . 'role-user-data'); ?>?' + qparam,
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
                "url": '<?= base_url(ADMINPATH . 'role-user-data'); ?>' + newQueryParam,
                "type": 'POST',
                dataSrc: (res) => {
                    return res.data
                }
            },
            "columns": [{ data: "sr_no", "name": "Sr.No", "title": "Sr.No" },
            { data: "", "title": "State Name","render":user_detail },
            { data: "", "title": "Login Details","render":login_detail },
            { data: "", "title": "Dates","render":dates },
          
            { data: "status","title": "Status"},
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

    
    var user_detail = (data, type, row, meta) => {
  var data = '';
  let user_name = row.user_name != null ? row.user_name : "";
  let user_email = row.user_email != null ? row.user_email : "";
  let user_phone = row.user_phone != null ? row.user_phone : "";
  if (type === 'display') {
    data += '<span class="fotr_10"><b>Name : </b>' + user_name + '</span><br>';
    data += '<span class="fotr_10"><b>Email : </b>' + user_email + '</span><br>';
    data += '<span class="fotr_10"><b>Phone : </b>' + user_phone + '</span>';
  }
  return data;
}

 var login_detail = (data, type, row, meta) => {
  var data = '';
  let last_login = row.last_login != null ? row.last_login : "";
  let otp = row.otp != null ? row.otp : "";

  if (type === 'display') {
    data += '<span class="fotr_10"><b>Last Login : </b>' + last_login + '</span><br>';
    data += '<span class="fotr_10"><b>OTP : </b>' + otp + '</span>';
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
    var onclick = "remove('" + row.id + "','dt_role_users')";
    output = '<a href="<?= base_url(ADMINPATH . "add-role-user?id=") ?>' + row.id + '" class="btn actnbtn btn-orange" title="Edit Role User"><i class="tf-icons bx bx-edit"></i></a> ';
   // output += '<a href="<?= base_url(ADMINPATH . "assign-menu?id=") ?>' + row.id + '" class="btn btn-success btn-sm" ><i class="tf-icons bx bx-menu"></i></a>';
  }
  return output;
}




</script>