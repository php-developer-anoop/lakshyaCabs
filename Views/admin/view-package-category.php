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
            <h4 class="cardhdng">Package Category List</h4>
            <a href="<?= base_url(ADMINPATH . 'add-package-category') ?>" class="sitebtn">Add</a>
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
            url: '<?= base_url(ADMINPATH . 'package-category-data'); ?>?' + qparam,
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
                "url": '<?= base_url(ADMINPATH . 'package-category-data'); ?>' + newQueryParam,
                "type": 'POST',
                dataSrc: (res) => {
                    return res.data
                }
            },
            "columns": [{ data: "sr_no", "name": "Sr.No", "title": "Sr.No" },
            { data: "", "title": "Category Details","render": category_details  },
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

var category_details = (data, type, row, meta) => {
  let result = '';
  let category_name = row.category_name != null ? row.category_name : "";
  let url = row.url != null ? row.url : "";
  let slug = row.slug != null ? row.slug : "";
  if (type === 'display') {
    result += '<span class="fotr_10"><b>Category Name : </b>' + category_name + '</span><br>';
    result += '<span class="fotr_10"><b>Category Slug: </b><a href="' + slug + '" target="_anoop">' + url + '</a></span>';
  }
  return result;
}

function action_render(data, type, row, meta) {
  let output = '';
  if (type === 'display') {
    var onclick = "remove('" + row.id + "','dt_package_category')";
    output = '<a href="<?= base_url(ADMINPATH . "add-package-category?id=") ?>' + row.id + '" class="btn actnbtn btn-orange" title="Edit Package Category"><i class="tf-icons bx bx-edit"></i></a> ';
    output += '<a class="btn actnbtn btn-red" onclick="' + onclick + '" title="Delete Package Category"><i class="tf-icons bx bx-trash"></i></a> ';
  }
  return output;
}

function status_render(data, type, row, meta) {
  if (type === 'display') {
    const isChecked = row.status === 'Active';
    const label = isChecked ? 'Active' : 'Inactive';
    const id = `tableswitch5${row.id}`;
    const onchange = `change_status(${row.id}, 'dt_package_category')`;

    const ismenu = row.is_menu === 'Yes';
    const labelmenu = ismenu ? 'Yes' : 'No';
    const idmenu = `tableswitch6${row.id}`;
    const onchangemenu = `change_menu(${row.id}, 'dt_package_category')`;

    const ispopular = row.is_popular === 'Yes';
    const labelpopular = ispopular ? 'Yes' : 'No';
    const idpopular = `tableswitch7${row.id}`;
    const onchangepopular = `change_popular(${row.id}, 'dt_package_category')`;

    const isspecial = row.is_special === 'Yes';
    const labelspecial = isspecial ? 'Yes' : 'No';
    const idspecial = `tableswitch8${row.id}`;
    const onchangespecial = `change_special(${row.id}, 'dt_package_category')`;

    return `<div class="d-flex flex-row gap-2"><b>Status : </b>
    <div class="custom-control custom-switch form-switch">
                <input type="checkbox" onchange="${onchange}" ${isChecked ? 'checked' : ''} class="custom-control-input form-check-input" id="${id}" role="switch">
                <label class="custom-control-label" for="${id}" id="status_label${row.id}">${label}</label>
            </div> </div>
            <div class="d-flex flex-row gap-2"><b>Is Menu : </b><div class="custom-control custom-switch form-switch"> 
                <input type="checkbox" onchange="${onchangemenu}" ${ismenu ? 'checked' : ''} class="custom-control-input form-check-input" id="${idmenu}" role="switch">
                <label class="custom-control-label" for="${idmenu}" id="menu_label${row.id}">${labelmenu}</label>
            </div> </div>
            <div class="d-flex flex-row gap-2"><b>Is Popular : </b><div class="custom-control custom-switch form-switch"> 
                <input type="checkbox" onchange="${onchangepopular}" ${ispopular ? 'checked' : ''} class="custom-control-input form-check-input" id="${idpopular}" role="switch">
                <label class="custom-control-label" for="${idpopular}" id="popular_label${row.id}">${labelpopular}</label>
            </div> </div>
            <div class="d-flex flex-row gap-2"><b>Is Special : </b><div class="custom-control custom-switch form-switch"> 
                <input type="checkbox" onchange="${onchangespecial}" ${isspecial ? 'checked' : ''} class="custom-control-input form-check-input" id="${idspecial}" role="switch">
                <label class="custom-control-label" for="${idspecial}" id="special_label${row.id}">${labelspecial}</label>
            </div> </div>
             `;
  }
  return '';
}

</script>