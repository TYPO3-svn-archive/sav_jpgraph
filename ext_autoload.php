<?php

$extensionClassesPath = t3lib_extMgm::extPath('sav_jpgraph') . 'Classes/';
return array(
	'ux_sc_view_help' => $extensionClassesPath . 'Utility/ViewHelpXclass.php',
	'tx_savjpgraph_xmlparser_xmlgraph' => $extensionClassesPath . 'XmlParser/XmlGraph.php',

	'tx_savjpgraph_xmlparser_abstractxmltag' => $extensionClassesPath . 'XmlParser/AbstractXmlTag.php',

	'tx_savjpgraph_xmlparser_xmlcallbacktag' => $extensionClassesPath . 'XmlParser/XmlCallbackTag.php',
	'tx_savjpgraph_xmlparser_xmldatatag' => $extensionClassesPath . 'XmlParser/XmlDataTag.php',
	'tx_savjpgraph_xmlparser_xmlfiletag' => $extensionClassesPath . 'XmlParser/XmlFileTag.php',
	'tx_savjpgraph_xmlparser_xmlmarkertag' => $extensionClassesPath . 'XmlParser/XmlMarkerTag.php',
	'tx_savjpgraph_xmlparser_xmlquerytag' => $extensionClassesPath . 'XmlParser/XmlQueryTag.php',
	'tx_savjpgraph_xmlparser_xmltemplatetag' => $extensionClassesPath . 'XmlParser/XmlTemplateTag.php',
	'tx_savjpgraph_xmlparser_xmltypo3tag' => $extensionClassesPath . 'XmlParser/XmlTypo3Tag.php',


);
?>
