<?php
require __DIR__ . "/../acm/SysFileAutoLoader.php";

$FetchProjects = _DB_COMMAND_("SELECT LeadRequirementDetails, LeadMainId FROM lead_requirements ORDER BY LeadRequirementID DESC", true);
if ($FetchProjects != null) {
  foreach ($FetchProjects as $Projects) {
    $Update = UPDATE("UPDATE leads SET LeadProjectId='" . $Projects->LeadRequirementDetails . "' where LeadsId='" . $Projects->LeadMainId . "'");
    echo "@=>" . $Projects->LeadRequirementDetails . " for " . $Projects->LeadMainId . "<br>";
  }
}

$FethUpdated = _DB_COMMAND_("SELECT LeadFollowUpCreatedAt, LeadFollowMainId FROM lead_followups GROUP BY LeadFollowMainId ORDER BY LeadFollowUpId DESC", true);
if ($FethUpdated != null) {
  foreach ($FethUpdated as $Projects) {
    $Update = UPDATE("UPDATE leads SET LeadPersonLastUpdatedAt='" . $Projects->LeadFollowUpCreatedAt . "' where LeadsId='" . $Projects->LeadFollowMainId . "'");
    echo "@=>" . $Projects->LeadFollowUpCreatedAt . " for " . $Projects->LeadFollowMainId . "<br>";
  }
}
