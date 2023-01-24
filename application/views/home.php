<div class="form-signup center-block">
    <div class="panel panel-default">
        <div class="panel-body">
            <h2 class="text-center">heap<b>underflow</b></h2>
            <form action="<?= base_url() ?>index.php/auth/confirmregister" method="POST" class="form-horizontal" role="form">
                <div class="form-group">
                    <label for="fullName" class="col-sm-4 control-label">Full Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Full Name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="col-sm-4 control-label">Username</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="username" name="username" placeholder="username">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-4 control-label">Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirmPassword" class="col-sm-4 control-label">Confirm Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="confirmPassword" placeholder="Password">
                    </div>
                </div>
                <div class="form-group" style="justify-content: center; display: flex">
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-success">Sign up</button>
                    </div>
                    <div class="col-sm-3">
                        <a href="<?= base_url() ?>index.php/auth/login" class="btn btn-success">Already a User?</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>