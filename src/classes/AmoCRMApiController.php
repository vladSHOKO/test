<?php

namespace App;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Client\LongLivedAccessToken;
use AmoCRM\Collections\ContactsCollection;
use AmoCRM\Collections\CustomFieldsValuesCollection;
use AmoCRM\Collections\TagsCollection;
use AmoCRM\Exceptions\InvalidArgumentException;
use AmoCRM\Models\ContactModel;
use AmoCRM\Models\CustomFieldsValues\TextCustomFieldValuesModel;
use AmoCRM\Models\CustomFieldsValues\ValueCollections\TextCustomFieldValueCollection;
use AmoCRM\Models\CustomFieldsValues\ValueModels\TextCustomFieldValueModel;
use AmoCRM\Models\LeadModel;
use AmoCRM\Models\TagModel;

class AmoCRMApiController
{
    public string $amoCRMDomain = 'kuziavladik.amocrm.ru';

    public string $accessToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjY2MWUwNjc1ZTBlMzI3NzYxMDJhNDkzMTdjYTc0YzQ5Y2M3MTQxN2ZlMmQ1NTJjZTMyNmJmMTMwM2NjNTE0NjFmMGMxM2FkMTRlOTY5YTEzIn0.eyJhdWQiOiIzYzhhMDUyZS1jZjI1LTRjYjgtYmIxNi1mMjA5ZmFhMDA1Y2YiLCJqdGkiOiI2NjFlMDY3NWUwZTMyNzc2MTAyYTQ5MzE3Y2E3NGM0OWNjNzE0MTdmZTJkNTUyY2UzMjZiZjEzMDNjYzUxNDYxZjBjMTNhZDE0ZTk2OWExMyIsImlhdCI6MTcyNzAyODMyNSwibmJmIjoxNzI3MDI4MzI1LCJleHAiOjE3NDU5NzEyMDAsInN1YiI6IjExNTUyMDk4IiwiZ3JhbnRfdHlwZSI6IiIsImFjY291bnRfaWQiOjMxOTY1Mzk0LCJiYXNlX2RvbWFpbiI6ImFtb2NybS5ydSIsInZlcnNpb24iOjIsInNjb3BlcyI6WyJjcm0iLCJmaWxlcyIsImZpbGVzX2RlbGV0ZSIsIm5vdGlmaWNhdGlvbnMiLCJwdXNoX25vdGlmaWNhdGlvbnMiXSwiaGFzaF91dWlkIjoiYzdiMjAxMjAtMGMzMS00ZmNhLWFmMWEtNThhYjJlOTI5ZDg2IiwiYXBpX2RvbWFpbiI6ImFwaS1iLmFtb2NybS5ydSJ9.P9YYLPSyh7RGiU-G7ORgBczadN1SJalJsC5tur6enGR5_3rcS_z85ljxWfb2ojsF5lFFeijdF7Wst2odmATLO7IkozjQdaXYhWiibrM-kI1rtNe5j4m_TLvUHjJ3HnUtfyYAb9srdwZ_6peFoPWgOS1ZjSsDaUdYu0cKUjeUWo1ES6PjiWG3ZtZ6B-EKSt2ZKLxrg1p9DZflT783Czo5s0tJ9DNoxPkRLVC4XWBTd1AlKFaoh3ahRJGyFNErx5Qk3nWyFdGVnR8BcwNxcc-M1gCA5HqlbJwJ_UXSgRz8a6x79P3ae-35_4wMcMhJuXNeTLE6uSfdy0oMSFFvjwwUWA';

    public AmoCRMApiClient $apiClient;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct()
    {
        $apiClient = new AmoCRMApiClient();
        $longLivedAccessToken = new LongLivedAccessToken($this->accessToken);
        $apiClient->setAccessToken($longLivedAccessToken)->setAccountBaseDomain($this->amoCRMDomain);
        $this->apiClient = $apiClient;
    }

    public function addOneComplex(): void
    {
        $this->apiClient->leads()->addOneComplex($this->createOneLeadModel());
    }

    public function createOneLeadModel(): LeadModel
    {
        $customContactFieldsValuesCollection = new CustomFieldsValuesCollection();
        $phoneCustomFieldValueModel = new TextCustomFieldValuesModel();
        $phoneCustomFieldValueModel->setFieldId(265681)->setValues((new TextCustomFieldValueCollection())->add((new TextCustomFieldValueModel())->setValue($_POST['user-number'])));
        $customContactFieldsValuesCollection->add($phoneCustomFieldValueModel);

        $customMetaDataFieldValuesCollection = new CustomFieldsValuesCollection();
        $sourceCustomFieldValueModel = new TextCustomFieldValuesModel();
        $commentCustomFieldValueModel = new TextCustomFieldValuesModel();

        $commentCustomFieldValueModel->setFieldId(323275)->setValues((new TextCustomFieldValueCollection())->add((new TextCustomFieldValueModel())->setValue($_POST['comment'])));
        $sourceCustomFieldValueModel->setFieldId(239987)->setValues((new TextCustomFieldValueCollection())->add((new TextCustomFieldValueModel())->setValue('Сайт')));

        $customMetaDataFieldValuesCollection->add($sourceCustomFieldValueModel);
        $customMetaDataFieldValuesCollection->add($commentCustomFieldValueModel);

        $leadModel = new LeadModel();
        $leadModel->setName("Заказ с сайта " . date("Y-m-d H:i:s", time() + 10800))->setContacts((new ContactsCollection())->add((new ContactModel())->setFirstName($_POST['username'])->setCreatedAt(time())->setCustomFieldsValues($customContactFieldsValuesCollection)))->setCreatedAt(time())->setCustomFieldsValues($customMetaDataFieldValuesCollection)->setTags((new TagsCollection())->add((new TagModel())->setName('сайт')));
        return $leadModel;
    }

}