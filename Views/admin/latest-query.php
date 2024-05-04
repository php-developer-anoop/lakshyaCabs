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
          <div class="card-body">
               <div class="dflexbtwn hdngvwall">
                   <h4 class="card-hdng">Latest Query</h4>
               </div>  
               <div class="dflexbtwn mt-4"> 
                  <div class="bkdate_selct">
                      <div class="cstm_bookdate">
                          <i class="fa-solid fa-phone"></i>
                          <input type="text" class="form-control" placeholder="Search phone number">
                      </div>
                      <div class="cstm_bookdate">
                          <i class="fa-solid fa-location-dot"></i>
                          <input type="text" class="form-control" placeholder="Pick up City">
                      </div>
                      <div class="bkselect">
                          <select name="" id="" class="form-control select2" required>
                              <option value="">--Drop type--</option>
                          </select>
                      </div>
                  </div>
                  <div class="filtrbtn">
                      <button type="submit">Search</button>
                  </div>
               </div>
               
               <div class="mt-4 table-responsive text-nowrap">
                  <table id="tabless" class="table bookingtable mb-0">
                      <thead>
                          <tr>
                              <th>Sr. No.</th>
                              <th>Name</th>
                              <th>Trip Type</th>
                              <th>Pickup Destination</th>
                              <th>Drop Destination</th>
                              <th>Booking Date</th>
                              <th>Status</th>
                              <th>Last Updated</th>
                              <th style="min-width:140px">Action</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr>
                              <td>1</td>
                              <td>
                                  <div class="bkid">
                                      <p><a class="text-blue" href="query-detail">Booking ID: 1110110</a></p>
                                      <p>Arun K</p>
                                      <p>+91-9101101100</p>
                                  </div>
                              </td>
                              <td>
                                 <div class="cstmrdtl">
                                     <p>Outstation</p>
                                 </div>
                              </td>
                              <td>
                                  <div class="trpdtl">
                                      <p>112/ABC, Sector 1, Lucknow 226110</p>
                                  </div>
                              </td>
                              <td>
                                  <div class="drivrdtl">
                                      <p>112/ABC, Sector 1, Lucknow 226110</p>
                                  </div>
                              </td>
                              <td>
                                  <div class="vndrdtl">
                                      <p>2/01/2024</p>
                                  </div>
                              </td>
                              <td>
                                  <div class="status">
                                       <p class="bookingtag active">New</p>
                                  </div>
                              </td>
                              <td>
                                  <div class="status">
                                       <p>2/01/2024</p>
                                  </div>
                              </td>
                              <td>
                                  <div class="actnswrapr">
                                      <button class="btn actnbtn btn-blue" data-toggle="tooltip" data-placement="top" title="Tooltip on top" title="">
                                         <img src="https://lakshyacabs.nshops.in/uploads/discuss.png">
                                      </button>
                                      <button class="btn actnbtn btn-orange" data-toggle="tooltip" data-placement="top" title="Tooltip on top" title="">
                                         <img src="https://lakshyacabs.nshops.in/uploads/f-edit.png">
                                      </button>
                                      <button class="btn actnbtn btn-voilet" data-toggle="tooltip" data-placement="top" title="Tooltip on top" title="">
                                         <img src="https://lakshyacabs.nshops.in/uploads/convert.png">
                                      </button>
                                      <button class="btn actnbtn btn-dblue" data-toggle="tooltip" data-placement="top" title="Tooltip on top" title="">
                                        <img src="https://lakshyacabs.nshops.in/uploads/t-lead.png">
                                      </button>
                                      <button class="btn actnbtn btn-red" data-toggle="tooltip" data-placement="top" title="Tooltip on top" title="">
                                         <img src="https://lakshyacabs.nshops.in/uploads/trash.png">
                                      </button>
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td>2</td>
                              <td>
                                  <div class="bkid">
                                      <p><a class="text-blue" href="query-detail">Booking ID: 1110110</a></p>
                                      <p>Arun K</p>
                                      <p>+91-9101101100</p>
                                  </div>
                              </td>
                              <td>
                                 <div class="cstmrdtl">
                                     <p>Outstation</p>
                                 </div>
                              </td>
                              <td>
                                  <div class="trpdtl">
                                      <p>112/ABC, Sector 1, Lucknow 226110</p>
                                  </div>
                              </td>
                              <td>
                                  <div class="drivrdtl">
                                      <p>112/ABC, Sector 1, Lucknow 226110</p>
                                  </div>
                              </td>
                              <td>
                                  <div class="vndrdtl">
                                      <p>2/01/2024</p>
                                  </div>
                              </td>
                              <td>
                                  <div class="status">
                                       <p class="bookingtag active">New</p>
                                  </div>
                              </td>
                              <td>
                                  <div class="status">
                                       <p>2/01/2024</p>
                                  </div>
                              </td>
                              <td>
                                  <div class="actnswrapr">
                                      <button class="btn actnbtn btn-blue" data-toggle="tooltip" data-placement="top" title="Tooltip on top" title="">
                                         <img src="https://lakshyacabs.nshops.in/uploads/discuss.png">
                                      </button>
                                      <button class="btn actnbtn btn-orange" data-toggle="tooltip" data-placement="top" title="Tooltip on top" title="">
                                         <img src="https://lakshyacabs.nshops.in/uploads/f-edit.png">
                                      </button>
                                      <button class="btn actnbtn btn-voilet" data-toggle="tooltip" data-placement="top" title="Tooltip on top" title="">
                                         <img src="https://lakshyacabs.nshops.in/uploads/convert.png">
                                      </button>
                                      <button class="btn actnbtn btn-dblue" data-toggle="tooltip" data-placement="top" title="Tooltip on top" title="">
                                        <img src="https://lakshyacabs.nshops.in/uploads/t-lead.png">
                                      </button>
                                      <button class="btn actnbtn btn-red" data-toggle="tooltip" data-placement="top" title="Tooltip on top" title="">
                                         <img src="https://lakshyacabs.nshops.in/uploads/trash.png">
                                      </button>
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td>3</td>
                              <td>
                                  <div class="bkid">
                                      <p class="text-blue">Booking ID: 1110110</p>
                                      <p>Arun K</p>
                                      <p>+91-9101101100</p>
                                  </div>
                              </td>
                              <td>
                                 <div class="cstmrdtl">
                                     <p>Outstation</p>
                                 </div>
                              </td>
                              <td>
                                  <div class="trpdtl">
                                      <p>112/ABC, Sector 1, Lucknow 226110</p>
                                  </div>
                              </td>
                              <td>
                                  <div class="drivrdtl">
                                      <p>112/ABC, Sector 1, Lucknow 226110</p>
                                  </div>
                              </td>
                              <td>
                                  <div class="vndrdtl">
                                      <p>2/01/2024</p>
                                  </div>
                              </td>
                              <td>
                                  <div class="status">
                                       <p class="bookingtag active">New</p>
                                  </div>
                              </td>
                              <td>
                                  <div class="status">
                                       <p>2/01/2024</p>
                                  </div>
                              </td>
                              <td>
                                  <div class="actnswrapr">
                                      <button class="btn actnbtn btn-blue" data-toggle="tooltip" data-placement="top" title="Tooltip on top" title="">
                                         <img src="https://lakshyacabs.nshops.in/uploads/discuss.png">
                                      </button>
                                      <button class="btn actnbtn btn-orange" data-toggle="tooltip" data-placement="top" title="Tooltip on top" title="">
                                         <img src="https://lakshyacabs.nshops.in/uploads/f-edit.png">
                                      </button>
                                      <button class="btn actnbtn btn-voilet" data-toggle="tooltip" data-placement="top" title="Tooltip on top" title="">
                                         <img src="https://lakshyacabs.nshops.in/uploads/convert.png">
                                      </button>
                                      <button class="btn actnbtn btn-dblue" data-toggle="tooltip" data-placement="top" title="Tooltip on top" title="">
                                        <img src="https://lakshyacabs.nshops.in/uploads/t-lead.png">
                                      </button>
                                      <button class="btn actnbtn btn-red" data-toggle="tooltip" data-placement="top" title="Tooltip on top" title="">
                                         <img src="https://lakshyacabs.nshops.in/uploads/trash.png">
                                      </button>
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td>4</td>
                              <td>
                                  <div class="bkid">
                                      <p class="text-blue">Booking ID: 1110110</p>
                                      <p>Arun K</p>
                                      <p>+91-9101101100</p>
                                  </div>
                              </td>
                              <td>
                                 <div class="cstmrdtl">
                                     <p>Outstation</p>
                                 </div>
                              </td>
                              <td>
                                  <div class="trpdtl">
                                      <p>112/ABC, Sector 1, Lucknow 226110</p>
                                  </div>
                              </td>
                              <td>
                                  <div class="drivrdtl">
                                      <p>112/ABC, Sector 1, Lucknow 226110</p>
                                  </div>
                              </td>
                              <td>
                                  <div class="vndrdtl">
                                      <p>2/01/2024</p>
                                  </div>
                              </td>
                              <td>
                                  <div class="status">
                                       <p class="bookingtag active">New</p>
                                  </div>
                              </td>
                              <td>
                                  <div class="status">
                                       <p>2/01/2024</p>
                                  </div>
                              </td>
                              <td>
                                  <div class="actnswrapr">
                                      <button class="btn actnbtn btn-blue" data-toggle="tooltip" data-placement="top" title="Tooltip on top" title="">
                                         <img src="https://lakshyacabs.nshops.in/uploads/discuss.png">
                                      </button>
                                      <button class="btn actnbtn btn-orange" data-toggle="tooltip" data-placement="top" title="Tooltip on top" title="">
                                         <img src="https://lakshyacabs.nshops.in/uploads/f-edit.png">
                                      </button>
                                      <button class="btn actnbtn btn-voilet" data-toggle="tooltip" data-placement="top" title="Tooltip on top" title="">
                                         <img src="https://lakshyacabs.nshops.in/uploads/convert.png">
                                      </button>
                                      <button class="btn actnbtn btn-dblue" data-toggle="tooltip" data-placement="top" title="Tooltip on top" title="">
                                        <img src="https://lakshyacabs.nshops.in/uploads/t-lead.png">
                                      </button>
                                      <button class="btn actnbtn btn-red" data-toggle="tooltip" data-placement="top" title="Tooltip on top" title="">
                                         <img src="https://lakshyacabs.nshops.in/uploads/trash.png">
                                      </button>
                                  </div>
                              </td>
                          </tr>
                      </tbody>
                  </table>
                </div>
               
          </div>
        </div>
      </div>
    </div>
  </div>
</div>