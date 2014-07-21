<?php
if (!defined ('TYPO3_MODE')) {
 	die ('Access denied.');
}

t3lib_extMgm::addPItoST43($_EXTKEY, 'Classes/class.tx_savjpgraph_pi1.php', '_pi1', 'list_type', 1);

// Adds a hook to the tcemain
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearAllCache_additionalTables'][] = 'tx_savjpgraph_cache';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc'][] = 'EXT:sav_jpgraph/Classes/class.tx_savjpgraph_tcemain.php:tx_savjpgraph_tcemain->clearCachePostProc';
     
?>
