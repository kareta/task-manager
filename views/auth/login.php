
<?php include $this->basePath() .  'common/header.php' ?>

<h1>Login</h1>
<?php
    if (isset($_SESSION['login_error'])) {
        echo "<p class='text-danger'>{$_SESSION['login_error']}</p>";
        unset($_SESSION['login_error']);
    }
?>
<form action="/auth/login" method="post">

    <?= $this->csrfToken() ?>

    <div class="col-md-12 form-group no-padding">
        <label for="login-name">Name</label>
        <input id="login-name" type="text" name="name" class="max-width-300 form-control input-md">
    </div>

    <div class="col-md-12 form-group no-padding">
        <label for="login-password">Password</label>
        <input id="login-password" type="password" name="password" class="max-width-300 form-control input-md">
    </div>

    <button id="login-submit" class="btn btn-primary" name="submit">Login</button>

</form>

<?php include $this->basePath() .  'common/footer.php' ?>
