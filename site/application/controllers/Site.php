<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {

	public function index()
	{
		$this->load->view('site/welcome');
		$this->load->helper('url');
    }

	public function login(){
        $this->load->helper('url');
        $this->load->view('site/loginpage');
    }

    public function dashboard(){
        $this->load->helper('url');
        $this->load->view('site/dashboard');
    }

}
