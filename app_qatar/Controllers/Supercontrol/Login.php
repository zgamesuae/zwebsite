<?php
namespace App\Controllers\Supercontrol;
use App\Controllers\BaseController;
class Login extends \App\Controllers\BaseController{
    	public function logout()
	{
	     $session = session();
				    $session->remove('adminLoggedin');
				    	$this->session->setFlashdata('success', 'You have been successfully logged out.');   
	    	return redirect()->to(site_url('supercontrol/Login'));
	}
	public function index()
	{  
		$data = [];
		helper(['form','url']);
		if ($this->request->getMethod() == "post") {
			$validation =  \Config\Services::validation();
			$rules = [
				"email" => [
					"label" => "Email", 
					"rules" => "required"
				],
				"password" => [
					"label" => "Password", 
					"rules" => "required"
				]
			];
			if ($this->validate($rules)) {
				$email=$this->request->getVar('email');
				$pass=base64_encode($this->request->getVar('password'));
				
				$sql="select * from admin where email='$email' AND password ='$pass' AND status='Active'";
				$res=$this->userModel->customQuery($sql); 
				if($res){ 
				    
				    $session = session();
				    $session->set('adminLoggedin', $res[0]->admin_id);
				//   print_r($session->get('adminLoggedin'));exit;
				    
					return redirect()->to(site_url('supercontrol/Home'));
				}
				else{
					$this->session->setFlashdata('error', 'Invalid Username or Password!!!!');   
				}
			} else {
				$data["validation"] = $validation->getErrors();
			}
		}
		$data['flashData']=$this->session->getFlashdata(); 
		$sql="select * from settings";
		$data['settings']=$this->userModel->customQuery($sql);
		echo view('/Supercontrol/Login',$data);
	}
	public function header()
	{
		return view('/Supercontrol/Common/Header');
	}
	public function footer()
	{
		return view('/Supercontrol/Common/Footer');
	}
	public function validateLogin()
	{
		helper(['form', 'url']);
		$input = $this->validate([
			'username' => 'required|min_length[3]',
			'password' => 'required' 
		]);
		if (!$input) {
			echo view('login', [
				'validation' => $this->validator
			]);
		}
		else {
			$data = array(
				'username' => $this->input->post('username'),
				'password' => $this->input->post('password')
			);
			$result = $this->Model_users->login($data);
			if($result == TRUE) {
				$username = $this->input->post('username');
				if($result != false) {
					$session_data = array(
						'username'=>$this->input->post('username'),
						'is_logged_in'=>1
					);
					$this->session->set_userdata('sys_logged_in', $session_data);
					$this->session->set_userdata('sys_is_logged_in', '1');
					redirect('/supercontrol/Home');
				}
			}else {
				$this->session->setFlashdata('loginerror', 'Invalid Username or Password!!!!');
				redirect('/supercontrol/login');	
			}
		}
	}
}