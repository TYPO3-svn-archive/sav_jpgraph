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
 * This class is used to define <data> </data> in xml code
 *
 */
class Tx_SavJpgraph_XmlParser_XmlDataTag extends Tx_SavJpgraph_XmlParser_AbstractXmlTag {
	

  private $data = '';
  private $firstArray = true;
  
	/**
	 * Construtor
	 *
	 * @param $data string
	 *
	 * @return none
	 */
  public function __construct($data = '') {
    $this->data = trim($data);
  }

	/**
	 * Default method
	 *
	 * @param none
	 *
	 * @return none
	 */
  protected function defaultMethod() {
    $this->setData($this->data);  	
  }  
  
	/**
	 * Sets the data.
	 * Data are in a comma-separated string
	 *
	 * @param string $data Comma-separated string
	 *
	 * @return none
	 */
  public function setData($data = '') {
    $this->reference->setReferenceArray(
      'data',
      $this->referenceId,
      explode(',', $data)
    );
  }
  
	/**
	 * Sets the data from a query
	 * Data are in an array
	 *
	 * @param array $rows Array of fields
	 * @param string $field Field from which data are got
	 *
	 * @return none
	 */
  public function setDataFromQuery($rows, $field, $default = '') {
		$configuration = Tx_SavJpgraph_XmlParser_xmlGraph::getConfiguration();
		if (empty($configuration['allowQueries'])) {
			JpGraphError::Raise(
          'Queries must be allowed to use SetDataFromQuery'
        );
		}

		// Initializes data
		$data = array();
		 	
  	// Uses default values if any and rows are empty
  	if (empty($rows) && !empty($default)) {
  		$defaultValues = explode (',', $default);
  		$rows = array();
  		foreach($defaultValues as $value) {
  			$rows[] = array($field => $value);
  		}
  	}
	
		// Gets all data for the field
		$fieldList =  explode(',', $field);

		foreach($rows as $row) {
			if(count($fieldList) == 1) {
				$data[] = $row[$fieldList[0]];
			} else {
				$dataArray =array();
				foreach ($fieldList as $field) {
					$dataArray[] = $row[$field];
				}
				$data[] = array($dataArray);
			}
		}

    // Sets the data in the reference array
    $this->reference->setReferenceArray(
      'data',
      $this->referenceId,
      $data
    );
  }

	/**
	 * Sets the data from a query which have a GROUP BY clause
	 * Data are in an array
	 *
	 * @param array $rows Array of fields
	 * @param string $field Field from which data are got
	 * @param $groupData Data which are possible values for the group
	 * @param string $groupField The field used in the GROUP BY clause
	 * @param string $default The default values as a comma-seprated string
	 *
	 * @return none
	 */
  public function setDataFromQueryWithGroup($rows, $field, $groupData, $groupField, $default = '') {
  	$configuration = Tx_SavJpgraph_XmlParser_xmlGraph::getConfiguration();
		if (empty($configuration['allowQueries'])) {
			JpGraphError::Raise(
          'Queries must be allowed to use setDataFromQueryWithGroup'
        );
		}
  	
		// Initializes data
		$data = array();
		
		// Gets all data for the field
		reset($rows);
		foreach ($groupData as $value) {
			$row = current($rows);
			if ($row[$groupField] == $value) {
				$data[] = $row[$field];
				next($rows);
			} else {
				$data[] = $default;
			}	
		}

    // Sets the data in the reference array
    $this->reference->setReferenceArray(
      'data',
      $this->referenceId,
      $data
    );
  }  
  
	/**
	 * Sets the data from a query row
	 * Data are in an array
	 *
	 * @param array $row Array of fields
	 * @param string $fields Field from which data are got
	 *
	 * @return none
	 */
  public function setDataFromQueryRow($row, $fields, $default = '') {
    $configuration = Tx_SavJpgraph_XmlParser_xmlGraph::getConfiguration();
		if (empty($configuration['allowQueries'])) {
			JpGraphError::Raise(
          'Queries must be allowed to use setDataFromQueryRow'
        );
		}
  	
  	$fieldsArray = explode(',', $fields);
  	  	
    // Uses default values if any and row are empty
  	if (empty($row) && !empty($default)) {
  		$defaultValues = explode (',', $default);
  		$row = array(0 => array());
  		foreach($defaultValues as $valueKey => $value) {
  			$row[0] = array_merge($row[0], array($fieldsArray[$valueKey] => $value));
  		}
  	}
  	  	
		// Gets all data for the field
		foreach($fieldsArray as $field) {
			$data[] = $row[0][$field];
		}

    // Sets the data in the reference array
    $this->reference->setReferenceArray(
      'data',
      $this->referenceId,
      $data
    );
  }  
  
	/**
	 * Sets data from an array of array
	 *
	 * @param array $dataArray Array of array
	 * @param string $index Index from which data are got
	 *
	 * @return none
	 */
  public function setDataFromArray($dataArray, $index) {
 	
    // Sets the data in the reference array
    $this->reference->setReferenceArray(
      'data',
      $this->referenceId,
      $dataArray[$index]
    );
  }

	/**
	 * Inserts an array of data
	 *
	 * @param array $data Array of data
	 * @param string $index Index from which data are got
	 * @param boolean $asArray If true, data are set in an array with the index 0
	 *
	 * @return none
	 */
  public function InsertArray($data) {
    // Clears the element with index 0 at the first call
    if ($this->firstArray) {
      $this->reference->unsetReferenceArray(
        'data',
        $this->referenceId,
        0
      );
      $this->firstArray = false;
    }

    // Sets the data in the reference array
    $this->reference->setReferenceArray(
      'data',
      $this->referenceId,
      array(0 => $data),
      ''  
    );
  }  
  
	/**
	 * Sets an array of data
	 *
	 * @param string $data Comma-separated string
	 * @param string $index Index to set the data
	 * @param boolean $asArray If true, data are set in an array with the index 0
	 *
	 * @return none
	 */
  public function setArray($data = '', $index = '', $asArray = FALSE) {

    // Clears the element with index 0 at the first call
    if ($this->firstArray) {
      $this->reference->unsetReferenceArray(
        'data',
        $this->referenceId,
        0
      );
      $this->firstArray = false;
    }
    
    // Sets the data in the reference array
    $this->reference->setReferenceArray(
      'data',
      $this->referenceId,
      ($asArray ? array(0 => explode(',', $data)) : explode(',', $data)),
      $index
    );
  }
  
	/**
	 * Changes the data to percentage
	 *
	 * @param none
	 *
	 * @return none
	 */
  public function changeToPercentage() {
    $dataArray = $this->reference->getReferenceArray('data', $this->referenceId);
    
    // Computes the sum
    foreach($dataArray as $data) {
      if (is_array($data)) {
        $dataToProcess = $data[0];
      } else {
        $dataToProcess = $data;
      }
      foreach($dataToProcess as $key => $value) {
        if (!isset($sum[$key])) {
          $sum[$key] = $value;
        } else {
          $sum[$key] += $value;
        }
      }
    }

    foreach($dataArray as $dataKey => $data) {
      if (is_array($data)) {
        $dataToProcess = $data[0];
      } else {
        $dataToProcess = $data;
      }
      foreach($dataToProcess as $key => $value) {
          $dataArray[$dataKey][0][$key] = $dataArray[$dataKey][0][$key] * 100 / $sum[$key];
      }
    }
    
    $this->reference->setReferenceArray(
      'data',
      $this->referenceId,
      $dataArray
    );
  }

}

?>
