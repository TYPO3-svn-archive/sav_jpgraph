<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

// Adds a user function for help in flexforms
if (!function_exists('user_savJpgraphHelp')) {
  function user_savJpgraphHelp($PA, $fobj){

		$message = $fobj->sL('LLL:EXT:sav_jpgraph/Resources/Private/Language/locallang.xml:pi_flexform.help');	
		$cshTag = $PA['fieldConf']['config']['userFuncParameters']['cshTag'];
		$skinnedIcon = t3lib_iconWorks::skinImg($GLOBALS['BACK_PATH'], 'gfx/helpbubble.gif', '');
		$icon = '<img'.$skinnedIcon.' class="typo3-csh-icon" alt="' . t3lib_div::lcfirst($cshTag) . '" />';
		if (t3lib_utility_VersionNumber::convertVersionNumberToInteger(TYPO3_version)	< 6000000) {
			$helpUrl = 'view_help.php?';
		}	else {
			$helpUrl = 'mod.php?M=help_cshmanual&';			
		}
    return '<a href="#" onclick="vHWin=window.open(\'' . $helpUrl . 'tfID=xEXT_sav_jpgraph_' .
    	 t3lib_div::lcfirst($cshTag) .
    	 '.*\',\'viewFieldHelp\',\'height=400,width=600,status=0,menubar=0,scrollbars=1\');vHWin.focus();return false;">' . 
    	 $icon . ' '. $message . '</a>';     
  }
}

// Adds a user function to get the overloaded attributes
if (!function_exists('user_showOverloadedAttributes')) {
  require_once(t3lib_extMgm::extPath($_EXTKEY).'Configuration/Flexforms/user_showOverloadedAttributes.php');
}

// Adds flexform fields to the plugin option
$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY.'_pi1'] = 'pi_flexform';

// Adds the flexform DataStructure
t3lib_extMgm::addPiFlexFormValue($_EXTKEY . '_pi1', 'FILE:EXT:' . $_EXTKEY . '/Configuration/Flexforms/ExtensionFlexform.xml');

// Adds the context sensitive help (CSH)
t3lib_extMgm::addLLrefForTCAdescr('xEXT_' . $_EXTKEY . '_helpGeneral', 'EXT:' . $_EXTKEY . '/Resources/Private/Language/ContextSensitiveHelp/locallang_csh_helpGeneral.xml');
t3lib_extMgm::addLLrefForTCAdescr('xEXT_' . $_EXTKEY . '_marker','EXT:' . $_EXTKEY . '/Resources/Private/Language/ContextSensitiveHelp/locallang_csh_marker.xml');
t3lib_extMgm::addLLrefForTCAdescr('xEXT_' . $_EXTKEY . '_query','EXT:' . $_EXTKEY . '/Resources/Private/Language/ContextSensitiveHelp/locallang_csh_query.xml');
t3lib_extMgm::addLLrefForTCAdescr('xEXT_' . $_EXTKEY . '_data','EXT:' . $_EXTKEY . '/Resources/Private/Language/ContextSensitiveHelp/locallang_csh_data.xml');
t3lib_extMgm::addLLrefForTCAdescr('xEXT_' . $_EXTKEY . '_template','EXT:' . $_EXTKEY . '/Resources/Private/Language/ContextSensitiveHelp/locallang_csh_template.xml');
t3lib_extMgm::addLLrefForTCAdescr('xEXT_' . $_EXTKEY . '_otherTags','EXT:' . $_EXTKEY . '/Resources/Private/Language/ContextSensitiveHelp/locallang_csh_otherTags.xml');
t3lib_extMgm::addLLrefForTCAdescr('xEXT_' . $_EXTKEY . '_comments','EXT:' . $_EXTKEY . '/Resources/Private/Language/ContextSensitiveHelp/locallang_csh_comments.xml');
t3lib_extMgm::addLLrefForTCAdescr('xEXT_' . $_EXTKEY . '_file','EXT:' . $_EXTKEY . '/Resources/Private/Language/ContextSensitiveHelp/locallang_csh_file.xml');
t3lib_extMgm::addLLrefForTCAdescr('xEXT_' . $_EXTKEY . '_foreach','EXT:' . $_EXTKEY . '/Resources/Private/Language/ContextSensitiveHelp/locallang_csh_foreach.xml');
t3lib_extMgm::addLLrefForTCAdescr('xEXT_' . $_EXTKEY . '_callback','EXT:' . $_EXTKEY . '/Resources/Private/Language/ContextSensitiveHelp/locallang_csh_callback.xml');

t3lib_extMgm::addPlugin(array(
	'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	''
),'list_type');


if (TYPO3_MODE == 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_savjpgraph_pi1_wizicon'] = t3lib_extMgm::extPath($_EXTKEY).'Classes/class.tx_savjpgraph_pi1_wizicon.php';
}
?>
