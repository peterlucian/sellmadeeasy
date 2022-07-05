<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class category_model extends CI_Model {

function __construct()
{
    parent::__construct();
}



function _insert($data) 
{
    $this->db->insert('category', $data);
}

function _search() 
{
    $query = $this->db->get('category');
    return $query;
}

function _delete($id)
{
    $this->db->where('id', $id);
    $this->db->delete('category');
}

function _parent_cat()
{
    $this->db->where('parent_cat_id', 0);
    $query = $this->db->get('category');
    return $query;
    
}

function _parent_cat_title($id)
{
    $this->db->select('name');
    $this->db->where('id', $id);
    $query = $this->db->get('category');
    return $query;
    
}

}