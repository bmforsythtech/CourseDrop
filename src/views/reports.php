<div class="row">
    <div class="large-16 columns">
        <h4>Reports</h4>
        <p>Download all drop requests for: (Excel format)</p>
        <ul>
            <?php foreach ($semestersList as $value) { ?>
                <li><a href="reports.php?semester=<?php echo $value['semester']; ?>"><?php echo $value['semester']; ?></a></li>
            <?php } ?>
        </ul>
    </div>
</div>