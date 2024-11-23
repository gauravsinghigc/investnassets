<section class="pop-section hidden" id="view_company_policy_<?php echo $PolicyMainId; ?>">
    <div class="action-window">
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <h4 class='app-heading'>Applicable Policy @ <?php echo FETCH($PolicySQL, "PolicyName"); ?></h4>
                </div>
            </div>
            <div class="row">
                <div class='col-md-12 mb-3'>
                    <h6 class='text-grey mb-0'>Policy Name</h6>
                    <h5 class='bold text-primary'><?php echo FETCH($PolicySQL, "PolicyName"); ?></h5>
                </div>

                <div class='col-md-12 mb-3'>
                    <h6 class='text-grey mb-0'>Active From</h6>
                    <h5 class='bold text-primary'><?php echo DATE_FORMATES("d M, Y", FETCH($PolicySQL, "PolicyActiveFrom")); ?></h5>
                </div>

                <div class='col-md-12 mb-3'>
                    <h6 class='text-grey mb-0'>Policy Details</h6>
                    <h5 class='bold text-primary'><?php echo SECURE(FETCH($PolicySQL, "PolicyDetails"), "d"); ?></h5>
                </div>

                <div class='col-md-12 text-right'>
                    <hr>
                    <a onclick="Databar('view_company_policy_<?php echo $PolicyMainId; ?>')" class="btn btn-md btn-success mr-3">Agree & Close</a>
                </div>
            </div>
        </div>
    </div>
</section>