<div class="row">
    <div class="large-16 columns">
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
                <td>Reason(s)</td>
                <td><?php echo $data['reasons']; ?></td>
            </tr>
            <tr>
                <td>Official Withdrawal Date</td>
                <td><?php echo date('m/d/Y', $data['officialwithdrawal']); ?></td>
            </tr>
            <tr>
                <td>Grade</td>
                <td><?php echo $data['grade']; ?></td>
            </tr>
            <tr>
                <td>Last Date of Attendance</td>
                <td><?php echo $data['lastdate']; ?></td>
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
        <h3>Logs</h3>
        <table width="100%">
            <thead>
            <th>Name</th>
            <th>Action</th>
            <th>Time</th>
            </thead>
            <?php foreach ($logs as $log) { ?>
                <tr>
                    <td><?php echo $log['name']; ?></td>
                    <td><?php echo $log['message']; ?></td>
                    <td><?php echo date('g:ia m/d/y', $log['time']); ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>