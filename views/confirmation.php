<div class="row">
    <div class="large-16 columns">
        <h4>Confirmation</h4>
        <?php if (!empty($_SESSION['form_ids'])) { ?>
            <div class="alert-box success">
                Your request to drop the following course(s) was sucessfully submitted.<br /><br />You will receive a confirmation email once the form has been reviewed and processed.
            </div>
        <?php } ?>
        <table style="width: 100%;">
            <thead>
            <th>Form ID</th>
            <th>Section</th>
            <th>Course</th>
            <th>Instructor</th>
            </thead>
            <tbody>
                <?php
                foreach ($data as $row) {
                    preg_match('/\[(.+?)\s\w+?\]\s(.+)/', $row['course_name'], $matches);
                    $section = $matches[1];
                    $title = $matches[2];
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $section; ?></td>
                        <td><?php echo $title; ?></td>
                        <td><?php echo $row['instructorname']; ?></td>
                    </tr>
<?php } ?>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="large-16 columns">
        <h5>Reason(s) for dropping the above course(s):</h5>
    </div>
</div>
<div class="row">
    <div class="large-16 columns">
        <ul>
            <?php foreach ($_SESSION['reasonsToDrop'] as $reason) { ?>
                <li><?php echo $reason; ?></li>
<?php } ?>
        </ul>
    </div>
</div>
<div class="row">
    <div class="large-16 columns">
        <h5>Veteran?:</h5>
    </div>
</div>
<div class="row">
    <div class="large-16 columns">
        <ul>
            <li><?php echo ucfirst($_SESSION['veteran']); ?></li>
        </ul>
    </div>
</div>
<div class="row hide-on-print">
    <div class="large-16 columns">
        <a href="javascript:window.print()" class="button">Print this page</a>
    </div>
</div>