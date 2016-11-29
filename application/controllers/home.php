<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index(){
		$data=array('title'=>'Winnowing Algorithm', 
					'subtitle'=>'Algorithm Which Run Plagiarism Detection Machine',
					'isi' =>'home/index_home'
					);
					
		$this->load->view('layout/wrapper',$data);
	}
}
