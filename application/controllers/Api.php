<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Aws\Ses\SesClient;
use Aws\Exception\AwsException;

class Api extends CI_Controller {

	private $keyData = array();

	public function __construct(){
		parent::__construct();
		$this->verifyKey();
		$this->load->model('mail_model');
	}

	public function index(){

		$mailData = array(
			'apiId' => $this->keyData['id'],
			'date' => date('Y-m-d H:i:s',time()),
			'sendTo' => $this->input->post('sendTo'),
			'replyTo' => !empty($this->input->post('replyTo')) ? $this->input->post('replyTo') : 'no-reply@winlas.se',
			'sendFrom' => !empty($this->input->post('from')) ? $this->input->post('from') : 'no-reply@winlas.se',
			'subject' => $this->input->post('subject'),
			'ip' => $_SERVER['REMOTE_ADDR']
		);


		if($this->input->post('action') == 'report'){
			$this->saveReport($mailData);
			return;
		}
		if(!empty($this->input->post('template'))){
			$data = array(
				'title' => $this->input->post('subject'),
				'bodyText' => $this->input->post('body'),
				'customerName' => $this->keyData['name'],
			);
			$html = $this->load->view('templates/empty_mail',$data,TRUE);
		}
		else{
			$html = $this->input->post('body');
		}
		$trackerId = hash('sha256',random_bytes(16));
		$tracker = "<img src='".base_url('tracker/').$trackerId."'>";
		$mailData['trackerId'] = $trackerId;
		$mailData['body'] = $html . $tracker;
		$logo = base_url().$this->keyData['logoUrl'];
		$mailData['status'] = 'WAITING';
		$id = $this->mail_model->addMail($mailData);
		$returnData = array(
			'status' => 'success',
			'id' => $id,
			'status' => 'WAITING'
		);
		echo json_encode($returnData);
	}

	public function send(){
		$mails = $this->mail_model->getUnsentMail();
		$char_set = 'UTF-8';
		if(empty($mails)){
			return;
		}
		$SesClient = new SesClient([
			'version' => '2010-12-01',
			'region'  => 'eu-west-1',
			'credentials' => SES_CREDENTIALS,
			'http'    => [
				'verify' => false
			]
		]);
		foreach ($mails as $key => $mail) {
			try{

				$result = $SesClient->sendEmail([
					'Destination' => [
						'ToAddresses' => [$mail['sendTo']],
					],
					'ReplyToAddresses' => [$mail['replyTo']],
					'Source' => $mail['sendFrom'],
					'Message' => [
						'Body' => [
							'Html' => [
								'Charset' => $char_set,
								'Data' => $mail['body'],
							],
						],
						'Subject' => [
							'Charset' => $char_set,
							'Data' => $mail['subject'],
						],
					],
				]);
				$messageId = $result['MessageId'];
				$mailData['externalId'] = $messageId;
				$mailData['status'] = 'SENT';
				$id = $this->mail_model->editMail($mail['id'],$mailData);
			}catch(AwsException $e){
				echo $e->getMessage();
				echo("The email was not sent. Error message: ".$e->getAwsErrorMessage()."\n");
				echo "\n";
			}catch(Exception $e){
				echo $e->getMessage();
			}
		}
	}

	public function mail($id = FALSE){
		if($id){
			$mail = $this->mail_model->getMail($id);
		}
		else{
			$mail = $this->mail_model->getAllMail();
		}
		
		echo json_encode($mail);
	}

	public function tracker(){
		header('Content-Type: image/gif');
		readfile(base_url('tracking.gif'));
		$id = $this->input->get('id');
		$date = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
		$this->mail_model->saveOpenedTime($id,$date);
	}

	private function saveReport($mailData){
		$mailData['status'] = 'REPORT';
		$id = $this->mail_model->addMail($mailData);
		$returnData = array(
			'status' => 'success',
			'id' => $id,
			'status' => 'REPORT'
		);
		echo json_encode($returnData);
	}

	public function poll(){
		$data['undelivered'] = $this->mail_model->getUndeliverables($this->keyData['id']);
		$data['opened'] = $this->mail_model->getOpened($this->keyData['id']);
		echo json_encode($data);
	}


	public function uploadLogo(){
		try{
			$new_img = imagecreatetruecolor(250, 100);
			list($width, $height) = getimagesize($_FILES['profile-img']['tmp_name']);
			$image = imagecreatefromstring(file_get_contents($_FILES['profile-img']['tmp_name']));
			imagecopyresampled($new_img, $image, 0, 0, 0, 0, 250, 100, $width, $height);
			$filename = md5(time().$_FILES['profile-img']['name']).".jpg";
			$serverpath =  "static/" . $filename;
			$localpath = FCPATH . $serverpath;
			imagejpeg($new_img, $localpath, 100);
			$data = array('id'=>$this->keyData['id'],'logoUrl' => $serverpath);
			var_dump($this->keyData);
			$this->updateLogoServer($data);
		}
		catch(exception $e){
			$json['errors'] .= '<p>Din bild kunde ej laddas upp.</p>';
		}

	}

	private function updateLogoServer($data){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,WLOFFICE_PATH."api/updateApiLogo");
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_CAINFO, getcwd(). "\assets\cert\cacert.pem");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$server_output = curl_exec ($ch);
		$info = curl_getinfo($ch);
		echo ($server_output);
		curl_close($ch);
	}

	public function updateMail(){
		ini_set('display_errors', 1);
		$json = file_get_contents('php://input');
		$data = json_decode($json,true);
		$this->mail_model->setMailError($data['id']);
	}
	
	private function verifyKey(){
		if(empty($_SERVER['PHP_AUTH_USER'])){
			header('HTTP/1.0 403 Forbidden');
			exit();
		}
		$key = $_SERVER['PHP_AUTH_USER'];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,WLOFFICE_PATH."api/verifyApiKey");
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_CAINFO, getcwd(). "\assets\cert\cacert.pem");
		curl_setopt($ch, CURLOPT_POST, 1);
		$data = array('key'=>$key);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$server_output = curl_exec ($ch);
		$info = curl_getinfo($ch);
		$replyData = json_decode($server_output,TRUE);
		if($replyData['status'] == 'success'){
			$this->keyData = $replyData['keyData'];
			return;
		}
		else if(!empty($replyData)){
			echo json_encode($replyData);
		}
		else{
			$json['status'] = 'failure';
			$json['error'] = "No reply from master-API";
			echo json_encode($json);
		}
		curl_close($ch);
		die();
	}


}
