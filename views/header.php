<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Forsyth Tech - Online Course Withdrawal</title>
        <link rel="stylesheet" href="stylesheets/foundation.min.css" />
        <link rel="stylesheet" href="stylesheets/app.css" />
        <script src="javascripts/vendor/modernizr.js"></script>
    </head>
    <body>

        <div class="container">
            <div class="header">
                <div class="row">
                    <div class="large-3 medium-3 columns logo hide-on-print hide-for-small">
                        <a href="<?php
                        $logo_path = pathinfo($_SERVER['REQUEST_URI']);
                        echo $logo_path['dirname'];
                        ?>" name="Logo">Forsyth Tech</a>
                    </div>
                    <div class="large-5 medium-5 columns title">
                        <span>Online Course Withdrawal</span>
                    </div>
                    <div class="large-8 medium-8 columns">
                        <?php if ($_SESSION['auth'] == 1) { ?>
                            <span class="right">You are logged in as <?php echo $_SESSION['fullname']; ?> <a href="index.php?logout=true" class="tiny alert button radius hide-on-print" target="_top">Logout</a></span>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="menu-bar hide-on-print">
                <div class="row">
                    <div class="large-3 medium-3 columns sublogo hide-for-small">
                        <a href="<?php
                        $logo_path = pathinfo($_SERVER['REQUEST_URI']);
                        echo $logo_path['dirname'];
                        ?>" title="Education For Life">Education For Life</a>
                    </div>
                    <div class="large-13 medium-13 columns">
                        <nav class="top-bar" data-topbar>
                            <ul class="title-area">
                                <li class="name"></li>
                                <li class="toggle-topbar menu-icon"><a href="#">Menu</a></li>
                            </ul>
                            <section class="top-bar-section">
                                <ul class="left">
                                    <li class="hide-for-medium-up"><a href="<?php
                                        $logo_path = pathinfo($_SERVER['REQUEST_URI']);
                                        echo $logo_path['dirname'];
                                        ?>">Home</a></li>
                                        <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) { ?>
                                        <li><a href="admin.php" title="Admin">Admin</a></li>
                                        <li><a href="view_form.php" title="Forms">Forms</a></li>
                                        <li><a href="setup.php" title="Forms">Setup</a></li>
                                        <li><a href="reports.php" title="Forms">Reports</a></li>
                                    <?php } ?>
                                    <?php if (isset($_SESSION['instructor']) && $_SESSION['instructor'] == 1) { ?>
                                        <li><a href="instructor.php" title="Instructor">Instructor</a></li>
                                    <?php } ?>
                                </ul>
                            </section>
                        </nav>
                    </div>
                </div>
            </div>

            <?php if (!empty($_SESSION['errors'])) { ?>
                <div class="row" style="margin-top: 15px;">
                    <div class="large-16 columns">
                        <?php foreach ($_SESSION['errors'] as $error) { ?>
                            <div data-alert class="alert-box radius alert">
                                <?php echo $error; ?>
                                <a href="#" class="close">&times;</a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
            <?php unset($_SESSION['errors']); ?>

            <?php if (!empty($_SESSION['messages'])) { ?>
                <div class="row" style="margin-top: 15px;">
                    <div class="large-16 columns">
                        <?php foreach ($_SESSION['messages'] as $message) { ?>
                            <div data-alert class="alert-box radius">
                                <?php echo $message; ?>
                                <a href="#" class="close">&times;</a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
            <?php unset($_SESSION['messages']); ?>