<?php require_once APPROOT.'/views/inc/components/header.php'; ?>
<?php require_once APPROOT.'/views/inc/components/navBar.php'; ?>

    <h1>Us</h1>

    <?php foreach($data['users'] as $user) : ?>
        <p><?php echo $user->name; ?>-<?php echo $user->email ?></p>
    <?php endforeach; ?>
<?php require_once APPROOT.'/views/inc/components/footer.php'; ?>