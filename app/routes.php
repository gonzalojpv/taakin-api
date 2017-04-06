<?php
$app->mount("/users", new Todos\Provider\UserProvider());
$app->mount("/messages", new Todos\Provider\MessageProvider());
?>
