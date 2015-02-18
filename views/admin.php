<div class="row">
    <div class="large-16 columns">
        <h3>Administration</h3>
    </div>
</div>

<form action="admin.php" method="post">
    <div class="row">
        <div class="large-12 columns">
            <label for="sid">Switch to user (Paste employee/student ID)</label>
            <input type="text" name="sid" id="sid">
        </div>
        <div class="large-4 columns">
            <input type="submit" name="submit" value="Switch User" class="small success radius button" />
        </div>
    </div>
</form>
<div class="row">
    <div class="large-16 columns">
        <h3>Logs</h3>
        <table width="100%">
            <thead>
            <th>Name</th>
            <th>ID</th>
            <th>Action</th>
            <th>Time</th>
            </thead>
            <?php foreach ($logs as $log) { ?>
                <tr>
                    <td><?php echo $log['name']; ?></td>
                    <td><?php echo $log['pid']; ?></td>
                    <td><?php echo nl2br($log['message']); ?></td>
                    <td><?php echo date('g:ia m/d/y', $log['time']); ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>