<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Request extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('phpmailer');
        $this->load->model('request_model');
    }

    public function index()
    {
        $this->load->view('home');
    }

    public function delete($id)
    {
        $request_method = $this->input->server('REQUEST_METHOD');
        if($request_method == "delete")
        {
            $result = array();
            if($this->request_model->delete($id) == TRUE)
            {
                $result["status"] ="success";
                $result["message"] = "Data with id ". $id. " is deleted";
            }
            else
            {
                $result["status"] ="fail";
                $result["message"] = "Data with id ". $id. " couldn't be deleted";
            }
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }
        $this->load->view('home');

    }
}
