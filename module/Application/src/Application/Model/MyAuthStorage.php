<?php
//module/SanAuth/src/SanAuth/Model/MyAuthStorage.php
namespace Application\Model;

use Zend\Authentication\Storage;

class MyAuthStorage extends Storage\Session
{
    public function setRememberMe($rememberMe = 0, $time = 1209600)
    {
        if ($rememberMe == 1) {
            $this->session->getManager()->rememberMe($time);
        }
    }

    public function forgetMe()
    {
        $this->session->getManager()->forgetMe();
    }
}