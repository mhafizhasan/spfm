<?php if(!defined("BASEPATH")) exit("No direct script access allowed");
class MY_Pagination extends CI_Pagination{

    function MY_Pagination()
    {

        parent::CI_Pagination();
        $this->CI = & get_instance();

    }

    function initialize($params = array())
    {
        if (count($params) > 0)
        {
            foreach ($params as $key => $val)
            {
                if (isset($this->$key))
                {
                    $this->$key = $val;
                }
            }
        }
        $this->tidy_base_url();
    }

    function tidy_base_url(){

        if ($this->CI->config->item('enable_query_strings') === TRUE OR $this->page_query_string === TRUE)
        {
            if(strpos($this->base_url, '&') === false){
                $this->base_url .= "/";
            }
            
           // $pattern = "#&per_page=#";//"#(&{$this->query_string_segment}=[\w]+)#is";
            //$this->base_url = preg_replace($pattern, '', $this->base_url);
            //$this->base_url = preg_replace($pattern, '', $this->base_url);
            
            $this->base_url  = str_replace('&', '', $this->base_url);
        }
    }

}  