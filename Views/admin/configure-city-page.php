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
        <div class="row">
          <div class="col-lg-3">
            <select name="city" id="city" class="form-control select2">
              <option value="">Select City</option>
              <?php if (!empty($city_list)) {
                foreach ($city_list as $clkey => $clvalue) {
                ?>
              <option value="<?= $clvalue['id'],','.$clvalue['city_name'] ?>">
                <?= ($clvalue['city_name'] . ', ' . $clvalue['state_name']) ?>
              </option>
              <?php
                }
                } ?>
            </select>
          </div>
          <div class="col-lg-2"><button class="btn btn-success" id="create_page" onclick="return createPage()">Create Page</button></div>
        </div>
        <div class="dflexbtwn hdngvwall">
          <!--<a href="<?= base_url(ADMINPATH . 'add-route') ?>" class="sitebtn">Add Route</a>-->
        </div>
        <div class="table-responsive text-nowrap container">
          <input type="hidden" value="0" id="totalRecords" />
          <table id="responseData" class="table  mb-0 ">
            <thead>
              <tr>
                <th>Sr.No.</th>
                <th>City</th>
                <?php if(!empty($tab_list)){foreach($tab_list as $tlkey=>$tlvalue){?>
                <th><?=$tlvalue['tab_name']?></th>
                <?php }} ?>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $i = 1;
                if (!empty($page_list)) {
                    foreach ($page_list as $plkey => $plvalue) {
                        
                       
                ?>
              <tr>
                <th scope="row"><?= $i ?></th>
                <td><?= $plvalue['from_city_name'] ?></td>
                <?php
                  if (!empty($tab_list)) {
                      foreach ($tab_list as $tlkey => $tlvalue) {
                          $text_class = !empty(getTabStatus($plvalue['id'],$tlvalue['id'])) ? "text-success" : "text-danger";
                          $url = $plvalue['parent_id'] != 0 ? "?cms_id=" . $plvalue['id'] : "?parent_id=" . $plvalue['id'] . "&tab_id=" . $tlvalue['id'];
                  ?>
                <td><a href="<?= base_url(ADMINPATH . "edit-tab-city-seo-page") . $url ?>" class="" title="Add City Page"><i class="tf-icons bx bx-edit <?= $text_class ?>"></i></a></td>
                <?php
                  }
                  }
                  ?>
                <td><a class="btn actnbtn btn-red btn-sm" onclick="return deleteAllPage(<?=$plvalue['id']?>)" title="Delete Page"><i class="tf-icons bx bx-trash"></i></a></td>
              </tr>
              <?php
                $i++;
                }
                }
                ?>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="content-backdrop fade"></div>
</div>
<script>
$(document).ready(function() {
      $('#responseData').DataTable({
            "processing": true,
            "serverSide": false,
            
            
             
            "rowReorder": { selector: 'td:nth-child(2)' },
            "responsive": false,
            "autoWidth": false,
            "destroy": true,
            "searchDelay": 500,
            "searching": true,
            "pagingType": 'simple_numbers',
            //"rowId": (a) => { return 'id_' + a.id; },
            "iDisplayLength": 10,
            "order": [2, "asc"],
        });
});

    function getTotalRecordsData(qparam) {
        $.ajax({
            url: '<?= base_url(ADMINPATH . 'configure-city-data'); ?>?' + qparam,
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

    // $(document).ready(function () {
    //     let qparam = (new URL(location)).searchParams;
    //     getTotalRecordsData(qparam);
    // });

    function loadAllRecordsData(qparam) {
       // alert(qparam);
        $('#responseData').html('');
        var newQueryParam = '?'+qparam + '&recordstotal=' + $('#totalRecords').val();
        $('#responseData').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": '<?= base_url(ADMINPATH . 'configure-city-data'); ?>' + newQueryParam,
                "type": 'POST',
                dataSrc: (res) => {
                    return res.data
                }
            },
            "columns": [{ data: "sr_no", "name": "Sr.No", "title": "Sr.No" },
            { data: "from_city_name", "title": "City" },
            <?php if(!empty($tab_list)){foreach($tab_list as $tlkey=>$tlvalue){?>
            { data: "<?=$tlvalue['tab_name']?>", "title": "<?=$tlvalue['tab_name']?>","render":tab_data },
            <?php }} ?>
            //{ data: "", "title": "Dates","render":dates },
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

<?php
// Preprocess the tab list in PHP
$tab_ids = array_map(function($tab) {
    return $tab['id'];
}, $tab_list);

// Convert the PHP array to JSON format
$tab_list_json = json_encode($tab_ids);
?>


function tab_data(data, type, row, meta) {
  let output = '';
  let text_class = row.parent_id != 0 ? "text-primary" : "text-danger";
  let tabid = '';
  var tab_list = <?= $tab_list_json ?>;
  
//   console.log(tab_list);
  tab_list.forEach(tab => {
    if (row.tab_id.includes(tab)) {
      tabid = tab;
      // Move the URL generation inside the loop
      let url = row.parent_id != 0 ? "?cms_id=" + row.id : "?parent_id=" + row.id + "&tab_id=" + tabid;
      if (type === 'display') {
        // Construct the output inside the loop
        output = '<a href="<?= base_url(ADMINPATH . "edit-tab-city-seo-page") ?>' + url + '" class="" title="Add City Page"><i class="tf-icons bx bx-edit ' + text_class + '"></i></a> ';
      }
    }
  });

  return output;
}

function action_render(data, type, row, meta) {
  let output = '';
  if (type === 'display') {
    var onclick = "remove('" + row.id + "','dt_all_cms_data')";
    output = '<a href="<?= base_url(ADMINPATH . "edit-city-seo-page?id=") ?>' + row.id + '" class="btn actnbtn btn-orange btn-sm" title="Edit Route"><i class="tf-icons bx bx-edit"></i></a> ';
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

function createPage(){
    var city = $('#city').val();
    if(city == ""){
        toastr.error('Select City');
        return false;
    } else {
        $.ajax({
            url: '<?= base_url(ADMINPATH . 'createPage'); ?>',
            type: "POST",
            data: {city: city},
            cache: false,
            dataType: 'json',
            beforeSend: function() {
                $('#create_page').prop('disabled', true).text('Please Wait..');
            },
            success: function(response) {
                if(response.status == true){
                    toastr.success(response.message);
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                } else {
                    toastr.error(response.message);
                }
                $('#create_page').prop('disabled', false).text('Create Page');  
            },
            error: function(xhr, status, error) {
                toastr.error('Error occurred while processing the request.');
                $('#create_page').prop('disabled', false).text('Create Page');  
            }
        });  
    }
}


function deleteAllPage(parent_id){
  Swal.fire({
    title: "Are you sure?",
    text: "It Will Delete the Row!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, Delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
            url: '<?= base_url(ADMINPATH . 'deleteAllPage'); ?>',
            type: "POST",
            data: {parent_id:parent_id},
            cache: false,

            success: function (response) {
             
                    toastr.success('Record Deleted Successfully');
                    setTimeout(function() {
                           window.location.reload();
                    }, 1000);
                                            
                
               
            }
        });
    }
  });
}
</script>