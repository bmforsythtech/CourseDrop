<div class="row">
    <div class="large-16 columns">
        <h4>Confirmation</h4>
        <?php if (!empty($_SESSION['form_ids'])) { ?>
            <div class="alert-box success">
                Your request to drop the following student(s) was sucessfully submitted.<br /><br />You will receive a confirmation email once the form(s) have been reviewed and processed.
            </div>
        <?php } ?>
        <table style="width: 100%;">
            <thead>
            <th>Form ID</th>
            <th>Name</th>
            <th>Student ID</th>
            <th>Reasons</th>
            <th>Last Date Attended</th>
            <th>Grade</th>
            <th>Comments</th>
            </thead>
            <tbody>
                <?php
                foreach ($_SESSION['studentsToDrop'] as $id => $row) {
                    preg_match('/\[(.+?)\s\w+?\]\s(.+)/', $row['name'], $matches);
                    $section = $matches[1];
                    $title = $matches[2];
                    ?>
                    <tr>
                        <td><?php echo $_SESSION['formids'][$row['user_id']]; ?></td>
                        <td><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
                        <td><?php echo $row['user_id']; ?></td>
                        <td><?php echo $row['reasons']; ?></td>
                        <td><?php echo $row['lastdate']; ?></td>
                        <td><?php echo $row['grade']; ?></td>
                        <td><?php echo $row['comments']; ?></td>
                    </tr>
<?php } ?>
            </tbody>
        </table>
    </div>
</div>
<div class="row hide-on-print">
    <div class="large-16 columns">
        <a href="javascript:window.print()" class="button">Print this page</a>
    </div>
</div>