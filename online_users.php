<?php
require 'function.php';

$currentTime = date('Y-m-d H:i:s');
$onlineTimeLimit = date('Y-m-d H:i:s', strtotime('-5 minutes'));

$onlineUsers = mysqli_query($conn, 
    "SELECT u.*, TIMEDIFF('$currentTime', last_activity) as time_diff 
     FROM users u 
     WHERE last_activity > '$onlineTimeLimit' 
     ORDER BY last_activity DESC");
?>

<div class="card mb-4">
    <div class="card-header bg-info text-white">
        <i class="fas fa-users"></i> Pengguna Online
        <span class="badge bg-light text-dark"><?= mysqli_num_rows($onlineUsers) ?></span>
    </div>
    <div class="card-body p-0">
        <ul class="list-group list-group-flush">
            <?php while($user = mysqli_fetch_assoc($onlineUsers)): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-circle text-success me-2"></i>
                    <?= $user['username'] ?>
                    <small class="text-muted d-block"><?= $user['email'] ?></small>
                </div>
                <small class="text-muted">
                    <?= explode(':', $user['time_diff'])[0] ?>m 
                    <?= explode(':', $user['time_diff'])[1] ?>s
                </small>
            </li>
            <?php endwhile; ?>
        </ul>
    </div>
</div>