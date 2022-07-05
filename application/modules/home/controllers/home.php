<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class home extends MX_Controller {

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
	public function index($data = null)
	{
		

		$this->load->model('category/category_model');
		$data['categorias']=$this->category_model->_search();
		//$data['parent_cat']=$this->category_model->_parent_cat();
		
		if(!isset($data['module']) && !isset($data['view_file'])){
			
			$user_id = $this->session->userdata("id");
			
			if(!isset($user_id)){
				
				$this->load->module('users');;
				$ip= $this->users->get_user_ip();
				
			}

			$data['module']='items';
			$data['view_file']='items_view_bycat';

			$this->load->model('items/items_model');
			$data['itemsbycat'] = $this->items_model->_history_search_all($user_id, @$ip);

		}
		
		

		$this->load->view('home', $data);
	}
}
