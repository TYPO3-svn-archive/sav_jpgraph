<?php
/***************************************************************
*  Copyright notice
*
*  (c) 20013 Laurent Foulloy <yolf.typo3@orange.fr>
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
 * Hooks to the tcemain.
 *
 * @author	Laurent Foulloy <yolf.typo3@orange.fr>
 * @package	TYPO3
 * @subpackage	tx_savjpgraph
 */
class tx_savjpgraph_tcemain {

	function clearCachePostProc($parameters) {
		// Deletes the records in the page when the content is saved
		$resource = $GLOBALS['TYPO3_DB']->exec_DELETEquery(
			/* TABLE    */	'tx_savjpgraph_cache',
	 		/* WHERE    */	'pid = ' . intval($parameters['uid_page'])
		);			
	}	
	
}

?>
