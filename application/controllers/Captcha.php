<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Captcha extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('captcha');
        $this->load->library('image_lib');
        $this->load->library('form_validation');
        
    }
public function index(){
    $data = array(
        
        'img_path'=>'./assets/captcha/',
        'img_url'=>'http://localhost/codeigniter2/capchahelper/assets/captcha/',
        'img_width'=>120,
        'img_height'=>70,
        'expiration'=>7200,
        'word_length'=>4,
        'font_size'=>16
    );
    $data_captcha = create_captcha($data);

    $this->session->set_userdata('captchaword', $data_captcha['word']);
    $data= array(
        'image'=> $data_captcha['image'],
        'word'=> $data_captcha['word'],
    );

    $this->load->view('login',$data);

}

  public function check_captcha($string)
  {
    if($string==$this->session->userdata('captchaword'))
    {
        return TRUE;
    }
    else
    {
      $this->form_validation->set_message('check_captcha', 'Wrong captcha code');
      return FALSE;
    }
  }

public function verify(){
    
        $this->form_validation->set_rules('captcha','captcha','trim|required|callback_check_captcha');
        if ($this->form_validation->run() == FALSE)
        {
            echo "gagal";
        }else{
            echo "berhasil";
        }
    }
}