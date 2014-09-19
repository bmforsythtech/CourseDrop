<div class="row">
    <div class="large-16 columns">
        <h4>Enrollment</h4>
        <h5>Semester: <?php echo $semester; ?></h5>
        <table style="width: 100%;">
            <thead>
            <th>Status</th>
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
                        <td><?php
                        if (in_array($row['course'], $droppedCourses)) {
                            echo 'Not Eligible<br />Pending Drop';
                        } elseif ($row['end_date'] < time()) {
                            echo 'Not Eligible<br />Ended ' . date('m/d/y', $row['end_date']);
                        }
                        ?></td>
                        <td><?php echo $section; ?></td>
                        <td><?php echo $title; ?></td>
                        <td><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>