<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

// Add a user function for the help icon
if (!function_exists('user_helpIcon')) {
  function user_helpIcon($PA, $fobj){
    if (t3lib_div::int_from_ver(TYPO3_version) < 4002000) {
      $ext = str_replace('_pi1','',$PA['row']['list_type']);
      $helpItem = 'help';
      return '<a href="#" style="padding:3px;" onclick="vHWin=window.open(\''.'view_help.php?tfID='.$ext.'.'.$helpItem.'\',\'viewFieldHelp\',\'height=400,width=600,status=0,menubar=0,scrollbars=1\');vHWin.focus();return false;"><img src="'.'sysext/t3skin/icons/gfx/helpbubble.gif" width="16" height="16" hspace="2" border="0" class="typo3-csh-icon" alt="'.'help'.'" /></a>';
    } else {
      return '&nbsp;';
    }
  }
}

// Add a user function to get the overloaded attributes
if (!function_exists('user_showOverloadedAttributes')) {
  require_once(t3lib_extMgm::extPath($_EXTKEY).'user_showOverloadedAttributes.php');
}

// Add flexform field to plugin option
$TCA["tt_content"]["types"]["list"]["subtypes_addlist"][$_EXTKEY."_pi1"]="pi_flexform";

// Add flexform DataStructure
t3lib_extMgm::addPiFlexFormValue($_EXTKEY."_pi1", "FILE:EXT:".$_EXTKEY."/flexform_ds_pi1.xml");

// Adding context sensitive help (CSH)
if (t3lib_div::int_from_ver(TYPO3_version) < 4002000) {
  t3lib_extMgm::addLLrefForTCAdescr($_EXTKEY,'EXT:' . $_EXTKEY . '/res/locallang_csh_flexform.xml');
}


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:sav_jpgraph/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	''
),'list_type');


if (TYPO3_MODE == 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_savjpgraph_pi1_wizicon'] = t3lib_extMgm::extPath($_EXTKEY).'pi1/class.tx_savjpgraph_pi1_wizicon.php';
}
?>
