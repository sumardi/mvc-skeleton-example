<?php include 'header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Register</div>
                <div class="card-body">
                    <form action="<?php echo url('/register') ?>" method="POST">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" />
                        </div>
                        <div class="form-group">
                            <label for="name">Email</label>
                            <input type="text" class="form-control" name="email" />
                        </div>
                        <div class="form-group">
                            <label for="name">Password</label>
                            <input type="password" class="form-control" name="password" />
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a class="btn btn-secondary" href="<?php echo url('/') ?>">Cancel</a>
                    </form>
                </div>
            </div>

            <p class="mt-2">Already have an account? <a href="<?php echo url('/login') ?>">Login Here</a></p>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>