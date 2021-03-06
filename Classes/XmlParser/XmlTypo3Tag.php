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
 * Class data
 *
 * This class is used to defined <typo3> </typo3> in xml code
 *
 */
class Tx_SavJpgraph_XmlParser_XmlTypo3Tag extends Tx_SavJpgraph_XmlParser_AbstractXmlTag {

	/**
	 * Processes the query
	 *
	 * @param $id string Identifier for the query
	 *
	 * @return none
	 */
  public function processQuery($id) {
  
    // Checks if there is a query manager
    $queryManager = $this->reference->getReferenceArray('queryManager', $id);

    if ($queryManager === NULL) {
      // The default TYPO3 API is used
      $hookObject = &$this;
      $queryManager['uid'] = $id;
    } else {
      // Unsets te configuration manager
      $this->reference->unsetReferenceArray('queryManager', $id);

      // Gets the class from the hook
			$hookFound = false;      
      if (is_array ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sav_jpgraph']['queryManagerClass'])) {
        foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sav_jpgraph']['queryManagerClass'] as $key => $classRef) {
          if ($key == $queryManager['name']) {
            $hookObject = &t3lib_div::getUserObj($classRef);
            $hookFound = true;
          }
        } 
      } 
      
      if ($hookFound === false) {
        JpGraphError::Raise(
          'A query manager must be defined by a hook for ' . $queryManager['name']
        );
      }
    }

    // Executes the query
    if (method_exists($hookObject, 'injectMarkers')) {
      $hookObject->injectMarkers($queryManager['markers']);
    }    
    
    // Executes the query
    if (method_exists($hookObject, 'executeQuery')) {
      $rows = $hookObject->executeQuery($queryManager['uid']);
    }
    
    // Processes the error if any
    if (method_exists($hookObject, 'checkError')) {
    	if($hookObject->checkError($queryManager['uid'])) {
      	if (method_exists($hookObject, 'getErrorMessage')) {
        	$errorMessage = $hookObject->getErrorMessage($queryManager['uid']);
      	} else {
      		$errorMessage = 'Error in query';
      	}
				JpGraphError::Raise($errorMessage);    		
    	}
    }    

    // Sets the result if any
    if (is_array($rows)) {
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
    } 
    
    // Unsets the query definition
    $this->reference->unsetReferenceArray('querySelect', $id);
    $this->reference->unsetReferenceArray('queryFrom', $id);
    $this->reference->unsetReferenceArray('queryWhere', $id);
    $this->reference->unsetReferenceArray('queryGroupby', $id);
    $this->reference->unsetReferenceArray('queryOrderby', $id);
    $this->reference->unsetReferenceArray('queryLimit', $id);
  }

	/**
	 * Processes queries
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

	/**
	 * Executes the query
	 *
	 * @return array The rows
	 */
  private function executeQuery($id) {
    $rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
      $this->reference->getReferenceArray('querySelect', $id),
      $this->reference->getReferenceArray('queryFrom', $id),
      $this->reference->getReferenceArray('queryWhere', $id),
      $this->reference->getReferenceArray('queryGroupby', $id),
      $this->reference->getReferenceArray('queryOrderby', $id),
      $this->reference->getReferenceArray('queryLimit', $id)
    );
    return $rows;
  }

	/**
	 * Checks if there is an error message
	 *
	 * @return boolean
	 */
  private function checkError($id) {
    $error = $GLOBALS['TYPO3_DB']->sql_error();
 	 	return !empty($error);
  }   
  
	/**
	 * Gets the error message if any
	 *
	 * @return string The error message
	 */
  private function getErrorMessage($id) {
    $lastBuiltQuery = $GLOBALS['TYPO3_DB']->debug_lastBuiltQuery;
 	 	$lastBuiltQuery = str_replace(chr(9), '', $lastBuiltQuery);
  	$lastBuiltQuery = str_replace('  ', '', $lastBuiltQuery);
  	
  	$errorMessage = 'SQL error: ' . $GLOBALS['TYPO3_DB']->sql_error() . chr(10) .
      'In query: '. $lastBuiltQuery;

    return $errorMessage;
  }
  
}

?>
