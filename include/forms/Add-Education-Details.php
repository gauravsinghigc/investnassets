<section class="pop-section hidden" id="AddEducationDetails">
    <div class="action-window">
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <h4 class='app-heading'>Add Educational Details</h4>
                </div>
            </div>
            <form class="row" action="<?php echo CONTROLLER; ?>" method="POST">
                <?php FormPrimaryInputs(true, [
                    "UserId" => $UserId,
                    "OnboardingId" => $OnBoardingRequestedBy
                ]); ?>
                <div class="form-group col-lg-12 col-md-12 col-12">
                    <label>Qualification Title</label>
                    <input type='text' name='ued_title' class='form-control'>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-12">
                    <label>Board/Institution/Collage/Entity Name</label>
                    <input type="text" name="ued_athority" class="form-control">
                </div>
                <input type='hidden' name='UserCountry' value='India'>
                <div class="form-group col-lg-6 col-md-6 col-12">
                    <label>Select Qualifications</label>
                    <select class="state form-control SelectedState" name="ued_qualification_type">
                        <?php echo InputOptionsWithKey(QUALIFICATION_TYPE, ""); ?>
                    </select>
                </div>
                <div class="form-group col-lg-6 col-md-6 col-12">
                    <label>Qualified Year</label>
                    <input type="date" name="ued_passed_year" value='<?php echo DATE("Y-m-d"); ?>' class="form-control">
                </div>
                <div class="form-group col-lg-12 col-md-12 col-12">
                    <label>Mention few points</label>
                    <textarea class='form-control' rows='3' name='ued_remarks'></textarea>
                </div>
                <div class='col-md-12 text-right'>
                    <hr>
                    <a onclick="Databar('AddEducationDetails')" class="btn btn-md btn-default mr-3">Cancel</a>
                    <button type="submit" name="ADD_EDUCATIONAL_DETAILS" class='btn btn-md btn-success'><i class='fa fa-check'></i> Save Details</button>
                </div>
            </form>
        </div>
    </div>
</section>