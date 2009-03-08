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

require_once(PATH_tslib.'class.tslib_pibase.php');


/**
 * Plugin 'SAV JpGraph' for the 'sav_jpgraph' extension.
 *
 * @author	Yolf (Laurent Foulloy) <yolf.typo3@orange.fr>
 * @package	TYPO3
 * @subpackage	tx_savjpgraph
 */

require_once(PATH_tslib . 'class.tslib_pibase.php');
/**
 * Plugin 'SAV JpGraph' for the 'sav_jpgraph' extension.
 *
 * @author	Yolf <yolf.typo3@orange.fr>
 * @package	TYPO3
 * @subpackage	tx_savjpgraph
 */
class tx_savjpgraph_pi1 extends tslib_pibase {
	var $prefixId = 'tx_savjpgraph_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_savjpgraph_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey = 'sav_jpgraph';	// The extension key.

	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content,$conf)	{
		$this->conf=$conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
		$this->pi_USER_INT_obj=1;	// Configuring so caching is not expected. This value means that no cHash params are ever set. We do this, because it's a USER_INT object!

    // define the constant LOCALE for the use in the template
    define(LOCALE, $GLOBALS['TSFE']->config['config']['locale_all']);
    
    // Redefine the constant for TTF directory if necessary
    $temp = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$this->extKey]);
    if ($temp['plugin.'][$this->extKey . '.']['ttfDir']) {
      define('TTF_DIR', $temp['plugin.'][$this->extKey . '.']['ttfDir']);
    }
    
    // Define the main directory
    define('JP_maindir', t3lib_extMgm::extPath($this->extKey) . 'src/');

    // Require the xml class
    require_once(t3lib_extMgm::extPath('sav_jpgraph'). 'class.xmlgraph.php');

    // Init FlexForm configuration for plugin and get the configuration fields
    $this->loadFlexform();

    // Define the file name for the resulting image
    if (!is_dir('typo3temp/sav_jpgraph')) {
      mkdir('typo3temp/sav_jpgraph');
    }
    $imageFileName = 'typo3temp/sav_jpgraph/img_' .
      $this->cObj->data['uid'] . '.png';

    // Delete the file if it exists
    if (file_exists(PATH_site . $imageFileName)) {
      unlink(PATH_site . $imageFileName);
    }

    // Create the xlmgraph
    $xmlGraph = new xmlGraph();

    // Set the image and oad the xml markers configuration and process it
    $xmlGraph->loadXmlString(
      $xmlGraph->addXmlPrologue(
        '<file id="1">
          <setFileDir dir="PATH_site" />
          <setFile file="' . $imageFileName . '" />
        </file>' .
        $this->conf['xmlMarkersConfig'])
    );
    $xmlGraph->processXmlGraph();

    // Load the xml queries configuration and process it
    $xmlGraph->loadXmlString(
      $xmlGraph->addXmlPrologue($this->conf['xmlQueriesConfig'])
    );
    $xmlGraph->processXmlGraph();

    // Exec all the queries if allowed
    if ($this->conf['allowQueries']) {

      $GLOBALS['TYPO3_DB']->store_lastBuiltQuery = true;

      foreach($xmlGraph->getReferenceArray('querySelect') as $id => $value) {
        $rows = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
          $xmlGraph->getReferenceArray('querySelect', $id),
          $xmlGraph->getReferenceArray('queryFrom', $id),
          $xmlGraph->getReferenceArray('queryWhere', $id),
          $xmlGraph->getReferenceArray('queryGroupby', $id),
          $xmlGraph->getReferenceArray('queryOrderby', $id),
          $xmlGraph->getReferenceArray('queryLimit', $id)
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
          $xmlGraph->setReferenceArray('query', $id, $rows);
        }
      }
    }

    // Load the xml data configuration and process it
    $xmlGraph->loadXmlString(
      $xmlGraph->addXmlPrologue($this->conf['xmlDataConfig'])
    );
    $xmlGraph->processXmlGraph();

    // Load the xml templates configuration and process it
    $xmlGraph->loadXmlString(
      $xmlGraph->addXmlPrologue($this->conf['xmlTemplatesConfig'])
    );
    $xmlGraph->processXmlGraph();

    $content = '<img class="jpgraph" src="' . $imageFileName . '" alt="" />';

		return $this->pi_wrapInBaseClass($content);
	}

  private function loadFlexform() {
    // Init FlexForm configuration for plugin and get the configuration fields
    $this->pi_initPIflexForm();
    if (!isset($this->cObj->data['pi_flexform']['data'])) {
      $this->addError('error.incorrectPluginConfiguration_1', $this->extKey);
      $this->addError('error.incorrectPluginConfiguration_2');
      return $this->pi_wrapInBaseClass($this->showErrors());
    }
    foreach ($this->cObj->data['pi_flexform']['data']['sDEF']['lDEF'] as $key => $value) {
  		$flexConf[$key] = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], $key);
    }

    // Merge the flexform configuration with the plugin configuration
    $this->conf = array_merge($this->conf, $flexConf);
  }

}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/sav_jpgraph/pi1/class.tx_savjpgraph_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/sav_jpgraph/pi1/class.tx_savjpgraph_pi1.php']);
}

?>
