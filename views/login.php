<header class="row">
    <div class="large-16 columns">
        <h3>Sign in Below</h3>
        <h5 class="subheader">Use your TechID and Password</h5>
        <p>If you are unsure of your login credentials, please see our <a href="http://www.forsythtech.edu/techlink" target="_blank">help page</a>.
    </div>
</header>

<?php
if (!empty($errors)) {
    ?>
    <div class="row">
        <div class="large-16 columns">
            <?php
            foreach ($errors as $error) {
                echo '<div class="alert-box alert">' . $error . '<a href="" class="close">&times;</a></div>' . "\n";
            }
            ?>
        </div>
    </div>
    <?php
}
?>

<div class="row">
    <section class="large-6 columns">
        <form name="login" action="index.php" method="post">
            <input type="text" placeholder="TechID" name="username" required />
            <input type="password" placeholder="Password" name="password" required />
            <input type="submit" value="Login" class="small success radius button" />
        </form>
    </section>
</div>