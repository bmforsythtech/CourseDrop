<form action="process_instructor.php" method="post">
    <div class="row">
        <div class="large-16 columns">
            <h4>Confirm submission</h4>
            <h5>Course: <?php echo $_SESSION['icourse']; ?></h5>
            <table style="width: 100%;">
                <thead>
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
    <div class="row">
        <div class="large-16 columns">
            <p>You are agreeing to drop the students(s) above.</p>
            <p>Clicking the confirm button below will serve as an electronic signature.</p>
            <input type="submit" name="submit" value="Confirm" class="success radius button" />
            <a href="instructor.php" class="alert radius button">Cancel</a>
        </div>
    </div>
</form>
<div class="row">
    <div class="large-16 columns">
        <p>Your IP address: <?php echo $_SERVER['REMOTE_ADDR']; ?><br />
            Date: <?php echo date('F jS, Y'); ?></p>
    </div>
</div>