<?php
namespace Home\Controller;
use Think\Controller;
class MailController extends Controller {

    public function __construct()
    {
        parent::__construct();
        if(empty($_SESSION['Home'])){
            A('Login')->login('Index/Index');
            die;
        }
    }

    public function addinfo()
    {
        
    }
}