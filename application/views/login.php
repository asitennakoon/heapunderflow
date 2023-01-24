<div class="form-login center-block">
    <div class="panel panel-default">
        <div class="panel-body">
            <h2 class="text-center">Sign In</h2>

            <?php
            if (isset($login_error_msg)) {
            ?>
                <div style="color:red">
                    <?= $login_error_msg ?>
                </div>
            <?php
            }
            ?>

            <form action="<?= base_url() ?>index.php/auth/authenticate" method="POST" class="form-horizontal" role="form">
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="username" name="username" placeholder="username">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                </div>
                <!-- <a href="">Forgot password</a> -->
                <div class="form-group" style="display: flex; justify-content: center">
                    <div>
                        <button type="submit" class="btn btn-success">Login</button>
                    </div>
                    <div style="margin-left: 25px">
                        <a href="<?= base_url() ?>index.php" class="btn btn-success">Create Account</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>