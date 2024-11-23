<section class="pop-section hidden" id="edit_work_details_<?php echo $WorkDetails->uwe_id; ?>">
    <div class="action-window">
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <h4 class='app-heading'>Update Work Experiences</h4>
                </div>
            </div>
            <form class="row" action="<?php echo CONTROLLER; ?>" method="POST">
                <?php FormPrimaryInputs(true, [
                    "UserId" => $UserId,
                    "OnboardingId" => $OnBoardingRequestedBy,
                    "uwe_id" => $WorkDetails->uwe_id
                ]); ?>
                <div class="form-group col-lg-6 col-md-6 col-12">
                    <label>Job/Work Profile Name</label>
                    <input type='text' name='uwe_work_title' value='<?php echo $WorkDetails->uwe_work_title; ?>' class='form-control'>
                </div>
                <div class="form-group col-lg-6 col-md-6 col-12">
                    <label>Company Name</label>
                    <input type="text" name="uwe_company_name" value='<?php echo $WorkDetails->uwe_company_name; ?>' class="form-control">
                </div>
                <input type='hidden' name='UserCountry' value='India'>
                <div class="form-group col-lg-6 col-md-6 col-12">
                    <label>Employment Type</label>
                    <select class="state form-control SelectedState" name="uwe_employement_type">
                        <?php echo InputOptionsWithKey(EMPLOYEMENT_TYPE, $WorkDetails->uwe_employement_type); ?>
                    </select>
                </div>
                <div class="form-group col-lg-6 col-md-6 col-12">
                    <label>Work Location</label>
                    <input id="uwe_work_location" type="text" name="uwe_work_location" value='<?php echo $WorkDetails->uwe_work_location; ?>' class="form-control">
                </div>
                <div class="form-group col-lg-6 col-md-6 col-12">
                    <label>Start Date</label>
                    <input type="date" name="uwe_start_date" value='<?php echo $WorkDetails->uwe_start_date; ?>' class="form-control">
                </div>
                <div class="form-group col-lg-6 col-md-6 col-12">
                    <label>End Date</label>
                    <input type="date" name="uwe_end_date" value='<?php echo $WorkDetails->uwe_end_date; ?>' class="form-control">
                </div>
                <div class="form-group col-lg-12 col-md-12 col-12">
                    <label>Job Role & Responsibilities</label>
                    <textarea class='form-control' rows='5' name='uwe_role_and_work_details'><?php echo SECURE($WorkDetails->uwe_role_and_work_details, "d"); ?></textarea>
                </div>
                <div class='col-md-12 text-right'>
                    <hr>
                    <?php echo CONFIRM_DELETE_POPUP(
                        "work_details",
                        [
                            "remove_work_experience_records" => true,
                            "uwe_id" => $WorkDetails->uwe_id,
                        ],
                        null,
                        "<i class='fa fa-trash'></i> Remove Permanently",
                        "btn btn-md btn-default pull-left text-danger"
                    ); ?>
                    <a onclick="Databar('edit_work_details_<?php echo $WorkDetails->uwe_id; ?>')" class="btn btn-md btn-default mr-3">Cancel</a>
                    <button type="submit" name="UPDATE_WORK_EXPERIENCES_DETAILS" class='btn btn-md btn-success'><i class='fa fa-check'></i> Update Details</button>
                </div>
            </form>
        </div>
    </div>
</section>