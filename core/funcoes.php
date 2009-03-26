<?php
/* 
 * Copyright (c) 2008, Carlos André Ferrari <[carlos@]ferrari.eti.br>; Luan Almeida <[luan@]luan.eti.br>
 * All rights reserved. 
 */

/**
* Framework functions
* @package Framework
*/

/**
* auto load classes
* @param	$class	classname
* @return	void
*/
function __autoload($class)
{
	if (class_exists($class, false) || interface_exists($class, false)) {
        return;   
    }
    
    $folders = array(
	    "core/classes/",
	    "core/classes/exceptions",
	    "app/classes/",
	    "app/model/",
	    "app/controller/",
		"app/helper/",
		"core/helper/"
    );
    
	if (defined("module")){
		$m = module;
		$folders[] = "app/modules/$m/model/";
		$folders[] = "app/modules/$m/controller/";
	}

	foreach ($folders as $f)
		if (file_exists(rootfisico . "{$f}/{$class}.php")) { require_once(rootfisico . "{$f}/{$class}.php"); return; }
    
 	//throw (new Exception("Class not found: $class"));
}

/**
* Check if the request is from a mobile phone
* @return	boolean
*/
function is_mobile(){
	$op = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE']) ? $_SERVER['HTTP_X_OPERAMINI_PHONE'] : '');
	$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
	$ac = strtolower($_SERVER['HTTP_ACCEPT']);
	return strpos($ac, 'application/vnd.wap.xhtml+xml') !== false
		|| $op != ''
		|| strpos($ua, 'iphone') !== false
		|| strpos($ua, 'android') !== false
		|| strpos($ua, 'symbian') !== false 
		|| strpos($ua, 'htc') !== false
		|| strpos($ua, 'blackberry') !== false
		|| strpos($ua, 'sprint') !== false    
		|| strpos($ua, 'nokia') !== false 
		|| strpos($ua, 'sony') !== false 
		|| strpos($ua, 'wap') !== false
		|| strpos($ua, 'samsung') !== false 
		|| strpos($ua, 'mobile') !== false
		|| strpos($ua, 'windows ce') !== false
		|| strpos($ua, 'epoc') !== false
		|| strpos($ua, 'opera mini') !== false
		|| strpos($ua, 'nitro') !== false
		|| strpos($ua, 'j2me') !== false
		|| strpos($ua, 'midp-') !== false
		|| strpos($ua, 'cldc-') !== false
		|| strpos($ua, 'netfront') !== false
		|| strpos($ua, 'mot') !== false
		|| strpos($ua, 'up.browser') !== false
		|| strpos($ua, 'up.link') !== false
		|| strpos($ua, 'audiovox') !== false
		|| strpos($ua, 'ericsson') !== false
		|| strpos($ua, 'panasonic') !== false
		|| strpos($ua, 'philips') !== false
		|| strpos($ua, 'sanyo') !== false
		|| strpos($ua, 'sharp') !== false
		|| strpos($ua, 'sie-') !== false
		|| strpos($ua, 'portalmmm') !== false
		|| strpos($ua, 'blazer') !== false
		|| strpos($ua, 'avantgo') !== false
		|| strpos($ua, 'danger') !== false
		|| strpos($ua, 'palm') !== false
		|| strpos($ua, 'series60') !== false
		|| strpos($ua, 'palmsource') !== false
		|| strpos($ua, 'pocketpc') !== false
		|| strpos($ua, 'smartphone') !== false
		|| strpos($ua, 'rover') !== false
		|| strpos($ua, 'ipaq') !== false
		|| strpos($ua, 'au-mic,') !== false
		|| strpos($ua, 'alcatel') !== false
		|| strpos($ua, 'ericy') !== false
		|| strpos($ua, 'up.link') !== false
		|| strpos($ua, 'vodafone/') !== false;
}

/**
* Check if is a Search Engine bot request
* @return	boolean
*/
function is_bot(){
	$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
	$ip = $_SERVER['REMOTE_ADDR'];
	return $ip == '66.249.65.39' 
		|| strpos($ua, 'googlebot') !== false 
		|| strpos($ua, 'mediapartners') !== false 
		|| strpos($ua, 'yahooysmcm') !== false 
		|| strpos($ua, 'baiduspider') !== false
		|| strpos($ua, 'msnbot') !== false
		|| strpos($ua, 'slurp') !== false
		|| strpos($ua, 'ask') !== false
		|| strpos($ua, 'teoma') !== false
		|| strpos($ua, 'spider') !== false 
		|| strpos($ua, 'heritrix') !== false 
		|| strpos($ua, 'attentio') !== false 
		|| strpos($ua, 'twiceler') !== false 
		|| strpos($ua, 'irlbot') !== false 
		|| strpos($ua, 'fast crawler') !== false                        
		|| strpos($ua, 'fastmobilecrawl') !== false 
		|| strpos($ua, 'jumpbot') !== false
		|| strpos($ua, 'googlebot-mobile') !== false
		|| strpos($ua, 'yahooseeker') !== false
		|| strpos($ua, 'motionbot') !== false
		|| strpos($ua, 'mediobot') !== false
		|| strpos($ua, 'chtml generic') !== false;
}

/**
* get a posted value
* @param	$v	variable name
* @return	string
*/
function p($v){
	global $_POST, $_PAR;
	return isset($_POST[$v]) ? $_POST[$v] : (isset($_PAR[$v]) ? $_PAR[$v] : '');
}

/**
* Redirect the response
* @param	$destino	Destination url encoded with Link class
* @param	$delay		Delay
* @return	void
*/
function redirect($destino="", $delay=0){
	//if (!ereg("^/", $destino) && !ereg("^http://", $destino)) $destino = "/$destino";
	if (ajax){
		$json = Json::getInstance();
		$json->addPacote(array("redirect", $destino, $delay));
		die($json->render());
	}else
		die ("<html><head><meta http-equiv=\"refresh\" content=\"$delay;URL=$destino\"></head><body></body></html>");
}

/**
* Reset a vector keys
* @param	$arr		Array
* @return	array
*/
function reset_keys(&$arr){
	$new = array();
	foreach ($arr as $i) $new[] = $i;
	$arr = $new;
	return $arr;
}

/**
* Convert sala-de-imprensa to SalaDeImprensa
* @param	$str		string
* @return	string
*/
function camelize($str="") {
    return str_replace(" ", "", ucwords(str_replace(array("_", "-"), " ", $str)));
}

/**
* Convert the first char to lower case
* @param	$str		string
* @return	string
*/
if (!function_exists("lcfirst")){
	function lcfirst($str="") {
		if ($str=='') return '';
		$str{0} = strtolower($str{0});
    	return $str;
	}
}

/**
* Translate a phrase using I18n class
* @param	mixed
* @return	string
*/
function e(){
	return I18n::e(func_get_args());
}
