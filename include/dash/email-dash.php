<div class="row">
    <div class="col-md-12">
        <div class='flex-s-b'>
            <h3 class="app-heading w-pr-80 m-t-0"><i class="fa fa-home"></i> Email Sender Dashboard </h3>
            <?php if (LOGIN_UserType == 'Admin') { ?>
                <form>
                    <select name="view" onchange="form.submit()" class="form-control ">
                        <?php echo InputOptions(USER_DASHBOARD_TYPES, IfRequested('GET', 'view', 'EMAIL Sender Dashboard', false)); ?>
                    </select>
                </form>
            <?php } ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3 col-6 text-center">
        <a href="<?php echo APP_URL; ?>/emails/compose">
            <div class="box-shadow p-2 b-r-1">
                <h1 class="text-danger"><i class='fa fa-send'></i></h1>
                <h5>SEND NEW EMAILs</h5>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-6 text-center">
        <a href="<?php echo APP_URL; ?>/emails/templates/new">
            <div class="box-shadow p-2 b-r-1">
                <h1 class="text-info"><i class='fa fa-file'></i></h1>
                <h5>CREATE NEW TEMPLATE</h5>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-6 text-center">
        <a href="<?php echo APP_URL; ?>/emails/smtps">
            <div class="box-shadow p-2 b-r-1">
                <h1 class="text-warning"><i class='fa fa-gears'></i></h1>
                <h5>ADD SENDER-IDs</h5>
            </div>
        </a>
    </div>
</div>