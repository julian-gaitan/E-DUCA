<?php include_once 'lib/include_many.php'; ?>
<?php if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); } ?>
<?php 
    $user_present = !empty($_SESSION['user']);
    if ($user_present) {
        $user = unserialize($_SESSION['user']);
        $user = User::findbyId($conn, new User(), $user->get_id());
    } else {
        $user = new User();
    }
    $role = Role::findbyId($conn, new Role(), $user->get_role());
    $pages_auth = explode(",", $role->get_pages());
?>