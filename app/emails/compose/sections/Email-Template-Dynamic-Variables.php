<?php
if (isset($_SESSION['SENDING_MODULE'])) {
    $SendingModule = $_SESSION['SENDING_MODULE'];

    //common variables
    $RunningDate = DATE_FORMATES("d M, Y", CURRENT_DATE);
    $RunningTime = DATE_FORMATES("h:i A", CURRENT_DATE);
    $RunningDateTime = DATE_FORMATES("d M, Y h:i A", CURRENT_DATE_TIME);
    $RunningYear = DATE_FORMATES("Y", CURRENT_DATE);
    $RunningMonth = DATE_FORMATES("M", CURRENT_DATE);
    $RunningDay = DATE_FORMATES("d", CURRENT_DATE);
    $RunningWeekDay = DATE_FORMATES("w", CURRENT_DATE);

    //users variables
    if ($SendingModule == "users") {
        $EMAIL_TEMP_USER_SQL = "SELECT * FROM users, user_employment_details where users.UserId=user_employment_details.UserMainUserId and UserEmailId='$Emails'";
        $UserId = FETCH($EMAIL_TEMP_USER_SQL, "UserId");
        $UserSalutation = FETCH($EMAIL_TEMP_USER_SQL, "UserSalutation");
        $UserFullName = FETCH($EMAIL_TEMP_USER_SQL, "UserFullName");
        $UserPhoneNumber = FETCH($EMAIL_TEMP_USER_SQL, "UserPhoneNumber");
        $UserEmailId = FETCH($EMAIL_TEMP_USER_SQL, "UserEmailId");
        $UserPassword = FETCH($EMAIL_TEMP_USER_SQL, "UserPassword");
        $UserCreatedAt = DATE_FORMATES("d M, Y h:i A", FETCH($EMAIL_TEMP_USER_SQL, "UserCreatedAt"));
        $UserType = FETCH($EMAIL_TEMP_USER_SQL, "UserType");
        $UserDateOfBirth = DATE_FORMATES("d M, Y", FETCH($EMAIL_TEMP_USER_SQL, "UserDateOfBirth"));
        $UserEmpBloodGroup = FETCH($EMAIL_TEMP_USER_SQL, "UserEmpBloodGroup");
        $UserEmpReraId = FETCH($EMAIL_TEMP_USER_SQL, "UserEmpReraId");
        $UserEmpReportingMemberName = "(UID" . FETCH($EMAIL_TEMP_USER_SQL, "UserEmpReportingMemberName") . ")-" . FETCH("SELECT UserFullName FROM users where UserId='" . FETCH($EMAIL_TEMP_USER_SQL, "UserEmpReportingMemberName") . "'", "UserFullName");
        $UserEmpCode = EMP_CODE . FETCH($EMAIL_TEMP_USER_SQL, "UserEmpJoinedId");
        $UserEmpWorkEmailId = FETCH($EMAIL_TEMP_USER_SQL, "UserEmpWorkEmailId");
        $UserEmpGroupName = FETCH($EMAIL_TEMP_USER_SQL, "UserEmpGroupName");
        $UserEmpDesignation = FETCH($EMAIL_TEMP_USER_SQL, "UserEmpType");
        $UserEmpLocations = UserLocation($UserId, "Name");
        $UserEmpOnRoleOffRoleStatus = FETCH($EMAIL_TEMP_USER_SQL, "UserEmpRoleStatus");

        //customer variables
    } elseif ($SendingModule == "customers") {
        $EMAIL_TEMP_CUSTOMERS_SQL = "SELECT * FROM customers where CustomerEmailId='$Emails'";
        $CustomerId = FETCH($EMAIL_TEMP_CUSTOMERS_SQL, "CustomerId");
        $CustomerAddressSQL = "SELECT * FROM customer_address where CustomerMainId='$CustomerId'";
        $CustomerPerAddressSQL = "SELECT * FROM customer_address where CustomerMainId='$CustomerId' AND CustomerAddressType='PERMANENT'";
        $CustomerCurrAddressSQL = "SELECT * FROM customer_address where CustomerMainId='$CustomerId' AND CustomerAddressType='CURRENT'";
        $CustomerCoCustomerSql = "SELECT * FROM customer_co_details where MainCustomerId='$CustomerId'";
        $MainCoCustomerId = FETCH($CustomerCoCustomerSql, "MainCoCustomerId");
        $CustomerCoCustomerAddress = "SELECT * FROM customer_co_address_details where MainCoCustomerId='$MainCoCustomerId'";
        $CustomerNomineeSQL = "SELECT * FROM customer_nominees where CustomerMainId='$CustomerId'";

        $CustomerId = FETCH($EMAIL_TEMP_CUSTOMERS_SQL, "CustomerId");
        $CustomerName = FETCH($EMAIL_TEMP_CUSTOMERS_SQL, "CustomerName");
        $CustomerFatherMotherName = FETCH($EMAIL_TEMP_CUSTOMERS_SQL, "CustomerRelationName");
        $CustomerPhoneNumber = FETCH($EMAIL_TEMP_CUSTOMERS_SQL, "CustomerPhoneNumber");
        $CustomerEmailId = FETCH($EMAIL_TEMP_CUSTOMERS_SQL, "CustomerEmailId");
        $CustomerBirthdate = DATE_FORMATES("d M, Y", FETCH($EMAIL_TEMP_CUSTOMERS_SQL, "CustomerBirthdate"));
        $CustomerCreatedAt = DATE_FORMATES("d M, Y h:i A", FETCH($EMAIL_TEMP_CUSTOMERS_SQL, "CustomerCreatedAt"));
        $CustAddressId = FETCH($EMAIL_TEMP_CUSTOMERS_SQL, "CustAddressId");
        $CustomerAddressType = FETCH($CustomerAddressSQL, "CustomerAddressType");
        $CustomerCompletePermanentAddress = "PERMANENT-ADDRESS:";
        $CustomerCompletePermanentAddress .= FETCH($CustomerPerAddressSQL, "CustomerStreetAddress") . " ";
        $CustomerCompletePermanentAddress .= FETCH($CustomerPerAddressSQL, "CustomerAreaLocality") . " ";
        $CustomerCompletePermanentAddress .= FETCH($CustomerPerAddressSQL, "CustomerCity") . " ";
        $CustomerCompletePermanentAddress .= FETCH($CustomerPerAddressSQL, "CustomerState") . " ";
        $CustomerCompletePermanentAddress .= FETCH($CustomerPerAddressSQL, "CustomerCountry") . "-";
        $CustomerCompletePermanentAddress .= FETCH($CustomerPerAddressSQL, "CustomerPincode") . " <br>";
        $CustomerCompleteCurrentAddress = "CURRENT-ADDRESS:";
        $CustomerCompleteCurrentAddress .= FETCH($CustomerCurrAddressSQL, "CustomerStreetAddress") . " ";
        $CustomerCompleteCurrentAddress .= FETCH($CustomerCurrAddressSQL, "CustomerAreaLocality") . " ";
        $CustomerCompleteCurrentAddress .= FETCH($CustomerCurrAddressSQL, "CustomerCity") . " ";
        $CustomerCompleteCurrentAddress .= FETCH($CustomerCurrAddressSQL, "CustomerState") . " ";
        $CustomerCompleteCurrentAddress .= FETCH($CustomerCurrAddressSQL, "CustomerCountry") . "-";
        $CustomerCompleteCurrentAddress .= FETCH($CustomerCurrAddressSQL, "CustomerPincode") . " ";
        $CustomerBothAddress = $CustomerCompletePermanentAddress . $CustomerCompleteCurrentAddress;
        $CustomerPermStreetAddress = FETCH($CustomerPerAddressSQL, "CustomerStreetAddress");
        $CustomerPermAreaLocality = FETCH($CustomerPerAddressSQL, "CustomerAreaLocality");
        $CustomerPermCity = FETCH($CustomerPerAddressSQL, "CustomerCity");
        $CustomerPermState = FETCH($CustomerPerAddressSQL, "CustomerState");
        $CustomerPermCountry = FETCH($CustomerPerAddressSQL, "CustomerCountry");
        $CustomerPermPincode = FETCH($CustomerPerAddressSQL, "CustomerPincode");
        $CustomerCurrStreetAddress = FETCH($CustomerCurrAddressSQL, "CustomerStreetAddress");
        $CustomerCurrAreaLocality = FETCH($CustomerCurrAddressSQL, "CustomerAreaLocality");
        $CustomerCurrCity = FETCH($CustomerCurrAddressSQL, "CustomerCity");
        $CustomerCurrState = FETCH($CustomerCurrAddressSQL, "CustomerState");
        $CustomerCurrCountry = FETCH($CustomerCurrAddressSQL, "CustomerCountry");
        $CustomerCurrPincode = FETCH($CustomerCurrAddressSQL, "CustomerPincode");

        $CoCustomerName = FETCH($CustomerCoCustomerSql, "CoCustomerName");
        $CoCustomerRelationName = FETCH($CustomerCoCustomerSql, "CoCustomerRelationName");
        $CoCustomerPhoneNumber = FETCH($CustomerCoCustomerSql, "CoCustomerPhoneNumber");
        $CoCustomerEmailId = FETCH($CustomerCoCustomerSql, "CoCustomerEmailId");
        $CoCustomerCreatedAt = DATE_FORMATES("d M, Y h:i A", FETCH($CustomerCoCustomerSql, "CoCustomerCreatedAt"));
        $CoCustomerStreetAddress = FETCH($CustomerCoCustomerAddress, "CoCustomerStreetAddress");
        $CoCustomerAreaLocality = FETCH($CustomerCoCustomerAddress, "CoCustomerAreaLocality");
        $CoCustomerCity = FETCH($CustomerCoCustomerAddress, "CoCustomerCity");
        $CoCustomerState = FETCH($CustomerCoCustomerAddress, "CoCustomerState");
        $CoCustomerCountry = FETCH($CustomerCoCustomerAddress, "CoCustomerCountry");
        $CoCustomerPincode = FETCH($CustomerCoCustomerAddress, "CoCustomerPincode");

        $CustNomRelation = FETCH($CustomerNomineeSQL, "CustNomRelation");
        $CustNomFullName = FETCH($CustomerNomineeSQL, "CustNomFullName");
        $CustNomPhoneNumber = FETCH($CustomerNomineeSQL, "CustNomPhoneNumber");
        $CustNomEmailId = FETCH($CustomerNomineeSQL, "CustNomEmailId");
        $CustNomStreetAdress = FETCH($CustomerNomineeSQL, "CustNomStreetAdress");
        $CustNomAreaLocality = FETCH($CustomerNomineeSQL, "CustNomAreaLocality");
        $CustNomCity = FETCH($CustomerNomineeSQL, "CustNomCity");
        $CustNomState = FETCH($CustomerNomineeSQL, "CustNomState");
        $CustNomCountry = FETCH($CustomerNomineeSQL, "CustNomCountry");
        $CustNomPincode = FETCH($CustomerNomineeSQL, "CustNomPincode");
        $CustNomDateofbirth = DATE_FORMATES("d M, Y", FETCH($CustomerNomineeSQL, "CustNomDateofbirth"));
        $CustNomCreatedAt = DATE_FORMATES("d M, Y h:i A", FETCH($CustomerNomineeSQL, "CustNomCreatedAt"));

        $CustomerRegistrationSQL = "SELECT * FROM bookings where BookingMainCustomerId='$CustomerId'";
        $RegistrationProjectId = FETCH($CustomerRegistrationSQL, "BookingForProject");
        $RegistrationProjectSQL = "SELECT * FROM projects where ProjectId='$RegistrationProjectId'";
        $RegistrationProjectName = FETCH($RegistrationProjectSQL, "ProjectName");
        $RegistrationProjectType = FETCH($RegistrationProjectSQL, "ProjectType");
        $RegistrationBusinessUsersSQL = "SELECT * FROM users where UserId='" . FETCH($CustomerRegistrationSQL, "BookingBusinessHead") . "'";
        $RegistrationDirectSaleUsersSQL = "SELECT * FROM users WHERE UserId='" . FETCH($CustomerRegistrationSQL, "BookingDirectSalePersonId") . "'";
        $RegistrationTeamUsersSQL = "SELECT * FROM users WHERE UserId='" . FETCH($CustomerRegistrationSQL, "BookingTeamHeadId") . "'";

        $RegisteredCustomerName = FETCH($CustomerRegistrationSQL, "BookingCustomerName");
        $RegisterationId = FETCH($CustomerRegistrationSQL, "bookingId");
        $RegistrationAcknowledgeCode = FETCH($CustomerRegistrationSQL, "BookingAckCode");
        $RegistrationProjectPhase = FETCH($CustomerRegistrationSQL, "BookingProjectPhase");
        $RegistrationAmount = FETCH($CustomerRegistrationSQL, "BookingAmount");
        $RegistrationPaymentMode = FETCH($CustomerRegistrationSQL, "BookingPaymentMode");
        $RegistrationPaymentSource = FETCH($CustomerRegistrationSQL, "BookingPaymentSource");
        $RegistrationPaymentRefNo = FETCH($CustomerRegistrationSQL, "BookingPaymentRefNo");
        $RegistrationPaymentMoreDetails = FETCH($CustomerRegistrationSQL, "BookingPaymentDetails");
        $RegistrationDate = DATE_FORMATES("d M, Y", FETCH($CustomerRegistrationSQL, "BookingDate"));
        $RegistrationCreatedAt = DATE_FORMATES("d M, Y h:i A", FETCH($CustomerRegistrationSQL, "BookingCreatedAt"));
        $RegistrationNotes = FETCH($CustomerRegistrationSQL, "BookingNotes");
        $RegistrationStatus = FETCH($CustomerRegistrationSQL, "BookingStatus");
        $RegistrationBusinessHeadName = "(" . FETCH($CustomerRegistrationSQL, "BookingBusinessHead") . ")" . FETCH($RegistrationBusinessUsersSQL, "UserFullName");
        $RegistrationBusinessHeadPhone = FETCH($RegistrationBusinessUsersSQL, "UserPhoneNumber");
        $RegistrationBusinessHeadEmailId = FETCH($RegistrationBusinessUsersSQL, "UserEmailId");
        $RegistrationDirectSalePersonName = "(" . FETCH($CustomerRegistrationSQL, "BookingDirectSalePersonId") . ")" . FETCH($RegistrationDirectSaleUsersSQL, "UserFullName");
        $RegistrationDirectSalePersonPhone = FETCH($RegistrationDirectSaleUsersSQL, "UserPhoneNumber");
        $RegistrationDirectSalePersonEmailId = FETCH($RegistrationDirectSaleUsersSQL, "UserEmailId");
        $RegistrationTeamHeadName = "(" . FETCH($CustomerRegistrationSQL, "BookingTeamHeadId") . ")" . FETCH($RegistrationTeamUsersSQL, "UserFullName");
        $RegistrationTeamHeadPhone = FETCH($RegistrationTeamUsersSQL, "UserPhoneNumber");
        $RegistrationTeamHeadEmailId = FETCH($RegistrationTeamUsersSQL, "UserEmailId");
        $RegistrationCustomerId = FETCH($CustomerRegistrationSQL, "BookingMainCustomerId");
        $RegisterationHaveLeadsId = FETCH($CustomerRegistrationSQL, "LeadsId");

        $BookingSqls = [
            "BookingAcknowledgeCode",
            "BookingId",
            "BookingProjectId",
            "BookingProjectName",
            "BookingProjectType",
            "BookingUnitCost",
            "BookingAllotmentPhase",
            "BookingUnitArea",
            "BookingUnitName",
            "BookingUnitRate",
            "BookingNetCharges",
            "BookingProjectCost",
            "BookingDate",
            "BookingPossessionStatus",
            "BookingBusinessHeadName",
            "BookingBusinessHeadPhone",
            "BookingBusinessHeadEmailId",
            "BookingDirectSalePersonName",
            "BookingDirectSalePersonPhone",
            "BookingDirectSalePersonEmailId",
            "BookingTeamHeadName",
            "BookingTeamHeadPhone",
            "BookingTeamHeadEmailId",
            "BookingCreatedAt",
            "BookingNotes",
            "BookingHaveRegistration"
        ];

        $BookingSqls = "SELECT * FROM registrations where RegMainCustomerId='$CustomerId'";
        $BookingAcknowledgeCode = FETCH($BookingSqls, "RegAcknowledgeCode");
        $BookingId = FETCH($BookingSqls, "RegistrationId");
        $BookingProjectId = FETCH($BookingSqls, "RegProjectId");
        $BookingProjectSQL = "SELECT * FROM projects where ProjectId='$RegistrationProjectId'";
        $BookingProjectName = "(PRJ$BookingProjectId)" . FETCH($BookingProjectSQL, "ProjectName");
        $BookingProjectType = FETCH($BookingProjectSQL, "ProjectType");
        $BookingUnitCost = FETCH($BookingSqls, "RegUnitCost");
        $BookingAllotmentPhase = FETCH($BookingSqls, "RegAllotmentPhase");
        $BookingUnitArea = FETCH($BookingSqls, "RegUnitSizeApplied") . " " . FETCH($BookingSqls, "RegUnitMeasureType");
        $BookingUnitName = FETCH($BookingSqls, "RegUnitName");
        $BookingUnitRate = FETCH($BookingSqls, "RegUnitRate");
        $BookingNetCharges = FETCH($BookingSqls, "RegNetCharges");
        $BookingProjectCost = FETCH($BookingSqls, "RegProjectCost");
        $BookingDate = DATE_FORMATES("d M, Y", FETCH($BookingSqls, "RegDate"));
        $BookingPossessionStatus = FETCH($BookingSqls, "RegPossessionStatus");
    }
}
