<form action="process.php" method="post">
    <div class="row">
        <div class="large-16 columns">
            <h4>Confirm the course(s) to drop</h4>
            <table style="width: 100%;">
                <thead>
                <th>Section</th>
                <th>Course</th>
                <th>Instructor</th>
                </thead>
                <tbody>
                    <?php
                    foreach ($data as $row) {
                        preg_match('/\[(.+?)\s\w+?\]\s(.+)/', $row['name'], $matches);
                        $section = $matches[1];
                        $title = $matches[2];
                        ?>
                        <tr>
                            <td><?php echo $section; ?></td>
                            <td><?php echo $title; ?></td>
                            <td><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
                        </tr>
<?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="large-8 columns">
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
        <div class="large-8 columns">
            <h5>Veteran?</h5>
        </div>
    </div>
    <div class="row">
        <div class="large-16 columns">
            <ul>
                <li><?php echo ucfirst($_SESSION['veteran']); ?></li>
            </ul>
        </div>
    </div>
<?php if (!empty($_SESSION['droppingAll']) && !empty($config['studentservicesemail'])) { ?>
        <div class="row">
            <div class="large-16 columns">
                <h5>You are dropping all of your courses for this semester:</h5>
            </div>
        </div>
        <div class="row">
            <div class="large-8 columns">
                <p>If you would like someone to contact to help you build a plan for returning to Forsyth Tech, please leave a phone number where you can be contacted:</p>
            </div>
            <div class="large-8 columns">
                <label for="phone">Phone:</label>
                <input type="text" name="phone" id="phone" />
            </div>
        </div>
<?php } ?>
    <div class="row">
        <div class="large-16 columns">
            <div class="alert-box radius secondary">
                <h5>Are you receiving a financial aid this semester?</h5>
                <p>Withdrawing from course(s) can negatively affect your financial aid, and in some cases, may require tuition to be paid back.  If you have any questions about this, please contact the Financial Aid Office at (336) 734-7235.</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="large-16 columns">
            <h5>You are agreeing to drop the course(s) above.</h5>
            <p>Clicking the confirm button below will serve as an electronic signature.</p>
            <input type="submit" name="submit" value="Confirm" class="success radius button" />
            <a href="form.php" class="alert radius button">Cancel</a>
        </div>
    </div>
</form>
<div class="row">
    <div class="large-16 columns">
        <p>Your IP address: <?php echo $_SERVER['REMOTE_ADDR']; ?><br />
            Date: <?php echo date('F jS, Y'); ?></p>
    </div>
</div>