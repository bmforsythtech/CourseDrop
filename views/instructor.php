<div class="row">
    <div class="large-16 columns">
        <h4>Drop a student</h4>
        <p>Select a course.  Semester: <?php echo $semester; ?></p>
        <ul>
            <?php
            foreach ($data as $row) {
                preg_match('/\[(.+?)\s\w+?\]\s(.+)/', $row['name'], $matches);
                $title = $semester . ' - ' . $matches[1] . ' - ' . $matches[2];
                ?>
                <li><a href="?c=<?php echo urlencode($row['course']); ?>"><?php echo $title; ?></a></li>
            <?php } if (empty($data)) { ?>
                <li>No courses found.</li>
            <?php } ?>
        </ul>
    </div>
</div>
<div class="row">
    <div class="large-16 columns">
        <h4>History</h4>
        <table width="100%">
            <thead>
            <th>Form ID</th>
            <th>Semester</th>
            <th>Course</th>
            <th>Student</th>
            <th>SID</th>
            <th>Status</th>
            </thead>
            <?php
            foreach ($history as $row) {
                preg_match('/\[(.+?)\s\w+?\]\s(.+)/', $row['course_name'], $matches);
                $title = $matches[1] . ' - ' . $matches[2];
                ?>
                <tr>
                    <td><a href="/view_form_instructor.php?id=<?php echo $row['id']; ?>"><?php echo $row['id']; ?></a></td>
                    <td><?php echo $row['semester']; ?></td>
                    <td><?php echo $title; ?></td>
                    <td><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
                    <td><?php echo $row['studentid']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                </tr>

            <?php } if (empty($history)) { ?>
                <ul>
                    <li>No withdrawals for this term found.</li>
                </ul>
            <?php } ?>
        </table>
    </div>
</div>