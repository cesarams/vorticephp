<?php
/* 
 * Copyright (c) 2008, Carlos André Ferrari <[carlos@]ferrari.eti.br>; Luan Almeida <[luan@]luan.eti.br>
 * All rights reserved. 
 */

/**
 * IntegerRequiredException Class, create an error object
 *
 * @version	1
 * @package	Exceptions
 * @author	Carlos André Ferrari <carlos@ferrari.eti.br>
 */
class IntegerRequiredException extends BaseException{
	/**
	* Constructor, create an error object
	*
	* @param	string	$desc	Error description
	* @return	void
	*/
	public function __construct($desc=''){
		header('HTTP/1.1 500 Internal Server Error');
		parent::__construct("A Integer is required", $desc, "500");
	}
}