<?php

defined('BASEPATH') or exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation
{

    public function alpha_tr($str)
    {
        return (bool)preg_match('/^[\p{L}a-z\s]+$/u', $str);
    }

}
