<?php

/**
* 
 * PHPRender fast and simple to use PHP MVC framework
 *
 * MVC Framework for PHP 5.2 + with PHP files views part of YMVC System
 * SystemException Class work exception inside YMVC
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Library
 * @package    SystemException
 * @author     ydk2 <me@ydk2.tk>
 * @copyright  1997-2016 ydk2.tk
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    2.0.1
 * @link       http://ymvc.ydk2.tk
 * @since      File available since Release 1.0.0
 
 */
namespace Library;

class SystemException extends \Exception {
	
	public function Code() {
		return $this->getCode();
	}
		
	public function Message() {
		return $this->getMessage();
	}

  public function ErrorMessage() {
    //error message
    $errorMsg = 'Error on line '.$this->getLine().' in '.$this->getFile()
    .': <b>'.$this->getMessage().'</b> :'.$this->getCode();
    return $errorMsg;
  }
}
?>