<div class='row'>
    <div class='col-md-12 text-center'>
        <div class="p-5">
            <h1 class="text-success fs-100"><i class='fa fa-check blink-data'></i></h1>
            <h4 class='text-primary fs-50'>Congratulation!</h4>
            <p class='fs-20'>
                Your account has been successfully created. HR will review your account and approved it. You will receive response over your provided email id within a few minutes, please also check your spam folder.
            </p>
            <p class='fs-15 bold p-1'>REF No: <?php echo DATE_FORMATES("dmY", FETCH($OnBoardSQL, "user_onboarding_requested_at")) . "/" . $OnBoardingRequestedBy; ?></p>
            <a href='<?php echo DOMAIN; ?>/auth/logout' class='btn btn-primary mt-3'>Login Now <i class='fa fa-sign-in'></i></a>
        </div>
    </div>
</div>