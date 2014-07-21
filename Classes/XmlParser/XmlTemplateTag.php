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
 * Class template
 *
 * This class is used to define <template> </template> in xml code
 *
 */
class Tx_SavJpgraph_XmlParser_XmlTemplateTag extends Tx_SavJpgraph_XmlParser_AbstractXmlTag {
	
  private $templateDir = '';
  private $fileName = '';
  private $imageDir = '';
  
	/**
	 * Construtor
	 *
	 * @param $markerValue string
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
    $this->setTemplateDir();

    if ($this->fileName) {
      $this->loadTemplate($this->fileName);
    }
  }    
 
	/**
	 * Sets the template directory
	 *
	 * @param $dirName string Template directory (defined constant is interpreted)
	 *
	 * @return none
	 */
  public function setTemplateDir($dirName = '') {
    $this->templateDir = $dirName;
  }

	/**
	 * Loads and processes an xml template
	 *
	 * @param $fileName string File name
	 *
	 * @return none
	 */
  public function loadTemplate($fileName) {
    $fullFileName = $this->templateDir . $fileName;
    $this->reference->setReferenceArray(
      'template',
      $this->referenceId,
      $fullFileName
    );

    // loads and processes the file
    $this->reference->loadXmlFile($fullFileName);
    $this->reference->processXmlGraph();
  }

	/**
	 * Sets the image directory
	 *
	 * @param $dirName string Image directory (defined constant is interpreted)
	 *
	 * @return none
	 */
  public function setCopyImageDir($dirName = '') {
    $this->imageDir = $dirName;
  }
  
	/**
	 * Copies the image in another file
	 *
	 * @param $fileName string File name
	 *
	 * @return none
	 */
  public function copyImageInFile($sourceFile = '', $destinationFile = '') {
    copy($sourceFile, $this->imageDir . $destinationFile);
  }
  
}

?>
