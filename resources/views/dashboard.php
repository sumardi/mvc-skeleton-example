<?php include 'header.php'; ?>

<div class="container">
    <h1>Dashboard</h1>

    <p>Welcome, <?php echo $user['name'] ?>!</p>

    <a href="<?php echo url('/logout') ?>" class="btn btn-primary">Logout</a>
</div>

<?php include 'footer.php'; ?>