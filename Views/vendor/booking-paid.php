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
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#" class="d-flex flex-row gap-2 align-items-center"
              ><i class="fa-solid fa-house"></i> Dashboard
            </a>
          </li>
          <li class="breadcrumb-item"><a href="#">Booking</a></li>
          <li class="breadcrumb-item active" aria-current="page">Close Booking</li>
        </ol>
      </nav>
      <div class="card border-0 rounded-3 billsection">
        <div class="card-body">
          <div class="d-flex flex-row gap-4 selector">
            <h5>Select Trip Type</h5>
            <div class="form-check">
              <input
                class="form-check-input"
                type="radio"
                name="flexRadioDefault"
                id="flexRadioDefault1"
                />
              <label class="form-check-label" for="flexRadioDefault1">
              One way
              </label>
            </div>
            <div class="form-check">
              <input
                class="form-check-input"
                type="radio"
                name="flexRadioDefault"
                id="flexRadioDefault2"
                checked
                />
              <label class="form-check-label" for="flexRadioDefault2">
              Round Trip
              </label>
            </div>
            <div class="form-check">
              <input
                class="form-check-input"
                type="radio"
                name="flexRadioDefault"
                id="flexRadioDefault3"
                checked
                />
              <label class="form-check-label" for="flexRadioDefault3">
              Local
              </label>
            </div>
            <div class="form-check">
              <input
                class="form-check-input"
                type="radio"
                name="flexRadioDefault"
                id="flexRadioDefault4"
                checked
                />
              <label class="form-check-label" for="flexRadioDefault4">
              Airport
              </label>
            </div>
          </div>
          <div class="row gy-4 pt-3">
            <div class="col-lg-6">
              <div class="d-flex flex-column gap-3">
                <div class="input-card">
                  <h5>Enter fair details</h5>
                  <div class="card rounded-3 border-0 mt-1">
                    <div class="card-body">
                      <div class="d-flex flex-column gap-2">
                        <div class="d-flex flex-row gap-3">
                          <input type="text" placeholder="Start KM" />
                          <div class="plus d-flex align-items-center">
                            <i class="fa-solid fa-plus"></i>
                          </div>
                          <input type="text" placeholder="End KM" />
                          <div class="plus d-flex align-items-center">
                            <i class="fa-solid fa-equals"></i>
                          </div>
                          <input type="text" placeholder="Total KM" />
                        </div>
                        <div class="d-flex flex-row gap-3">
                          <input type="text" placeholder="Estimated KM" />
                          <div class="plus d-flex align-items-center">
                            <i class="fa-solid fa-plus"></i>
                          </div>
                          <input type="text" placeholder="Rate per KM" />
                          <div class="plus d-flex align-items-center">
                            <i class="fa-solid fa-equals"></i>
                          </div>
                          <input
                            type="text"
                            placeholder="Estimated fare"
                            />
                        </div>
                        <div class="d-flex flex-row gap-3">
                          <input type="text" placeholder="Extra KM" />
                          <div class="plus d-flex align-items-center">
                            <i class="fa-solid fa-plus"></i>
                          </div>
                          <input type="text" placeholder="Rate per KM" />
                          <div class="plus d-flex align-items-center">
                            <i class="fa-solid fa-equals"></i>
                          </div>
                          <input type="text" placeholder="Extra fare" />
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card rounded-3 border-0 mt-3">
                    <div class="card-body">
                      <div class="d-flex flex-column gap-2">
                        <div class="d-flex flex-row gap-3">
                          <input type="text" placeholder="Total Fare" />
                          <div class="plus d-flex align-items-center">
                            <i class="fa-solid fa-plus"></i>
                          </div>
                          <input
                            type="text"
                            placeholder="Total Charges"
                            />
                          <div class="plus d-flex align-items-center">
                            <i> - </i>
                          </div>
                          <input type="text" placeholder="Discount" />
                        </div>
                        <div class="d-flex flex-row gap-3">
                          <input
                            type="text"
                            class="w-100"
                            placeholder="Net amount (fare + charges - discount)"
                            />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="input-card">
                  <h5>Taxes</h5>
                  <div class="card rounded-3 border-0 mt-1">
                    <div class="card-body">
                      <div class="d-flex flex-column gap-2">
                        <div class="d-flex flex-row gap-3">
                          <input type="text" placeholder="CGST" />
                          <div class="plus d-flex align-items-center">
                            <i class="fa-solid fa-plus"></i>
                          </div>
                          <input type="text" placeholder="SGST" />
                          <div class="plus d-flex align-items-center">
                            <i> - </i>
                          </div>
                          <input type="text" placeholder="IGST" />
                        </div>
                        <div class="d-flex flex-row gap-3">
                          <input
                            type="text"
                            class="w-100"
                            placeholder="Net Payable (Net amount + taxes)"
                            />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="input-card">
                  <h5>Other Charges</h5>
                  <div class="card rounded-3 border-0 mt-1">
                    <div class="card-body">
                      <div class="d-flex flex-column gap-2">
                        <div class="d-flex flex-row gap-3">
                          <input type="text" placeholder="State" />
                          <div class="plus d-flex align-items-center">
                            <i class="fa-solid fa-plus"></i>
                          </div>
                          <input type="text" placeholder="Toll" />
                          <div class="plus d-flex align-items-center">
                            <i class="fa-solid fa-plus"></i>
                          </div>
                          <input type="text" placeholder="Other" />
                        </div>
                        <div class="d-flex flex-row gap-3">
                          <input
                            type="text"
                            class="w-100"
                            placeholder="Gross total (Net payable + other charges)"
                            />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="input-card">
                <h5>Allowance Charges</h5>
                <div class="card rounded-3 border-0 mt-1">
                  <div class="card-body">
                    <div class="d-flex flex-column gap-2">
                      <div class="d-flex flex-row gap-3">
                        <input type="text" placeholder="Driver charge" />
                        <div class="plus d-flex align-items-center">
                          <i class="fa-solid fa-plus"></i>
                        </div>
                        <input type="text" placeholder="Days" />
                        <div class="plus d-flex align-items-center">
                          <i class="fa-solid fa-equals"></i>
                        </div>
                        <input type="text" placeholder="Total driver charge" />
                      </div>
                      <div class="d-flex flex-row gap-3">
                        <input type="text" placeholder="Driver charge" />
                        <div class="plus d-flex align-items-center">
                          <i class="fa-solid fa-plus"></i>
                        </div>
                        <input type="text" placeholder="Days" />
                        <div class="plus d-flex align-items-center">
                          <i class="fa-solid fa-equals"></i>
                        </div>
                        <input type="text" placeholder="Total driver charge" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="final-payble mt-5">
                <h5>Final Payable</h5>
                <div class="card rounded-3 border-0 mt-3">
                  <div class="card-body">
                    <div class="d-flex flex-column gap-2 py-3">
                      <div class="d-flex flex-column gap-3">
                        <input type="text" class="w-100" placeholder="Gross Total">
                        <input type="text" class="w-100" placeholder="Advance">
                        <input type="text" class="w-100" placeholder="Due Amount">
                        <div class="d-flex flex-row gap-4 selector">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="payactivity" id="logActivity1" checked="">
                            <label class="form-check-label" for="logActivity1">
                            Paid
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="payactivity" id="logActivity2">
                            <label class="form-check-label" for="logActivity2">
                            Pay Later
                            </label>
                          </div>
                        </div>
                        <div class="paid">
                          <div class="d-flex flex-row gap-2 mb-3 align-items-center select-driver">
                            <select class="form-select" aria-label="Default select example">
                              <option selected>Open this select menu</option>
                              <option value="1">One</option>
                              <option value="2">Two</option>
                              <option value="3">Three</option>
                            </select>
                            <h6 class="w-100">To The driver</h6>
                          </div>
                          <input type="text" class="w-100" placeholder="Transaction ID">
                        </div>
                        <div class="pay-later" style="display: none;">
                          <div class="d-flex position-relative flex-row gap-2 align-items-center ">
                            <input type="date" class="w-100 order-2">
                            <h6 class=" order-1">Date</h6>
                          </div>
                        </div>
                        <button class="btn btn-primary py-2">
                        Save
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>