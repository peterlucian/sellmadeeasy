<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class items extends MX_Controller {

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


	public function display() {
		$id=$this->uri->segment(3);
		

		$this->load->model('items_model');
		$data['itemsbycat'] = $this->items_model->_searchbycat($id);

	 	


		$data['module']='items';
		$data['view_file']='items_view_bycat';

		$this->load->module('home');
		$this->home->index($data);
	}

	public function display_item() {
		$id=$this->uri->segment(3);
		$user_id = $this->session->userdata("id");

		$this->load->model('items_model');
		$data['itemsbyid'] = $this->items_model->_search_by_id($id);
		
		$result = $this->items_model->_search_history($id, $user_id);
		
			 
		if($result->num_rows() < 1){
			if (isset($user_id)){
				$datahistory['item_id'] = $id;
				$datahistory['user_id'] = $user_id;
				$datahistory['date'] = date('y-m-d');

				$this->items_model->_delete_history();
				$this->items_model->_history_insert($datahistory);
			} 
		}
				
		$data['module']='items';
		$data['view_file']='item_view';

		$this->load->module('home');
		$this->home->index($data);
	}

	public function items_form($data = null  )
	{
		$this->load->module('users');
		$this->users->_make_sure_loggged_in();


		$this->load->model('category/category_model');
		$data['categorias']=$this->category_model->_search();

		$this->load->model('items/items_model');
		$data['items']=$this->items_model->_search();

		$data['module']='items';
		$data['view_file']='items_view';

		$this->load->module('home');
		$this->home->index($data);
	}

	function _generate_thumbnail($file_name){

		$config['image_library'] = 'gd2';
		$config['source_image'] = './uploads/'.$file_name;
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['width']         = 200;
		$config['height']       = 200;

		$this->load->library('image_lib', $config);

		$this->image_lib->resize();

	}

	public function add_item()
	{	

		$config['upload_path']          = './uploads/';
		$config['allowed_types']        = 'gif|jpg|png';
		$config['max_size']             = 350;
		$config['max_width']            = 1024;
		$config['max_height']           = 768;

		$this->load->library('upload', $config);

		if ( !$this->upload->do_upload('userfile'))
		{
				$data['error'] = array('error' => $this->upload->display_errors("<p style='color: red;'>", "</p>"));
				
				$this->items_form($data);
		}
		else
		{
				
				$data = array('upload_data' => $this->upload->data());

				$upload_data = $data['upload_data'];
				$file_name = $upload_data['file_name'];
				$this->_generate_thumbnail($file_name);

				$pieces=explode(".", $file_name);


				$info['file_name'] = $pieces[0] . "_thumb." . $pieces[1];
				$info['categorie_id'] = $this->input->post('categorie_id', TRUE);
				$info['content'] = $this->input->post('tiny', TRUE);
				$info['title'] = $this->input->post('title', TRUE);
				$info['price'] = $this->input->post('price', TRUE);
				$info['qty'] = $this->input->post('qty', TRUE);
				$info['user_id'] = $this->session->userdata('id'); 

				$this->load->model('items_model');
				$this->items_model->_insert($info);
	
				$data['message'] = "Inserido com sucesso!";

				$this->items_form($data);
		
		}

	}

	public function delete_items()
	{
		$id=$this->uri->segment(3);  
		
		$this->load->model('items_model');
		$result=$this->items_model->_search_in_history($id);
		$check=$this->items_model->_delete_from_history($id);
		if($check == true || $result->num_rows() < 1){
			$this->items_model->_delete($id);
		} 

		$this->items_form();

	}
}
