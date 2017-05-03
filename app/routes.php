<?php
$app->mount("/users", new Taakin\Provider\UserProvider());
$app->mount("/messages", new Taakin\Provider\MessageProvider());
$app->mount("/tasks", new Taakin\Provider\TaskProvider());
?>
