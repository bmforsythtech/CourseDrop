<script type="text/javascript" src="/javascripts/datepickr.min.js"></script>
<div class="row">
    <div class="large-16 columns">
        <h3>Setup</h3>
    </div>
</div>

<form action="setup.php" method="post">
    <div class="row">
        <div class="large-16 columns">
            <h5>Term</h5>
        </div>
    </div>
    <div class="row">
        <div class="large-8 columns">
            <label for="close">Semester</label>
            <select name="semester" id="semester">
                <option value="SP"<?php if($config['semester'] == 'SP') echo ' selected'; ?>>Spring</option>
                <option value="SU"<?php if($config['semester'] == 'SU') echo ' selected'; ?>>Summer</option>
                <option value="FA"<?php if($config['semester'] == 'FA') echo ' selected'; ?>>Fall</option>
            </select>
        </div>
        <div class="large-8 columns">
            <label for="open">Year</label>
            <input type="text" name="year" id="year" value="<?php echo $config['year']; ?>" required pattern="\d\d\d\d">
        </div>
    </div>
    <div class="row">
        <div class="large-16 columns">
            <h5>Open/Close Dates</h5>
        </div>
    </div>
    <div class="row">
        <div class="large-8 columns">
            <label for="open">Student Open</label>
            <input type="text" name="open" id="open" value="<?php echo $config['open']; ?>" required pattern="\d\d\/\d\d\/\d\d\d\d">
        </div>
        <div class="large-8 columns">
            <label for="close">Student Close</label>
            <input type="text" name="close" id="close" value="<?php echo $config['close']; ?>" required pattern="\d\d\/\d\d\/\d\d\d\d">
        </div>
    </div>
    <div class="row">
        <div class="large-8 columns">
            <label for="open">Instructor Open</label>
            <input type="text" name="iopen" id="iopen" value="<?php echo $config['iopen']; ?>" required pattern="\d\d\/\d\d\/\d\d\d\d">
        </div>
        <div class="large-8 columns">
            <label for="close">Instructor Close</label>
            <input type="text" name="iclose" id="iclose" value="<?php echo $config['iclose']; ?>" required pattern="\d\d\/\d\d\/\d\d\d\d">
        </div>
    </div>
    <div class="row">
        <div class="large-8 columns">
            <label for="closedMessage">Closed Message</label>
            <textarea rows="6" name="closedMessage" id="closedMessage"><?php echo $config['closedMessage']; ?></textarea>
        </div>
    </div>
    <div class="row">
        <div class="large-16 columns">
            <h5>Grade Option Cutoffs</h5>
        </div>
    </div>
    <div class="row">
        <div class="large-8 columns">
            <label for="wpcutoff">Withdrawal Passing</label>
            <input type="text" name="wpcutoff" id="wpcutoff" value="<?php echo $config['wpcutoff']; ?>" required pattern="\d\d\/\d\d\/\d\d\d\d">
        </div>
        <div class="large-8 columns">
            <label for="wfcutoff">Withdrawal Failing</label>
            <input type="text" name="wfcutoff" id="wfcutoff" value="<?php echo $config['wfcutoff']; ?>" required pattern="\d\d\/\d\d\/\d\d\d\d">
        </div>
    </div>
    <div class="row">
        <div class="large-16 columns">
            <h5>Email's</h5>
            <p>Leave blank to disable.</p>
        </div>
    </div>
    <div class="row">
        <div class="large-8 columns">
            <?php foreach ($divisions as $division=>$email) { ?>
            <label for="deanfor<?php echo strtolower($division); ?>"><?php echo $division; ?> Division</label>
            <input type="text" name="deanfor<?php echo strtolower($division); ?>" id="deanfor<?php echo strtolower($division); ?>" value="<?php echo $email; ?>" required pattern="^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$">
            <?php } ?>
        </div>
        <div class="large-8 columns">
            <label for="recordsemail">Records</label>
            <textarea name="recordsemail" id="recordsemail" rows="3" required><?php echo $config['recordsemail']; ?></textarea>
            <label for="studentservicesemail">Student Services</label>
            <textarea name="studentservicesemail" id="studentservicesemail" rows="3" required><?php echo $config['studentservicesemail']; ?></textarea>
            <label for="veteransemail">Veterans</label>
            <textarea name="veteransemail" id="veteransemail" rows="3" required><?php echo $config['veteransemail']; ?></textarea>
        </div>
    </div>
    <div class="row">
        <div class="large-16 columns">
            <input type="submit" value="Save" class="small radius button" />
        </div>
    </div>
</form>
<script type="text/javascript">
    new datepickr('open', {
        'dateFormat': 'm/d/Y'
    });
    new datepickr('close', {
        'dateFormat': 'm/d/Y'
    });
    new datepickr('iopen', {
        'dateFormat': 'm/d/Y'
    });
    new datepickr('iclose', {
        'dateFormat': 'm/d/Y'
    });
    new datepickr('wpcutoff', {
        'dateFormat': 'm/d/Y'
    });
    new datepickr('wfcutoff', {
        'dateFormat': 'm/d/Y'
    });
</script>