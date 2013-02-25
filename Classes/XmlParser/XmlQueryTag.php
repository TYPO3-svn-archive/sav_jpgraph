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
 * Class query
 *
 * This class is used to define <query> </query> in xml code
 *
 */
class Tx_SavJpgraph_XmlParser_XmlQueryTag extends Tx_SavJpgraph_XmlParser_AbstractXmlTag {

	/**
	 * Default method
	 *
	 * @param none
	 *
	 * @return none
	 */
  protected function defaultMethod() {
    $this->select();
    $this->from();
    $this->where();
    $this->groupby();
    $this->orderby();
    $this->limit();
  }   	

	/**
	 * Sets the query manager
	 *    .
	 * @param $querySelect string
	 *
	 * @return none
	 */
  public function setQueryManager($type, $uid) {

		// Builds an array of markers to be passed to the query manager
		$markers = array();
		$arguments = func_get_args();
		for ($i=2; $i < func_num_args(); $i++) {
			if (preg_match('/^marker#(\w*)$/', $arguments[$i], $match)) {
				$markers[$match[1]] = $this->reference->processReference($arguments[$i]);
			} elseif (preg_match('/^(\w+)#(.*)$/', $arguments[$i], $match)) {			
				$markers[$match[1]] = $match[2];
			}
		}
	
    $this->reference->setReferenceArray(
      'queryManager',
      $this->referenceId,
      array('name' => $type, 'uid' => $uid, 'markers' => $markers)
    );
  }
  
	/**
	 * Sets the SELECT part of the query
	 *    .
	 * @param $querySelect string
	 *
	 * @return none
	 */
  public function select($querySelect = '') {
    $this->reference->setReferenceArray(
      'querySelect',
      $this->referenceId,
      $querySelect
    );
  }
  
	/**
	 * Sets the FROM part of the query
	 *    .
	 * @param $queryFrom string
	 *
	 * @return none
	 */
  public function from($queryFrom = '') {
    $this->reference->setReferenceArray(
      'queryFrom',
      $this->referenceId,
      $queryFrom
    );
  }
  
	/**
	 * Sets the WHERE part of the query
	 *    .
	 * @param $queryWhere string
	 *
	 * @return none
	 */
  public function where($queryWhere = '') {
    $this->reference->setReferenceArray(
      'queryWhere',
      $this->referenceId,
      $this->replaceTags($queryWhere)
    );
  }

	/**
	 * Sets the GROUP BY part of the query
	 *    .
	 * @param $queryGroupby string
	 *
	 * @return none
	 */
  public function groupby($queryGroupby = '') {
    $this->reference->setReferenceArray(
      'queryGroupby',
      $this->referenceId,
      $queryGroupby
    );
  }

	/**
	 * Sets the ORDER BY part of the query
	 *    .
	 * @param $queryOrderby string
	 *
	 * @return none
	 */
  public function orderby($queryOrderby = '') {
    $this->reference->setReferenceArray(
      'queryOrderby',
      $this->referenceId,
      $queryOrderby
    );
  }

	/**
	 * Sets the LIMIT part of the query
	 *    .
	 * @param $queryLimit string
	 *
	 * @return none
	 */
  public function limit($queryLimit = '') {
    $this->reference->setReferenceArray(
      'queryLimit',
      $this->referenceId,
      $queryLimit
    );
  }

	/**
	 * Replaces tags in a string
	 *    .
	 * @param $string string
	 *
	 * @return string
	 */
  private function replaceTags($string = '') {

    $out = $string;
    
    preg_match_all('/###([A-Za-z]+)#([0-9A-Za-z_]*)###/', $out, $matches);
    foreach($matches[0] as $key => $match) {
      $out = str_replace(
        $matches[0][$key],
        $this->reference->getReferenceArray($matches[1][$key], $matches[2][$key]),
        $out
      );
    }
    
    return $out;
  }

}

?>
