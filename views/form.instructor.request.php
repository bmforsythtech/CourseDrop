<script type="text/javascript" src="/javascripts/datepickr.min.js"></script>
<form action="<?php echo basename($_SERVER['SCRIPT_NAME']); ?>" method="post">
    <div class="row">
        <div class="large-16 columns">
            <h3>Additional Information Needed</h3>
            <table width="100%">
               	<tr>
                    <td width="30%">Form ID</td>
                    <td><?php echo $data['id']; ?></td>
                </tr>
                <tr>
                    <td>Course</td>
                    <td><?php echo $data['course']; ?></td>
                </tr>
                <tr>
                    <td>Student Name</td>
                    <td><?php echo $data['firstname']; ?> <?php echo $data['lastname']; ?></td>
                </tr>
                <tr>
                    <td>Student ID</td>
                    <td><?php echo $data['studentid']; ?></td>
                </tr>
                <tr>
                    <td>Student Email</td>
                    <td><a href="mailto:<?php echo $data['studentemail']; ?>"><?php echo $data['studentemail']; ?></a></td>
                </tr>
                <tr>
                    <td>Reason(s)</td>
                    <td><?php echo $data['reasons']; ?></td>
                </tr>
                <tr>
                    <td>Official Withdrawal Date</td>
                    <td><?php echo date('m/d/Y', $data['officialwithdrawal']); ?></td>
                </tr>
                <tr>
                    <td>Grade</td>
                    <td>
                        <select name="grade" id="grade" required>
                            <option value=""></option>
                            <option value="W">W</option>
                            <?php
                                if (strtotime($config['wpcutoff']) > time()) {
                                    echo '<option value="WP">WP</option>';
                                }
                            ?>
                            <?php
                                if (strtotime($config['wfcutoff']) > time()) {
                                    echo '<option value="WF">WF</option>';
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Last Date of Attendance</td>
                    <td><input type="text" name="lastdate" id="lastdate" required pattern="\d\d\/\d\d\/\d\d\d\d"></td>
                </tr>
                <tr>
                    <td>Comments</td>
                    <td><textarea name="comments" id="comments" rows="4"></textarea></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="large-16 columns">
            <input type="submit" name="submit" value="Submit" class="success radius button" />
        </div>
    </div>
</form>
<script type="text/javascript">
    new datepickr('lastdate', {
        'dateFormat': 'm/d/Y'
    });
</script>