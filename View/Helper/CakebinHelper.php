<?php
App::import('Vendor', 'Geshi');
App::uses('AppHelper', 'View/Helper');
App::uses('Hash', 'Utility');

class CakebinHelper extends AppHelper {
	
	var $helpers = array('Text');

	var $Geshi;
	
	function init($lang = 'php') {
		$this->Geshi = new Geshi(null, null);
		$this->Geshi->set_language($lang);
	}
	function htmldecode($string) {
		$patterns = array("&amp;", "&#37;", "&lt;", "&gt;", "&quot;", "&#39;", "&#40;", "&#41;", "&#43;", "&#45;");
		$replacements = array("&", "%", "<", ">", '"', "'", "(", ")", "+", "-");
		$string = str_replace($patterns, $replacements, $string);
		return html_entity_decode($string);
	}
	function format($source = null) {
		$this->Geshi->set_source($this->htmldecode($source));
		$this->Geshi->set_header_type(GESHI_HEADER_DIV);
		$this->Geshi->enable_line_numbers(GESHI_FANCY_LINE_NUMBERS, 2);
		$this->Geshi->set_tab_width('4');
		$this->Geshi->set_footer_content('Parsed in <TIME> seconds,  using GeSHi <VERSION>');
		$this->Geshi->set_footer_content_style('font-family: Verdana, Arial, sans-serif; color: #808080; font-size: 70%; font-weight: bold; background-color: #f0f0ff; border-top: 1px solid #d0d0d0; padding: 2px;');
		return $this->Geshi->parse_code();
	}
	
	function get_stylesheet() {
		$this->Geshi->enable_classes();
		return $this->Geshi->get_stylesheet();
	}
	function aList($array) {
		if(!empty($array)) {
			$array = Hash::extract($array, '{n}.name');
			if(!empty($array)) {
				asort($array);
				return $this->Text->toList(array_values($array));
			}
		}
		return false;
	}
}
