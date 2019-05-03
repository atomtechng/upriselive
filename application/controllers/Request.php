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
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $phonenumber = $this->input->post('phonenumber');
        $link = $this->input->post('link');

        $data = array("name" => $name,
            "email" => $email,
            "phonenumber" => $phonenumber,
            "link" => $link,
            "date_registered" => date("Y-m-d H:i:s"));

        $this->request_model->create($data);

        $Subject ="Welcome to Upriselive!!!";
        $alt_body ="You are about to experince a breakthrough in your career";
        $message= "You are about to experince a breakthrough in your career";
        $this->mail($email, "Upriselive", $name, $message, $Subject, $alt_body);

        redirect('thanks');
    }

    public function delete($id=-1)
    {
        
        $request_method = $this->input->server('REQUEST_METHOD');
        $result = array();
        if($request_method == "delete")
        {
            
            if ($id != -1) {
                
                if ($this->request_model->delete($id) == true) {
                    $result["status"] ="success";
                    $result["message"] = "Data with id ". $id. " is deleted";
                } else {
                    $result["status"] ="fail";
                    $result["message"] = "Data with id ". $id. " couldn't be deleted";
                }
                $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
            }
            else{
                $result["status"] ="fail";
                $result["message"] = "No id specified";
                $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
            }
        }
        else{
            $result["status"] ="fail";
            $result["message"] = "unauthorized Access";
            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array("status" => "unauthorized")));
        }

    }

    private function mail($email, $from_name, $to_name, $message, $Subject, $alt_body)
    {
        $mail = $this->phpmailer->load();

        //$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
                $mail->SMTPDebug = 0;                                 // Enable verbose debug output
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'smtp.zoho.com';  					  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = 'tosin@fungifting.com';                 // SMTP username
                $mail->Password = 'Amudafala$9876';                    // SMTP password
                $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 465;                                    // TCP port to connect to

                //Recipients
            $mail->setFrom('hello@fungifting.com', $from_name);
            $mail->addAddress($email, $to_name);     // Add a recipient
            $mail->addReplyTo('hello@fungifting.com', $from_name);

         
            //Content
                $mail->isHTML(true); // Set email format to HTML
                $mail->Subject = $Subject;
            $mail->Body = $message;
            $mail->AltBody = $alt_body;
            $mail->send();
        } catch (Exception $e) {
            ;
        }
    }
}
