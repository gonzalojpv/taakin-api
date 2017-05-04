<?php
$app->mount("/users", new Taakin\Provider\UserProvider());
$app->mount("/amounts", new Taakin\Provider\AmountProvider());
$app->mount("/customers", new Taakin\Provider\CustomerProvider());
$app->mount("/payments", new Taakin\Provider\PaymentProvider());

$app->mount("/", new Admin\Provider\IndexProvider());
$app->mount("/dashboard/users", new Admin\Provider\UserProvider());
?>
