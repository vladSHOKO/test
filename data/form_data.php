<?php

namespace App;

use App\AmoCRMApiController;

if (isset($_POST['username']) && isset($_POST['user-number'])) {
    $api = new AmoCRMApiController();
    $api->addOneComplex();
}

echo "<pre>";
var_dump($api);
echo "</pre>";
