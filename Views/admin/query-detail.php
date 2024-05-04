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
            <div class="card mb-4">
                <div class="card-body querywraper">
                    <div class="qrydtl-left">
                       <div class="dflexbtwn hdngvwall">
                           <div class="bkid_btn">
                              <h4 class="card-hdng">Booking ID:123455</h4>
                              <button class="editbtn">Edit</button>
                           </div>
                        </div>
                        <div class="editable_wrap">
                            <div class="primryarea">
                                <div class="row">
                                    <div class="col-6">
                                        <label>Name</label>
                                        <input class="noedit" type="text" value="Birendra Pandey" readonly>
                                    </div>
                                    <div class="col-6">
                                        <label>Email</label>
                                        <input class="noedit"type="text" value="brixyz@gmail.com" readonly>
                                    </div>
                                    <div class="col-6">
                                        <label>Mobile</label>
                                        <input class="noedit"type="text" value="+91-910101100" readonly>
                                    </div>
                                    <div class="col-6">
                                        <label>Trip Type</label>
                                        <input class="noedit" type="text" value="Outstation" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="bookingareadtl">
                                <h4>Booking Detail</h4>
                                <div class="bookingarea">
                                    <div class="row">
                                        <div class="col-12 dflx-txtright">
                                            <label>Booking Date & Time:</label>
                                            <input class="noedit" type="text" value="09/01/2024 11:32 PM" readonly>
                                        </div>
                                        <div class="col-12 dflx-txtright">
                                            <label>Pickup Location:</label>
                                            <textarea class="noedit" rows="3" readonly>HM173, Pocket B, Sukhdev Vihar, Okhla, New Delhi, 110025T2024140</textarea>
                                        </div>
                                        <div class="col-12 dflx-txtright">
                                            <label>Pickup date & time:</label>
                                            <input class="noedit" type="text" value="10/01/2024 03:15 AM" readonly>
                                        </div>
                                        <div class="col-12 dflx-txtright">
                                            <label>Drop Location:</label>
                                            <textarea class="noedit" rows="3" readonly>Pocket B, Sukhdev Vihar, Okhla, New Delhi, Delhi, India </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="qrydtl-right">
                        <div class="dflxend">
                            <div class="filtrbtn">
                                <button type="submit">Convert</button>
                            </div>
                        </div>
                        <div class="leadstage_wrap">
                            <h4>Lead Stage</h4>
                            <div class="dflexbtwn">
                               <nav class="bookingtabs">
                                   <button class="bktab active">New</button>
                                   <button class="bktab">Working</button>
                                   <button class="bktab">Follow Up</button>
                                   <button class="bktab">Customer</button>
                               </nav>
                            </div>
                            <div class="logact_wrap mt-4">
                                <div class="d-flex logactbtn">
                                    <button> <img src="https://lakshyacabs.nshops.in/uploads/log-act.png">
                                    Log Activity
                                    <img src="https://lakshyacabs.nshops.in/uploads/caret-up.png">
                                    </button>
                                    <div class="log_filters d-flex">
                                        <div class="custom-control custom-checkbox">
                                          <input class="custom-control-input" checked name="status" type="radio" id="checkStatus11">
                                          <label class="custom-control-label" for="checkStatus11">Call</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                          <input class="custom-control-input" name="status" type="radio" id="checkStatus12">
                                          <label class="custom-control-label" for="checkStatus12">Email</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                          <input class="custom-control-input" name="status" type="radio" id="checkStatus13">
                                          <label class="custom-control-label" for="checkStatus13">Whatsapp</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                          <input class="custom-control-input" name="status" type="radio" id="checkStatus14">
                                          <label class="custom-control-label" for="checkStatus14">SMS</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="loggforms">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="col-form-label" for="package_name" class="col-form-label">Lead Stage</label>
                                            <select name="" id="" class="form-control select2" required>
                                              <option value="">New leads</option>     
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="col-form-label" for="package_name" class="col-form-label">Lead Dispostion</label>
                                            <select name="" id="" class="form-control select2" required>
                                              <option value="">Follow up</option>     
                                            </select>
                                        </div>
                                        <div class="col-sm-10">
                                            <label class="col-form-label">Add Notes</label>
                                            <textarea class="form-control" rows="6" placeholder="Add notes here..."></textarea>
                                        </div>
                                        <div class="frmbtn mt-4">
                                            <button class="savebtn" type="submit">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
            <div class="card cstmcard_lp">
                          <div class="card-header">
                            <div class="d-flex justify-content-between">
                              <h5 class="mb-0">Discussion
                              <span class="ms-1" data-toggle="tooltip" data-placement="top" title="" data-bs-original-title="Tooltip on top" aria-label="Tooltip on top">
                                  <img src="dist/img/Tooltip.png" alt="">
                              </span>
                              </h5>
                            </div>  
                          </div>
                          <div class="card-body custom-scroll pt-0" data-select2-id="249">
                            <div class="discussion-modal-body" data-select2-id="248">
                              <ul class="history-list" data-select2-id="247">
                                <li class="history-item" data-select2-id="246">
                                  <div class="history-box" data-select2-id="245">
                                    <div class="history-icon"><img src="https://lakshyacabs.nshops.in/uploads/history-icon3.png" alt=""></div>
                                    <div class="d-flex">
                                        <h3>Connected</h3>
                                        <span><img src="https://lakshyacabs.nshops.in/uploads/microphone-filled.png" alt="">2m 40s</span>
                                    </div>
                                    <div class="leaddtls d-flex flex-wrap times">
                                        <span>Start: 10/06/2023, 10:50 AM</span>
                                        <span>End: 10/06/2023, 11:10 AM</span>
                                        <span class="recordings">
                                          <a href="#!" class="text-blue">Listen recording</a>
                                        </span>
                                    </div>
                                    <div class="form-group">
                                          <label>Choose option</label>
                                          <select class="form-control select2" tabindex="-1" aria-hidden="true" data-select2-id="102">
                                            <option data-select2-id="104">New leads</option>
                                          </select>
                                    </div>
                                    <ul class="child-history-list">
                                        <li class="child-history-item">
                                          <div class="child-history-box"> 
                                            <div class="child-history-icon"><img src="https://lakshyacabs.nshops.in/uploads/history-icon5.png" alt=""></div>
                                            <div class="d-flex flex-wrap">
                                               <textarea rows="3" class="child-history-input" placeholder="Good call. I introduced myself and he asked me to connect next week. Also mailed him brochures and program fee details"></textarea>
                                            </div>
                                          </div>
                                        </li>
                                      </ul>
                                  </div>
                                </li>
                                <li class="history-item">
                                  <div class="history-box">
                                    <div class="history-icon"><img src="https://lakshyacabs.nshops.in/uploads/history-icon3.png" alt=""></div>
                                    <h3>No Answer</h3>
                                    <h6>15/06/2023, 11:15 AM</h6>
                                  </div>
                                </li>
                                <li class="history-item">
                                  <div class="history-box">
                                    <div class="history-icon"><img src="https://lakshyacabs.nshops.in/uploads/history-icon3.png" alt=""></div>
                                    <h3>No Answer</h3>
                                    <h6>15/06/2023, 11:15 AM</h6>
                                  </div>
                                </li>
                                
                                <li class="history-item">
                                  <div class="history-box">
                                    <div class="history-icon"><img src="https://lakshyacabs.nshops.in/uploads/history-icon4.png" alt=""></div>
                                    <h3>hi</h3>
                                    <h6>15/06/2023, 11:15 AM</h6>
                                  </div>
                                </li>
                                <li class="history-item">
                                  <div class="history-box">
                                    <div class="history-icon"><img src="https://lakshyacabs.nshops.in/uploads/history-icon3.png" alt=""></div>
                                    <h3>No Answer</h3>
                                    <h6>15/06/2023, 11:15 AM</h6>
                                  </div>
                                </li>
                                <li class="history-item">
                                  <div class="history-box">
                                    <div class="history-icon"><img src="https://lakshyacabs.nshops.in/uploads/history-icon1.png" alt=""></div>
                                    <h3>Lead picked by Anirudh</h3>
                                    <h6>15/06/2023, 11:15 AM</h6>
                                  </div>
                                </li>
                              </ul>
                            </div>
                            <div class="text-center mt-3">
                              <a href="#!" class="load-more">Load More</a>
                            </div>
                          </div>
                      </div>
        </div>
    </div>
  </div>
</div>