<div class="row">
    <div class="large-16 columns">
        <h3>Online Course Withdrawal</h3>
        <p><?php echo $config['closedMessage']; ?></p>
    </div>
</div>
<?php if ($_SESSION['instructor'] == 1) { ?>
<div class="row">
    <div class="large-16 columns">
        <h4>Instructor Access</h4>
        <p>Please see the <a href="instructor.php">Instructor Page</a> to access your information.</p>
    </div>
</div>
<?php } ?>