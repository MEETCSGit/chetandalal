<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
require_once APPPATH."/third_party/Lavacharts/src/Lavacharts.php"; 
require_once APPPATH."/third_party/Lavacharts/src/Carbon/Carbon.php"; 
 
class LavachartsLib extends Lavacharts { 
    public function __construct() { 
        parent::__construct(); 
    } 
}