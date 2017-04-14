<?php
$app->mount("/users", new Todos\Provider\UserProvider());
$app->mount("/messages", new Todos\Provider\MessageProvider());
$app->mount("/tasks", new Todos\Provider\TaskProvider());
?>
