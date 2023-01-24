<div class="container">
    <h2>Account Overview</h2>

    <div class="row" style="padding-top: 2%; padding-bottom: 2%">
        <label class="col-sm-1 control-label">Full Name</label>
        <div class="col-sm-11">
            <span id="full-name"><?= $fullName ?></span>
            <a id="change-name-link" style="margin-left: 10px" href="#">Change</a>
        </div>
    </div>

    <div class="row">
        <label class="col-sm-1 control-label">Password</label>
        <div class="col-sm-11">
            ************
            <a id="change-password-link" style="margin-left: 10px" href="#">Change</a>
        </div>
    </div>
</div>


<div class="modal" id="change-name-modal" tabindex="-1" role="dialog" aria-labelledby="change-name-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="change-name-modal-label">Change Full Name</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <input type="text" class="form-control" id="change-name"></input>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save-name-change-btn">Confirm</button>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="change-password-modal" tabindex="-1" role="dialog" aria-labelledby="change-password-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="change-password-modal-label">Change Password</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="current-password" class="control-label">Current Password:</label>
                        <input type="password" class="form-control" id="current-password">
                    </div>
                    <div class="form-group">
                        <label for="new-password" class="control-label">New Password:</label>
                        <input type="password" class="form-control" id="new-password">
                    </div>
                    <div class="form-group">
                        <label for="confirm-password" class="control-label">Confirm Password:</label>
                        <input type="password" class="form-control" id="confirm-password">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save-password-change-btn">Confirm</button>
            </div>
        </div>
    </div>
</div>


<script>
    $('#save-name-change-btn').click(function() {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>index.php/auth/changename",
            data: {
                fullName: $('#change-name').val()
            },
            success: function(response) {
                $('#change-name-modal').modal('hide');
                $('#full-name').text(response);
            },
            error: function(response) {
                console.log(response);
            }
        });
    });

    $('#save-password-change-btn').click(function() {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>index.php/auth/changepassword",
            data: {
                oldPassword: $('#current-password').val(),
                newPassword: $('#new-password').val()
            },
            success: function(response) {
                $('#change-password-modal').modal('hide');
                window.location.href = '<?= base_url() ?>index.php/auth/login';
            },
            error: function(response) {
                console.log(response);
            }
        });
    });

    $('#change-name-link').click(function(e) {
        e.preventDefault();
        $('#change-name').val($('#full-name').text());

        $('#change-name-modal').modal('show');
    });

    $('#change-password-link').on('click', function(e) {
        e.preventDefault();
        $('#change-password-modal').modal('show');
    });

    $('[data-dismiss="modal"]').click(function() {
        $('.modal').modal('hide');
    });
</script>