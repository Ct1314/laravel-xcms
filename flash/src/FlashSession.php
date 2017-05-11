<?php

namespace Flash;

interface FlashSession
{
    public function flash($name,$data);
}