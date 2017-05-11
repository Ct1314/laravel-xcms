<?php

namespace Flash;

use Illuminate\Session\Store;

class LaravelSession implements FlashSession
{
    protected $session;

    /**
     * LaravelSession constructor.
     * @param Store $session
     */
    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * @name flash
     * @desc session flash
     * @param string $name session key
     * @param string $data session value
     * @author Yuanchang.xu
     * @since 2017-03-14
     * @return void
     */
    public function flash($name, $data)
    {
        $this->session->flash($name,$data);
    }
}