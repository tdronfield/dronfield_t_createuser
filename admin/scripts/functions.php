<?php

function redirect_to($location=null)
{
    if($location!=null){
        header('Location: '.$location);
        exit;
    }
}

function password_generate($chars) 
{
  $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
  return substr(str_shuffle($data), 0, $chars);
  exit;
}
  
