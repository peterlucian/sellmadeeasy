<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cart extends MX_Controller {

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


	public function delete_from_cart()
	{
		
		$id=$this->input->post('id', TRUE);

		$this->load->model('cart_model');
		$query=$this->cart_model->_delete($id);

		if ($query){
			echo "successs";
		}else{
			echo "fail";
		}
	}


	public function search_qty()
	{
		$item_id=$this->input->post('item_id', TRUE);

		$this->load->model('items/items_model');
		$query=$this->items_model->_search_qty($item_id);	

		$result= $query->result();

		
		echo json_encode($result);

		
	}

	public function get_cart()
	{
		$id=$this->input->post('user_id', TRUE);

		$this->load->model('cart_model');
		$query=$this->cart_model->_get_cart_by_user($id);	

		$result= $query->result();

		
		echo json_encode($result);

		
	}

	function update_qty(){

		$id=$this->input->post('id', TRUE);
		$qty=$this->input->post('qty', TRUE);

		$this->load->model('cart_model');
		$query=$this->cart_model->_update($id, $qty);
		
		if ($query){
			echo "qty update made";
		}else{
			echo "error";
		}

	}

	function _make_sure_loggged_in(){
		$user_mail = $this->session->userdata('email');
		if($user_mail == " " || $user_mail == null){
			return false;
		}else{
			return true;
		}
	}

	public function add_cart(){

		if ($this->_make_sure_loggged_in()){

			$data['title']=$this->input->post('title', TRUE);
			$data['price']=$this->input->post('price', TRUE);
			$data['image']=$this->input->post('image', TRUE);
			$data['user_id']=$this->input->post('user_id', TRUE);
			$data['item_id']=$this->input->post('item_id', TRUE);
			$data['qty']="1";
	
			$this->load->model('cart_model');
			$this->cart_model->_insert($data);

			echo "Item adcionado.";

		}else{

			echo "Make sure you are logged.";

		}		
	}


}
