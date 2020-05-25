<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perf extends CI_Controller {

	private $baseUrl;

	public function __construct(){
		parent::__construct();
		$this->baseUrl = 'https://testapi.winlas.se/email/perf/';
		$this->load->model('mail_model');
		set_time_limit(0);
	}

	public function testPost(){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$this->baseUrl);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_CAINFO, getcwd(). "/cacert.pem");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_USERPWD, "NGRmYjY2NDJlNGJlM2VhMjY5NTliNjkzZmM5NjIz");
		$email = array(
			'sendTo' => "test@winlas.se",
			'subject' => "Test",
			'body' => "Body"
		);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $email);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$elapsed = [];
		for($i = 0;$i <= 10000;$i++){
			$start = microtime(TRUE);
			curl_exec ($ch);
			$execTime = microtime(TRUE) - $start;
			array_push($elapsed,number_format($execTime,4)*100);
		}
		file_put_contents('testPost.txt', '');
		foreach ($elapsed as $time) {
			file_put_contents("testPost.txt", $time.PHP_EOL, FILE_APPEND);
		}
		

	}

	public function testPut(){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$this->baseUrl.'updateMail');
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_CAINFO, getcwd(). "/cacert.pem");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_USERPWD, "NGRmYjY2NDJlNGJlM2VhMjY5NTliNjkzZmM5NjIz");
		$data = array(
			'id' => 123
		);
		curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
		$elapsed = [];
		for($i = 0;$i <= 10000;$i++){
			$start = microtime(TRUE);
			curl_exec ($ch);
			$execTime = microtime(TRUE) - $start;
			array_push($elapsed,number_format($execTime,4)*100);
		}
		file_put_contents('testPut.txt', '');
		foreach ($elapsed as $time) {
			file_put_contents("testPut.txt", $time.PHP_EOL, FILE_APPEND);
		}
	}

	public function testGet(){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$this->baseUrl.'api/mail/1');
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_CAINFO, getcwd(). "/cacert.pem");
		curl_setopt($ch, CURLOPT_USERPWD, "NGRmYjY2NDJlNGJlM2VhMjY5NTliNjkzZmM5NjIz");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$elapsed = [];
		for($i = 0;$i <= 10000;$i++){
			$start = microtime(TRUE);
			curl_exec ($ch);
			$execTime = microtime(TRUE) - $start;
			array_push($elapsed,number_format($execTime,4)*100);
		}
		file_put_contents('testGet.txt', '');
		foreach ($elapsed as $time) {
			file_put_contents("testGet.txt", $time.PHP_EOL, FILE_APPEND);
		}
	}



}
