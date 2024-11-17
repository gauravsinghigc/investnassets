<?php
require __DIR__ . "/../acm/SysFileAutoLoader.php";

//validate the number
$AllInvalidNumber = _DB_COMMAND_("SELECT * FROM data_lead_uploads ORDER BY LeadsPhone ASC", true);
if ($AllInvalidNumber != null) {
    foreach ($AllInvalidNumber as $invalid) {
        $LeadsId = $invalid->leadsUploadId;
        $RealPhone = $invalid->LeadsPhone;
        $NewPhoneNumber = preg_replace('/[^0-9]/', '', $RealPhone);
        $PhoneNumberLength = strlen($NewPhoneNumber);

        //trim phone number and only 10 digit number
        $TrimedPhoneNumber = substr($NewPhoneNumber, -10);
        $UpdatePhone = UPDATE("UPDATE data_lead_uploads SET LeadsPhone='$TrimedPhoneNumber' where leadsUploadId='$LeadsId'");

        echo "
           LeadsId = (" . $LeadsId . ")
           -------RealPhoneNumber = (" . $RealPhone . ")
           --------Number Length = (" . $PhoneNumberLength . ")
           ---------New Phone Number = (" . $TrimedPhoneNumber . ")
           <br>
        ";
    }
}

/// check the duplicate number
$AllNumbers = _DB_COMMAND_("SELECT * FROM data_lead_uploads ORDER BY LeadsPhone ASC", true);
$seenNumbers = array();
$duplicateNumbers = array();

if ($AllNumbers != null) {
    foreach ($AllNumbers as $number) {
        $LeadPersonPhoneNumber = $number->LeadsPhone;
        $LeadsId = $number->leadsUploadId;

        echo "
        LeadsId = (" . $LeadsId . ")
        --------LeadPersonStatus = (" . $status . ")
        ------LeadPersonPhoneNumber = (" . $LeadPersonPhoneNumber . ")";

        // Check if the number is a duplicate
        if (isset($seenNumbers[$LeadPersonPhoneNumber])) {
            $OLDID = $seenNumbers[$LeadPersonPhoneNumber];
            echo " -------Duplicate --- LeadsId = " . $LeadsId . " (Original LeadsId = " . $OLDID  . ")";

            $duplicateNumbers[] = $LeadsId;
        } else {
            // Mark the number as seen and store its corresponding LeadsId
            $seenNumbers[$LeadPersonPhoneNumber] = $LeadsId;
        }

        echo "<br>";
    }
} else {
    echo "No Data found.";
}

// delete duplicate leads
if (!empty($duplicateNumbers)) {
    $deleteQuery = "DELETE FROM data_lead_uploads WHERE leadsUploadId IN (" . implode(",", $duplicateNumbers) . ")";
    $deleteResult = _DB_COMMAND_($deleteQuery, true);
    if ($deleteResult) {
        echo "Deleted duplicate leads successfully.";
    } else {
        echo "Failed to delete duplicate leads.";
    }
}
