<?php
if (!defined ('TYPO3_MODE')) {
 	die ('Access denied.');
}

t3lib_extMgm::addPItoST43($_EXTKEY, 'Classes/class.tx_savjpgraph_pi1.php', '_pi1', 'list_type', 1);

// Extends the context sensitive help
//$TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['typo3/view_help.php'] = t3lib_extMgm::extPath($_EXTKEY) . 'Classes/Utility/ViewHelpXclass.php';
      
?>
