<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('phpmailer');

    }

    public function index()
    {
        $this->load->view('home');
    }

    public function thanks()
    {
        $this->load->view('thanks');
    }
   
}
