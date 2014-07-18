<form action="confirm_instructor.php" method="post">
    <div class="row">
        <div class="large-16 columns">
            <h4>Select the students(s) to drop</h4>
            <h6>Course: <?php echo $_SESSION['icourse']; ?></h6>
            <table style="width: 100%;">
                <thead>
                <th>Select</th>
                <th>Student Name</th>
                <th>Student ID</th>
                </thead>
                <tbody>
                    <?php
                    foreach ($data as $row) {
                        if (in_array($row['user_id'], $processed)) {
                            continue;
                        }
                        ?>
                        <tr>
                            <td><input name="students[]" type="checkbox" value="<?php echo $row['user_id']; ?>" /></td>
                            <td><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
                            <td><?php echo $row['user_id']; ?></td>
                        </tr>
<?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="large-16 columns">
            <hr>
            <input type="submit" name="submit" value="Submit" class="success radius button" />
            <a href="instructor.php" class="alert radius button">Cancel</a>
        </div>
    </div>
</form>