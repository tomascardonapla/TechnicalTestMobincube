<?php

namespace App\Classes;

class ToXml {

	private $xml;
	private $element;
	
	public function __construct ()
	{
		$this->xml = new \DomDocument('1.0', 'UTF-8');
        $this->element['root'] = $this->xml->createElement('Document');
        $this->element['root'] = $this->xml->appendChild($this->element['root']);
		
	}

	public function addElement ($name, $parent, $value = '', $index = '') {
		$index != '' ? $name_element = ($name . $index) : $name_element = $name;
		
		$this->element[$name_element] = $this->xml->createElement($name);

		if ($value == '') {
			$this->element[$name_element] = $this->element[$parent]->appendChild($this->element[$name_element]);
		} else {
			$this->element[$name_element] = $this->element[$parent]->appendChild($this->element[$name_element], $value);
		}
	}

	public function addAttributes ($names, $parent, $data) {
        for ($i = 0; $i < count($names); $i++) {
        	$this->addAttribute ($names[$i], $parent, $data[$names[$i]]);
        }
	}

	public function addAttribute ($name, $parent, $value = '') {
        $attr = $this->xml->createAttribute($name);
        $attr = $this->element[$parent]->appendChild($attr);
        $attr_text = $this->xml->createTextNode($value);
        $attr->appendChild($attr_text);

	}

	public function saveXml ($filename) {
		$this->xml->formatOutput = true;
        $strings_xml = $this->xml->saveXML();
	
		$this->xml->save($filename);

        return $filename;
	}
}

?>