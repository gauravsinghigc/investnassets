<?php
define("ONBOARDING_MENUS", [
    1 => [
        "count" => "1",
        "name" => "Primary Details",
        "url" => "primary_details",
        "include" => "PrimaryForm.php"
    ],
    2 => [
        "count" => "2",
        "name" => "Contact Address",
        "url" => "contact_address",
        "include" => "AddressForm.php"
    ],
    3 => [
        "count" => "3",
        "name" => "Work Experience",
        "url" => "work_experience",
        "include" => "EmploymentForm.php"
    ],
    4 => [
        "count" => "4",
        "name" => "Bank Details",
        "url" => "bank_details",
        "include" => "BankAccountForm.php"
    ],
    5 => [
        "count" => "5",
        "name" => "Upload Documents",
        "url" => "upload_documents",
        "include" => "DocumentUploadForm.php"
    ],
    6 => [
        "count" => "6",
        "name" => "Login & Security",
        "url" => "login_and_security",
        "include" => "LoginSecurityForm.php"
    ],
    7 => [
        "count" => "7",
        "name" => "Congratulation!",
        "url" => "completed",
        "include" => "OnboardingDone.php"
    ]
]);
