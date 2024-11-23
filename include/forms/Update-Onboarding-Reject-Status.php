<section class="pop-section hidden" id="RejectCandidateThroughOnboarding">
    <div class="action-window">
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <h4 class='app-heading'>Enter Onboarding Rejection Reason</h4>
                </div>

                <div class="form-group col-md-12">
                    <label>Onboarding Rejection Reason <?php echo $req; ?></label>
                    <textarea name="user_onboarding_rejection_reason" class="form-control" rows="3"></textarea>
                </div>

                <div class='col-md-12 text-right'>
                    <hr>
                    <a onclick="Databar('RejectCandidateThroughOnboarding')" class="btn btn-md btn-default mr-3">Cancel</a>
                    <button type="submit" name='SUBMIT_ONBOARDING_STATUS' value='REJECTED' class='btn btn-md btn-danger blink-data'><i class='fa fa-check'></i> Confirm & Reject Onboarding</button>
                </div>
            </div>
        </div>
</section>