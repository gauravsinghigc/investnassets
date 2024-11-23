<div class="row">
    <div class='col-md-12'>
        <div class='flex-s-b mb-2'>
            <h5 class='app-heading mb-0 w-pr-70'>Work Experiences</h5>
            <button type='button' onclick="Databar('AddWorkExperiences')" class='btn btn-danger btn-sm w-pr-30 ml-1'><i class='fa fa-plus'></i> ADD Details</button>
        </div>

        <?php
        $AllWorkDetails = _DB_COMMAND_("SELECT * FROM user_work_experiences WHERE uwe_main_user_id='$UserId'", true);
        if ($AllWorkDetails == null) {
            $disabled = "disabled";
            $ButtonType = "button";
            echo NoData("No Work details found!");
        } else {
            $disabled = "";
            $ButtonType = "submit";
            foreach ($AllWorkDetails as $WorkDetails) { ?>
                <div class="data-list flex-s-b">
                    <div class='w-pr-20'>
                        <span class='text-grey'>Profile</span><br>
                        <b><?php echo $WorkDetails->uwe_work_title; ?></b>
                    </div>
                    <div class='w-pr-20'>
                        <span class='text-grey'>Type</span><br>
                        <b><?php echo $WorkDetails->uwe_employement_type; ?></b>
                    </div>
                    <div class='w-pr-30'>
                        <span class='text-grey'>Company</span><br>
                        <b><?php echo $WorkDetails->uwe_company_name; ?></b><br>
                        <span><?php echo $WorkDetails->uwe_work_location; ?></span>
                    </div>
                    <div class='w-pr-20'>
                        <span class='text-grey'>Start-End</span><br>
                        <b>
                            <?php echo DATE_FORMATES("d M, Y", $WorkDetails->uwe_start_date); ?>
                            <i class='fa fa-arrow-right'></i><BR>
                            <?php echo DATE_FORMATES("d M, Y", $WorkDetails->uwe_end_date); ?>
                        </b>
                    </div>
                    <div class="w-pr-10">
                        <a href="#" onclick="Databar('edit_work_details_<?php echo $WorkDetails->uwe_id; ?>')" class='btn btn-xs btn-info text-white'><i class='fa fa-edit text-white'></i></a>
                    </div>
                </div>
        <?php
                include $Dir . "/include/forms/Update-Work-Experience-Details.php";
            }
        }
        include $Dir . "/include/forms/Add-Work-Experiences.php"; ?>
    </div>
</div>