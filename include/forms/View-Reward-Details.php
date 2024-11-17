<section class="pop-section hidden" id="view_reward_<?php echo $Reward->RewardsId; ?>">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Reward Details</h4>
        </div>
      </div>
      <div class="row">
        <div class="col-md-8">
          <h6 class="text-secondary mb-0">Reward Name</h6>
          <h5><?php echo $Reward->RewardName; ?></h5>
        </div>
        <div class="col-md-4">
          <h6 class="text-secondary mb-0">Create Date</h6>
          <h5><?php echo DATE_FORMATES("d M, Y", $Reward->RewardCreatedAt); ?></h5>
        </div>
        <div class="col-md-5 mt-3">
          <h6 class="text-secondary mb-0">Sent by</h6>
          <?php
          $AllUsers = _DB_COMMAND_("SELECT UserId, UserFullName, UserPhoneNumber, UserEmailId FROM users where UserId='" . $Reward->RewardCreatedBy . "' and UserStatus='1' ORDER BY UserFullName ASC", true);
          if ($AllUsers == null) {
            NoData("No Users found!");
          } else {
            foreach ($AllUsers as $User) {
          ?> <label for="UserId34_<?php echo $User->UserId; ?>" class='data-list record-data-65 m-b-3'>
                <div class="flex-s-b">
                  <div class="w-pr-15">
                    <img src="<?php echo GetUserImage($User->UserId); ?>" class="img-fluid">
                  </div>
                  <div class="text-left w-pr-85 p-1">
                    <p>
                      <span class="h6 mt-0"><?php echo $User->UserFullName; ?></span><br>
                      <span class="text-gray small">
                        <span><?php echo $User->UserPhoneNumber; ?></span><br>
                        <span><?php echo $User->UserEmailId; ?></span><br>
                        <span>
                          <span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpJoinedId", "UserMainUserId='" . $User->UserId . "'"); ?></span>
                          (<span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpGroupName", "UserMainUserId='" . $User->UserId  . "'"); ?></span>)
                          | <span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpType", "UserMainUserId='" . $User->UserId  . "'"); ?></span>
                          - <span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpLocations", "UserMainUserId='" . $User->UserId  . "'"); ?></span>
                        </span>
                      </span>
                    </p>
                  </div>
                </div>
              </label>
          <?php
            }
          } ?>
        </div>
        <div class="col-md-7 text-right mt-3">
          <h6 class="text-secondary mb-0">View Attached File</h6>
          <?php $CheckFile = CHECK("SELECT * FROM user_rewards where RewardsId='" . $Reward->RewardsId . "'");
          if ($CheckFile == null) {
            NoData("No File attached!");
          } else {
          ?> <a class="btn btn-md btn-default" href="<?php echo STORAGE_URL; ?>/rewards/<?php echo $Reward->RewardRefNo; ?>/<?php echo $Reward->RewardAttachedCreative; ?>" download="<?php echo STORAGE_URL; ?>/rewards/<?php echo $Reward->RewardRefNo; ?>/<?php echo $Reward->RewardAttachedCreative; ?>">
              <i class="fa fa-file text-danger"></i> Download Attachement</a>
          <?php } ?>
        </div>
        <div class=" col-md-12 mt-3">
          <p class="text-secondary mb-0">Reward Details</p>
          <h5><?php echo SECURE($Reward->RewardMessage, "d"); ?></h5>
        </div>
        <div class="col-md-12 text-right">
          <form method="POST" action='<?php echo CONTROLLER; ?>'>
            <?php FormPrimaryInputs(true, [
              "RewardsId" => $Reward->RewardsId,
            ]); ?>

            <button name="MarkAsRead" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Mark as Read</button>
            <a href="#" onclick="Databar('view_reward_<?php echo $Reward->RewardsId; ?>')" class="btn btn-sm btn-default"><i class="fa fa-times"></i> Close Details</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>