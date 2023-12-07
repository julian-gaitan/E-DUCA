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
    $roles = Role::findAll($conn, new Role());
    $pages = "";
    foreach ($roles as $role) {
        if (($user->get_role() & $role->get_value()) > 0) {
            if (strlen($pages) > 0) {
                $pages = $pages . ",";
            }
            $pages = $pages . $role->get_pages();
        }
    }
    $pages_auth = explode(",", $pages);
    $file_name = $_SERVER['SCRIPT_NAME'];
    $file_name = substr(strrchr($file_name, "/"), 1);
    $file_name = strchr($file_name, ".", true);
?>