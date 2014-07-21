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
 * Plugin 'SAV JpGraph' for the 'sav_jpgraph' extension.
 *
 * @author	Laurent Foulloy <yolf.typo3@orange.fr>
 * @package	TYPO3
 * @subpackage	tx_savjpgraph
 */
 
class tx_savjpgraph_pi1 extends tslib_pibase {
	var $prefixId = 'tx_savjpgraph_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_savjpgraph_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey = 'sav_jpgraph';	// The extension key.
  var $pi_checkCHash = TRUE;

  // Session variables from SAV Filter
  protected $sessionFilter;
  protected $sessionFilterSelected;
  protected $errors;                                   // Errors list

  // Charset used in the flexform
  protected $flexformCharset;
  
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content,$conf)	{
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();

    // Defines the constant LOCALE for the use in the template
    define(LOCALE, $GLOBALS['TSFE']->config['config']['locale_all']);

    // Defines the constant CURRENT_PID for the use in the template
    define(CURRENT_PID, $GLOBALS['TSFE']->page['uid']);

    // Defines the constant STORAGE_PID for the use in the template
    $temp = $GLOBALS['TSFE']->getStorageSiterootPids();
    define(STORAGE_PID, $temp['_STORAGE_PID']);
    
    // Redefines the constant for TTF directory if necessary
    $temp = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['sav_jpgraph']);
    if ($temp['plugin.']['sav_jpgraph.']['ttfDir']) {
      define('TTF_DIR', $temp['plugin.']['sav_jpgraph.']['ttfDir']);
    }

    // Defines the main directory
    define('JP_maindir', t3lib_extMgm::extPath($this->extKey) . 'Classes/JpGraph/');
    
    // Defines the file name for the resulting image
    if (!is_dir('typo3temp/sav_jpgraph')) {
      mkdir('typo3temp/sav_jpgraph');
    }
    $imageFileName = 'typo3temp/sav_jpgraph/img_' .
      $this->cObj->data['uid'] . '.png';  
      
  	// Sets the csv file name
    $csvFileName = 'typo3temp/sav_jpgraph/img_' .
      $this->cObj->data['uid'] . '.csv';        
    
    // Defines the cache dir
    define('CACHE_DIR', 'typo3temp/sav_jpgraph/');

    // Initializes FlexForm configuration for plugin and get the configuration fields
    $this->loadFlexform();

    // Creates the xlmgraph
    $xmlGraph = t3lib_div::makeInstance('Tx_SavJpgraph_XmlParser_XmlGraph');
    $xmlGraph->injectConfiguration($this->conf);
        	
    // Sets the filter if any
    $this->sessionFilterSelected = $GLOBALS['TSFE']->fe_user->getKey('ses', 'filterSelected');
    $this->sessionFilter = $GLOBALS['TSFE']->fe_user->getKey('ses', 'filter');

    if ($this->sessionFilterSelected && is_array($this->sessionFilter[$this->sessionFilterSelected])) {
      foreach($this->sessionFilter[$this->sessionFilterSelected] as $key => $filter) {
        $xmlGraph->setReferenceArray('filter', $key, $filter);
      }
    } else {
      $xmlGraph->setReferenceArray('filter', 'addWhere', '1');
    }
    
    // Uses the cache if possible
    if ($this->conf['cache']) {  
			// Checks if the cache time is over
			$resource = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
				/* SELECT   */	'*, UNIX_TIMESTAMP(NOW()) AS time',
				/* FROM     */	'tx_savjpgraph_cache',
	 			/* WHERE    */	'cid = ' . intval($this->cObj->data['uid'])
			);			 

			// Gets the cache information
    	$row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($resource);    	
    	// Returns the image it it exists and the cahe is not over
    	if (!empty($row) && file_exists(PATH_site . $imageFileName) && $row['time'] < $row['cache_timeout']) {
    		$content = '<img class="jpgraph" src="' . $imageFileName . '" alt="" />';
    		if ($row['csv']) {
	    		$content .= '<a href="' . $csvFileName . '" ><img class="jpgraph" src="' . 
		    		t3lib_extMgm::siteRelPath($this->extKey) . 'Resources/Private/Icons/csv.gif' . '" alt="" /></a>'; 
    		}	    		
 				return $this->pi_wrapInBaseClass($content);   		
    	}
    }

	  // Deletes the file if it exists
    if (file_exists(PATH_site . $imageFileName)) {
      unlink(PATH_site . $imageFileName);
    }
    
    // Checks if queries are allowed
    if ($this->conf['allowQueries']) {

      // Gets the object type according to the TYPO3 version
      if (t3lib_utility_VersionNumber::convertVersionNumberToInteger(TYPO3_version) < 4003000) {
        $objectTypeUser = ux_tslib_cObj::OBJECTTYPE_USER;
      } else {
        $objectTypeUser = tslib_cObj::OBJECTTYPE_USER;
      }
      // Changes the plugin as a USER INT
      if ($this->cObj->getUserObjectType() == $objectTypeUser) {
  			$this->cObj->convertToUserIntObject();
  			return;
      }
      $this->pi_checkCHash = FALSE;
  		$this->pi_USER_INT_obj = 1;

      // Prepares the queries processing
      $processQueries = '
        <typo3>
          <processQueries />
        </typo3>
      ';
    } else {
      $processQueries = '';
    }

    // Sets the image and add the xml markers configuration and processes it
    $xmlGraph->loadXmlString(
      $xmlGraph->addXmlPrologue(
        '
        <file id="1">
          <setFileDir dir="PATH_site" />
          <setFile file="' . $imageFileName . '" />
        </file>' .
        $GLOBALS['TSFE']->csConvObj->conv(
          $this->conf['xmlMarkersConfig'],
          $this->flexformCharset,
          'utf-8'
        ) .
        $processQueries
      )
    );
    $xmlGraph->processXmlGraph();

    // Changes the markers values by Typoscript if any
    $markers = $this->conf['marker.'];
    if (is_array($markers)) {
	    foreach($markers as $markerKey => $marker) {
	    	$xmlGraph->setReferenceArray('marker', $markerKey, $marker);
	    }
    }
    
    // Loads the xml queries configuration and processes it
    $xmlGraph->loadXmlString(
      $xmlGraph->addXmlPrologue(
        $GLOBALS['TSFE']->csConvObj->conv(
          $this->conf['xmlQueriesConfig'],
          $this->flexformCharset,
          'utf-8'
        ) .
        $processQueries
        )
    );
    $xmlGraph->processXmlGraph();

    // Loads the xml data configuration and processes it
    $xmlGraph->loadXmlString(
      $xmlGraph->addXmlPrologue(
        $GLOBALS['TSFE']->csConvObj->conv(
          $this->conf['xmlDataConfig'],
          $this->flexformCharset,
          'utf-8'
        )
      )
    );
    $xmlGraph->processXmlGraph();

    // Loads the xml templates configuration and processes it
    $xmlGraph->loadXmlString(
      $xmlGraph->addXmlPrologue(
        $GLOBALS['TSFE']->csConvObj->conv(
          $this->conf['xmlTemplatesConfig'],
          $this->flexformCharset,
          'utf-8'
        )
      )
    );
    $xmlGraph->processXmlGraph();

    // Processes delayed methods if any
    $xmlGraph->processDelayedMethods();

 		// Prepares the output content
    $content = '<img class="jpgraph" src="' . $imageFileName . '" alt="" />';
     		
  	// Checks if a csv output is set for file#1
  	$csv = $xmlGraph->getReferenceArray('csv', 1);
  	if (!empty($csv)) { 	 		
  		$fileHandle = fopen(PATH_site . $csvFileName, 'w');
  		fwrite($fileHandle, $csv);
  		fclose($fileHandle);

    	$content .= '<a href="' . $csvFileName . '" ><img class="jpgraph" src="' . 
    		t3lib_extMgm::siteRelPath($this->extKey) . 'Resources/Private/Icons/csv.gif' . '" alt="" /></a>';  		
  	}
    
    // Includes the default style sheet if none was provided
		if (!isset($GLOBALS['TSFE']->additionalHeaderData[$this->extKey])) {
		  if (!$this->conf['fileCSS']) {
		    if (file_exists(t3lib_extMgm::siteRelPath($this->extKey) . 'Resources/Private/Styles/' . $this->extKey . '.css')) {
          $css = '<link rel="stylesheet" type="text/css" href="' . t3lib_extMgm::siteRelPath($this->extKey) . 'Resources/Private/Styles/' . $this->extKey . '.css" />';
        }
      } elseif (file_exists($this->conf['fileCSS'])) {
        $css = '<link rel="stylesheet" type="text/css" href="' . $this->conf['fileCSS'] . '" />';
		  } else {
        $this->addError('error.incorrectCSS', $this->conf['fileCSS']);
        return $this->pi_wrapInBaseClass($this->showErrors());
      }

      $GLOBALS['TSFE']->additionalHeaderData[$this->extKey] = $css;
		}

	  // Sets the cache
    if ($this->conf['cache']) { 

			// Defines the interval c&che timeout
    	$intervalCacheTimeout = array('', '+1 hour', '+1 day', '+1 week', '+1 month');
    	
    	// Updates or inserts the record
    	if (!empty($row)) {
				$resource = $GLOBALS['TYPO3_DB']->exec_UPDATEquery(
					/* TABLE   	*/	'tx_savjpgraph_cache',
		 			/* WHERE    */	'cid = ' . intval($this->cObj->data['uid']),				
					/* FIELDS   */	array(
						'tstamp' => time(), 
						'cache_timeout' => strtotime($intervalCacheTimeout[$this->conf['cache']]),
						'csv' => !empty($csv),				
					)
				);		
    	} else {
				$resource = $GLOBALS['TYPO3_DB']->exec_INSERTquery(
					/* TABLE   	*/	'tx_savjpgraph_cache',		
					/* FIELDS   */	array(
						'pid' => $this->cObj->data['pid'],
						'tstamp' => time(), 
						'cid' => $this->cObj->data['uid'],
						'cache_timeout' => strtotime($intervalCacheTimeout[$this->conf['cache']]),
						'csv' => !empty($csv),
					)
				);		    		    		
    	}
    }		

		return $this->pi_wrapInBaseClass($content);
	}

	/**
	 * Loads the flexform
	 *
	 * @param none
	 *
	 * @return none
	 */
  private function loadFlexform() {
  
    // Gets the charset in which the flexform is stored
    $this->flexformCharset = ($GLOBALS['TYPO3_CONF_VARS']['BE']['forceCharset'] ? $GLOBALS['TYPO3_CONF_VARS']['BE']['forceCharset'] : 'iso-8859-1');

		if (is_string($this->cObj->data['pi_flexform'])) {
	    preg_match('/^[[:space:]]*<\?xml[^>]*encoding[[:space:]]*=[[:space:]]*"([^"]*)"/', substr($this->cObj->data['pi_flexform'], 0, 200), $match);
			$this->flexformCharset = $match[1] ? $match[1] : $this->flexformCharset;
		} 
		
    // Initializes FlexForm configuration for plugin and get the configuration field
    $this->pi_initPIflexForm();
    if (!isset($this->cObj->data['pi_flexform']['data'])) {
      $this->addError('error.incorrectPluginConfiguration_1', $this->extKey);
      $this->addError('error.incorrectPluginConfiguration_2');
      return $this->pi_wrapInBaseClass($this->showErrors());
    }
    foreach ($this->cObj->data['pi_flexform']['data']['sDEF']['lDEF'] as $key => $value) {
  		$flexConf[$key] = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], $key);
    }

    // Merges the flexform configuration with the plugin configuration
    $this->conf = array_merge($this->conf, $flexConf);
  }

	/**
	 * Adds an error to the error list
	 *
	 * @errorLabel string (error label)
	 * @addMessage string (additional message)
	 *
	 * @return none
	 */
	protected function addError($errorLabel, $addMessage='') {
    $this->errors[] = sprintf($this->pi_getLL($errorLabel), $addMessage);
  }

	/**
	 * Returns the error list
	 *
	 * @return string (the error content result)
	 */
	protected function showErrors() {
		if(!$this->errors) {
			return '';
		} else {
			$errorList = '';
			foreach($this->errors as $error) {
        $errorList .= '<li class="error">' . $error . '</li>';
      }
			return  '<ul>' . $errorList . '</ul>';
		}
	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/sav_jpgraph/Classes/class.tx_savjpgraph_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/sav_jpgraph/Classes/class.tx_savjpgraph_pi1.php']);
}

?>
