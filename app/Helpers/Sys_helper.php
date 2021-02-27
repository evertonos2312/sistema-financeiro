<?php
/* ALL FUNCTIONS WITH NO CLASS GOES HERE */
if(!isset($GLOBALS['AppVersion'])){
	$GLOBALS['AppVersion'] = new \Config\Version();
	ini_set('default_charset', 'UTF-8');
}
if(!function_exists('GetCacheVersion')){
	function GetCacheVersion(){
		global $AppVersion;
		return ($AppVersion->enc_md5) ? md5($AppVersion->version) : $AppVersion->version;
	}
}
if(!function_exists('rdct')){
	function rdct($to){
		header('Location: '.$to);
		exit;
	}
}

if(!function_exists('scan_dir')){
	function scan_dir($path){
		$scan = scandir($path);
		$key_1 = array_search('.', $scan);
		$key_2 = array_search('..', $scan);
		unset($scan[$key_1]);
		unset($scan[$key_2]);
		return $scan;
	}
}
if(!function_exists('Mask')){
	function Mask($mask,$str)
	{

		$str = str_replace(" ","",$str);

		for($i=0;$i<strlen($str);$i++){
			$mask[strpos($mask,"#")] = $str[$i];
		}

		return $mask;

	}
	function MaskCPF($str)
	{
		return Mask('###.###.###-##', $str);
	}
}

if(!function_exists('round_up')){
	function round_up($number, $precision = 2)
	{
		$fig = (int) str_pad('1', $precision, '0');
		return (ceil($number * $fig) / $fig);
	}
	function round_down($number, $precision = 2)
	{
		$fig = (int) str_pad('1', $precision, '0');
		return (floor($number * $fig) / $fig);
	}
}
if(!function_exists('create_guid')){
	function create_guid(){
		$microTime = microtime();
		list($a_dec, $a_sec) = explode(' ', $microTime);
		$dec_hex = dechex($a_dec * 1000000);
		$sec_hex = dechex($a_sec);
		ensure_length($dec_hex, 5);
		ensure_length($sec_hex, 6);
		$guid = '';
		$guid .= $dec_hex;
		$guid .= create_guid_section(3);
		$guid .= '-';
		$guid .= create_guid_section(4);
		$guid .= '-';
		$guid .= create_guid_section(4);
		$guid .= '-';
		$guid .= create_guid_section(4);
		$guid .= '-';
		$guid .= $sec_hex;
		$guid .= create_guid_section(6);
		return $guid;
	}
	function create_guid_section($characters){
		$return = '';
		for ($i = 0; $i < $characters; ++$i) {
			$return .= dechex(mt_rand(0, 15));
		}
		return $return;
	}
	function ensure_length(&$string, $length){
		$strlen = strlen($string);
		if ($strlen < $length) {
			$string = str_pad($string, $length, '0');
		} elseif ($strlen > $length) {
			$string = substr($string, 0, $length);
		}
	}
	function microtime_diff($a, $b){
		list($a_dec, $a_sec) = explode(' ', $a);
		list($b_dec, $b_sec) = explode(' ', $b);
		return $b_sec - $a_sec + $b_dec - $a_dec;
	}
}

if(!function_exists('create_slug')){
	function create_slug($text)
	{
		// iconv_set_encoding("internal_encoding", "UTF-8");
		// replace non letter or digits by -
		$text = preg_replace('~[^\pL\d]+~u', '-', $text);

		// transliterate
		$text = removeAcentos($text);
		// remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);
		// trim
		$text = trim($text, '-');
	
		// remove duplicate -
		$text = preg_replace('~-+~', '-', $text);
	
		// lowercase
		$text = strtolower($text);
	
		if (empty($text)) {
		return 'n-a';
		}
	
		return $text;
	}
}


if(!function_exists('validaCPF')){
	function validaCPF($cpf = null) {

		// Verifica se um número foi informado
		if(empty($cpf)) {
			return false;
		}

		// Elimina possivel mascara
		$cpf = preg_replace("/[^0-9]/", "", $cpf);
		$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
		
		// Verifica se o numero de digitos informados é igual a 11 
		if (strlen($cpf) != 11) {
			return false;
		}
		// Verifica se nenhuma das sequências invalidas abaixo 
		// foi digitada. Caso afirmativo, retorna falso
		else if ($cpf == '00000000000' || 
			$cpf == '11111111111' || 
			$cpf == '22222222222' || 
			$cpf == '33333333333' || 
			$cpf == '44444444444' || 
			$cpf == '55555555555' || 
			$cpf == '66666666666' || 
			$cpf == '77777777777' || 
			$cpf == '88888888888' || 
			$cpf == '99999999999') {
			return false;
		 // Calcula os digitos verificadores para verificar se o
		 // CPF é válido
		 } else {   
			
			for ($t = 9; $t < 11; $t++) {
				
				for ($d = 0, $c = 0; $c < $t; $c++) {
					$d += $cpf{$c} * (($t + 1) - $c);
				}
				$d = ((10 * $d) % 11) % 10;
				if ($cpf{$c} != $d) {
					return false;
				}
			}

			return true;
		}
	}
}
if(!function_exists('convertSize')){
  function convertSize($size){
	$base = log($size) / log(1024);
	$suffix = array("", " KB", " MB", " GB", " TB");
	$f_base = floor($base);
	$math = round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
	
	$result = str_replace('.', ',', $math);
	return $result;
  }
}
if(!function_exists('removeAcentos')){
	function removeAcentos($string){
		return preg_replace(array("/ç|Ç/","/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","c a A e E i I o O u U n N"),$string);
	}
}
if(!function_exists('fatiarString')){
	function fatiarString($string, $int, $capitalize = false){
		$result = implode(' ', array_slice(explode(' ', $string), 0, $int));
		$result = removeAcentos($result);
		$result = str_replace(':','', $result);
		if(!$capitalize){
			$result = str_replace(' ', '_', $result);
			$result = strtoupper($result);
		}
		$result = ucfirst($result);
		return $result;
	}
	if(!function_exists('fatiarData')){
		function fatiarData($string, $inicio, $fim){
			$result = implode(' ', array_slice(explode(' ', $string), $inicio, $fim));
			return $result;
		}
	}

}
?>