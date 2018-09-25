<?php

namespace app\interfaces;

interface SmsSenderInterface
{
    public function send();
    public function check();
}
