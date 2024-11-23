<div class="row">
    <div class='col-md-12'>
        <div class='flex-s-b mb-2'>
            <h5 class='app-heading mb-0 w-pr-70'>Educational Details</h5>
            <button type='button' onclick="Databar('AddEducationDetails')" class='btn btn-danger btn-sm w-pr-30 ml-1'><i class='fa fa-plus'></i> ADD Details</button>
        </div>

        <?php
        $AllEducationalDetails = _DB_COMMAND_("SELECT * FROM user_educational_details WHERE ued_main_user_id='$UserId'", true);
        if ($AllEducationalDetails == null) {
            $disabled = "disabled";
            $ButtonType = "button";
            echo NoData("No Educational details found!");
        } else {
            $disabled = "";
            $ButtonType = "submit";
            foreach ($AllEducationalDetails as $EduDetails) { ?>
                <div class="data-list flex-s-b">
                    <div class='w-pr-20'>
                        <span class='text-grey'>Name</span><br>
                        <b><?php echo $EduDetails->ued_title; ?></b>
                    </div>
                    <div class='w-pr-20'>
                        <span class='text-grey'>Type</span><br>
                        <b><?php echo $EduDetails->ued_qualification_type; ?></b>
                    </div>
                    <div class='w-pr-30'>
                        <span class='text-grey'>Institution</span><br>
                        <b><?php echo $EduDetails->ued_athority; ?></b>
                    </div>
                    <div class='w-pr-20'>
                        <span class='text-grey'>Years</span><br>
                        <b><?php echo DATE_FORMATES("d M, Y", $EduDetails->ued_passed_year); ?></b>
                    </div>
                    <div class="w-pr-10">
                        <a href="#" onclick="Databar('edit_<?php echo $EduDetails->ued_id; ?>')" class='btn btn-xs btn-info text-white'><i class='fa fa-edit text-white'></i></a>
                    </div>
                </div>
        <?php
                include $Dir . "/include/forms/Update-Educational-Details.php";
            }
        }
        include $Dir . "/include/forms/Add-Education-Details.php"; ?>
    </div>
</div>