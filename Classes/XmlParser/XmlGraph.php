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

// The constant JP_maindir must be defined before calling this file
require_once (JP_maindir . 'jpgraph.php');

/**
 * Class xmlGraph
 *
 * This class extends the class graph to parse xml
 *
 */
class Tx_SavJpgraph_XmlParser_xmlGraph extends Graph {
	
  protected static $configuration = array();
  protected $referenceArray = array();
  protected $referenceId = 0;
  protected $xml = NULL;
  private $requireArray = array(
    // Antispam
    'HandDigits' => 'jpgraph_antispam.php',
    'AntiSpam' => 'jpgraph_antispam.php',
    // Band
    'PlotBand' => 'jpgraph_plotband.php',
    // Bar
    'BarPlot' => 'jpgraph_bar.php',
    'GroupBarPlot' => 'jpgraph_bar.php',
    'AccBarPlot' => 'jpgraph_bar.php',
    // Canvas
    'CanvasGraph' => 'jpgraph_canvas.php',
    // Canvas tools
    'CanvasScale' => 'jpgraph_canvtools.php',
    'Shape' => 'jpgraph_canvtools.php',
    'CanvasRectangleText' => 'jpgraph_canvtools.php',
    // Date
    'DateScale' => 'jpgraph_date.php',
    // Flags
    'FlagImages' => 'jpgraph_flags.php',
    // Gantt
    'GanttActivityInfo' => 'jpgraph_gantt.php',
    'GanttGraph' => 'jpgraph_gantt.php',
    'PredefIcons' => 'jpgraph_gantt.php',
    'IconImage' => 'jpgraph_gantt.php',
    'TextProperty' => 'jpgraph_gantt.php',
    'HeaderProperty' => 'jpgraph_gantt.php',
    'GanttScale' => 'jpgraph_gantt.php',
    'GanttConstraint' => 'jpgraph_gantt.php',
    'GanttPlotObject' => 'jpgraph_gantt.php',
    'Progress' => 'jpgraph_gantt.php',
    'HorizontalGridLine' => 'jpgraph_gantt.php',
    'GanttBar' => 'jpgraph_gantt.php',
    'MileStone' => 'jpgraph_gantt.php',
    'TextPropertyBelow' => 'jpgraph_gantt.php',
    'GanttVLine' => 'jpgraph_gantt.php',
    'LinkArrow' => 'jpgraph_gantt.php',
    'GanttLinkv' => 'jpgraph_gantt.php',
    // Gb2312
    'GB2312toUTF8' => 'jpgraph_gb2312.php',
    // Gradient
    'Gradient' => 'jpgraph_gradient.php',
    // Iconplot
    'IconPlot' => 'jpgraph_iconplot.php',
    // Imgtrans
    'ImgTrans' => 'jpgraph_imgtrans.php',
    // Led
    'DigitalLED74' => 'jpgraph_led.php',
    // Line
    'LinePlot' => 'jpgraph_line.php',
    'AccLinePlot' => 'jpgraph_line.php',
    // Log
    'LogScale' => 'jpgraph_log.php',
    'LogTicks' => 'jpgraph_log.php',
    // Mgraph
    'MGraph' => 'jpgraph_mgraph.php',
    // Pie3d
    'PiePlot3D' => 'jpgraph_pie.php,jpgraph_pie3d.php',
    // Pie
    'PiePlot' => 'jpgraph_pie.php',
    'PiePlotC' => 'jpgraph_pie.php',
    'PieGraph' => 'jpgraph_pie.php',
    // Plotband
    'Rectangle' => 'jpgraph_plotband.php',
    'RectPattern' => 'jpgraph_plotband.php',
    'RectPatternSolid' => 'jpgraph_plotband.php',
    'RectPatternHor' => 'jpgraph_plotband.php',
    'RectPatternVert' => 'jpgraph_plotband.php',
    'RectPatternRDiag' => 'jpgraph_plotband.php',
    'RectPatternLDiag' => 'jpgraph_plotband.php',
    'RectPattern3DPlane' => 'jpgraph_plotband.php',
    'RectPatternCross' => 'jpgraph_plotband.php',
    'RectPatternDiagCross' => 'jpgraph_plotband.php',
    'RectPatternFactory' => 'jpgraph_plotband.php',
    'PlotBand' => 'jpgraph_plotband.php',
    // Polar
    'PolarPlot' => 'jpgraph_polar.php',
    'PolarAxis' => 'jpgraph_polar.php',
    'PolarScale' => 'jpgraph_polar.php',
    'PolarLogScale' => 'jpgraph_polar.php',
    'PolarGraph' => 'jpgraph_polar.php',
    // Radar
    'RadarLogTicks' => 'jpgraph_radar.php',
    'RadarLinearTicks' => 'jpgraph_radar.php',
    'RadarAxis' => 'jpgraph_radar.php',
    'RadarGrid' => 'jpgraph_radar.php',
    'RadarPlot' => 'jpgraph_radar.php',
    'RadarGraph' => 'jpgraph_radar.php',
    // Regstat
    'Spline' => 'jpgraph_regstat.php',
    'Bezier' => 'jpgraph_regstat.php',
    // Scatter
    'FieldArrow' => 'jpgraph_scatter.php',
    'FieldPlot' => 'jpgraph_scatter.php',
    'ScatterPlot' => 'jpgraph_scatter.php',
    // Stock
    'StockPlot' => 'jpgraph_stock.php',
    'BoxPlot' => 'jpgraph_stock.php',
    // Utils
    'FuncGenerator' => 'jpgraph_utils.inc.php'
  );

  /**
	 * Injects the configuration
	 *
	 * @param array $configuration The configuration
	 *
	 * @return none
	 */
  public function injectConfiguration($configuration) {
  	self::$configuration = $configuration;
  }
  
  /**
	 * Gets the configuration
	 *
	 * @param none
	 *
	 * @return array The configuration
	 */
  public static function getConfiguration() {
  	return self::$configuration;
  }
    
	/**
	 * Loads an xml file
	 *
	 * @param string $fileName File nmame
	 *
	 * @return none
	 */
  public function loadXmlFile($fileName) {
    // Uses XML internal errors
    libxml_use_internal_errors(true);
    
    // Loads the xml file
    $this->xml = @simplexml_load_file($fileName);
    
    // Checks if an error is detected
    if ($this->xml === false) {
      $errors = libxml_get_errors();
      // Displays the first error
      JpGraphError::Raise(
        'XML error: ' . $errors[0]->message . 'Check line ' . $errors[0]->line
      );
    }
  }

	/**
	 * Load an xml string
	 *
	 * @param string $xmlString xml string
	 *
	 * @return none
	 */
  public function loadXmlString($xmlString) {
     // Uses XML internal errors
    libxml_use_internal_errors(true);

    // Loads the xml string
    $this->xml = @simplexml_load_string($xmlString);

    // Checks if an error is detected
    if ($this->xml === false) {
      $errors = libxml_get_errors();
      // Display the first error
      JpGraphError::Raise(
        'XML error: ' . $errors[0]->message . 'Check line ' . $errors[0]->line
      );
    }
  }

	/**
	 * Sets the reference array
	 *
	 * @param $name string tag name
	 * @param $id string id
	 * @param $value mixed
	 *
	 * @return none
	 */
  public function setReferenceArray($name, $id, $value, $index = false) {
    if ($index === false ) {
      $this->referenceArray[$name][$id] = $value;
    } elseif (is_integer($index)) {
      $this->referenceArray[$name][$id][$index] = $value;
    } else {
      $index = count($this->referenceArray[$name][$id]);
      $this->referenceArray[$name][$id][$index] = $value;
    }
  }
  
	/**
	 * Unsets the reference array
	 *
	 * @param $name string tag name
	 * @param $id string id
	 *
	 * @return none
	 */
  public function unsetReferenceArray($name, $id, $index = false) {
    if ($index === false) {
      unset ($this->referenceArray[$name][$id]);
    } else {
      unset ($this->referenceArray[$name][$id][$index]);
    }
  }
  
	/**
	 * Gets the reference array
	 *
	 * @param $name string tag name
	 * @param $id string id
	 * @param $value mixed
	 *
	 * @return none
	 */
  public function getReferenceArray($name = '', $id = false, $index = false) {
  	if ($name == '') {
			return $this->referenceArray;  		
  	} elseif ($id === false) {
      return $this->referenceArray[$name];
    } elseif ($index === false) {
      return $this->referenceArray[$name][$id];
    } else {
      return $this->referenceArray[$name][$id][$index];
    }
  }

	/**
	 * Checks if the reference exists in the reference array
	 *
	 * @param $name string tag name
	 * @param $id string id
	 * @param $value mixed
	 *
	 * @return none
	 */
  public function existsInReferenceArray($name, $id) {
   $result = is_null($this->getReferenceArray($name, $id));
   return ($result ? false : true);
  }

	/**
	 * Replaces SQL variables in the reference array
	 *
	 * @param $name string tag name
	 * @param $variable string variable which must e replaced
	 * @param $value string value used for replacement
	 *
	 * @return none
	 */
  public function replaceVariableInReferenceArray($name, $variable, $value) {
    foreach($this->referenceArray[$name] as $id => $reference) {
      $this->setReferenceArray(
        $name,
        $id,
        str_replace($variable, $value, $reference)
      );
    }
  }

	/**
	 * Processes a reference
	 *
	 * @param $reference string
	 *
	 * @return string/boolean (return the reference or false)
	 */
  public function processReference($reference) {
    // Get the tag and the id
    if (preg_match('/^(\w+)#(\w+)((:)(?:(\d+)|(each)#(\w+)))?((:)(?:(\d+)))?$/', $reference, $matches)) {

      if (isset($this->referenceArray[$matches[1]][$matches[2]])) {
        $referenceValue = $this->referenceArray[$matches[1]][$matches[2]];
        if(is_scalar($referenceValue)) {
          return $this->processConstant((string) $referenceValue);
        } elseif (is_array($referenceValue) && !empty($matches[3])) {
        	if(!empty($matches[5]) || $matches[5] === '0') {
        		return $referenceValue[intval($matches[5])];
        	} elseif ($matches[6] == 'each') {
   					if (!empty($matches[9])) {
        			return $referenceValue[$this->referenceArray['each'][$matches[7]]][intval($matches[10])];   						
   					} else {     		
        			return $referenceValue[$this->referenceArray['each'][$matches[7]]];   						
   					}
        	}
        } else {
          return $referenceValue;
        }
      } else {
        return false;
      }
    } else {
      JpGraphError::Raise(
        'Incorrect reference attribute "' . $reference . '".' .
        ' Syntax tagNmae#id (example PiePlot#1)'
      );
    }
  }

	/**
	 * Processes a constant
	 *
	 * @param $value string
	 *
	 * @return string
	 */
  protected function processConstant($value) {
    return (defined($value) ? constant($value) : $value);
  }

	/**
	 * Processes attributes
	 *
	 * @param $element object
	 *
	 * @return boolean
	 */
  protected function processAttributes($element) {
    $temp = array();
    $this->delayedMethod = false;
    foreach($element->attributes() as $name => $value) {
      switch ($name) {
        case 'return':
          $this->referenceArray['return'][0] = (string) $value;
          break;
        case 'ref_for':
          $temp[$name] = $this->processReference($value);       
          break;          
        case 'ref':
          if ($this->referenceIndex !== false) {
            $referenceArray = $this->processReference($value);
            $reference = $referenceArray[$this->referenceIndex];
            if (is_array($reference)) {
              $temp = $reference;
            } else {
              $temp[$name] = $reference;
            }
          } else {
            $temp[$name] = $this->processReference($value);
          }         
          break;
        case 'id':
          // It's an id. Sets the reference id
          $this->referenceId = (string) $value;
          break;
        case 'delayed':
          // The method should be delayed
          $this->delayedMethod = true;
          break;
        default:
          // Checks if the attribute name starts with ref_
          if (preg_match('/^ref_(.*)$/', $name, $matches)) {
            // Checks if it's in a foreach
            if ($this->referenceIndex !== false) {
              $referenceArray = $this->processReference($value);
              $reference = (
                $referenceArray !== false ?
                $referenceArray[$this->referenceIndex] :
                false
              );
              if (is_array($reference)) {
                $temp = $reference;
              } else {
                if ($reference !== false) {
                  // Replaces the attribute by its reference
                  $temp[$matches[1]] = $reference;
                }
              }
            } else {
              // Gets the reference tag and id
              $referenceValue = $this->processReference($value);
              if ($referenceValue !== false) {
                // Replaces the attribute by its reference
                $temp[$matches[1]] = $referenceValue;
              }
            }
          } elseif (preg_match_all('/([^\|]*)?\|([^\|]*)/', (string) $value, $matches)) {
            // Checks if the expression contains an operator |
            for($i=0; $i<count($matches[0]); $i++) {
              if ($matches[1][$i]) {
                $result = $this->processConstant(trim((string) $matches[1][$i]));
              }
              $result = $result | $this->processConstant(trim((string) $matches[2][$i]));
            }
            $temp[$name] = $result;
          } else {
            $temp[$name] = $this->processConstant((string) $value);
          }
          break;
      }
    }

    return array_values($temp);
  }


	/**
	 * Processes a method
	 *
	 * @param $method array (clasName,methodName)
	 * @param $parameter array
	 *
	 * @return none
	 */
  protected function processMethod($method, &$parameters) {

    switch (count($parameters)) {
      case 0:
        return call_user_func($method);
      case 1:
        return call_user_func($method,
          $parameters[0]
        );
      case 2:
        return call_user_func($method,
          $parameters[0],
          $parameters[1]
        );
      case 3:
        return call_user_func($method,
          $parameters[0],
          $parameters[1],
          $parameters[2]
        );
      case 4:
        return call_user_func($method,
          $parameters[0],
          $parameters[1],
          $parameters[2],
          $parameters[3]
        );
      case 5:
        return call_user_func($method,
          $parameters[0],
          $parameters[1],
          $parameters[2],
          $parameters[3],
          $parameters[4]
        );
      case 6:
        return call_user_func($method,
          $parameters[0],
          $parameters[1],
          $parameters[2],
          $parameters[3],
          $parameters[4],
          $parameters[5]
        );        
      default:
        JpGraphError::Raise(
          'Too many parameters in the method "' . $method[1] . '"'
        );
    }
  }

	/**
	 * Processes an object
	 *
	 * @param $method array (clasName,methodName)
	 * @param $parameter array
	 *
	 * @return none
	 */
  protected function createObject($className, &$parameters) {
    switch (count($parameters)) {
      case 0:
        return t3lib_div::makeInstance($className);
      case 1:
        return t3lib_div::makeInstance($className,
          $parameters[0]
        );
      case 2:
        return t3lib_div::makeInstance($className,
          $parameters[0],
          $parameters[1]
        );
      case 3:
        return t3lib_div::makeInstance($className,
          $parameters[0],
          $parameters[1],
          $parameters[2]
        );
      case 4:
        return t3lib_div::makeInstance($className,
          $parameters[0],
          $parameters[1],
          $parameters[2],
          $parameters[3]
        );
      case 5:
        return t3lib_div::makeInstance($className,
          $parameters[0],
          $parameters[1],
          $parameters[2],
          $parameters[3],
          $parameters[4]
        );      
      default:
        JpGraphError::Raise(
          'Too many parameters when creating the object "' . $className . '"'
        );
    }
  }

	/**
	 * Processes a xml element
	 *
	 * @param $element object
	 * @param $JpGraph object
	 *
	 * @return none
	 */
   protected function processElement($element, &$JpGraphObject) {

    foreach($element->children() as $child) {
      // Checks if the child has children
      if (! count($child->children())) {
        // Unsets return
        unset($this->referenceArray['return']);
        // Checks if the child has a content
        if ((string)$child) {
          $attributes[0] = (string)$child;
        } else {
          $attributes = $this->processAttributes($child);
        }

        // Builds the method array (classname, method)
        $method = array(&$JpGraphObject, (string) $child->getName());
        // Checks if the method exists
        if (!method_exists($method[0], $method[1])) {
          JpGraphError::Raise(
            'Method "' . $method[1] . '" does not exit in class "' .
            (string) $element->getName() . '".' .
            ' If the function name  is correct, check the class tag in your xml.'
          );
        } else {
          // Calls the method
          if ($this->delayedMethod !== true) {
            $res = $this->processMethod($method, $attributes);
            // Checks if the return value should be processed as a reference
            if (isset($this->referenceArray['return'][0])) {
              // Gets the tag and the id
              $reference = $this->referenceArray['return'][0];
              if (preg_match('/^([A-Za-z]+)#([0-9A-Za-z_]*)$/', $reference, $matches)) {
                $this->referenceArray[$matches[1]][$matches[2]] = $res;
              } else {
                JpGraphError::Raise(
                  'Incorrect reference attribute "' . $reference . '".' .
                  ' Syntax tagNmae#id (example data#1)'
                );
              }
            }
          } else {
            $this->referenceArray['delayedMethods'][] = array('method' => $method, 'attributes' => $attributes);
          }
        }
      } else {
        // Calls recursively with the child element if not foreach
        // Else calls recursively each child
        $childJpGraphObject = (string)$child->getName();
        if ($childJpGraphObject == 'foreach') {
          // Processes attributes
          $attributes = $this->processAttributes($child);

          // Saves the reference index
          $referenceIndex = $this->referenceIndex;
          
          // Processes the attributes
          if (is_array($attributes[0])) {
            foreach ($attributes[0] as $key => $attribute) {
              $this->setReferenceArray($childJpGraphObject, $this->referenceId, $attributes[0]);
              $this->referenceIndex = $key;
              $this->processElement($child, $JpGraphObject);
            }
          }
          
          //Resets the reference index
          $this->referenceIndex = $referenceIndex;

        } else {
          $this->processElement($child, $JpGraphObject->$childJpGraphObject);
        }
      }
    }
  }

	/**
	 * Processes child
	 *
	 * @param $child object
	 *
	 * @return none
	 */
	public function processChild($child) {

    // Resets the reference id
    $this->referenceId = 0;

    // Gets the child name
    $childName = (string)$child->getName();

    // Processes the attributes
    $attributes = $this->processAttributes($child);

    // If there is a child string, it is passed as the first parameter
    // for allowed tags
    if ((string)$child) {
      switch($childName) {
        case 'comments':
          return;
        case 'marker':
        case 'data':
        case 'file':
        case 'template':
          $attributes = array_merge(array((string)$child), $attributes);
          break;
        case 'foreach':
          // Saves the reference index
          $referenceIndex = $this->referenceIndex;

          // Processes the attributes
          if (is_array($attributes[0])) {
            $this->setreferenceArray($childName, $this->referenceId, $attributes[0]);                   	
          	foreach ($attributes[0] as $key => $attribute) {
              $this->setreferenceArray('each', $this->referenceId, $key);         
              $this->referenceIndex = $key;                         
              foreach($child->children() as $subChild){            	
                $this->processChild($subChild);
              }                       
            }
          }
          
          // Resets the reference index
          $this->referenceIndex = $referenceIndex;

          return;
      }
    }

    // Includes required file if any
    if (array_key_exists($childName, $this->requireArray)) {
      $requiredFiles = explode(',', $this->requireArray[$childName]);
      foreach($requiredFiles as $requiredFile) {
        require_once(JP_maindir . $requiredFile);
      }
    }
  
    if (!$this->existsInReferenceArray($childName, $this->referenceId) || $this->referenceIndex !== false) {	
    	$className = 'Tx_SavJpgraph_XmlParser_Xml' . ucfirst($childName) . 'Tag';
    	if (!class_exists($className)) {
    		$className = $childName;
    	}
      $newObject = $this->createObject($className, $attributes);
      $this->setReferenceArray($childName, $this->referenceId, $newObject, $this->referenceIndex);

      // Calls the method setReferenceId if any
      if (method_exists($newObject, 'setReference')) {
        $newObject->setReference($this->referenceId, $this);
        $newObject->defaultMethod();
      }
    } else {
    	 switch($childName) {    	
        case 'marker':
        case 'data':
        case 'file':
        case 'template':
		    	$className = 'Tx_SavJpgraph_XmlParser_Xml' . ucfirst($childName) . 'Tag';
		    	if (!class_exists($className)) {
		    		$className = $childName;
		    	}
		      $newObject = $this->createObject($className, $attributes);
		    	if (method_exists($newObject, 'setReference')) {
		        $newObject->setReference($this->referenceId, $this);
		      }      
		      break;
      default:
      	  $newObject = $this->getReferenceArray($childName, $this->referenceId);
    	 }        	    	
    }

    // Processes the child
    $this->processElement($child, $newObject);
  }

	/**
	 * Processes the xml graph
	 *
	 * @param none
	 *
	 * @return none
	 */
	public function processXmlGraph() {

		foreach ($this->xml->children() as $child) {
      $this->referenceIndex = false;
      $this->processChild($child);
		}		
  }

	/**
	 * Processes delayed methods
	 *
	 * @param none
	 *
	 * @return none
	 */
	public function processDelayedMethods() {
		$delayedMethods = $this->referenceArray['delayedMethods'];
		if (is_array($delayedMethods)) {
			foreach ($delayedMethods as $delayedMethod) {
	      $this->processMethod($delayedMethod['method'], $delayedMethod['attributes']);
	    }
		}
  }

	/**
	 * Adds the xml prologue
	 *
	 * @param $xmlString string xml string
	 *
	 * @return string
	 */
  public function addXmlPrologue($xmlString) {

    $out = '<?xml version="1.0" encoding="utf-8"?>
      <jpgraph>
      ' . $xmlString . '
      </jpgraph>';

    return $out;
  }

	/**
	 * Replaces special characters
	 *
	 * @param string $data
	 *
	 * @return string
	 */
  public static function replaceSpecialChars($data) {
    $data = str_replace('\r', chr(13), $data);
    $data = str_replace('\n', chr(10), $data);
    $data = str_replace('\t', chr(9), $data);

    return $data;
  }
  
}

?>
