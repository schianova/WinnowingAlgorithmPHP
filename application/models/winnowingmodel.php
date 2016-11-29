<?php
	class Winnowingmodel extends CI_Model{

		public function __construct(){
			parent::__construct();
			$this->load->database();
			$this->load->helper('upload','form','url');

		}

        public function getselect($selected){
            
            $query = $this->db->query("SELECT `nama`, `judul`, `text`, `date_upload` FROM `filebank` WHERE `id` = ?", array($selected));
            
            
            return $query->row();
        }

        public function showdata(){

            $this->db->select('id,nama,judul,date_upload');
            $this->db->from('filebank');
            $query = $this->db->get();
            $this->db->last_query();
            return $result = $query->result();
        }

		public function filterText($data){
			$judul = $data['judul'];
			$text = $data['text'];
            $text = strtolower($text);
			$ban = array(
				"bab i","pendahuluan","latar belakang masalah","rumusan masalah",
				"batasan masalah","tujuan penelitian","manfaat penelitian","bab ii",
                "tinjauan pustaka dan landasan teori","bab iii","metode penelitian",
                "instrumen penelitian","prosedur pengambilan data","pengumpulan data",
				"teknik analisis data","model/metode yang diusulkan","eksperimen dan
                 cara pengujian",   "daftar pustaka");

			$text = str_ireplace($ban, "", $text, $count);
			$text = preg_replace("/[^A-Za-z]/", '', $text);
            $data['judul'] = $judul;
			$data['text'] = $text;
			return $data;
		}

		public function uploadData($data){
			
			return $this->db->insert('filebank', $data);
		}

		

		public function rollingHash($kgram, $text){
			$text = $text;
        	$hash_value = 0;
        	$prev_hash = 0;
        	$basis = 7;
        	$ascii = 0;
        	$c_awal;
        	$c_akhir;
     	    $prime = 100007;

        	for($j=0; $j <= (strlen($text)-$kgram); $j++){
        		$charArray[$j] = substr($text, $j, $kgram);
        	}
        	
        	for($i = 0; $i < $kgram; $i++){
        		$ascii = ord($charArray[$i][$i]);
        		$hash_value = $hash_value + $ascii * pow($basis, $kgram - $i+1);                
        	}

 			$hash_value = $hash_value % $prime;
            $hash[0] = $hash_value;
            $prev_hash = $hash_value;

           for($k = 1; $k < count($charArray);$k++){
                
                $c_awal = substr($charArray[$k-1], 1);
                $c_awal = ord($c_awal);
                $c_akhir = substr($charArray[$k], -1);
                    $hash_value = (($prev_hash + $prime) - pow($basis, $kgram - $k)
                             * $c_awal % $prime) % $prime;     
                $hash_value = ($hash_value * $basis + ord($c_akhir)) % $prime;
                $prev_hash = $hash_value;           
                $hash[$k] = $hash_value;
            }  
        	return $hash;
  		}

        public function winnowingFingerprint($wgram, $data){
            $hash = $data['hash'];
            $fingerprint=array();
            $low;

            for($k = 0; $k <= count($hash)-$wgram; $k++){
                $j = $k;
                for($l=0; $l <$wgram;$l++){
                    $winnow[$k][$l] = $hash[$j];
                    $j++;
                }  
            }

            $keys=array();
            for($m = 0; $m <count($winnow); $m++){
                    $low = min($winnow[$m]);
                    
                    if(in_array($low, $hash)){
                        $key = array_search($low, $hash);
                        if(!in_array($key, $keys)){
                            $fingerprint[$m] = $low;
                            $keys[$m] = $key;
                        }
                    }                   
                }
                return $fingerprint;            
        }
	}
?>