<?php

use App\Contracts\Translator;

class YandexTranslator implements Translator {
    const URL = 'https://translate.api.cloud.yandex.net/translate/v2/translate';
    private $yandexIamToken;
    public function __construct() {
        $this->yandexIamToken = env("YANDEX_IAM_TOKEN");
    }
    public function translate(string $word) {

    }
}
