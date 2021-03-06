<div class="row">
    <form method="GET">
        <div class="large-10 columns">
            <h3>Forms</h3>
        </div>
        <div class="large-6 columns" style="text-align:right;">
            <div class="row collapse postfix-round">
                <div class="small-8 columns">
                    <input type="text" name="search" value="<?php echo $_SESSION['filter']['search']; ?>" placeholder="Last name or SID" />
                </div>
                <div class="small-4 columns">
                    <input type="submit" value="Search" class="button postfix" />
                </div>
                <div class="small-4 columns">
                    <input type="submit" name="reset" value="Reset" class="tiny secondary button" />
                </div>
            </div>
        </div>
    </form>
</div>
<div class="row">
    <div class="large-16 columns">
        <dl class="sub-nav">
            <dt>Filter:</dt>
            <dd<?php if (empty($_SESSION['filter']['filter'])) echo ' class="active"'; ?>><a href="view_form.php?filter=">All</a></dd>
            <?php foreach ($view_filters as $key => $value) { ?>
                <dd<?php if ($_SESSION['filter']['filter'] == $key) echo ' class="active"'; ?>><a href="?filter=<?php echo $key; ?>"><?php echo $value; ?></a></dd>
            <?php } ?>
        </dl>
        <dl class="sub-nav">
            <dt>Status:</dt>
            <dd<?php if (empty($_SESSION['filter']['status'])) echo ' class="active"'; ?>><a href="view_form.php?status=">All</a></dd>
            <?php foreach ($statuses as $key=>$value) { ?>
                <dd<?php if ($_SESSION['filter']['status'] == $key) echo ' class="active"'; ?>><a href="?status=<?php echo $key; ?>"><?php echo $value; ?></a></dd>
            <?php } ?>
        </dl>
        <dl class="sub-nav">
            <dt>Semester:</dt>
            <dd<?php if (empty($_SESSION['filter']['semester'])) echo ' class="active"'; ?>><a href="view_form.php?semester=">All</a></dd>
            <?php foreach ($semestersList as $value) { ?>
                <dd<?php if ($_SESSION['filter']['semester'] == $value['semester']) echo ' class="active"'; ?>><a href="?semester=<?php echo $value['semester']; ?>"><?php echo $value['semester']; ?></a></dd>
            <?php } ?>
        </dl>
    </div>
</div>
<?php if (!empty($_SESSION['filter']['deleted'])){ ?>
<div class="row">
    <div class="large-16 columns">
        <div data-alert class="alert-box warning radius">
            You are currently viewing deleted forms.  Click the reset button above to view all forms.
            <a href="#" class="close">&times;</a>
        </div>
    </div>
</div>
<?php } ?>
<div class="row">
    <div class="large-16 columns">
        <?php if (empty($history)) { ?>
            <ul>
                <li>No withdrawals for this term found.</li>
            </ul>
        <?php } ?>
        <table width="100%">
            <thead>
            <th>Form ID</th>
            <th>Semester</th>
            <th>Course</th>
            <th>Student</th>
            <th>SID</th>
            <th>Status</th>
            </thead>
            <tbody>
            <?php
            foreach ($history as $row) {
                preg_match('/\[(.+?)\s\w+?\]\s(.+)/', $row['course_name'], $matches);
                $title = $matches[1] . ' - ' . $matches[2];
                ?>
                <tr>
                    <td><a href="view_form.php?id=<?php echo $row['id']; ?>"><?php echo $row['id']; ?></td>
                    <td><?php echo $row['semester']; ?></td>
                    <td><?php echo $title; ?></td>
                    <td><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
                    <td><?php echo $row['studentid']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<div class="pagination-centered">
    <ul class="pagination">
        <?php if ($page != 1){ ?>
        <li class="arrow"><a href="?page=<?php echo $page-1; if(isset($filter)) echo '&filter=' . $filter; ?>">&laquo;</a></li>
        <?php } ?>
        <?php
            $rangel = $page-5;
            if ($rangel <= 1) $rangel = 1;
            $rangeu = $page+5;
            if ($rangeu >= $pages) $rangeu = $pages;
            for ($i=$rangel; $i<=$rangeu; $i++){
        ?>
        <li<?php if ($page == $i) echo ' class="current"'; ?>><a href="?page=<?php echo $i; if(isset($filter)) echo '&filter=' . $filter; ?>"><?php echo $i; ?></a></li>
        <?php } ?>
        <?php if ($page != $pages){ ?>
        <li class="arrow"><a href="?page=<?php echo $page+1; if(isset($filter)) echo '&filter=' . $filter; ?>">&raquo;</a></li>
        <?php } ?>
    </ul>
    <p>Total: <?php echo $pagesCount[0]['pages']; ?></p>
</div>
<div class="row">
    <div class="large-16 columns">
        <p class="text-center"><a href="?deleted=<?php echo (empty($_SESSION['filter']['deleted'])) ? '1' : '0' ?>">View <?php echo (empty($_SESSION['filter']['deleted'])) ? 'deleted' : 'all' ?> forms.</a></p>
    </div>
</div>