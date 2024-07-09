<?php 
class model_users extends CI_Model{
	public function can_log_in(){
		$this->db->where('email',$this->input->post('email'));
		$this->db->where('email',md5($this->input->post('password')));
		$query=$this->db->get('club');
		$result = $query->result();
		return $result;
		/*if($query->num_rows()==1){
			return true;
		}else{
			return false;
		}*/
	} 
	
	public function login($data) {
		$condition = "email_verified='Verified' AND email =" . "'" . $data['email'] . "' AND " . "password =" . "'" . base64_encode($data['password']) . "'";
		$this->db->select('*');
		$this->db->from('club');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return($query->num_rows() > 0) ? $query->result(): NULL;
		} else {
			return false;
		}
	}
public function login_customer($data) {
		$condition = "email_verified='Verified' AND email =" . "'" . $data['email'] . "' AND " . "password =" . "'" . base64_encode($data['password']) . "'";
		$this->db->select('*');
		$this->db->from('customer');
		$this->db->where($condition);
		$this->db->limit(1);
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return($query->num_rows() > 0) ? $query->result(): NULL;
		} else {
			return false;
		}
	}


	public function checkOldPass($old_password,$id){
		$this->db->select('*');
		$this->db->where('club_id', $id);
		$this->db->where('password', $old_password);
		$query = $this->db->get('club');
		$result = $query->result();
		return $result;
	}
	function show_pass()
	{
		$sql ="select * from club where club_id=1 ";
		$query = $this->db->query($sql);
		return($query->num_rows() > 0) ? $query->result(): NULL;
	}

	function get_settings()
	{
		$sql ="select * from settings where id=1 ";
		$query = $this->db->query($sql);
		return($query->num_rows() > 0) ? $query->result(): NULL;
	}
	public function saveNewPass($new_pass,$id){
		$data = array(
			'password' => $new_pass
		);
		$this->db->where('club_id', $id);
		$this->db->update('club', $data);
		return true;
		print $this->db->last_query();
	}
	
	
}



?>