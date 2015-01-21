<script type="text/javascript" src="javascripts/datepickr.min.js"></script>
<div class="row">
    <div class="large-16 columns">
        <h2>Setup</h2>
    </div>
</div>

<form action="setup.php" method="post">
    <div class="row">
        <div class="large-16 columns">
            <h3>Term</h3>
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
            <h3>Open/Close Dates</h3>
        </div>
    </div>
    <div class="row">
        <div class="large-8 small-8 columns">
            <h5>Student Open</h5>
        </div>
        <div class="large-8 small-8 columns">
            <h5>Student Close</h5>
        </div>
    </div>
    <div class="row">
        <div class="large-4 small-4 columns">
            <label for="openTime">Time (24 Hour Format XX:XX)</label>
            <input type="text" name="openTime" id="openTime" value="<?php echo $config['openTime']; ?>" required pattern="\d\d:\d\d">
        </div>
        <div class="large-4 small-4 columns">
            <label for="open">Date</label>
            <input type="text" name="open" id="open" value="<?php echo $config['open']; ?>" required pattern="\d\d\/\d\d\/\d\d\d\d">
        </div>
        <div class="large-4 small-4 columns">
            <label for="closeTime">Time (24 Hour Format XX:XX)</label>
            <input type="text" name="closeTime" id="closeTime" value="<?php echo $config['closeTime']; ?>" required pattern="\d\d:\d\d">
        </div>
        <div class="large-4 small-4 columns">
            <label for="close">Date</label>
            <input type="text" name="close" id="close" value="<?php echo $config['close']; ?>" required pattern="\d\d\/\d\d\/\d\d\d\d">
        </div>
    </div>
    <div class="row">
        <div class="large-16 columns">
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="large-8 small-8 columns">
            <h5>Instructor Open</h5>
        </div>
        <div class="large-8 small-8 columns">
            <h5>Instructor Close</h5>
        </div>
    </div>
    <div class="row">
        <div class="large-4 small-4 columns">
            <label for="iopenTime">Time (24 Hour Format XX:XX)</label>
            <input type="text" name="iopenTime" id="iopenTime" value="<?php echo $config['iopenTime']; ?>" required pattern="\d\d:\d\d">
        </div>
        <div class="large-4 small-4 columns">
            <label for="iopen">Date</label>
            <input type="text" name="iopen" id="iopen" value="<?php echo $config['iopen']; ?>" required pattern="\d\d\/\d\d\/\d\d\d\d">
        </div>
        <div class="large-4 small-4 columns">
            <label for="icloseTime">Time (24 Hour Format XX:XX)</label>
            <input type="text" name="icloseTime" id="icloseTime" value="<?php echo $config['icloseTime']; ?>" required pattern="\d\d:\d\d">
        </div>
        <div class="large-4 small-4 columns">
            <label for="iclose">Date</label>
            <input type="text" name="iclose" id="iclose" value="<?php echo $config['iclose']; ?>" required pattern="\d\d\/\d\d\/\d\d\d\d">
        </div>
    </div>
    <div class="row">
        <div class="large-16 columns">
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="large-16 columns">
            <h5>Closed Message</h5>
        </div>
    </div>
    <div class="row">
        <div class="large-8 columns">
            <label for="closedMessage">Students</label>
            <textarea rows="6" name="closedMessage" id="closedMessage"><?php echo $config['closedMessage']; ?></textarea>
        </div>
        <div class="large-8 columns">
            <label for="iclosedMessage">Instructors</label>
            <textarea rows="6" name="iclosedMessage" id="iclosedMessage"><?php echo $config['iclosedMessage']; ?></textarea>
        </div>
    </div>
    <div class="row">
        <div class="large-16 columns">
            <h3>Instructor Grade Options</h3>
        </div>
    </div>
    <div class="row">
        <div class="large-8 columns">
            <label for="wpcutoff">Withdrawal Passing (Enables WP option after this date)</label>
            <input type="text" name="wpcutoff" id="wpcutoff" value="<?php echo $config['wpcutoff']; ?>" required pattern="\d\d\/\d\d\/\d\d\d\d">
        </div>
        <div class="large-8 columns">
            <label for="wfcutoff">Withdrawal Failing (Enables WF option after this date)</label>
            <input type="text" name="wfcutoff" id="wfcutoff" value="<?php echo $config['wfcutoff']; ?>" required pattern="\d\d\/\d\d\/\d\d\d\d">
        </div>
    </div>
    <div class="row">
        <div class="large-16 columns">
            <h3>Email's</h3>
            <p>Leave blank to disable.  Separate by line breaks in multi-line fields.</p>
        </div>
    </div>
    <div class="row">
        <div class="large-8 columns">
            <?php foreach ($divisions as $division=>$email) { ?>
            <label for="deanfor<?php echo strtolower($division); ?>"><?php echo $division; ?> Division</label>
            <input type="text" name="deanfor<?php echo strtolower($division); ?>" id="deanfor<?php echo strtolower($division); ?>" value="<?php echo $email; ?>" pattern="^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$">
            <?php } ?>
        </div>
        <div class="large-8 columns">
            <label for="recordsemail">Records</label>
            <textarea name="recordsemail" id="recordsemail" rows="3"><?php echo $config['recordsemail']; ?></textarea>
            <label for="studentservicesemail">Student Services</label>
            <textarea name="studentservicesemail" id="studentservicesemail" rows="3"><?php echo $config['studentservicesemail']; ?></textarea>
            <label for="veteransemail">Veterans</label>
            <textarea name="veteransemail" id="veteransemail" rows="3"><?php echo $config['veteransemail']; ?></textarea>
        </div>
    </div>
    <div class="row">
        <div class="large-16 columns">
            <h3>Miscellaneous</h3>
        </div>
    </div>
    <div class="row">
        <div class="large-8 columns">
            <label for="emailInstructors">Email Instructors?</label>
            <select name="emailInstructors" id="emailInstructors">
                <option value="0"<?php if($config['emailInstructors'] == '0') echo ' selected'; ?>>No</option>
                <option value="1"<?php if($config['emailInstructors'] == '1') echo ' selected'; ?>>Yes</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="large-16 columns">
            <input type="submit" value="Save" class="small radius button" />
        </div>
    </div>
</form>