<script type="text/javascript" src="/javascripts/datepickr.min.js"></script>
<form action="<?php echo basename($_SERVER['SCRIPT_NAME']); ?>" method="post">
    <div class="row">
        <div class="lage-16 columns">
            <h3>View Form</h3>
            <table width="100%">
               	<tr>
                    <td width="30%">Form ID</td>
                    <td><?php echo $data['id']; ?></td>
                </tr>
                <tr>
                    <td width="30%">Status</td>
                    <td><?php echo $data['status']; ?></td>
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
                    <td>Student Phone</td>
                    <td><?php echo $data['phone']; ?></td>
                </tr>
                <tr>
                    <td>Veteran</td>
                    <td><?php echo ucfirst($data['veteran']); ?></td>
                </tr>
                <tr>
                    <td>Division</td>
                    <td><?php echo $data['division']; ?></td>
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
                    <td><select name="grade" id="grade">
                            <option value="W"  <?php if ($data['grade'] == 'W') echo 'selected'; ?>>W</option>
                            <option value="WP" <?php if ($data['grade'] == 'WP') echo 'selected'; ?>>WP</option>
                            <option value="WF" <?php if ($data['grade'] == 'WF') echo 'selected'; ?>>WF</option>
                        </select></td>
                </tr>
                <tr>
                    <td>Last Date of Attendance</td>
                    <td><input type="text" name="lastdate" id="lastdate" value="<?php echo $data['lastdate']; ?>"></td>
                </tr>
                <tr>
                    <td>Comments</td>
                    <td><?php echo $data['comments']; ?></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="large-16 columns">
            <?php if ($data['status_code'] != 3) { ?>
                <input type="submit" name="approve" value="Approve" class="radius success button" />
            <?php } ?>
            <input type="submit" name="update" value="Update" class="radius button" />
            <input type="submit" name="cancel" value="Cancel" class="radius alert button" />
        </div>
    </div>
</form>
<script type="text/javascript">
    new datepickr('lastdate', {
        'dateFormat': 'm/d/Y'
    });
</script>
<div class="row">
    <div class="large-16 columns">
        <h3>Logs</h3>
        <table width="100%">
            <thead>
            <th>Name</th>
            <th>ID</th>
            <th>Action</th>
            <th>Time</th>
            <th>IP</th>
            </thead>
            <?php foreach ($logs as $log) { ?>
                <tr>
                    <td><?php echo $log['name']; ?></td>
                    <td><?php echo $log['pid']; ?></td>
                    <td><?php echo $log['message']; ?></td>
                    <td><?php echo date('g:ia m/d/y', $log['time']); ?></td>
                    <td><?php echo $log['ip']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
<div class="row">
    <div class="large-16 columns">
        <a href="#" class="small radius alert button right" data-reveal-id="delete">Delete Form</a>
        <div id="delete" class="reveal-modal" data-reveal>
            <h2>Delete Course Drop Request</h2>
            <p class="lead">This action will remove all traces of this form from the system.</p>
            <a href="view_form.php?delete=<?php echo $data['id']; ?>" class="alert radius button">Delete Form</a>
            <a class="close-reveal-modal">&#215;</a>
        </div>
    </div>
</div>