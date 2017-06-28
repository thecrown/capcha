<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Login extends CI_Controller
{
  private function _create_captcha()
  {
    // we will first load the helper. We will not be using autoload because we only need it here
    $this->load->helper('captcha');
    // we will set all the variables needed to create the captcha image
    $options = array(
        'img_path'=>FCPATH.'./assets/captcha/',
        'img_url'=>site_url().'/assets/captcha/',
        'img_width'=>200,
        'img_height'=>100,
        'expiration'=>7200,
        'word_length'   => 3
        );
    //now we will create the captcha by using the helper function create_captcha()
    $cap = create_captcha($options);
    // we will store the image html code in a variable
    $image = $cap['image'];
    $word = $cap['word'];
    // ...and store the captcha word in a session
    $this->session->set_userdata('captchaword', $cap['word']);
    // we will return the image html code
    $data = array(
        'word'=>$word,
        'image'=>$image
    );
    return $data;
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
 
  public function index()
  {
    //whenever someone gets to the login page we will create a captcha and render the login form
    $data['image']=$this->_create_captcha();
    $data['word']=$image;
    $this->load->view('login_view',$data);
  }
  // we will also create a method to verify the data that the user has entered
 
  public function verify()
  {
    //we will check the form completion and verify the credentials such as the username, email or password. I will jump over that part and concentrate on the captcha part...
    $this->form_validation->set_rules( 'captcha', 'captcha', 'trim|callback_check_captcha|required' );
    //as you can see, I used the check_captcha callback to verify if the characters the user entered are the same as the ones that can be found inside the captcha image
    if($this->form_validation->run()===false) /* if the form validation failed */
    {
      echo "gagal";
    }
    else
    {
      echo "berhasil";
    }
  }
}