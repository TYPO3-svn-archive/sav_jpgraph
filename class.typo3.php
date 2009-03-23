<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Yolf (Laurent Foulloy) <yolf.typo3@orange.fr>
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
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */



/**
 * Class data
 *
 * This class is used to defined <data> </data> in xml code
 *
 */
class typo3 {
  
  private $referenceId = 0;
  private $reference = NULL;

	/**
	 * Set Reference to the calling object
	 *
	 * @param $referenceId string Identifier for the object
	 * @param $reference Object Reference to the calling object
	 *
	 * @return none
	 */
  public function setReference($referenceId, &$reference) {
    $this->referenceId = $referenceId;
    $this->reference = &$reference;
  }
  

	/**
	 * Process query
	 *
	 * @param $id string Identifier for the query
	 *
	 * @return none
	 */
  public function processQuery($id) {

    // Execute the query
    $rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
      $this->reference->getReferenceArray('querySelect', $id),
      $this->reference->getReferenceArray('queryFrom', $id),
      $this->reference->getReferenceArray('queryWhere', $id),
      $this->reference->getReferenceArray('queryGroupby', $id),
      $this->reference->getReferenceArray('queryOrderby', $id),
      $this->reference->getReferenceArray('queryLimit', $id)
    );

    // Check for errors
    if (!is_array($rows)) {
      $lastBuiltQuery = $GLOBALS['TYPO3_DB']->debug_lastBuiltQuery;
			$lastBuiltQuery = str_replace(chr(9), '', $lastBuiltQuery);
			$lastBuiltQuery = str_replace('  ', '', $lastBuiltQuery);
      JpGraphError::Raise(
        'SQL error: ' . $GLOBALS['TYPO3_DB']->sql_error() . chr(10) .
        'In query: '. $lastBuiltQuery
      );
    } else {
      $this->reference->setReferenceArray('query', $id, $rows);

      // Process variable definitions and replace them in the markers
      if (is_array($rows[0])) {
        foreach($rows[0] as $key => $row) {
          if (preg_match('/^\$.*$/', $key, $match )) {
            $this->reference->replaceVariableInReferenceArray(
              'marker',
              $match[0],
              $row
            );
          }
        }
      }

      // Unset the query definition
      $this->reference->unsetReferenceArray('querySelect', $id);
      $this->reference->unsetReferenceArray('queryFrom', $id);
      $this->reference->unsetReferenceArray('queryWhere', $id);
      $this->reference->unsetReferenceArray('queryGroupby', $id);
      $this->reference->unsetReferenceArray('queryOrderby', $id);
      $this->reference->unsetReferenceArray('queryLimit', $id);
    }
  }

	/**
	 * Process queries
	 *
	 * @return none
	 */
  public function processQueries() {
  
    $querySelect = $this->reference->getReferenceArray('querySelect');
    if (is_array($querySelect)) {
      foreach($this->reference->getReferenceArray('querySelect') as $id => $value) {
        $this->processQuery($id);
      }
    }
  }

  
}


?>
