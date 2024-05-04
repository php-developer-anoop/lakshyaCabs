
<div class="content-wrapper card-full">
<div class="container-xxl flex-grow-1 container-p-y">
   
<div class="sitebreadcrumb">
  <a href="javascript:void(0)"><i class="fa-solid fa-house"></i>Dashboard</a>
</div>
<div class="sitepagename">
  <h3 class="pagename">Dashboard</h3>
</div>
<div class="row align-item-center">
  <div class="col-lg-6">
    <div class="row cardcstm_padd">
      <div class="col-lg-4 col-md-4 col-6 mb-2">
        <a href="<?=base_url(VENDORPATH.'booking-list?booking_status=new')?>">
          <div class="card">
            <div class="card-body">
              <span class="fw-medium d-block mb-1">New Bookings</span>
              <h4 class="card-title mb-2" id="new">00</h4>
              <!--<div class="prcnt_data">-->
              <!--  <p><i class="fa-solid fa-arrow-up-long"></i> 5.25%</p>-->
              <!--  <span>Since last month</span>-->
              <!--</div>-->
        <a href="<?=base_url(VENDORPATH.'booking-list')?>" class="cardcircle circle-add bg-blue"><i class="fa-solid fa-plus"></i></a>
        </div>
        </div></a>
      </div>
      <div class="col-lg-4 col-md-4 col-6 mb-2">
        <a href="<?=base_url(VENDORPATH.'booking-list?booking_status=pendingdriver')?>">
          <div class="card">
            <div class="card-body">
              <span class="fw-medium d-block mb-1">Driver Pending</span>
              <h4 class="card-title mb-2" id="pendingdriver">00</h4>
              <!--<div class="prcnt_data">-->
              <!--  <p><i class="fa-solid fa-arrow-up-long"></i> 5.25%</p>-->
              <!--  <span>Since last month</span>-->
              <!--</div>-->
            </div>
          </div>
        </a>
      </div>
      <div class="col-lg-4 col-md-4 col-6 mb-2">
        <a href="<?=base_url(VENDORPATH.'booking-list?booking_status=assigneddriver')?>">
          <div class="card">
            <div class="card-body">
              <span class="fw-medium d-block mb-1">Driver Assigned</span>
              <h4 class="card-title mb-2" id="assigneddriver">00</h4>
              <!--<div class="prcnt_data">-->
              <!--  <p><i class="fa-solid fa-arrow-up-long"></i> 5.25%</p>-->
              <!--  <span>Since last month</span>-->
              <!--</div>-->
        <a href="javascript:void(0)" class="cardcircle circle-add bg-red"><i class="fa-solid fa-times"></i></a>
        </div>
        </div></a>
      </div>
      <div class="col-lg-4 col-md-4 col-6 mb-2">
        <a href="<?=base_url(VENDORPATH.'booking-list?booking_status=inprogress')?>">
          <div class="card">
            <div class="card-body">
              <span class="fw-medium d-block mb-1">In Progress</span>
              <h4 class="card-title mb-2" id="inprogress">00</h4>
              <!--<div class="prcnt_data">-->
              <!--  <p><i class="fa-solid fa-arrow-up-long"></i> 5.25%</p>-->
              <!--  <span>Since last month</span>-->
              <!--</div>-->
            </div>
          </div>
        </a>
      </div>
      <div class="col-lg-4 col-md-4 col-6 mb-2">
        <a href="<?=base_url(VENDORPATH.'booking-list?booking_status=completed')?>">
          <div class="card">
            <div class="card-body">
              <span class="fw-medium d-block mb-1">Completed</span>
              <h4 class="card-title mb-2" id="completed">00</h4>
              <!--<div class="prcnt_data">-->
              <!--  <p><i class="fa-solid fa-arrow-up-long"></i> 5.25%</p>-->
              <!--  <span>Since last month</span>-->
              <!--</div>-->
            </div>
          </div>
        </a>
      </div>
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="dflexbtwn">
              <div class="wltleft">
                <h3><?=!empty($vendor['wallet_balance'])?'₹ '.$vendor['wallet_balance']:"N/A"?></h3>
                <span>Wallet</span>  
              </div>
              <div class="arrowimg">
                <img src="<?=base_url('assets/vendor/images/wallet-up.png')?>">
              </div>
              <div class="wltright">
                <a href="<?=base_url(VENDORPATH.'my-wallet')?>" class="text-white"><button class="sitebtn">+ Add</button></a>   
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card">
      <div class="card-body">
        <h3 class="card-hdng">Whats up for today</h3>
        <p class="cardsub">Total bookings <span id="bcount">0</span></p>
        <div class="custom_calender d-flex">
          <div class="daydate rcc" onclick="return getDayWiseBookings('<?=date('Y-m-d', strtotime('yesterday'))?>')" id="currentdate_<?=date('Y-m-d', strtotime('yesterday'))?>">
            <span><?=date('D', strtotime('yesterday'))?></span>
            <p><?=date('d', strtotime('yesterday'))?></p>
          </div>
          <?php for($i=0; $i<9; $i++) { ?>
          <div class="daydate rcc <?php if (date('d') == date('d', strtotime("$i days"))) echo 'currentday'; ?>" onclick="return getDayWiseBookings('<?=date('Y-m-d', strtotime("+$i days"))?>')" id="currentdate_<?=date('Y-m-d', strtotime("+$i days"))?>">
            <span><?= date('D', strtotime("+$i days")) ?></span>
            <p><?= date('d', strtotime("+$i days")) ?></p>
          </div>
          <?php } ?>
        </div>
        <div class="bookinglist">
          <?php if(!empty($booking_list)){foreach($booking_list as $blkey=>$blvalue){?>
          <div class="booking_row">
            <div class="bkng_dtls border-blue">
              <h5><?=$blvalue['guest_name']?></h5>
              <span><?='+91 '.$blvalue['guest_mobile_no']?></span>
              <div class="cabtype">
                <span class="cabtag"><?=$blvalue['trip_type']?></span>
                <span class="picktext">Pickup: <?=$blvalue['pickup_city_name']?></span>
              </div>
              <p class="drivrname">Driver name - <?=$blvalue['driver_name']?> (<?=$blvalue['vehicle_no']?>)</p>
            </div>
            <div class="bkng_time">
              <h5><?=$blvalue['pickup_time']?></h5>
            </div>
            <div class="bkng_time">
              <a href="javascript:void(0)" onclick="return getBookingDetails(<?=$blvalue['id']?>)" class="sitebtn">View</a>
            </div>
          </div>
          <?php }} ?>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row mt-4">
  <?php if(!empty($wallet_list)){?>
  <div class="col-lg-6">
    <div class="card">
      <div class="card-body">
        <div class="dflexbtwn hdngvwall">
          <h4 class="cardhdng">Latest Transactions</h4>
          <a href="<?=base_url(VENDORPATH.'my-wallet')?>" class="sitebtn">View All</a>
        </div>
        <div class="cardtbl">
          <table>
            <tr>
              <th>Txn Id</th>
              <th>Amount</th>
              <th>Remark</th>
              <th>Date</th>
            </tr>
            <?php foreach($wallet_list as $wlkey=>$wlvalue){?>
            <tr>
              <td><?=$wlvalue['reference_id']?></td>
              <td><?=$wlvalue['txn_amount']?></td>
              <td><?=$wlvalue['remark']?></td>
              <td><?=$wlvalue['created_date']?></td>
            </tr>
            <?php } ?>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
  <div class="col-lg-6">
    <div class="card">
      <div class="card-body">
        <div class="dflexbtwn hdngvwall">
          <h4 class="cardhdng">Billing</h4>
          <a href="<?=base_url(VENDORPATH.'booking-paid')?>" class="sitebtn">View All</a>
        </div>
        <div class="progress-section">
          <div class="prgwrap">
            <div class="sideimg">
              <img src="<?=base_url('assets/vendor/images/cls-duty.png')?>">
            </div>
            <div class="task-progress">
              <p>Close Duty <span>36/100</span></p>
              <progress class="progress progress1" max="100" value="36"></progress>
            </div>
          </div>
          <div class="prgwrap">
            <div class="sideimg">
              <img src="<?=base_url('assets/vendor/images/r-invoice.png')?>">
            </div>
            <div class="task-progress">
              <p>Raised Invoices <span>100/1000</span></p>
              <progress class="progress progress3" max="100" value="10"></progress>
            </div>
          </div>
          <div class="prgsbtns">
            <a href="javascript:void(0)" class="pgbtns">Take Booking</a>
            <a href="javascript:void(0)" class="pgbtns tbtn">List Invoice</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row mt-4">
  <?php if(!empty($ratings)){?>
  <div class="col-lg-6">
    <div class="card">
      <div class="card-body">
        <div class="dflexbtwn hdngvwall">
          <h4 class="cardhdng">Rating history</h4>
          <a href="<?=base_url(VENDORPATH.'ratings')?>" class="sitebtn">View All</a>
        </div>
        <div class="ratingwrp">
          <?php foreach($ratings as $rkey=>$rvalue){?>
          <div class="row_rate">
            <h4><?=$rvalue['customer_name']?></h4>
            <div class="dflexbtwn">
              <div class="stars">
                <ul>
                  <?=showRatings($rvalue['rating'])?>
                </ul>
              </div>
              <span><?=$rvalue['add_date']?></span>
            </div>
            <p><?=$rvalue['description']?></p>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
  <?php if(!empty($ticket_list)){?>
  <div class="col-lg-6">
    <div class="card">
      <div class="card-body">
        <div class="dflexbtwn hdngvwall">
          <h4 class="cardhdng">Support Ticket</h4>
          <a href="<?=base_url(VENDORPATH.'tickets')?>" class="sitebtn">View All</a>
        </div>
        <div class="cardtbl tickettbl ">
          <table>
            <tr>
              <th>Ticket ID</th>
              <th>Name & Number</th>
              <th>Status</th>
              <th>Urgency</th>
              <th>Submitted On</th>
              <th>Updated On</th>
            </tr>
            <?php foreach($ticket_list as $tlkey=>$tlvalue){?>
            <tr>
              <td>
                <a href="<?=base_url(VENDORPATH.'view-ticket?ticket_id='.$tlvalue['ticket_id'])?>" class="text-blue fw-medium"><?=$tlvalue['ticket_id']?></a>
              </td>
              <td><?=$tlvalue['user_name']?> <br> +91-<?=$tlvalue['user_mobile_no']?></td>
              <td>
                <p class="text-green"><?=$tlvalue['status']?> </p>
              </td>
              <td>
                <p class="text-red"><?=$tlvalue['urgency_type']?></p>
              </td>
              <td><?=date('d/m/Y',strtotime($tlvalue['add_date']))?> <br> <?=date('h:i A',strtotime($tlvalue['add_date']))?></td>
              <td><?=date('d/m/Y',strtotime($tlvalue['update_date']))?><br> <?=date('h:i A',strtotime($tlvalue['update_date']))?></td>
            </tr>
            <?php } ?>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>

</div>


<script>
  function getCount( type,table ){  
    $.ajax({
      url: '<?= base_url(VENDORPATH.'getCount') ?>',
      type: "POST",
      data: {'type': type,'table':table},
      cache: false,
        success:function(response) {   
         $('#'+ type ).html(response);
        }
      });
    }
    function loaddatavalue(){  
  setTimeout( ()=>{ getCount( 'new','bookings' ); },200 );
  setTimeout( ()=>{ getCount( 'pendingdriver','bookings' ); },400 );
  setTimeout( ()=>{ getCount( 'assigneddriver','bookings' ); },600 );
  setTimeout( ()=>{ getCount( 'inprogress','bookings' ); },800 );
  setTimeout( ()=>{ getCount( 'completed','bookings' ); },1000 );

  
}
  
  window.load = loaddatavalue();
  
  function getDayWiseBookings(pickup_date){
      $('.rcc').removeClass('currentday');
      $('#currentdate_' + pickup_date).addClass('currentday');
      $('.bookinglist').html('');
      $('#bcount').html('');
     $.ajax({
      url: '<?= base_url(VENDORPATH.'getDayWiseBookings') ?>',
      type: "POST",
      data: {'pickup_date': pickup_date},
      cache: false,
      dataType:'json',
        success:function(response) {   
         $('.bookinglist').html(response.html);
         $('#bcount').html(response.booking_count);
        }
      }); 
  }
  
  function getBookingDetails(booking_id){
      $('#bookingDetailModal').modal('show');
      $('#appendBookingDetail').html('');
      $.ajax({
      url: '<?= base_url('api/v1/customer/getBookingDetails') ?>',
      type: "POST",
      data: {'booking_id': booking_id},
      dataType:'html',
      cache: false,
        success:function(response) {   
        $('#appendBookingDetail').html(response);
         
        }
      }); 
  }
</script>