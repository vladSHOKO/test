<?php

namespace App;

use App\Bitrix24\Bitrix24API;

class Bitrix24CRMApiController
{
    public string $webhookURL = 'https://b24-ub1w1l.bitrix24.ru/rest/1/8bjplekwyq2o4zx9/';

    public Bitrix24API $bitrix24;

    public function __construct()
    {
        $this->bitrix24 = new Bitrix24API($this->webhookURL);
    }

    public function addContact(): int
    {
        return $this->bitrix24->addContact([
            'NAME' => $_POST['username'],
            'PHONE' => [[
                'VALUE' => $_POST['user-number'],
                'VALUE_TYPE' => 'WORK'
            ]]
        ]);
    }

    public function addDeal()
    {
        return $this->bitrix24->addDeal([
            'TITLE' => 'Сделка с сайта ' . date("Y-m-d H:i:s", time() + 10800),
            'CONTACT_ID' => $this->addContact(),
            'COMMENTS' => $_POST['comment']
        ]);

    }
}