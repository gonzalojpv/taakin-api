<?php
$app->mount("/users", new Taakin\Provider\UserProvider());
$app->mount("/amounts", new Taakin\Provider\AmountProvider());
$app->mount("/customers", new Taakin\Provider\CustomerProvider());
?>
