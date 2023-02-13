<?php

namespace Victtech\Lottery;

use Illuminate\Config\Repository;
use Illuminate\Session\SessionManager;

class BaseLottery
{
    protected $session;
    protected $config;


    public function __construct(SessionManager $session,Repository $config){
        $this->session = $session;
        $this->config = $config;
    }

}
