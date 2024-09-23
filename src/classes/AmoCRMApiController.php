<?php

namespace App;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Client\LongLivedAccessToken;
use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Exceptions\InvalidArgumentException;
use AmoCRM\Models\CustomFieldsValues\TextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\TextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\TextCustomFieldValueModel;
use AmoCRM\Models\LeadModel;

class AmoCRMApiController
{
    private static string $amoCRMDomain = 'kuziavladik.amocrm.ru';

    private static string $accessToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjY2MWUwNjc1ZTBlMzI3NzYxMDJhNDkzMTdjYTc0YzQ5Y2M3MTQxN2ZlMmQ1NTJjZTMyNmJmMTMwM2NjNTE0NjFmMGMxM2FkMTRlOTY5YTEzIn0.eyJhdWQiOiIzYzhhMDUyZS1jZjI1LTRjYjgtYmIxNi1mMjA5ZmFhMDA1Y2YiLCJqdGkiOiI2NjFlMDY3NWUwZTMyNzc2MTAyYTQ5MzE3Y2E3NGM0OWNjNzE0MTdmZTJkNTUyY2UzMjZiZjEzMDNjYzUxNDYxZjBjMTNhZDE0ZTk2OWExMyIsImlhdCI6MTcyNzAyODMyNSwibmJmIjoxNzI3MDI4MzI1LCJleHAiOjE3NDU5NzEyMDAsInN1YiI6IjExNTUyMDk4IiwiZ3JhbnRfdHlwZSI6IiIsImFjY291bnRfaWQiOjMxOTY1Mzk0LCJiYXNlX2RvbWFpbiI6ImFtb2NybS5ydSIsInZlcnNpb24iOjIsInNjb3BlcyI6WyJjcm0iLCJmaWxlcyIsImZpbGVzX2RlbGV0ZSIsIm5vdGlmaWNhdGlvbnMiLCJwdXNoX25vdGlmaWNhdGlvbnMiXSwiaGFzaF91dWlkIjoiYzdiMjAxMjAtMGMzMS00ZmNhLWFmMWEtNThhYjJlOTI5ZDg2IiwiYXBpX2RvbWFpbiI6ImFwaS1iLmFtb2NybS5ydSJ9.P9YYLPSyh7RGiU-G7ORgBczadN1SJalJsC5tur6enGR5_3rcS_z85ljxWfb2ojsF5lFFeijdF7Wst2odmATLO7IkozjQdaXYhWiibrM-kI1rtNe5j4m_TLvUHjJ3HnUtfyYAb9srdwZ_6peFoPWgOS1ZjSsDaUdYu0cKUjeUWo1ES6PjiWG3ZtZ6B-EKSt2ZKLxrg1p9DZflT783Czo5s0tJ9DNoxPkRLVC4XWBTd1AlKFaoh3ahRJGyFNErx5Qk3nWyFdGVnR8BcwNxcc-M1gCA5HqlbJwJ_UXSgRz8a6x79P3ae-35_4wMcMhJuXNeTLE6uSfdy0oMSFFvjwwUWA';

    /**
     * @throws InvalidArgumentException
     */
    private function setConnection(): object
    {
        $apiClient = new \AmoCRM\Client\AmoCRMApiClient();
        $longLivedAccessToken = new LongLivedAccessToken(self::$accessToken);
        return $apiClient->setAccessToken($longLivedAccessToken)->setAccountBaseDomain(self::$amoCRMDomain);
    }

    public function addOneComplex(): object
    {
        $apiClient = $this->setConnection();
        $apiClient->leads()->addOneComplex(LeadModel::$model);
    }

    private function createOneLeadModel()
    {
        $lead = new LeadModel();
        $leadCustomFieldsValues = new CustomFieldsValuesCollection();
        $textCustomFieldValuesModel = new TextCustomFieldValuesModel();
        $textCustomFieldValuesModel->setFieldId(265681);
        $textCustomFieldValuesModel->setValues(
            (new TextCustomFieldValueCollection())
                ->add((new TextCustomFieldValueModel())->setValue($_POST['user-number']))
        );

    }

}