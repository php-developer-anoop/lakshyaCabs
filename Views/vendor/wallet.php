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
    <div class="row">
      <div class="col-xxl">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div class="dflexbtwn walletbg">
                <div class="wltleft">
                  <span>Total Balance</span>  
                  <h3> <?=!empty($vendor['wallet_balance'])?'₹ '.$vendor['wallet_balance']:"N/A"?></h3>
                </div>
                <div class="arrowimg">
                  <img src="<?=base_url('assets/vendor/images/whitewallet.png')?>">
                </div>
                <div class="wltright">
                  <button class="sitebtn" data-bs-toggle="modal" data-bs-target="#addmoney">Add Fund</button>   
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card mb-4">
          <div class="card-body">
            <div class="mt-4 table-responsive text-nowrap">
                <input type="hidden" id="totalRecords" value="0">
              <table id="responseData" class="table wallettable mb-0">
                
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="addmoney">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body paymodel p-0">
        <div class="modal-header p-0">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modeltxt mt-4">
          <h5>Select The Amount</h5>
          <div class="cstmradio">
            <ul class="donate-row">
                <?php if(!empty($plan_list)){foreach($plan_list as $plkey=>$plvalue){?>
              <li><input type="radio" id="ax<?=(int)$plvalue['amount']?>" name="amount" onclick="getAmount(<?=(int)$plvalue['amount']?>)"><label for="ax<?=(int)$plvalue['amount']?>"><?=(int)$plvalue['amount']?></label></li>
                <?php } } ?>
            </ul>
          </div>
          <div class="custminput">
            <label>Or Enter Amount to add</label>
            <input type="text" placeholder="Enter amount" id="amount"  maxlength="6" name="" class="numbersWithZeroOnlyInput" autocomplete="off">
          </div>
          <div class="mdlbtns">
            <button class="sitebtn" id="renderBtn" onclick="return loadGateway()">Add Amount</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
 <script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>
<script>
    function getAmount(val){
        $('#amount').val(val);
    }
    const cashfree = Cashfree({
        mode: "sandbox" //or production,
      });
    function loadGateway(){
       var amount= $('#amount').val();
       
       if(amount.trim()==''){
           toastr.error('Please Enter Amount');
           return false;
       }
         $.ajax({
    url: "<?=base_url(VENDORPATH.'getToken')?>",
    method: 'POST',
    data: { amount: amount },
    dataType: 'json',
    beforeSend: function() {
      $('#renderBtn').prop('disabled', true).text('Please Wait...');
    },
    success: function(response) {
      if (response.status) {
        toastr.success(response.message);
        //alert(response.data.payment_session_id);
        var paymentSessionId  = response.data.payment_session_id;  
        let paymentOptions = { 
            paymentSessionId: paymentSessionId,
            returnUrl: "<?=base_url('vendor/my-wallet')?>",
            redirect: "_self"
        }  
        cashfree.checkout( paymentOptions );
      } else {
        toastr.error(response.message);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log('Error: ' + errorThrown);
    },
  });
    }
    
    
    function getTotalRecordsData(qparam) {
        $.ajax({
            url: '<?= base_url(VENDORPATH . 'my-wallet-data'); ?>?' + qparam,
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
                "url": '<?= base_url(VENDORPATH . 'my-wallet-data'); ?>' + newQueryParam,
                "type": 'POST',
                dataSrc: (res) => {
                    return res.data
                }
            },
            "columns": [{ data: "sr_no", "name": "Sr.No", "title": "Sr.No" },
            { data: "id", "title": "Transaction","render":txn_id_data},
            { data: 'id', "title": "Credit/Debit","render":credit_debit_render},
            //{ data: "id", "title": "Status","render":orderstatus },
            { data: "txn_amount", "title": "Amount" },
            { data: "order_status", "title": "Status" },
            { data: "remark", "title": "Remark" },
            { data: "id", "title": "Download Receipt","render":download_receipt },
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
     var credit_debit_render = ( data, type, row, meta )=>{
  var data = '';
  let credit_debit= row.credit_debit!=null?capitalizeFirstLetters(row.credit_debit):"";
  if(type === 'display'){
        data= '<span>'+credit_debit+'</span><br>' ;
  }
return data;
}

   var txn_id_data = ( data, type, row, meta )=>{
  var data = '';
  let reference_id= row.reference_id!=null?row.reference_id:"N/A";
  let add_date= row.add_date!=null?row.add_date:"N/A";
  if(type === 'display'){
        data = "<div class='bkid'>";
        data+= '<p>'+reference_id+'</p>' ;
        data+= '<p class="transdate">'+add_date+'</p>' ;
        data+= '</div>';
  }
return data;
}

var download_receipt = (data, type, row, meta) => {
    var buttonHtml = '';
    if (type === 'display') {
        var endpoint = '<?= base_url(VENDORPATH.'downloadReceipt?id=')?>'+row.reference_id;
        buttonHtml = '<a class="btn btn-sm" href="' + endpoint + '" target="_anoop" title="Download Receipt"><i class="tf-icons bx bx-download"></i></a> ';
    }
    return buttonHtml;
}

</script>