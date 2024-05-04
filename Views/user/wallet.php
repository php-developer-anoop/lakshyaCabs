<div class="wd_dashcontent">
  <div class="container bookingpg">
    <div class="row">
      <h3>My Wallet</h3>
    </div>
    <div class="row walletwrpr">
      <div class="waltamnt_add">
        <p class="balnc">Balance: <?=!empty($wallet_balance)?'₹'.(int)$wallet_balance:'N/A';?></p>
        <a href="javascript:void(0)" class="yellwbtn" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Money</a>
      </div>
      <div class="table-responsive text-nowrap container mt-2">
        <input type="hidden" value="0" id="totalRecords" />
        <table id="responseData" class="table  mb-0 ">
        </table>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Money</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3 position-relative">
            <label class="form-label" for="">Amount</label>
            <input placeholder="Enter amount" type="text" id="amount" maxlength="6" class="form-control numbersWithZeroOnlyInput" autocomplete="off">
            <input type="hidden" name="user_id" value="<?=$user_id?>">
          </div>
          <?php if(!empty($plan_list)){?>
          <p>(Or) Select Amount</p>
          <div class="chooseamntrow">
            <?php foreach($plan_list as $plkey=>$plvalue){?>
            <a href="javascript:void(0)" onclick="getAmount(this.textContent)" class="chsamnt"><?=!empty($plvalue['amount'])?(int)$plvalue['amount']:''?></a>
            <?php  } ?>
          </div>
          <?php  } ?>
          <button class="sitebtn grnbtn" type="button" id="renderBtn" onclick="return loadGateway()"> Pay Now</button>
        </form>
      </div>
    </div>
  </div>
</div>
<div class='modal'>
<Modal.Header closeButton>
  <Modal.Title>Add Money</Modal.Title>
</Modal.Header>
<Modal.Body>
  <Form>
    <Form.Group class="mb-3 position-relative" controlId="">
      <Form.Label>Amount</Form.Label>
      <Form.Control type="text" placeholder="Enter amount" id="" />
    </Form.Group>
    <p>(Or) Select Amount</p>
    <div class="chooseamntrow">
      <a href="javascript:void(0)"  class="chsamnt">₹100</a>
      <a href="javascript:void(0)"  class="chsamnt">₹500</a>
      <a href="javascript:void(0)"  class="chsamnt">₹1000</a> 
      <a href="javascript:void(0)"  class="chsamnt">₹2000</a>
      <a href="javascript:void(0)"  class="chsamnt">₹5000</a>
      <a href="javascript:void(0)"  class="chsamnt">₹10000</a> 
    </div>
    <Button class="sitebtn grnbtn" type="button">
    Pay Now
    </Button>
  </Form>
</Modal.Body>
</Modal>

<script>
    function getAmount(val){
        $('#amount').val(val);
    }
    const cashfree = Cashfree({
        mode: "<?php echo CASHFREE_MODE == 'TEST' ? 'sandbox':'production'; ?>"
      });
    function loadGateway(){
       var amount= $('#amount').val();
       
       if(amount.trim()==''){
           toastr.error('Please Enter Amount');
           return false;
       }
         $.ajax({
    url: "<?=base_url(USERPATH.'getToken')?>",
    method: 'POST',
    data: { amount: amount },
    dataType: 'json',
    beforeSend: function() {
      $('#renderBtn').prop('disabled', true).text('Please Wait...');
    },
    success: function(response) {
      if (response.status) {
        toastr.success(response.message); 
        var paymentSessionId  = response.data.payment_session_id;  
        let paymentOptions = { 
            paymentSessionId: paymentSessionId,
            returnUrl: "<?=base_url('user/my-wallet')?>",
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
            url: '<?= base_url(USERPATH . 'my-wallet-data'); ?>?' + qparam,
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
                "url": '<?= base_url(USERPATH . 'my-wallet-data'); ?>' + newQueryParam,
                "type": 'POST',
                dataSrc: (res) => {
                    return res.data
                }
            },
            "columns": [{ data: "sr_no", "name": "Sr.No", "title": "Sr.No" },
            { data: "reference_id", "title": "Reference Id"},
            { data: "credit_debit", "title": "Credit/Debit"},
            { data: "txn_amount", "title": "Amount" },
            { data: "add_date", "title": "Transaction Date" },
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
var download_receipt = (data, type, row, meta) => {
    var buttonHtml = '';
    if (type === 'display') {
        if (row.credit_debit === "credit") {
            var endpoint = '<?= base_url(USERPATH.'downloadReceipt?id=')?>' + row.reference_id;
            buttonHtml = '<p class="text-center">';
            buttonHtml += '<a class="btn btn-sm" href="' + endpoint + '" target="_anoop" title="Download Receipt"><i class="fa fa-download"></i></a> ';
            buttonHtml += '</p>';
            
        } else {
            buttonHtml = '<p class="text-center">';
            buttonHtml += 'N/A';
            buttonHtml += '</p>';
        }
    }
    return buttonHtml;
}

</script>