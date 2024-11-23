<div class="row">
    <div class="col-md-2">
        <a href="<?php echo APP_URL; ?>/users/index.php" class="btn btn-md btn-block btn-danger"><i class='fa fa-angle-left'></i> Back to All Users</a>
    </div>
    <div class="col-md-10">
        <h4 class="app-heading mt-0"><?php echo IfRequested("GET", "get", "Main Dashboard", false); ?> @ <?php echo GET_DATA("users", "UserFullName", "UserId='$REQ_UserId'"); ?></h4>
    </div>
</div>

<div class='row'>
    <?php
    $CheckOnBoardingStatus = CHECK("SELECT * FROM user_onboarding where users_main_id='$REQ_UserId' and user_verification_status='1' and user_verification_approval_status='1'");
    if ($CheckOnBoardingStatus != null) {
    ?>
        <div class="col-md-12 text-center">
            <a href="<?php echo APP_URL; ?>/onboarding/view/?viewfor=<?php echo SECURE($REQ_UserId, "e"); ?>" class='flex-s-b btn btn-block btn-success blink-data'>
                <div class='btn btn-md text-white'>On-Boarding Details submitted!</div>
                <span class='btn btn-md btn-default'><i class='fa fa-eye'></i> Verify Candidate</span>
            </a>
        </div>
    <?php
    }
    ?>
</div>