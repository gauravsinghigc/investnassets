<div class="shadow-sm p-1">
    <input type='search' name='searchVariables' placeholder="Search System Variables..." class="form-control" Id='VariableSearch' oninput="SearchData('VariableSearch', 'variable-list')">
    <ul class='EmailTemplateVariables height-limit-2'>
        <?php foreach (SYSTEM_VARIABLES_FOR_EMAIL_TEMPLATE as $Key => $TEMPLATE_VARIABLES) { ?>
            <li>
                <div class="flex-s-b title d-block" onclick="Databar('options_<?php echo $Key; ?>')">
                    <h6><?php echo UpperCase($Key); ?></h6>
                    <a><i class="fa fa-angle-double-down"></i></a>
                </div>
                <div id='options_<?php echo $Key; ?>' class='content'>
                    <div class="options">
                        <?php if (!empty($TEMPLATE_VARIABLES)) {
                            foreach ($TEMPLATE_VARIABLES as $Options) { ?>
                                <span class="variable-box variable-list">
                                    <span class="variable"><span class="text-danger">$</span><?php echo UpperCase($Options); ?></span>
                                    <a class="copy pull-right" onclick="CopyReservedVariables('$<?php echo $Options; ?>', 'copy_<?php echo $Options; ?>')" id='copy_<?php echo $Options; ?>'><i class=" fa fa-copy text-danger"></i> CLICK TO COPY</a>
                                </span>
                        <?php }
                        } ?>
                    </div>
                </div>
            </li>
        <?php } ?>
    </ul>
</div>
<script>
    function CopyReservedVariables(originalText, copyElementId) {
        // Create a temporary textarea element to copy the text from
        const tempTextarea = document.createElement('textarea');
        tempTextarea.value = originalText;
        document.body.appendChild(tempTextarea);

        // Select the text
        tempTextarea.select();
        tempTextarea.setSelectionRange(0, 99999); // For mobile devices

        // Copy the text
        document.execCommand('copy');

        // Remove the temporary textarea
        document.body.removeChild(tempTextarea);

        // Change the appearance of the target element
        const copyElement = document.getElementById(copyElementId);
        copyElement.textContent = "✓ Text copied!";
        copyElement.classList.add('bg-danger');
    }
</script>