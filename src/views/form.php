<?php if (empty($data)) { ?>
    <div class="row">
        <div class="large-16 columns">
            <h4>Select the course(s) to drop</h4>
            <p>We're sorry, but we could not pull up your enrollment information at this time.</p>
            <p>Please contact the <a href="http://www.forsythtech.edu/services-students/student-resources/academic-records-transcripts/">Records Office</a> directly for further assistances.</p>
        </div>
    </div>
    <?php if ($_SESSION['instructor'] == 1) { ?>
        <div class="row">
            <div class="large-16 columns">
                <h4>Instructor Access</h4>
                <p>Please see the <a href="instructor.php">Instructor Page</a> to access your information.</p>
            </div>
        </div>
    <?php } ?>
<?php } else { ?>
    <form action="confirm.php" method="post">
        <div class="row">
            <div class="large-16 columns">
                <h4>Select the course(s) to drop</h4>
                <h5>Semester: <?php echo $semester; ?></h5>
                <table style="width: 100%;">
                    <thead>
                    <th>Select</th>
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
                                <td><input name="courses[]" type="checkbox" value="<?php echo $row['course']; ?>" /></td>
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
            <div class="large-16 columns">
                <h5>Reason(s) for dropping selected course(s):</h5>
            </div>
        </div>
        <div class="row">
            <div class="large-8 columns">
                <input name="reasons[]" type="checkbox" value="Employment" />Employment<br/>
                <input name="reasons[]" type="checkbox" value="Illness (Personal/Family)" />Illness (Personal/Family)<br/>
                <input name="reasons[]" type="checkbox" value="Child Care Problems" />Child Care Problems<br/>
                <input name="reasons[]" type="checkbox" value="Financial" />Financial<br/>
                <input name="reasons[]" type="checkbox" value="Transportation" />Transportation<br/>
                <input name="reasons[]" type="checkbox" value="Relocation" />Relocation<br/>
                <input name="reasons[]" type="checkbox" value="Course Load Too Heavy" />Course Load Too Heavy<br/>
                <input name="reasons[]" type="checkbox" value="Course Too Difficult" />Course Too Difficult<br/>
                <input name="reasons[]" type="checkbox" value="Course Not What Expected" />Course Not What Expected<br/>
                <input name="reasons[]" type="checkbox" value="Transfer to Another School" />Transfer to Another School<br/>
                <input name="reasons[]" type="checkbox" value="Dissatisfied - Instruction" />Dissatisfied - Instruction
            </div>
            <div class="large-8 columns">
                <input name="reasons[]" type="checkbox" value="Excessive Absences" />Excessive Absences<br/>
                <input name="reasons[]" type="checkbox" value="Changed My Mind" />Changed My Mind<br/>
                <input name="reasons[]" type="checkbox" value="Misadvised" />Misadvised<br/>
                <input name="reasons[]" type="checkbox" value="Personal" />Personal<br/>
                <input name="reasons[]" type="checkbox" value="Death in the Family" />Death in the Family<br/>
                <input name="reasons[]" type="checkbox" value="Goal Completed" />Goal Completed<br/>
                <input name="reasons[]" type="checkbox" value="Military Deployment" />Military Deployment<br/>
                <input name="reasons[]" type="checkbox" value="Changed Program" />Changed Program<br/><br/>
                <label for="reasons_other">Other, please specify:</label>
                <input name="reasons_other" type="text" value="" />
            </div>
        </div>
        <div class="row">
            <div class="large-16 columns">
                <h5>Are you a veteran?:</h5>
            </div>
        </div>
        <div class="row">
            <div class="large-16 columns">
                <input type="radio" name="veteran" value="yes" required>Yes<br>
                <input type="radio" name="veteran" value="no" required>No
            </div>
        </div>
        <div class="row">
            <div class="large-16 columns">
                <hr />
                <p>You will confirm your selection on the next page.</p>
                <input type="submit" name="submit" value="Submit" class="success radius button" />
                <a href="index.php?logout=true" class="alert radius button">Cancel</a>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="large-16 columns">
            <p>If you are receiving financial assistance (grants, loans, VA benefits) you should check with <a href="http://www.forsythtech.edu/services-students/student-resources/financial-aid/">Finacial Aid</a> before submitting an online course withdrawal.</p>
        </div>
    </div>
<?php } ?>