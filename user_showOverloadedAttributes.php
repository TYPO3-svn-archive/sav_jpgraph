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

// User function called through the flexform to display the overloaded attributes

  function user_showOverloadedAttributes($PA, $fobj){
  
    if (!$PA['row']['pi_flexform']) {
      return  '';
    }

    // Get the template field
    $xml = simplexml_load_string(html_entity_decode($PA['row']['pi_flexform']));

    // Get the template
    $templates = $xml->xpath('//field[@index="xmlTemplatesConfig"]/value/template');
    $tagsArray = array();
    foreach ($templates as $template) {

      $templateFileName = trim((string) $template);
      if (!$templateFileName) {
        // Chek if there is a tag setTemplateDir
        $templateDirTags = $template->xpath('//setTemplateDir[@dir]');
        $templateDir = (string) $templateDirTags[0]['dir'];
        $templateDir = (defined($templateDir) ? constant($templateDir) : $templateDir);
        // Chek if there is a tag loaadTemplate
        $loadTemplateTags = $template->xpath('//loadTemplate[@file]');
        $loadTemplate = (string) $loadTemplateTags[0]['file'];
        $templateFileName = $loadTemplate;
        if (!$templateFileName) {
          return '';
        }
      }

      // Load the template
      $templateFile = ($templateDir ? $templateDir : PATH_site) . $templateFileName;
      if (!file_exists($templateFile)) {
        return 'Template file: ' . $templateFile . ' does not exist.';
      }
      $xmlGraph = simplexml_load_file($templateFile);

      // Get the comments for the current language or from the default one
      $comments = $xmlGraph->xpath('//comments/languageKey[@index="'. $GLOBALS['LANG']->lang .'"]');
      if(!$comments) {
        $comments = $xmlGraph->xpath('//comments/languageKey[@index="default"]');
      }
      if($comments) {
        $labels = $comments[0]->xpath('//label[@index]');
        foreach($labels as $label) {
          $referenceAttributeValue = explode('#', (string)$label['index']);
          $labelsArray[$referenceAttributeValue[0]][$referenceAttributeValue[1]] = (string)$label;
        }
      }

      // Get the overloaded attributes
      $referenceAttributes = $xmlGraph->xpath('//@*[starts-with(name(),"ref_")]');
      foreach ($referenceAttributes as $referenceAttribute) {
        $referenceAttributeValue = explode('#', (string)$referenceAttribute);
        if (!is_array($tagsArray[$referenceAttributeValue[0]])) {
          $tagsArray[$referenceAttributeValue[0]]= array();
        }
        if (!in_array($referenceAttributeValue[1], $tagsArray[$referenceAttributeValue[0]]))
        $tagsArray[$referenceAttributeValue[0]][$referenceAttributeValue[1]] = $labelsArray[$referenceAttributeValue[0]][$referenceAttributeValue[1]];
      }
    }

    // Build the content
    $content = array();
    $content[] = '<style type="text/css">';
    $content[] = '  /*<![CDATA[*/';
    $content[] = '  table.comments td.link {padding:3px;}';
    $content[] = '  table.comments td.link a {padding:3px;}';
    $content[] = '  table.comments td.link:hover {background-color: #d7dbe2;}';
    $content[] = '  /*]]>*/';
    $content[] = '</style>';

    $content[] = '<table class="comments">';
    foreach ($tagsArray as $keyTags => $tagArray) {
      $content[] = '<tr colspan="2"><td><strong>Tags ' . $keyTags .':</strong><br /></td></tr>';
      switch ($keyTags) {
        case 'data':
          $name = 'xmlDataConfig';
          break;
        case 'marker':
          $name = 'xmlMarkersConfig';
          break;
        default:
          continue;
      }

      foreach ($tagArray as $keyTag => $tag) {
        $comment = ($tag ? $tag : '&nbsp;');
        $onclick = 'document.editform[\'data[tt_content]['. $PA['row']['uid'] .'][pi_flexform][data][sDEF][lDEF]['. $name .'][vDEF]\'].value+=\'' .
          '<' . $keyTags . ' id=&quot;'. $keyTag .'&quot;>\n\n' .
          '</'. $keyTags . '>\n\';' .
          'if(document.editform[\'data[tt_content]['. $PA['row']['uid'] .'][pi_flexform][data][sDEF][lDEF]['. $name .'][vDEF]\'].rows >=5) document.editform[\'data[tt_content]['. $PA['row']['uid'] .'][pi_flexform][data][sDEF][lDEF]['. $name .'][vDEF]\'].rows+=3;';
        $content[] = '<tr><td class="link">&nbsp;<a href="#" ondblclick="' . $onclick . '">' .$keyTag . '</a></td><td style="padding:3px;">' . $comment . '</td></tr>';
      }
    }
    $content[] = '</table>';

    return implode(chr(10), $content);
  }


?>
