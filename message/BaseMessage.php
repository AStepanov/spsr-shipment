<?php

namespace stp\spsr\message;

use stp\spsr\BaseType;

class BaseMessage extends BaseType
{
    protected $sid;

    /**
     * Set Session ID
     * @param string $sid
     */
    public function setSid($sid)
    {
        $this->sid = $sid;
    }

    public function isRequiredICN()
    {
        return 'ICN';
    }

    public function isRequiredLogin()
    {
        return 'Login';
    }

}
