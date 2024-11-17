<div class="w-50 lead-lists" loading="lazy">
  <div class="list-record bg-light">
    <label class="data-list w-100" loading="lazy" style="line-height:1rem;margin-bottom:0.5rem !important;">
      <span>
        <span class='count pull-right'><?php echo $Count; ?></span>
        <h5 class="mb-0">
          <b> <?php echo LimitText(ReturnValue($leads->LeadsName), 0, 25); ?></b>
        </h5>
        <p class="mb-0"> <?php echo $leads->LeadsPhone; ?></p>
        <span class="italic text-warning"><?php echo $leads->LeadsSource; ?></span><br>
        <span>
          <input type="checkbox" style='width:25px;height:25px;' class="form-control form-control-md" name="selected_lead_for_transfer[]" value="<?php echo $leads->leadsUploadId; ?>">
        </span>
      </span>
    </label>
  </div>
</div>