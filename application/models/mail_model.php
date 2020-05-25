<?php
class mail_model extends CI_Model{
	
	public function __construct(){
		$this->load->database();
	}

	public function getMail($id){
		$this->db->where('id',$id);
		$result = $this->db->get('mail');
		return $result->row_array();
	}

	public function addMail($data){
		$this->db->insert('mail',$data);
		return $this->db->insert_id();
	}

	public function editMail($id,$data){
		$this->db->where('id',$id);
		$this->db->update('mail',$data);
		return $this->db->affected_rows();
	}

	public function getUnsentMail(){
		$this->db->where('status','WAITING');
		$result = $this->db->get('mail');
		return $result->result_array();
	}
	
	public function setMailError($id){
		$this->db->where('externalId',$id);
		$this->db->set('STATUS','ERROR');
		$this->db->update('mail');
		return $this->db->affected_rows();
	}

	public function getUndeliverables($apiId){
		$this->db->where('apiId',$apiId);
		$this->db->where('status','ERROR');
		$result = $this->db->get('mail');
		return $result->result_array();
	}

	public function getOpened($apiId){
		$this->db->where('apiId',$apiId);
		$this->db->where('status','OPENED');
		$result = $this->db->get('mail');
		return $result->result_array();
	}

	public function saveOpenedTime($id,$date){
		$this->db->where('trackerId',$id);
		$data = array(
			'status' => 'OPENED',
			'openDate' => $date
		);
		$this->db->update('mail',$data);
	}
	
}
