<?php
class Util_Ip {


	static function updateIpDB() {

		$db = Zend_Registry::get('db');
		$fecha = $db->fetchOne('SELECT valor FROM config_bolivianbox WHERE config = "fecha_ipDB"');
		if(Util_Date::diff('-', date('Y-m-d'), $fecha) > 30) {

			$d = file_get_contents("http://ipinfodb.com/country_query.php?country=BO");
			if (!$d) {
				$backup = file_get_contents("http://backup.ipinfodb.com/country_query.php?country=BO");
				$answer = explode("\n", $backup);
				if (!$backup) return false;
			}else {
				$answer = explode("\n", $d);
			}

			$db->delete('ipDB');
			foreach($answer as $row)
				$db->insert('ipDB', array('ip' => $row));

			$db->update('config_bolivianbox', array('valor'=>date('Y-m-d')), 'config = "fecha_ipDB"');
		}
		return true;
	}

	static function netMatch ($CIDR,$IP) {
		list ($net, $mask) = explode ('/', $CIDR);
		return ( ip2long ($IP) & ~((1 << (32 - $mask)) - 1) ) == ip2long ($net);
	}

	static function isBO() {

		$db = Zend_Registry::get('db');
		$data = $db->fetchAll('SELECT * FROM ipDB');
		$ip = Util_Ip::obtenerIPreal();
		foreach($data as $row){
			if(Util_Ip::netMatch($row['ip'], $ip))
				return true;
		}
		return false;
	}

	function obtenerIPreal() {

		if( @$_SERVER['HTTP_X_FORWARDED_FOR'] != '' ) {
			$client_ip =
				( !empty($_SERVER['REMOTE_ADDR']) ) ?
				$_SERVER['REMOTE_ADDR']
				:
				( ( !empty($_ENV['REMOTE_ADDR']) ) ?
				$_ENV['REMOTE_ADDR']
				:
				"unknown" );

			// los proxys van añadiendo al final de esta cabecera
			// las direcciones ip que van "ocultando". Para localizar la ip real
			// del usuario se comienza a mirar por el principio hasta encontrar
			// una dirección ip que no sea del rango privado. En caso de no
			// encontrarse ninguna se toma como valor el REMOTE_ADDR

			$entries = split('[, ]', $_SERVER['HTTP_X_FORWARDED_FOR']);

			reset($entries);
			while (list(, $entry) = each($entries)) {
				$entry = trim($entry);
				if ( preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", $entry, $ip_list) ) {
				// http://www.faqs.org/rfcs/rfc1918.html
					$private_ip = array(
						'/^0\./',
						'/^127\.0\.0\.1/',
						'/^192\.168\..*/',
						'/^172\.((1[6-9])|(2[0-9])|(3[0-1]))\..*/',
						'/^10\..*/');

					$found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);

					if ($client_ip != $found_ip) {
						$client_ip = $found_ip;
						break;
					}
				}
			}
		}
		else {
			$client_ip =
				( !empty($_SERVER['REMOTE_ADDR']) ) ?
				$_SERVER['REMOTE_ADDR']
				:
				( ( !empty($_ENV['REMOTE_ADDR']) ) ?
				$_ENV['REMOTE_ADDR']
				:
				"unknown" );
		}

		return $client_ip;

	}
}

/*
 *
	private function onRange($ip, $from, $to) {
		$from = ip2long($from);
		$to = ip2long($to);
		//$ip = ip2long($HTTP_SERVER_VARS["REMOTE_ADDR"]);
		if ($ip > $from && $ip < $to)
			return true;

		return false;
	}

	static function isBO($ip) {

		$range = array(
			array('from'=>'12.144.80.0', 'to'=>'12.144.80.127'),
			array('from'=>'12.144.82.0', 'to'=>'12.144.87.255'),
			array('from'=>'63.65.11.0', 'to'=>'63.65.12.254'),
			array('from'=>'63.68.223.0', 'to'=>'63.68.223.255'),
			array('from'=>'65.173.56.0', 'to'=>'65.173.63.255'),
			array('from'=>'166.114.0.0', 'to'=>'166.114.255.255'),
			array('from'=>'167.157.0.0', 'to'=>'167.157.255.255'),
			array('from'=>'186.2.0.0', 'to'=>'186.2.63.255'),
			array('from'=>'190.11.64.0', 'to'=>'190.11.95.255'),
			array('from'=>'190.103.64.0', 'to'=>'190.103.79.255'),
			array('from'=>'190.104.0.0', 'to'=>'190.104.31.255'),
			array('from'=>'190.107.32.0', 'to'=>'190.107.47.255'),
			array('from'=>'190.129.0.0', 'to'=>'190.129.127.255'),
			array('from'=>'190.181.0.0', 'to'=>'190.181.63.255'),
			array('from'=>'190.186.0.0', 'to'=>'190.186.255.255'),
			array('from'=>'192.245.121.0', 'to'=>'192.245.121.255'),
			array('from'=>'200.7.160.0', 'to'=>'200.7.175.255'),
			array('from'=>'200.9.165.0', 'to'=>'200.9.168.255'),
			array('from'=>'200.13.152.0', 'to'=>'200.13.159.255'),
			array('from'=>'200.35.80.48', 'to'=>'200.35.80.55'),
			array('from'=>'200.58.64.0', 'to'=>'200.58.95.255'),
			array('from'=>'200.58.160.0', 'to'=>'200.58.191.255'),
			array('from'=>'200.61.65.160', 'to'=>'200.61.65.191'),
			array('from'=>'200.61.100.0', 'to'=>'200.61.100.255'),
			array('from'=>'200.61.104.0', 'to'=>'200.61.105.255'),
			array('from'=>'200.61.122.0', 'to'=>'200.61.123.255'),
			array('from'=>'200.71.80.0', 'to'=>'200.71.87.255'),
			array('from'=>'200.73.96.0', 'to'=>'200.73.103.255'),
			array('from'=>'200.75.160.0', 'to'=>'200.75.175.255'),
			array('from'=>'200.81.81.0', 'to'=>'200.81.81.127'),
			array('from'=>'200.81.84.0', 'to'=>'200.81.87.255'),
			array('from'=>'200.81.92.0', 'to'=>'200.81.93.255'),
			array('from'=>'200.85.128.0', 'to'=>'200.85.151.255'),
			array('from'=>'200.87.0.0', 'to'=>'200.87.255.255'),
			array('from'=>'200.90.144.0', 'to'=>'200.90.151.255'),
			array('from'=>'200.105.128.0', 'to'=>'200.105.191.255'),
			array('from'=>'200.105.208.0', 'to'=>'200.105.223.255'),
			array('from'=>'200.107.240.0', 'to'=>'200.107.247.255'),
			array('from'=>'200.112.192.0', 'to'=>'200.112.207.255'),
			array('from'=>'200.119.192.0', 'to'=>'200.119.223.255'),
			array('from'=>'201.222.64.0', 'to'=>'201.222.127.255'),
			array('from'=>'205.241.34.0', 'to'=>'205.241.39.255'),
			array('from'=>'206.73.51.128', 'to'=>'206.73.51.191'),
			array('from'=>'206.107.148.0', 'to'=>'206.107.151.255'),
			array('from'=>'208.1.190.0', 'to'=>'208.1.190.255'),
			array('from'=>'208.52.17.0', 'to'=>'208.52.17.255'),
			array('from'=>'208.52.19.0', 'to'=>'208.52.19.255'),
			array('from'=>'208.52.21.0', 'to'=>'208.52.21.255'),
			array('from'=>'208.52.80.0', 'to'=>'208.52.80.31'),
			array('from'=>'208.52.80.64', 'to'=>'208.52.85.255'),
			array('from'=>'208.52.88.0', 'to'=>'208.52.91.255'),
			array('from'=>'208.72.159.0', 'to'=>'208.72.159.15'),
			array('from'=>'212.63.178.72', 'to'=>'212.63.178.75'),
			array('from'=>'212.63.187.20', 'to'=>'212.63.187.23'),
			array('from'=>'216.118.226.16', 'to'=>'216.118.226.23'),
			array('from'=>'216.118.226.32', 'to'=>'216.118.226.39'),
			array('from'=>'216.118.226.64', 'to'=>'216.118.226.79'),
			array('from'=>'216.118.226.128', 'to'=>'216.118.226.159'),
			array('from'=>'216.184.105.0', 'to'=>'216.184.105.255'),
			array('from'=>'216.184.112.0', 'to'=>'216.184.115.255'),
		);

		foreach($range as $row)
			if($this->onRange($ip, $row['from'],$row['to']))
				return false;

		return true;
	}

		var_dump(Util_Date::diff('-', date('Y-m-d'), $fecha));exit();

 */

