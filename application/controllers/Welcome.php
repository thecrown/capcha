<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('image_lib');
		$this->load->helper('captcha');
	}
	public function index()
	{
		$data =  array(
			'img_path'=>'./assets/captcha/',
			'img_url'=>'http://localhost/codeigniter2/capchahelper/assets/captcha/',
			'img_width'=> '150',
			'img_height'=>'30'
		);
		$captcha = create_captcha($data);
		
		$data = array(
        'captcha_time'  => $captcha['time'],
        'ip_address'    => $this->input->ip_address(),
        'word'          => $captcha['word']
		);

		$query = $this->db->insert_string('captcha', $data);
		$this->db->query($query);


		echo 'Submit the word you see below:';
		echo $captcha['image'];
		echo form_open('welcome/submit/');
		echo '<input type="text" name="captcha" value="" />';
		echo '<input type="button" name="captcha" value="submit captcha" />';
		echo form_close();
		// $this->load->view('welcome_message',$captcha);
		$ip = $data['ip_address'];
		$time = $data['captcha_time'];	
	}
	public function submit(){
		$expiration = time() - 7200; // Two hour limit
		$this->db->where('captcha_time < ', $expiration)
				->delete('captcha');

		// Then see if a captcha exists:
		$word = $this->input->post('captcha');

		$sql = 'SELECT COUNT(*) AS count FROM captcha WHERE word = '$word' AND ip_address = '$data['ip_address']' AND captcha_time > '$data['captcha_time']';
		$binds = array($_POST['captcha'], $this->input->ip_address(), $expiration);
		$query = $this->db->query($sql, $binds);
		$row = $query->row();

		if ($row->count == 0)
		{
				echo 'You must submit the word that appears in the image.';
		}
	}
}
