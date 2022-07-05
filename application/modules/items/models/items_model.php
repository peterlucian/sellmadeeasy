<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class items_model extends CI_Model {

function __construct()
{
    parent::__construct();
}

function _insert($data) 
{
    $this->db->insert('items', $data);
}

function _search() 
{
    $query = $this->db->get('items');
    return $query;
}

function _searchbycat($id) 
{
    $this->db->where('categorie_id', $id);
    $query = $this->db->get('items');
    return $query;
}

function _search_by_id($id) 
{
    $this->db->where('id', $id);
    $query = $this->db->get('items');
    return $query;
}

function _delete($id)
{
    $this->db->where('id', $id);
    $this->db->delete('items');
}

function _update_qty($item_id, $qty)
{
    $this->db->set("qty", "qty-$qty", FALSE);
    $this->db->where('id', $item_id);
    $query = $this->db->update('items');
    return $query;
}

function _search_qty($item_id)
{
    $this->db->select('id, qty');
    $this->db->from('items');
    $this->db->where('id', $item_id);
    
    
    $query = $this->db->get();
    return $query;
    
}

//history table

function _history_insert($data) 
{
    $this->db->insert('history', $data);
}

function _history_search_all($user_id = null, $ip = null){

    $this->db->select('*');
    $this->db->from('items');
    $this->db->join('history', 'items.id = history.item_id');
    $this->db->join('users', 'users.id = history.user_id');
    if($user_id){
        
        $this->db->where('users.id', $user_id);

    }else{

        $this->db->where('users.ip', $ip);
    }

    $query = $this->db->get();

    return $query;
}

function _delete_history(){

    $this->db->query("DELETE FROM history WHERE date < DATE_SUB(NOW() , INTERVAL 15 DAY)");
}

function _search_history($item_id, $user_id) 
{
    $array = array('item_id' => $item_id, 'user_id' => $user_id);
    $this->db->where($array);
    $query = $this->db->get('history');
    return $query;
}
}