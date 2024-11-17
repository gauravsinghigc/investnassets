<section class="pop-section hidden" id="Update_Sender_Email_Id_<?php echo $SenderEmails->config_mail_sender_id; ?>">
    <div class="action-window">
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <h4 class='app-heading'>Update SENDER EMAIL-Id</h4>
                </div>
            </div>
            <form class="row" action="<?php echo CONTROLLER; ?>" method="POST">
                <?php FormPrimaryInputs(true, [
                    "config_mail_sender_id" => $SenderEmails->config_mail_sender_id
                ]); ?>
                <div class="col-md-7">
                    <h6 class="bold">Configuration Information</h6>
                    <hr>
                    <p class="small">
                        SMTP (Simple Mail Transfer Protocol) is the standard protocol used for sending emails across the Internet. Here’s why SMTP is widely used:
                    </p>
                    <ul class="small">
                        <li>
                            <b>Standardization: </b>SMTP is a well-established protocol that is standardized and universally supported by all email servers and clients.
                        </li>
                        <li>
                            <b>Reliability:</b> It is designed for reliable and efficient email transmission.
                        </li>
                        <li>
                            <b>Compatibility:</b> SMTP can handle different types of email content, including text and attachments, and is compatible with various email systems.
                        </li>
                        <li>
                            <b>Scalability: </b>It can handle a large volume of emails, making it suitable for both individual users and large organizations.
                        </li>
                        <li>
                            <b>Security:</b> While the basic SMTP is not secure, it can be used in conjunction with other protocols such as TLS (Transport Layer Security) to provide encryption and secure transmission.
                        </li>
                    </ul>
                    <p class="small">The limitations on sending emails via SMTP largely depend on the email service provider's policies. Common limitations include:</p>
                    <ul class="small">
                        <li><strong>Daily Sending Limits:</strong> Many email providers impose limits on the number of emails you can send per day. For example, Gmail limits free users to 500 emails per day, while Google Workspace users may have higher limits.</li>
                        <li><strong>Recipient Limits:</strong> Providers may limit the number of recipients per email or per day.</li>
                        <li><strong>Rate Limits:</strong> There can be restrictions on the number of emails sent per minute/hour to prevent spamming.</li>
                        <li><strong>Attachment Size Limits:</strong> Providers usually have limits on the size of attachments, typically ranging from 10MB to 25MB.</li>
                    </ul>

                    <p class="small">To send emails using SMTP, you need to configure your email client or application with the following details:</p>

                    <ul class="small">
                        <li><strong>SMTP Host:</strong> This is the server address of your email provider’s SMTP server. For example, Gmail’s SMTP host is <code>smtp.gmail.com</code>.</li>

                        <li><strong>SMTP Username:</strong> This is typically your email address or a username provided by your email service provider.</li>

                        <li><strong>SMTP Password:</strong> The password associated with your email account. For security reasons, some services use an app-specific password or OAuth tokens instead.</li>

                        <li><strong>SMTP Port:</strong> The port number used by the SMTP server. Common ports are:
                            <ul>
                                <li><strong>25:</strong> The default SMTP port (often blocked by ISPs due to spam issues).</li>
                                <li><strong>465:</strong> Used for SMTP with SSL (Secure Sockets Layer) encryption.</li>
                                <li><strong>587:</strong> Used for SMTP with STARTTLS (an extension that upgrades an existing connection to a secure one).</li>
                            </ul>
                        </li>
                    </ul>


                </div>
                <div class="col-md-5">
                    <p class="small">
                        <code class="h6 bold text-danger">PLEASE READ BEFORE UPDATING SENDER EMAIL-id</code><br>
                        We prefer SMTP protocols for sending emails, because SMTP helps prevent spam by verifying the sender's account before delivering an email. By preventing spam emails, SMTP also protects your IP reputation. SMTP increases delivery rate by restricting spam and protecting IP reputation. SMTP notifies senders if an email address is invalid or incorrect.
                    </p>
                    <hr>
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <h6 class='app-sub-heading'>Update SENDER EMAIL-id</h6>
                            <p class="text-secondary mb-10px">update smtp details for sender email-id</p>
                        </div>
                        <div class="form-group col-md-12 pb-2">
                            <label>SMTP Hostname *</label>
                            <input type="text" name="config_mail_sender_host" VALUE='<?php echo $SenderEmails->config_mail_sender_host; ?>' list='config_mail_sender_host' class="form-control" required>
                            <?php echo SUGGEST("config_mail_sender", "config_mail_sender_host", "ASC") ?>
                        </div>
                        <div class="form-group col-md-12 pb-2">
                            <label>Username *</label>
                            <input type="text" name="config_mail_sender_username" VALUE='<?php echo $SenderEmails->config_mail_sender_username; ?>' class="form-control" required>
                        </div>
                        <div class="form-group col-md-5 pb-2">
                            <label>Password *</label>
                            <input type="text" name="config_mail_sender_password" VALUE='<?php echo $SenderEmails->config_mail_sender_password; ?>' class="form-control" required>
                        </div>
                        <div class="form-group col-md-4 pb-2">
                            <label>SMTP PORT No *</label>
                            <select name="config_mail_sender_port" class="form-control" required="">
                                <?php echo InputOptionsWithKey([
                                    "0" => "Select Port",
                                    "25" => "25",
                                    "465" => "465",
                                    "587" => "587",
                                ], $SenderEmails->config_mail_sender_port); ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3 pb-2">
                            <label>Send Limit/24hr *</label>
                            <input type="number" name="config_mail_send_limit" min='1' value='<?php echo $SenderEmails->config_mail_send_limit; ?>' class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class=" col-md-12 text-right">
                    <?php
                    if ($SenderEmails->config_mail_sender_id != 1) {
                        CONFIRM_DELETE_POPUP(
                            "SenderEmails",
                            [
                                "Remove_Sender_Email_Ids" => true,
                                "config_mail_sender_id" => $SenderEmails->config_mail_sender_id
                            ],
                            null,
                            "<i class='fa fa-trash'></i> Remove Sender Email Permanently",
                            "btn btn-sm text-danger pull-left"
                        );
                    } ?>
                    <button type="submit" name="UPDATE_NEW_SENDER_EMAIL_ID" class="btn btn-lg btn-primary"><i class="fa fa-check"></i> UPDATE SENDER EMAIL</button>
                    <a href="#" onclick="Databar('Update_Sender_Email_Id_<?php echo $SenderEmails->config_mail_sender_id; ?>')" class="btn btn-lg btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>