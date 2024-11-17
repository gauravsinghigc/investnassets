<section class="pop-section hidden" id="AddVisitPopUp">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Add Visitor</h4>
        </div>
      </div>
      <form class="row" action="<?php echo CONTROLLER; ?>" method="POST">
        <?php FormPrimaryInputs(true); ?>
        <div class="col-md-8">
          <div class="row">
            <div class="col-md-12">
              <h4 class="app-sub-heading">Vistor details</h4>
            </div>
            <div class='col-md-4 form-group'>
              <label>Full Name <?php echo $req; ?></label>
              <input type="text" name="VisitorPersonName" class="form-control " required="">
            </div>
            <div class='col-md-4 form-group'>
              <label>Phone Number <?php echo $req; ?></label>
              <input type="tel" name="VisitorPersonPhone" class="form-control " required="">
            </div>
            <div class='col-md-4 form-group'>
              <label>Email-ID</label>
              <input type="email" name="VisitorPersonEmailId" class="form-control ">
            </div>
            <div class='col-md-12 form-group'>
              <label>Purpose <?php echo $req; ?></label>
              <input type="text" name="VisitPurpose" class="form-control " required="">
            </div>
            <div class='col-md-6 form-group'>
              <label>Visit Type <?php echo $req; ?></label>
              <select name="VisitPersonType" class='form-control' required>
                <?php echo CONFIG_VALUES("VISITOR_TYPES"); ?>
              </select>
            </div>
            <div class="form-group col-md-12">
              <label>Add Note & Remarks <?php echo $req; ?></label>
              <textarea name="VisitPeronsDescription" required="" class="form-control" rows="3"></textarea>
            </div>
            <div class='col-md-12 text-right'>
              <a onclick="Databar('AddVisitPopUp')" class="btn btn-md btn-default mt-3 mr-3">Cancel</a>
              <button type="submit" name="CreateVisitorRecord" class='btn btn-md btn-success'>Create Visit <i class='fa fa-check'></i></button>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <h4 class="app-sub-heading">Meeting With</h4>
          <label>Search Team Member</label>
          <input type="search" name="search" id="searchlist" oninput="SearchData('searchlist', 'record-data-list')" class='form-control' placeholder="Search Team Member">
          <div class='data-display height-limit'>
            <?php
            $AllUsers = _DB_COMMAND_("SELECT UserId, UserFullName, UserPhoneNumber, UserEmailId FROM users where UserStatus='1' ORDER BY UserFullName ASC", true);
            if ($AllUsers == null) {
              NoData("No Users found!");
            } else {
              foreach ($AllUsers as $User) {
            ?>
                <label for="UserId_<?php echo $User->UserId; ?>" class='data-list record-data-list m-b-3'>
                  <div class="flex-s-b">
                    <div class="w-pr-15">
                      <img src="<?php echo GetUserImage($User->UserId); ?>" class="img-fluid">
                    </div>
                    <div class="text-left w-pr-85 p-1">
                      <label class="w-100">
                        <span class="h6 mt-0"><?php echo $User->UserFullName; ?></span><br>
                        <span class="text-gray small">
                          <span><?php echo $User->UserPhoneNumber; ?></span><br>
                          <span><?php echo $User->UserEmailId; ?></span><br>
                          <span>
                            <span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpJoinedId", "UserMainUserId='" . $User->UserId . "'"); ?></span>
                            (<span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpGroupName", "UserMainUserId='" . $User->UserId  . "'"); ?></span>)
                            <br>
                            <span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpType", "UserMainUserId='" . $User->UserId  . "'"); ?></span> -
                            <span class="text-gray"><?php echo UserLocation($User->UserId); ?></span>
                          </span>
                        </span>
                        <input required='' type="radio" id="UserId_<?php echo $User->UserId; ?>" name="VisitPesonMeetWith" class="pull-right" value='<?php echo $User->UserId; ?>'>
                      </label>
                    </div>
                  </div>
                </label>
            <?php
              }
            } ?>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>