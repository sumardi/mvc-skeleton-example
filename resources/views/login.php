<?php include 'header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Login</div>
                <div class="card-body">
                    <form action="<?php echo url('/login') ?>" method="POST">
                        <div class="form-group">
                            <label>Email</label>
                            <input class="form-control" type="text" name="email" />
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input class="form-control" type="password" name="password" />
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                        <a class="btn btn-secondary" href="<?php echo url('/') ?>">Cancel</a>
                    </form>
                </div>
            </div>

            <p class="mt-2">Don't have an account? <a href="<?php echo url('/register') ?>">Register Here</a></p>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>