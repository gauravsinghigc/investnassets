<?php
define("STATES_OPTIONS", [
    'Select State',
    'Andaman and Nicobar Islands',
    'Andhra Pradesh',
    'Arunachal Pradesh',
    'Assam',
    'Bihar',
    'Chandigarh',
    'Chhattisgarh',
    'Dadra and Nagar Haveli',
    'Daman and Diu',
    'Delhi',
    'Goa',
    'Gujarat',
    'Haryana',
    'Himachal Pradesh',
    'Jammu and Kashmir',
    'Jharkhand',
    'Karnataka',
    'Kerala',
    'Lakshadweep',
    'Madhya Pradesh',
    'Maharashtra',
    'Manipur',
    'Meghalaya',
    'Mizoram',
    'Nagaland',
    'Odisha',
    'Puducherry',
    'Punjab',
    'Rajasthan',
    'Sikkim',
    'Tamil Nadu',
    'Telangana',
    'Tripura',
    'Uttar Pradesh',
    'Uttarakhand',
    'West Bengal'
]);

//qualification types
define("QUALIFICATION_TYPE", [
    "" => "Select Qualification",
    "10th" => "10th",
    "12th" => "12th",
    "Diploma_Degree" => "Diploma/Degree",
    "Graduation" => "Graduation",
    "Post_Graduation" => "Post Graduation",
    "Phd" => "Phd",
    "Doctor" => "Doctor",
    "Lawyer" => "Lawyer (LLB)",
    "Certification" => "Other Certification"
]);


//employement type
define("EMPLOYEMENT_TYPE", [
    "" => "Select Employment Type",
    "Full_Time" => "Full Time",
    "Part_Time" => "Part Time",
    "Contract" => "Contract",
    "Internship" => "Internship",
    "Freelance" => "Freelance",
]);


//one document upload from two only one submitted at a time
function HandleSubmittedDocument($UploadDir, $Name, $FileOne, $FileTwo)
{
    $ReturnDocumentName = null;

    if (isset($_FILES[$FileOne]['name']) && $_FILES[$FileOne]['name'] != null) {
        $ReturnDocumentName = UPLOAD_FILES($UploadDir, "null", $Name, $FileOne);
    } elseif (isset($_FILES[$FileTwo]['name']) && $_FILES[$FileTwo]['name'] != null) {
        $ReturnDocumentName = UPLOAD_FILES($UploadDir, "null", $Name, $FileTwo);
    }

    return $ReturnDocumentName;
}
