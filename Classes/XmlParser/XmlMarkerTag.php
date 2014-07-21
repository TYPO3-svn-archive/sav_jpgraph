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
 * Class marker
 *
 * This class is used to define <marker> </marker> in xml code
 *
 */
class Tx_SavJpgraph_XmlParser_XmlMarkerTag extends Tx_SavJpgraph_XmlParser_AbstractXmlTag {

  private $markerValue = '';

	/**
	 * Construtor
	 *
	 * @param $markerValue string
	 *
	 * @return none
	 */
  public function __construct($markerValue = '') {
    $this->markerValue = trim($markerValue);
  }

	/**
	 * Default method
	 *
	 * @param none
	 *
	 * @return none
	 */
  public function defaultMethod() {
    $this->setMarker($this->markerValue);
  }      

	/**
	 * Sets a marker
	 *
	 * @param $markerValue string Marker Value
	 *
	 * @return none
	 */
  public function setMarker($markerValue = '') {
    $this->reference->setReferenceArray(
      'marker',
      $this->referenceId,
      Tx_SavJpgraph_XmlParser_xmlGraph::replaceSpecialChars($markerValue)
    );   
  }

	/**
	 * Sets a marker by pieces 
	 *
	 * @param mixed $markerPiece,... 
	 *
	 * @return none
	 */
  public function setMarkerByPieces($markerPiece = '') {
  	
		// Builds the marker string from the parameters
		$markers = '';
		$arguments = func_get_args();
		foreach ($arguments as $argument) {
			$markers .= $argument;
		}
		  	
    $this->reference->setReferenceArray(
      'marker',
      $this->referenceId,
      Tx_SavJpgraph_XmlParser_xmlGraph::replaceSpecialChars($markers)
    );
  }
 
}

?>
