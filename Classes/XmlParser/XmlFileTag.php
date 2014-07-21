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
 * Class file
 *
 * This class is used to define <file> </file> in xml code
 *
 */
class Tx_SavJpgraph_XmlParser_XmlFileTag extends Tx_SavJpgraph_XmlParser_AbstractXmlTag {
	
  private $fileDir = '';
  private $fileName = '';

	/**
	 * Construtor
	 *
	 * @param $fileName string
	 *
	 * @return none
	 */
  public function __construct($fileName = '') {
    $this->fileName = trim($fileName);
  }

	/**
	 * Default method
	 *
	 * @param none
	 *
	 * @return none
	 */
  public function defaultMethod() {
    $this->setFile($this->fileName);	
  }    

	/**
	 * Sets the file directory
	 *
	 * @param $dirName string File directory (defined constant is interpreted)
	 *
	 * @return none
	 */
  public function setFileDir($dirName = '') {
    $this->fileDir = $dirName;
  }

	/**
	 * Sets the file name
	 *
	 * @param $fileName string File name
	 *
	 * @return none
	 */
  public function setFile($fileName = '') {
    $this->fileName = $fileName;
    $fullFileName = $this->fileDir . $fileName;
    $this->reference->setReferenceArray(
      'file',
      $this->referenceId,
      $fullFileName
    );
  }

	/**
	 * Exports data in csv
	 *
	 * @param $fileName string File name
	 *
	 * @return none
	 */
  public function exportCSV($arguments) {
  	// Gets the arguments
		$argumentsCount = func_num_args();	
		$arguments = func_get_args();
		$rowHeader = $arguments[0];
		$data = $arguments[1]; 
		$columnHeader = NULL;
		$groupHeader = NULL;
		if ($argumentsCount > 2) {
			$columnHeader = $arguments[2];
			if ($argumentsCount == 4) {
				$groupHeader = $arguments[3];
			}
		}  
			
		// Sets the row header
		$output = array();
		if ($columnHeader !== NULL) {		
			$rowHeader = array_merge(array(''), $rowHeader);
		}
  	if ($groupHeader !== NULL) {		
			$rowHeader = array_merge(array(''), $rowHeader);
		}				
		$output[] = t3lib_div::csvValues($rowHeader, ';');	
				
		// Sets the rows
		if (!is_array($data[0])) {
			// Table with one row
			$output[] = t3lib_div::csvValues($data, ';');					
		} else {
			// Table with several rows
			foreach ($data as $rowKey => $row) {
				if ($columnHeader !== NULL) {		
					if (!is_array($row[0][0])) {
						$value = array_merge(array($columnHeader[$rowKey]), $row[0]);
						$output[] = t3lib_div::csvValues($value, ';');
					} else {
						// Table with several rows and a agroup
						foreach($row[0] as $groupKey => $group) {
							$value = array_merge(array($columnHeader[$rowKey]), array($groupHeader[$groupKey]), $group[0]);	
							$output[] = t3lib_div::csvValues($value, ';');
						}												
					}															
				} else {
					$output[] = t3lib_div::csvValues($value, ';');						
				}					
			}
		}		
		
		$outputString = implode(chr(10), $output);
  	if (mb_detect_encoding($outputString) == 'UTF-8'){
			$outputString = utf8_decode($outputString);
		}
    $this->reference->setReferenceArray(
      'csv',
      $this->referenceId,
      $outputString
    );
  }  
}

?>
