<?php if(!defined("BASEPATH")) exit("No direct script access allowed");
/**
 * This extension ensures GET data is not erased
 */
class MY_Input extends CI_Input
{
    function _sanitize_globals()
    {
        $this->allow_get_array = TRUE;
        parent::_sanitize_globals();
    }
}  