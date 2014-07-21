<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Laurent Foulloy <yolf.typo3@orange.fr>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * Class callback
 *
 * This class is used to define <callback> </callback> in xml code
 *
 */
class Tx_SavJpgraph_XmlParser_XmlCallbackTag extends Tx_SavJpgraph_XmlParser_AbstractXmlTag {
	
  private $functionName = 'callback';
  private $className;
  private $counter = 0;
  
	/**
	 * Construtor
	 *
	 * @param string $functionName The function name
	 * @param string $className The class name
	 *
	 * @return none
	 */
  public function __construct($functionName = NULL, $className = NULL) {
  	if ($functionName !== NULL) {
    	$this->functionName = $functionName;
  	}
  	if ($className !== NULL) {
  		$this->className = $className;
  	} else {
  		$this->className = $this;
  	}
  }

	/**
	 * Default method
	 *
	 * @param none
	 *
	 * @return none
	 */
  public function defaultMethod() {
    $this->setCallback($this->functionName, $this->className);	
  }    


	/**
	 * Sets the callback function
	 *
	 * @param string $functionName The function name
	 * @param string $className The class name
	 *
	 * @return none
	 */
  public function setCallback($functionName, $className) {

    $this->reference->setReferenceArray(
      'callback',
      $this->referenceId,
      array($className, $functionName)
    );
  }

	/**
	 * Sets the return data for the callback function
	 *
	 * @param mixed $data The data
	 *
	 * @return none
	 */
  public function setReturn($data = NULL) {
		$callbackReturn = $this->reference->getReferenceArray(
      'callbackReturn',
      $this->referenceId
    );

    $this->reference->setReferenceArray(
      'callbackReturn',
      $this->referenceId,
      array_merge((array) $callbackReturn, array($data))
    );

  }  
  
	/**
	 * Defines the callback function
	 *
	 * @param integer $yvalue
	 * @param integer $xvalue
	 * 
	 * @return array
	 */  
  public function callback($yvalue, $xvalue) {
		$callbackReturn = $this->reference->getReferenceArray(
      'callbackReturn',
      $this->referenceId
    );
		$returnArray = array();
    foreach($callbackReturn as $argument) {
    	if ($argument === NULL) {
    		$returnArray[] = '';
    	} else {
    		$returnArray[] = $argument[$this->counter];
    	}
    }

  	$this->counter++;
  	
  	return $returnArray;
  }  
  
}

?>
