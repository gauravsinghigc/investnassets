<section class="container mt-3">
    <div class="row">
        <div class="col-md-12 text-left">
            <div class="flex-s-b">
                <div>
                    <img src="<?php echo APP_LOGO; ?>" class="logo-onboarding2 mt-0">
                </div>
                <div>
                    <span class='pull-right btn btn-md'><i class='fa fa-lock text-success'></i> Login as <b><?php echo FETCH($UserSQL, "UserFullName"); ?></b></span>
                </div>
            </div>
            <h4 class="pt-2 bold mb-2"><?php echo APP_NAME; ?></h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-left">
            <h5>ON-BOARDING & USER VERIFICATION</h5>
            <p class="small">
                This form will help you to create your account and secure your access to your online account. Please provide the necessary details to complete the onboarding process.
            </p>
            <hr>
        </div>
    </div>
</section>