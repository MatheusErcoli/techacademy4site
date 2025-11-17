<?php

namespace MercadoPago;

class Payer {
    /** @var string */
    public $name;
    /** @var string */
    public $email;
}

class Preference {
    /** @var string|null */
    public $id;
    /** @var Payer|null */
    public $payer;
    /** @var array|null */
    public $items;
    /** @var array|null */
    public $back_urls;
    /** @var string|null */
    public $notification_url;
    /** @var string|null */
    public $auto_return;

    public function save()
    {
        // stub: intencionalmente vazio para ajudar o analisador estático
    }
}
