<?php
//user per missions
define("USER_PERMISSIONS", array(
    "CREATE", "UPDATE", "DELETE", "IMPORT", "EXPORT", "PRINT", "VIEW", "REPORTS"
));

//user roles
define("USER_ROLES", array("Admin", "TeamMember", "EMAIL_SENDER", "HR", "Digital", "Receptions", "CRM", "Other Staff"));

//user genders
define("USER_GENDER", array("Male", "Female", "Others"));

//user salutation 
define("SALUTATION", array("Mr.", "Mrs.", "Miss", "M/s", "Prof", "Dr."));

define("USER_DASHBOARDS", [
    "Admin" => "admin-dash.php",
    "TeamMember" => "lead-dash.php",
    "HR" => "hr-dash.php",
    "Digital" => "d-dash.php",
    "Receptions" => "recep-dash.php",
    "CRM" => "crm-dash.php",
    "Other Staff" => "other-dash.php",
    "EMAIL_SENDER" => "email-dash.php",
]);

define('USER_DASHBOARD_TYPES', ["Admin Dashboard", "EMAIL Sender Dashboard", 'Lead Dashboard', 'CRM Dashboard', 'HR Dashboard', 'Reception Dashboard', 'Digital Dashboard']);
