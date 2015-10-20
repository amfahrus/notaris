<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SessionModel extends CI_Model {

	public function remove_sess(){
			$sess = array(
							'SESS_PENJUAL_ID' => '',
							'SESS_PENJUAL_NAME' => '',
							'SESS_PEMBELI_ID' => '',
							'SESS_PEMBELI_NAME' => '',
							'SESS_PEMOHON_ID' => '',
							'SESS_PEMOHON_NAME' => '',
							'SESS_TANAH_ID' => '',
							'SESS_TANAH_NAME' => ''
						);
			
			return $this->session->unset_userdata($sess);
		}

}

/* End of file SessionModel.php */
/* Location: ./application/models/SessionModel.php */