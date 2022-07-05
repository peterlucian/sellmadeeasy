<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class users extends MX_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */


	public function get_user_ip()
	{
		// Get real visitor IP behind CloudFlare network
		if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
				  $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
				  $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
		}
		$client  = @$_SERVER['HTTP_CLIENT_IP'];
		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		$remote  = $_SERVER['REMOTE_ADDR'];
	
		if(filter_var($client, FILTER_VALIDATE_IP))
		{
			$ip = $client;
		}
		elseif(filter_var($forward, FILTER_VALIDATE_IP))
		{
			$ip = $forward;
		}
		else
		{
			$ip = $remote;
		}
	
		return $ip;
	}

	public function login_form()
	{
		$data=$this->get_data_from_post();
		$data['module']='users';
		$data['view_file']='login_users';

		$this->load->module('home');
		$this->home->index($data);
	}

	public function sign_form()
	{
		$data=$this->get_data_from_post();
		$data['module']='users';
		$data['view_file']='sign_users';

		$this->load->module('home');
		$this->home->index($data);
	}

	function _make_sure_loggged_in(){
		$user_mail = $this->session->userdata('email');
		if($user_mail == " " || $user_mail == null){
			redirect('users/login_form');
		}
	}

	function get_data_from_post()
	{
		$data['nome']=$this->input->post('nome', TRUE);
		$data['apelido']=$this->input->post('apelido', TRUE);
		$data['email']=$this->input->post('email', TRUE);
		$data['password']=$this->input->post('password', TRUE);
		return $data;
	}

	private function hash_password($password){
		return password_hash($password, PASSWORD_BCRYPT);
	 }

	public function sign()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nome', 'Nome', 'required');
		$this->form_validation->set_rules('apelido', 'Apelido', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == FALSE) {
				$this->sign_form();
		} else {
			$data=$this->get_data_from_post();

			$data['password']=$this->hash_password($data['password']);
			$data['ip'] = $this->get_user_ip();
			
			$this->load->model('users_model');
			$this->users_model->_insert($data);

			$this->session->set_flashdata('mensagem', '<h5 style="text-align: center; color: red;"> Registado com sucesso </h5>');
			
			$this->sign_form();			
				
		}
	}

	public function login()
	{
		$data['email']=$this->input->post('email', TRUE);
		$data['password']=$this->input->post('password', TRUE);

		$this->load->model('users_model');
		$result=$this->users_model->_search($data['email']);
		
		 
		if($result->num_rows() === 1){
			$user = $result->row_array();
			if(password_verify($data['password'], $user['password'])){

				$ip = $this->get_user_ip();
				$id = $user['id'];

				if($user['ip'] != $ip){
					$this->users_model->_update_ip($id, $ip);
				}
				
				unset($user['password']);

				$this->session->set_userdata('email', $data['email']);
				$this->session->set_userdata('id', $user['id']);

				$this->load->module('home');
				$this->home->index();
			} 
			else {
				$this->session->set_flashdata('mensagem', '<h5 style="text-align: center; color: red;" > Password errada </h5>');
				$this->login_form();
			}
		} 
		else {
			$this->session->set_flashdata('mensagem', '<h5 style="text-align: center; color: red;" > Email não registado </h5>');
			$this->login_form();
		}
	}


	public function destroy_session(){
		session_destroy();
		$this->session->unset_userdata('email');
		$this->login_form();
	}
}
