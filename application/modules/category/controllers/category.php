<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class category extends MX_Controller {

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

	function _get_cat_title($id)
	{
		$this->load->model('category_model');
		$query=$this->category_model->_parent_cat_title($id);
		foreach($query->result() as $row){
			$data['name']=$row->name;
		}
		return $data['name'];
	} 

	public function category_form()
	{
		$this->load->module('users');
		$this->users->_make_sure_loggged_in();
		
		$this->load->model('category_model');
		$data['categorias']=$this->category_model->_search();
		$data['parent_cat']=$this->category_model->_parent_cat();

		$data['module']='category';
		$data['view_file']='crud_category';

		$this->load->module('home');
		$this->home->index($data);
	}


	public function delete_category()
	{
		$id=$this->uri->segment(3);  
		
		$this->load->model('category_model');
		$this->category_model->_delete($id);

		$this->category_form();

	}

	public function add_category()
	{
		 
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nome', 'Nome', 'required');

		if ($this->form_validation->run() == FALSE) {

			$this->category_form();

		} else {

			$data['name']=$this->input->post('nome', TRUE);
			$data['parent_cat_id']=$this->input->post('parent_id', TRUE);

			$this->load->model('category_model');
			$this->category_model->_insert($data);

			$this->category_form();		
			
		}


	}
}
