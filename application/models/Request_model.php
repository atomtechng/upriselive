<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Request_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get()
    {
        $response = array();
        
        // Select record
        $this->db->select('*');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(100); 
        $q = $this->db->get(TABLE_REQUESTS);
        $response = $q->result_array();
        return $response;
    }

  
    public function create($data)
    {
        return $this->db->insert(TABLE_REQUESTS, $data);
    }

    public function delete($id)
    {
        return $this->db->delete(TABLE_REQUESTS, array('id' => $id)); 
    }

    public function update_approval_status($id, $status_id)
    {

        $data = [ 'approval_status' => $status_id];
        $this->db->where('id', $id);
        $this->db->update('requests', $data);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE; 
    }

    public function update_review_status($id, $status_id)
    {
        $data = [ 'review_status' => $status_id];
        $this->db->where('id', $id);
        $this->db->update('requests', $data);
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE; 
    }
}
