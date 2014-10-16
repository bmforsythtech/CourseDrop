<script type="text/javascript" src="/javascripts/datepickr.min.js"></script>
<form action="confirm2_instructor.php" method="post">
    <div class="row">
        <div class="large-16 columns">
            <h4>Enter additional information for each student</h4>
            <h5>Course: <?php echo $_SESSION['icourse']; ?></h5>
            <table style="width: 100%;">
                <thead>
                <th>Name</th>
                <th>Student ID</th>
                <th>Reason(s)</th>
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
                            <td><input type="text" name="reasons_<?php echo $row['user_id']; ?>" required></td>
                            <td><input type="text" name="lastdate_<?php echo $row['user_id']; ?>" id="lastdate_<?php echo $row['user_id']; ?>" required pattern="\d\d\/\d\d\/\d\d\d\d"></td>
                            <td>
                                <select name="grade_<?php echo $row['user_id']; ?>" required>
                                    <option value=""></option>
                                    <option value="W">W</option>
                                    <?php
                                    if (time() > strtotime($config['wpcutoff'])) {
                                        echo '<option value="WP">WP</option>';
                                    }
                                    ?>
                                    <?php
                                    if (time() > strtotime($config['wfcutoff'])) {
                                        echo '<option value="WF">WF</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                            <td><input type="text" name="comments_<?php echo $row['user_id']; ?>"></td>
                        </tr>
                    <script type="text/javascript">
                        new datepickr('lastdate_<?php echo $row['user_id']; ?>', {
                            'dateFormat': 'm/d/Y'
                        });
                    </script>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="large-16 columns">
            <p>You will confirm your selection on the next page.</p>
            <input type="submit" name="submit" value="Submit" class="success radius button" />
            <a href="instructor.php" class="alert radius button">Cancel</a>
        </div>
    </div>
</form>