<?php

namespace App;


require_once __DIR__ . "/vendor/autoload.php";
include __DIR__ . "/data/form_data.php";

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="/styles.css" rel="stylesheet">
    <title>Test task</title>
</head>
<body>

<?php
include "route/form.php";
?>
</body>
</html>
