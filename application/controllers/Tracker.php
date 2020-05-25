<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tracker extends CI_Controller {


	public function __construct(){
		parent::__construct();
		$this->load->model('mail_model');
	}

	public function index($id){
		header('Content-Type: image/gif');
		readfile(base_url('tracking.gif'));
		$date = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
		$this->mail_model->saveOpenedTime($id,$date);
	}

	
}
