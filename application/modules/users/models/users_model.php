<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class users_model extends CI_Model {

function __construct()
{
    parent::__construct();
}



function _insert($data) 
{
    $this->db->insert('users', $data);
}

function _search($data) 
{
    $this->db->where('email', $data); 
    $query = $this->db->get('users');
    return $query;
}

function _update_ip($id, $ip){

    $this->db->set('ip', $ip);
    $this->db->where('id', $id);
    $query = $this->db->update('users');
    return $query;
}

}
