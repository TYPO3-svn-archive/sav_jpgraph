<?php
if (!defined ('TYPO3_MODE')) {
 	die ('Access denied.');
}

t3lib_extMgm::addPItoST43($_EXTKEY, 'pi1/class.tx_savjpgraph_pi1.php', '_pi1', 'list_type', 1);

  // Extend the tslib_cObj class if version is lower than 4.3
  if (t3lib_div::int_from_ver(TYPO3_version) < 4003000) {
    $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['tslib/class.tslib_content.php'] =
      t3lib_extMgm::extPath($_EXTKEY) . 'tslib/class.ux_tslib_content.php';
  }
  
?>
