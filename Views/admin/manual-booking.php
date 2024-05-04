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
                <div class="dflexbtwn hdngvwall">
                        <h4 class="card-hdng">Create Manual Booking</h4>
                </div> 
                <div class="card mb-4">
                  <div class="card-body">
                    <div class="col-xl-12">
                      <div class="nav-align-top mb-2">
                        <div class="dflexgp">
                            <div class="navhdng">
                                <h2 class="card-hdng">Choose Trip Type</h2>
                            </div>
                            <ul class="nav nav-pills radiolike mb-3" role="tablist">
                                    <a href="https://lakshyacabs.nshops.in/admin/add-oneway-fare">
                                        <li class="nav-item" role="presentation">
                                            <button type="button" class="nav-link active " role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-oneway" aria-controls="navs-pills-top-oneway" aria-selected="true">
                                            Oneway </button>
                                        </li>
                                    </a>
                                    <a href="https://lakshyacabs.nshops.in/admin/add-outstation-fare">
                                        <li class="nav-item" role="presentation">
                                            <button type="button" class="nav-link  " role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-oneway" aria-controls="navs-pills-top-oneway" aria-selected="false" tabindex="-1">
                                            Outstation </button>
                                        </li>
                                    </a>
                                    <a href="https://lakshyacabs.nshops.in/admin/add-local-fare">
                                        <li class="nav-item" role="presentation">
                                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-oneway" aria-controls="navs-pills-top-oneway" aria-selected="false" tabindex="-1">
                                            Local </button>
                                        </li>
                                    </a>
                                    <a href="https://lakshyacabs.nshops.in/admin/add-airport-fare">
                                        <li class="nav-item" role="presentation">
                                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-oneway" aria-controls="navs-pills-top-oneway" aria-selected="false" tabindex="-1">
                                            Airport </button>
                                        </li>
                                    </a>
                            </ul>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <form action="" id="" method="post" accept-charset="utf-8">
                                <div class="row bkngform">
                                  <div class="col-sm-6 mb-3">
                                      <label for="pickup_city" class="col-form-label">From</label> 
                                      <input type="text" name="drop_city" autocomplete="off" onkeyup="" value="" class="form-control" id="" placeholder="Enter location" />
                                   </div>
                                  <div class="col-sm-6 mb-3">
                                    <label for="drop_city" class="col-form-label">To</label>             
                                    <input type="text" name="drop_city" autocomplete="off" onkeyup="" value="" class="form-control" id="" placeholder="Enter location" />
                                  </div>
                                  <div class="col-sm-6  mb-3 position-relative">
                                      <label for="pickup_city" class="col-form-label">Date</label> 
                                      <input type="date" name="drop_city" autocomplete="off" onkeyup="" value="" class="form-control" id="" placeholder="Enter location" />
                                   </div>
                                  <div class="col-sm-6  mb-3 position-relative">
                                    <label for="drop_city" class="col-form-label">Time</label>             
                                    <input type="time" name="drop_city" autocomplete="off" onkeyup="" value="" class="form-control" id="" placeholder="Enter location" />
                                  </div>
                                  <div class="bookbtn mt-3">
                                      <button type="submit" id="submit" class="btn">Submit</button>
                                  </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-7">
                            <div class="cabs_table">
                                <table>
                                    <tr>
                                        <td><p class="fs-14"><span class="text-blue fw-medium">Dzire  Or Similar (Sedan CNG + 1)</span>(4)</p></td>
                                        <td><p>Fare per KM</p> <span>₹ 15.00</span></td>
                                        <td><p>Est. KM</p> <span>₹ 335.00</span></td>
                                        <td><p>Total Fare</p> <span>₹ 7481.25</span></td>
                                        <td class="maxw-100">
                                            <span class="fs-12 text-blue fw-medium">Fare Summary</span>
                                            <button class="tbl_cabbook">Book Now</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><p class="fs-14"><span class="text-blue fw-medium">Ertiga  Or Similar (SUV AC + 1)</span>(6)</p></td>
                                        <td><p>Fare per KM</p> <span>₹ 15.00</span></td>
                                        <td><p>Est. KM</p> <span>₹ 335.00</span></td>
                                        <td><p>Total Fare</p> <span>₹ 7481.25</span></td>
                                        <td class="maxw-100">
                                            <span class="fs-12 text-blue fw-medium">Fare Summary</span>
                                            <button class="tbl_cabbook">Book Now</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><p class="fs-14"><span class="text-blue fw-medium">Dzire  Or Similar (Sedan CNG + 1)</span>(4)</p></td>
                                        <td><p>Fare per KM</p> <span>₹ 15.00</span></td>
                                        <td><p>Est. KM</p> <span>₹ 335.00</span></td>
                                        <td><p>Total Fare</p> <span>₹ 7481.25</span></td>
                                        <td class="maxw-100">
                                            <span class="fs-12 text-blue fw-medium">Fare Summary</span>
                                            <button class="tbl_cabbook">Book Now</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><p class="fs-14"><span class="text-blue fw-medium">Ertiga  Or Similar (SUV AC + 1)</span>(6)</p></td>
                                        <td><p>Fare per KM</p> <span>₹ 15.00</span></td>
                                        <td><p>Est. KM</p> <span>₹ 335.00</span></td>
                                        <td><p>Total Fare</p> <span>₹ 7481.25</span></td>
                                        <td class="maxw-100">
                                            <span class="fs-12 text-blue fw-medium">Fare Summary</span>
                                            <button class="tbl_cabbook">Book Now</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><p class="fs-14"><span class="text-blue fw-medium">Dzire  Or Similar (Sedan CNG + 1)</span>(4)</p></td>
                                        <td><p>Fare per KM</p> <span>₹ 15.00</span></td>
                                        <td><p>Est. KM</p> <span>₹ 335.00</span></td>
                                        <td><p>Total Fare</p> <span>₹ 7481.25</span></td>
                                        <td class="maxw-100">
                                            <span class="fs-12 text-blue fw-medium">Fare Summary</span>
                                            <button class="tbl_cabbook">Book Now</button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-5">
                            <h4 class="card-hdng mb-3">Fare Detail</h4>
                            <div class="farediv">
                              <h5>Fare Breakup:</h5>
                              <div class="dflexbtwn">
                                  <p>Estimated Amount</p>
                                  <p>₹ 7125</p>
                              </div>
                              <div class="dflexbtwn">
                                  <p>Covered KM</p>
                                  <p>335 KM</p>
                              </div>
                              <div class="dflexbtwn">
                                  <p>GST (5%)</p>
                                  <p>₹ 356</p>
                              </div>
                              <div class="dflexbtwn">
                                  <p>Discount</p>
                                  <div class="fareinput"><input type="text" value="- 0"></div>
                              </div>
                              <div class="dflexbtwn">
                                  <p>Extra Charge</p>
                                  <div class="fareinput"><input type="text" value="+ 0"></div>
                              </div>
                              <div class="dflexbtwn">
                                  <p>Advance Amount</p>
                                  <div class="fareinput"><input type="text" value="+ 0"></div>
                              </div>
                              <div class="dflexbtwn">
                                  <p>Advance Amount Mode</p>
                                  <div class="fareselect">
                                      <select class="form-select">
                                          <option>Select Payment Mode</option>
                                          <option>Online</option>
                                          <option>Cash</option>
                                      </select>
                                  </div>
                              </div>
                              <div class="dflexbtwn">
                                  <p>Total Cost</p>
                                  <p>₹ 7481</p>
                              </div>
                              <div class="dflexbtwn">
                                  <div class="form-check">
                                     <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                     <label class="form-check-label" for="flexCheckDefault1">
                                        Flight number
                                     </label>
                                  </div>
                                  <div class="fareinput"><input type="text" placeholder="Enter flight number"></div>
                              </div>
                              <div class="dflexbtwn ">
                                  <div class="form-check">
                                     <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                     <label class="form-check-label" for="flexCheckDefault2">
                                        Send SMS Booking
                                     </label>
                                  </div>
                                  <div class="form-check">
                                     <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault3">
                                     <label class="form-check-label" for="flexCheckDefault3">
                                        Send Email Booking
                                     </label>
                                  </div>
                                  <div class="form-check">
                                     <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4">
                                     <label class="form-check-label" for="flexCheckDefault4">
                                        Send Payment Link
                                     </label>
                                  </div>
                              </div>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <h4 class="card-hdng mb-3">Customer Details</h4>
                            <div class="row csmtdtls">
                                  <div class="col-sm-12 mb-3">
                                      <label for="pickup_city" class="col-form-label">Full name</label> 
                                      <input type="text" name="drop_city" autocomplete="off" onkeyup="" value="" class="form-control" id="" placeholder="Enter full name" />
                                  </div>
                                  <div class="col-sm-6 mb-3">
                                    <label for="drop_city" class="col-form-label">Mobile Number</label>             
                                    <input type="text" name="drop_city" autocomplete="off" onkeyup="" value="" class="form-control" id="" placeholder="Enter mobile number" />
                                  </div>
                                  <div class="col-sm-6 mb-3">
                                    <label for="drop_city" class="col-form-label">Alt Mobile Number</label>             
                                    <input type="text" name="drop_city" autocomplete="off" onkeyup="" value="" class="form-control" id="" placeholder="Enter mobile number" />
                                  </div>
                                  <div class="col-sm-6 mb-3">
                                    <label for="drop_city" class="col-form-label">Email</label>             
                                    <input type="email" name="drop_city" autocomplete="off" onkeyup="" value="" class="form-control" id="" placeholder="Enter email ID" />
                                  </div>
                                  <div class="col-sm-6 mb-3">
                                    <label for="drop_city" class="col-form-label">Number of Passenger</label>             
                                    <select class="form-select">
                                          <option>Number of Passenger</option>
                                          <option>2</option>
                                          <option>4</option>
                                    </select>
                                  </div>
                                  <div class="col-sm-6  mb-3">
                                      <label for="pickup_city" class="col-form-label">Pick up from</label> 
                                      <input type="text" name="drop_city" autocomplete="off" onkeyup="" value="" class="form-control" id="" placeholder="Enter pickup address" />
                                   </div>
                                  <div class="col-sm-6 mb-3">
                                    <label for="drop_city" class="col-form-label">Drop to</label>             
                                    <input type="text" name="drop_city" autocomplete="off" onkeyup="" value="" class="form-control" id="" placeholder="Enter drop address" />
                                  </div>
                                  <div class="col-sm-6  mb-3">
                                      <label for="" class="col-form-label">GSTIN</label> 
                                      <input type="text" name="drop_city" autocomplete="off" onkeyup="" value="" class="form-control" id="" placeholder="Enter GSTIN" />
                                  </div>
                                  <div class="col-sm-6 mb-3">
                                    <label for="drop_city" class="col-form-label">Billing State</label>             
                                    <select class="form-select">
                                          <option>Select State</option>
                                          <option>2</option>
                                          <option>4</option>
                                    </select>
                                  </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <button class="tbl_cabbook sbmtbtn">Submit</button>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>         
                    
    </div>
</div>        
     
                   
                    