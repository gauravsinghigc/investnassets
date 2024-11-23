<section class="pop-section hidden" id="AddWorkExperiences">
    <div class="action-window">
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <h4 class='app-heading'>Add Work Experiences</h4>
                </div>
            </div>
            <form class="row" action="<?php echo CONTROLLER; ?>" method="POST">
                <?php FormPrimaryInputs(true, [
                    "UserId" => $UserId,
                    "OnboardingId" => $OnBoardingRequestedBy
                ]); ?>
                <div class="form-group col-lg-6 col-md-6 col-12">
                    <label>Job/Work Profile Name</label>
                    <input type='text' name='uwe_work_title' class='form-control'>
                </div>
                <div class="form-group col-lg-6 col-md-6 col-12">
                    <label>Company Name</label>
                    <input type="text" name="uwe_company_name" class="form-control">
                </div>
                <input type='hidden' name='UserCountry' value='India'>
                <div class="form-group col-lg-6 col-md-6 col-12">
                    <label>Employment Type</label>
                    <select class="state form-control SelectedState" name="uwe_employement_type">
                        <?php echo InputOptionsWithKey(EMPLOYEMENT_TYPE, ""); ?>
                    </select>
                </div>
                <div class="form-group col-lg-6 col-md-6 col-12">
                    <label>Work Location</label>
                    <input id="uwe_work_location" type="text" name="uwe_work_location" class="form-control">
                </div>
                <div class="form-group col-lg-6 col-md-6 col-12">
                    <label>Start Date</label>
                    <input type="date" name="uwe_start_date" value='<?php echo DATE("Y-m-d", strtotime("-2 month")); ?>' class="form-control">
                </div>
                <div class="form-group col-lg-6 col-md-6 col-12">
                    <label>End Date</label>
                    <input type="date" name="uwe_end_date" value='<?php echo DATE("Y-m-d", strtotime("-1 month")); ?>' class="form-control">
                </div>
                <div class="form-group col-lg-12 col-md-12 col-12">
                    <label>Job Role & Responsibilities</label>
                    <textarea class='form-control' rows='5' name='uwe_role_and_work_details'></textarea>
                </div>
                <div class='col-md-12 text-right'>
                    <hr>
                    <a onclick="Databar('AddWorkExperiences')" class="btn btn-md btn-default mr-3">Cancel</a>
                    <button type="submit" name="ADD_WORK_EXPERIENCES_DETAILS" class='btn btn-md btn-success'><i class='fa fa-check'></i> Save Details</button>
                </div>
            </form>
        </div>
    </div>
</section>