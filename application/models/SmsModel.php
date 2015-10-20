<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SmsModel extends CI_Model {


	public function kirim_pesan($data)
	{
		$data = array_merge(array('SenderID' => NULL, 'CreatorID' => '', 'validity' => '-1'), $data);

		if ($data['dest'] != NULL && $data['date'] != NULL && $data['message'] != NULL) {
			switch ($data['coding']) {
				case 'default':
					$standar_length = 160;
					$data['coding'] = 'Default_No_Compression';
					break;
				
				case 'unicode':
					$standar_length = 70;
					$data['coding'] = 'Unicode_No_Compression';
					break;

			}

			$message_length = $this->message_length($data['message'], $data['coding']);

			if ($message_length > $standar_length) {
				$UDH_length = 7;
				$multipart_length = $standar_length + $UDH_length;

				/* GENERATE UDH */
				$UDH = "050003";
				$hex = dechex(mt_rand(0,255));
				$hex = str_pad($hex, 2, "0", STR_PAD_LEFT);
				$UDH .= strtoupper($hex);
				$data['UDH'] = $UDH;
				$tmpmsg = $this->message_multipart($data['message'], $data['coding'], $multipart_length);

				/* HITUNG POTONGAN PESAN */
				$part = count($tmpmsg);
				if ($part < 10) {
					$part = '0'.$part;
				}
				$data['option'] = 'multipart';
				$data['message'] = $tmpmsg[0];
				$data['part'] = $part;
				$outboxid = $this->kirim($data);

				for ($i=1; $i < count($tmpmsg); $i++) { 
					$this->kirim_multipart($outboxid, $tmpmsg[$i], $i, $part, $data['coding'], $data['class'], $UDH);
				}
			}else{
				$data['option'] = 'single';
				$this->kirim($data);
			}
		}else{
			echo 'Parameter Invalid';
		}
	}

	public function kirim($tmp_data)
	{
		$otherdb = $this->load->database('otherdb', TRUE);

		$tmp_data['dest'] = str_replace(" ", "", $tmp_data['dest']);
		$tmp_data['dest'] = str_replace("-", "", $tmp_data['dest']);

		$data = array('InsertIntoDB' => gmdate('Y-m-d H:i:s', time()+60*60*7),
		 				'SendingDateTime' => $tmp_data['date'],
		 				'DestinationNumber' => $tmp_data['dest'],
		 				'Coding' => $tmp_data['coding'],
		 				'Class' => $tmp_data['class'],
		 				'CreatorID' => $tmp_data['CreatorID'],
		 				'SenderID' => $tmp_data['SenderID'],
		 				'TextDecoded' => $tmp_data['message'],
		 				'RelativeValidity' => $tmp_data['validity'],
		 				'DeliveryReport' => $tmp_data['delivery_report']);
		if ($tmp_data['option'] == 'multipart') {
			$data['MultiPart'] = 'true';
			$data['UDH'] = $tmp_data['UDH'].$tmp_data['part'].'01';
		}

		$otherdb->insert('outbox', $data);

		$last_outbox_id = $otherdb->insert_id();
		return $last_outbox_id;
	}

	public function kirim_multipart($outboxid, $message, $pos, $part, $coding, $class, $UDH)
	{
		$code = $post+1;
		if ($code < 10) {
			$code = '0'.$code;
		}

		$data = array('ID' => $outboxid,
		 				'UDH' => $UDH.$part.''.$code,
		 				'SequencePosition' => $pos+1,
		 				'Coding' => $coding,
		 				'Class' => $class,
		 				'TextDecoded' => $message);
		$otherdb->insert('outbox_multipart', $data);
	}

	public function message_length($message=NULL, $coding=NULL)
	{
		$msg_length = 0;
		if ($coding == "Default_No_Compression") {
			$msg_char = $this->split_string($message);
			foreach ($msg_char as $char) {
				if ($this->special_char($char)) {
					$msg_length +=2;
				}else{
					$msg_length +=1;
				}
			}
			return $msg_length;
		}else{
			return mb_strlen($message);
		}
	}

	public function message_multipart($message=NULL, $coding=NULL, $multipart_length=NULL)
	{
		if ($coding== "Default_No_Compression") {
			$char = $this->split_string($message);
			$string = "";
			$left = 153;
			$char_taken = 0;
			$msg = array();

			while (list($key, $val) = each($char)) {
				if ($left > 0) {
					if ($this->special_char($val)) {
						if ($left > 1) {
							$string .= $val;
							$left -= 2;
						}else{
							$left = 0;
							prev($char);
							$char_taken--;
						}
					}else{
						$string .= $val;
						$left -= 1;
					}
				}
				$char_taken++;

				if ($left==0 || $char_taken == mb_strlen($message)) {
					$msg[] = $string;
					$string = "";
					$left = 153;
				}
			}
		}else{
			$msg = $this->split_string($message, $multipart_length);
		}
		return $msg;
	}

	public function special_char($char)
	{
		$special_char = array('^','{','}','[',']','~','|','\\');

		$default = array(
						'☺','☻','♥','♦','♣','♠','•','◘','○','◙',
						'♂','♀','♪','♫','☼','►','◄','↕','‼','¶',
						'§','▬','↨','↑','↓','→','←','∟','↔','▲',
						'▼',' ','!','"','#','$','%','&','(',')',
						'*','+',',','-','.','/','0','1','2','3',
						'4','5','6','7','8','9',':',';','<','=',
						'>','?','@','A','B','C','D','E','F','G',
						'H','I','J','K','L','M','N','O','P','Q',
						'R','S','T','U','V','W','X','Y','Z','[',
						'\'',']','^','_','`','a','b','c','d','e',
						'f','g','h','i','j','k','l','m','n','o',
						'p','q','r','s','t','u','v','w','x','y',
						'z','{','|','}','~','⌂','Ç','ü','é','â',
						'ä','à','å','ç','ê','ë','è','ï','î','ì',
						'Ä','Å','É','æ','Æ','ô','ö','ò','û','ù');

		if (in_array($char, $special_char)) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function split_string($string, $length=1)
	{
		$len = mb_strlen($string);
		$result = array();
		for ($i=0; $i < $len; $i+=$length) { 
			$char = mb_substr($string, $i, $length);
			array_push($result, $char);
		}
		return $result;
	}

}

/* End of file SmsModel.php */
/* Location: ./application/models/SmsModel.php */
