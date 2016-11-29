<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller {

	public function __construct(){
            parent::__construct();
            $this->load->model('winnowingmodel');
            $this->load->helper('upload','form','url','date');
            $this->load->library('session','form_validation');
			
        }

	public function index()	{
		$this->session->unset_userdata('user');
		$data=array('title'=>'Preprocessing',
					'subtitle'=>'Upload file untuk Preprocess',
					'isi'=>'home/upload_view'
					);
		$this->load->view('layout/wrapper',$data);
	}

	public function status(){
		$this->session->unset_userdata('hash');
		$this->session->unset_userdata('fingerprint');
		$this->session->unset_userdata('kgram');
		$this->session->unset_userdata('wgram');

		$data=array('title'=>'File Status',
					'subtitle'=>'Halaman status dokumen anda',
					'isi'=>'home/status_view',
					'user'=>$this->session->userdata('user'),
					);
		
		$this->load->view('layout/wrapper',$data);
	}

	
	public function result()	{
		$data=array('title'=>'File Status',
					'subtitle'=>'Halaman status dokumen anda',
					'isi'=>'home/result_view',
					'user'=>$this->session->userdata('user'),
					'hash'=>$this->session->userdata('hash'),					
					'kgram'=>$this->session->userdata('kgram'),
					'wgram'=>$this->session->userdata('wgram'),	
					'fingerprint'=>$this->session->userdata('fingerprint'),		
					'time'=>$this->session->userdata('time'),		
					'table'=>$this->winnowingmodel->showdata()
					);
		
		$this->load->view('layout/wrapper',$data);
	}

	public function similarity()	{
		
		$start = microtime(true);
		function jaccardCoeffient($text1,$text2){
			$intersect=0;
			foreach ($text1 as $r) {
							# code...
					if(in_array($r, $text2)){
						$intersect++;
					}
				}			
					$a=count($text1);
					$b=count($text2);
					$union = $a+$b-$intersect;

					$result=$intersect/$union*100;
					return round($result,2);
		}

		$selected=$this->input->post('selected');
		$data2 = $this->winnowingmodel->getselect($selected);
		$judul2=$data2->judul;
		$hash2 =$this->winnowingmodel->rollingHash($this->session->userdata('kgram'), $data2->text);
		$fingerprint2 = $this->winnowingmodel->winnowingFingerprint($this->session->userdata('wgram'), array('hash' => $hash2));
		$text1=array(
			'judul'=>$this->session->userdata('user')['judul'],
			'fingerprint' =>$this->session->userdata('fingerprint')
			);
		$text2=array(
			'judul'=>$judul2,
			'fingerprint' =>$fingerprint2
			);
		$similarity=jaccardCoeffient($text1['fingerprint'], $text2['fingerprint']);
		$time_elapsed_secs = microtime(true) - $start;
		$time_elapsed_secs = round($time_elapsed_secs,2);
		$data=array('title'=>'Hasil Similarity',
					'subtitle'=>'Silakan check persentase kesamaan file anda',
					'isi'=>'home/similarity_view',
					'text1'=>$text1,
					'text2'=>$text2,
					'similarity'=>$similarity,
					'time'=>$time_elapsed_secs,
					);		
		$this->load->view('layout/wrapper',$data);
	}

	public function simpandata(){
		$this->winnowingmodel->uploadData($this->session->userdata('user'));
	}

	public function runWinnowing(){
		$start = microtime(true);
		ini_set('max_execution_time', 300);
		$this->form_validation->set_rules('kgram','Kgram','required');
		$this->form_validation->set_rules('wgram','Wgram','required');

		if($this->form_validation->run()==FALSE){
			$this->session->set_flashdata('Message','Nilai Kgram dan Wgram belum diisi!');
			redirect('upload/status');
		}
		else{
			
			$text=$this->input->post('cleantext');
			$kgram=$this->input->post('kgram');
			$wgram=$this->input->post('wgram');
			$hash = $this->winnowingmodel->rollingHash($kgram, $text);
			$this->session->set_userdata('hash',$hash);
			$fingerprint= $this->winnowingmodel->winnowingFingerprint($wgram, array('hash' => $hash));
			$time_elapsed_secs = microtime(true) - $start;
			$time_elapsed_secs = round($time_elapsed_secs,2);
			$this->session->set_userdata('time',$time_elapsed_secs);
			$this->session->set_userdata('fingerprint',$fingerprint);
			$this->session->set_userdata('kgram',$kgram);
			$this->session->set_userdata('wgram',$wgram);
			//$this->session->set_userdata('fingerprint',$data);

			redirect('upload/result');

			
			
		}
	}

	public function uploadValidation(){
		$this->form_validation->set_rules('judulskripsi','JudulSkripsi','required');
		$this->form_validation->set_rules('namauploader','NamaUploader','required');
		$judul=$this->input->post('namauploader');
		$database=$this->winnowingmodel->showdata();
		foreach ($database as $r) {
			
			if ($judul==$r->judul) {
				$this->session->set_flashdata('Message','Judul Sudah Ada D Database!');
				redirect('upload');
			}
		}

		if(!isset($_FILES['fileToUpload']))
		{
			$this->session->set_flashdata('Message','Judul Belum Terisi Atau File Belum Diupload Silahkan Lakukan Check Ulang!');
			redirect('upload');
		}

		if($this->form_validation->run()==FALSE)
		{
			$this->session->set_flashdata('Message','Judul Belum Terisi Atau File Belum Diupload Silahkan Lakukan Check Ulang!');
			redirect('upload');
		}
		else
		{
			
			$parser = new \Smalot\PdfParser\Parser();
			
			
					if(isset($_FILES['fileToUpload']))
					{
					$pdf = $parser->parseFile($_FILES['fileToUpload']['tmp_name']);
					$text = $pdf->getText();
					$data['nama']=strtolower($this->input->post('namauploader'));
					$data['judul']=strtolower($this->input->post('judulskripsi'));
					$data['text']=$text;
					$data['date_upload']= date("Y-m-d");
					$data = $this->winnowingmodel->filterText($data);
					$this->session->set_userdata('user',$data);
					redirect('upload/status');
					//$this->winnowingmodel->uploadData($data);
					}
		
		}

	}

}
