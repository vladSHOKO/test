<?php

namespace App;

include "../src/core.php";


if (isset($_POST['username']) && isset($_POST['user-number'])) {
    $amoApi = new AmoCRMApiController();
    $amoApi->addOneComplex();

    $bitrix24Api = new Bitrix24CRMApiController();
    $bitrix24Api->addDeal();

    unsetPOSTArray();
}


