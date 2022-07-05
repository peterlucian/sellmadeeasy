<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class cart_model extends CI_Model {

function __construct()
{
    parent::__construct();
}



function _insert($data) 
{
    $this->db->insert('cart', $data);
}

function _get_cart_by_user($id)
{
    $this->db->where('user_id', $id);
    $query = $this->db->get('cart');
    return $query;
    
}


function _delete($id)
{
    $this->db->where('id', $id);
    $query = $this->db->delete('cart');
    return $query;
}

function _delete_by_user($user_id)
{
    $this->db->where('user_id', $user_id);
    $query = $this->db->delete('cart');
    return $query;
}


function _update($id, $qty){

    $this->db->set('qty', $qty);
    $this->db->where('id', $id);
    $query = $this->db->update('cart');
    return $query;
}


}