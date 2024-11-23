  <div class="row">
      <div class='col-md-12'>
          <div class="shadow-sm p-2 b-r-1">
              <form action='<?php echo CONTROLLER; ?>' method="POST" class='row'>
                  <?php echo FormPrimaryInputs(true, [
                        "UserId" => $UserId,
                        "OnboardingId" => $OnBoardingRequestedBy
                    ]); ?>
                  <?php $BankSql = "SELECT * FROM user_bank_details where UserMainId='$UserId'"; ?>
                  <div class="col-md-12 text-center">
                      <p class='text-danger p-2'>Bank details is optional, you can skip and continue for next step.</p>
                  </div>
                  <div class="col-md-12">
                      <h5 class="app-heading"> Bank Account Details (Optional)</h5>
                  </div>
                  <div class="form-group col-md-6">
                      <label>Bank Name</label>
                      <select name='UserBankName' class='form-control' required>
                          <?php echo InputOptions(BANK_LIST, FETCH($BankSql, "UserBankName")); ?>
                      </select>
                  </div>
                  <div class="form-group col-md-6">
                      <label>Account No</label>
                      <input type="text" name="UserBankAccountNo" value='<?php echo FETCH($BankSql, "UserBankAccountNo"); ?>' class="form-control">
                  </div>
                  <div class="form-group col-md-6">
                      <label>IFSC Code</label>
                      <input type="text" name="UserBankIFSC" value='<?php echo FETCH($BankSql, "UserBankIFSC"); ?>' class="form-control">
                  </div>
                  <div class="form-group col-md-6">
                      <label>Account Holder Name</label>
                      <input type="text" name="UserBankAccoundHolderName" value='<?php echo FETCH($BankSql, "UserBankAccoundHolderName"); ?>' class="form-control">
                  </div>

                  <div class="col-md-12 text-right">
                      <button type="submit" name="UPDATE_BANK_DETAILS" class="btn btn-sm btn-primary"><i class="fa fa-check-circle"></i> Update Details</button>
                  </div>
              </form>

              <form action='<?php echo CONTROLLER; ?>' method="POST" class='col-md-12 text-right'>
                  <?php echo FormPrimaryInputs(true, [
                        "UserId" => $UserId,
                        "OnboardingId" => $OnBoardingRequestedBy
                    ]); ?>
                  <hr>
                  <a href="?back_to=3" class='btn btn-md btn-default'><i class='fa fa-angle-left'></i> Back to Previous</a>
                  <button type='submit' name='CONTINUE_FOR_DOCUMENT_UPLOAD' class='btn btn-success'>Continue for Documentations <i class='fa fa-angle-right'></i></button>
              </form>
          </div>
      </div>
  </div>