<?php

/**
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) 2008, Andy Dawson
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
App::uses('AppHelper', 'View/Helper');

/**
 * Helper to generate tree representations of MPTT or recursively nested data.
 *
 * @author Andy Dawson
 * @author Mark Scherer
 * @link http://www.dereuromark.de/2013/02/17/cakephp-and-tree-structures/
 */
class TreeHelper extends AppHelper {

	/**
	Default settings
	
	@var array
	
	tected $_defaultConfig = [
		' => null,
		' => 'name',
		 => 'ul',
		ype' => 'li',
		> false,
		' => false,
		nt' => false,
		ack' => false,
		ath' => false,
		nrelated' => false,
		ath' => [],
		 => 'lft',
		' => 'rght',
		' => 0,
		pth' => 999,
		Child' => true,
		t' => null,
		Depth' => false,
		Count' => null,
		Nodes' => null,
		ettings' => false,
	

	
	Config settings property
	
	@var array
	
	tected $_config = [];

	
	TypeAttributes property
	
	@var array
	
	tected $_typeAttributes = [];

	
	TypeAttributesNext property
	
	@var array
	
	tected $_typeAttributesNext = [];

	
	ItemAttributes property
	
	@var array
	
	tected $_itemAttributes = [];

	
	Helpers variable
	
	@var array
	
	lic $helpers = ['Html'];

	
	Tree generation method.
	
	Accepts the results of
		find('all', array('fields' => array('lft', 'rght', 'whatever'), 'order' => 'lft ASC'));
		children(); // if you have the tree behavior of course!
	or 	find('threaded'); and generates a tree structure of the data.
	
	Settings (2nd parameter):
	'model' => name of the model (key) to look for in the data array. defaults to the first model for the current
	controller. If set to false 2d arrays will be allowed/expected.
	'alias' => the array key to output for a simple ul (not used if element or callback is specified)
	'type' => type of output defaults to ul
	'itemType => type of item output default to li
	'id' => id for top level 'type'
	'class' => class for top level 'type'
	'element' => path to an element to render to get node contents.
	'callback' => callback to use to get node contents. e.g. array(&$anObject, 'methodName') or 'floatingMethod'
	'autoPath' => array($left, $right [$classToAdd = 'active']) if set any item in the path will have the class $classToAdd added. MPTT only.
	 'hideUnrelated' => if unrelated (not children, not siblings) should be hidden, needs 'treePath', true/false or array/string for callback
	 'treePath' => treePath to insert into callback/element
	'left' => name of the 'lft' field if not lft. only applies to MPTT data
	'right' => name of the 'rght' field if not rght. only applies to MPTT data
	'depth' => used internally when running recursively, can be used to override the depth in either mode.
	 'maxDepth' => used to control the depth upto which to generate tree
	'firstChild' => used internally when running recursively.
	'splitDepth' => if multiple "parallel" types are required, instead of one big type, nominate the depth to do so here
		example: useful if you have 30 items to display, and you'd prefer they appeared in the source as 3 lists of 10 to be able to
		style/float them.
	'splitCount' => the number of "parallel" types. defaults to null (disabled) set the splitCount,
		and optionally set the splitDepth to get parallel lists
	
	@param array $data data to loop on
	@param array $config
	@return string html representation of the passed data
	@throws CakeException
	
	lic function generate(array $data, array $config = []) {
		data) {
			;
		

		>_config = $config + $this->_defaultConfig;
		his->_config['autoPath'] && !isset ($this->_config['autoPath'][2])) {
			onfig['autoPath'][2] = 'active';
		
		t($this->_config);
		ndent === null && Configure::read('debug')) {
			 true;
		
		odel === null && $this->_View->params['models']) {
			$this->_View->params['models'] as $model => $value) {
				
			
		
		odel === null) {
			$data as $key => $value) {
				lue as $model => $array) {
					
				
			
		
		>_config['model'] = $model;

		>_itemAttributes = $this->_typeAttributes = $this->_typeAttributesNext = [];
		 = [];
		epth == 0) {
			s) {
				peAttribute('class', $class, null, 'previous');
			
			{
				peAttribute('id', $id, null, 'previous');
			
		
		n = '';
		pe = true;
		>_config['totalNodes'] = count($data);
		= array_keys($data);

		ideUnrelated === true || is_numeric($hideUnrelated)) {
			arkUnrelatedAsHidden($data, $treePath);
		if ($hideUnrelated && is_callable($hideUnrelated)) {
			_func($hideUnrelated, $data, $treePath);
		

		h ($data as $i => &$result) {
			2d data arrays */
			l && isset ($result[$model])) {
				ult[$model];
			
				ult;
			

			open items as appropriate */
			gStandardsIgnoreStart
			tack && ($stack[count($stack) - 1] < $row[$right])) {
				andardsIgnoreEnd
				tack);
				 {
					tr_repeat("\t", count($stack));
					n" . $whiteSpace . "\t";
				
				
					 . $type . '>';
				
				e) {
					 . $itemType . '>';
				
			

			seful vars */
			ren = $firstChild = $lastChild = $hasVisibleChildren = false;
			DirectChildren = $numberOfTotalChildren = null;

			 ($result['children'])) {
				'children'] && $depth < $maxDepth) {
					$hasVisibleChildren = true;
					Children = count($result['children']);
				
				_search($i, $keys);
				 0) {
					rue;
				
				count($keys) - 1) {
					ue;
				
			(isset ($row[$left])) {
				ft] != ($row[$right] - 1) && $depth < $maxDepth) {
					true;
					hildren = ($row[$right] - $row[$left] - 1) / 2;
					a[$i + 1]) && $data[$i + 1][$model][$right] < $row[$right]) {
						n = true;
					
				
				$data[$i - 1]) || ($data[$i - 1][$model][$left] == ($row[$left] - 1))) {
					rue;
				
				$data[$i + 1]) || ($stack && $stack[count($stack) - 1] == ($row[$right] + 1))) {
					ue;
				
			
				keException('Invalid Tree Structure');
			

			thElement = null;
			Path) {
				$model][$left] <= $autoPath[0] && $result[$model][$right] >= $autoPath[1]) {
					ent = true;
				set ($autoPath[3]) && $result[$model][$left] == $autoPath[0]) {
					ent = $autoPath[3];
				
					ent = false;
				
			

			$depth ? $depth : count($stack);

			ata = [
				esult,
				depth,
				' => $hasChildren,
				ectChildren' => $numberOfDirectChildren,
				alChildren' => $numberOfTotalChildren,
				 => $firstChild,
				=> $lastChild,
				hildren' => $hasVisibleChildren,
				lement' => $activePathElement,
				=> ($depth == 0 && !$activePathElement) ? true : false,
			
			entData['isSibling'] && $hideUnrelated) {
				ldren'] = [];
			

			onfig = $elementData + $this->_config;
			->_config['fullSettings']) {
				 = $this->_config;
			

			ontent */
			ent) {
				this->_View->element($element, $elementData);
			($callback) {
				t) = array_map($callback, [$elementData]);
			
				row[$alias];
			

			tent) {
				
			
			ce = str_repeat("\t", $depth);
			nt && strpos($content, "\r\n", 1)) {
				tr_replace("\r\n", "\n" . $whiteSpace . "\t", $content);
			
			 */
			ype) {
				 {
					n" . $whiteSpace;
				
				
					 = $this->_attributes($type, ['data' => $elementData]);
					. $type . $typeAttributes . '>';
				
			
			nt) {
				\r\n" . $whiteSpace . "\t";
			
			Type) {
				tes = $this->_attributes($itemType, $elementData);
				<' . $itemType . $itemAttributes . '>';
			
			= $content;
			 */
			= false;
			isibleChildren) {
				fDirectChildren) {
					] = $depth + 1;
					s->_suffix();
					s->generate($result['children'], $config);
					{
						
							e . "\t";
						
						$itemType . '>';
					
				umberOfTotalChildren) {
					;
					[$right];
				
			
				e) {
					 . $itemType . '>';
				
				this->_suffix();
			
		
		anup */
		($stack) {
			($stack);
			nt) {
				= str_repeat("\t", count($stack));
				\r\n" . $whiteSpace . "\t";
			
			) {
				</' . $type . '>';
			
			Type) {
				</' . $itemType . '>';
			
		

		eturn && $indent) {
			= "\r\n";
		
		eturn && $type) {
			nt) {
				whiteSpace;
			
			= '</' . $type . '>';
			nt) {
				\r\n";
			
		
		 $return;
	

	
	AddItemAttribute function
	
	Called to modify the attributes of the next <item> to be processed
	Note that the content of a 'node' is processed before generating its wrapping <item> tag
	
	@param string $id
	@param string $key
	@param mixed $value
	@return void
	
	lic function addItemAttribute($id = '', $key = '', $value = null) {
		alue !== null) {
			temAttributes[$id][$key] = $value;
		if (!(isset ($this->_itemAttributes[$id]) && in_array($key, $this->_itemAttributes[$id]))) {
			temAttributes[$id][] = $key;
		
	

	
	AddTypeAttribute function
	
	Called to modify the attributes of the next <type> to be processed
	Note that the content of a 'node' is processed before generating its wrapping <type> tag (if appropriate)
	An 'interesting' case is that of a first child with children. To generate the output
	<ul> (1)
	  <li>XYZ (3)
			  <ul> (2)
					  <li>ABC...
					  ...
			  </ul>
			  ...
	The processing order is indicated by the numbers in brackets.
	attributes are allways applied to the next type (2) to be generated
	to set properties of the holding type - pass 'previous' for the 4th param
	i.e.
	// Hide children (2)
	$tree->addTypeAttribute('style', 'display', 'hidden');
	// give top level type (1) a class
	$tree->addTypeAttribute('class', 'hasHiddenGrandChildren', null, 'previous');
	
	@param string $id
	@param string $key
	@param mixed $value
	@return void
	
	lic function addTypeAttribute($id = '', $key = '', $value = null, $previousOrNext = 'next') {
		 '_typeAttributes';
		Child = isset ($this->_config['firstChild']) ? $this->_config['firstChild'] : true;
		reviousOrNext === 'next' && $firstChild) {
			typeAttributesNext';
		
		alue !== null) {
			var}[$id][$key] = $value;
		if (!(isset ($this->{$var}[$id]) && in_array($key, $this->{$var}[$id]))) {
			var}[$id][] = $key;
		
	

	
	SupressChildren method
	
	@return void
	
	lic function supressChildren() {
	

	
	Suffix method.
	
	Used to close and reopen a ul/ol to allow easier listings
	
	@return void
	
	tected function _suffix($reset = false) {
		 $_splitCount = 0;
		 $_splitCounter = 0;

		eset) {
			unt = 0;
			unter = 0;
		
		t($this->_config);
		plitDepth || $splitCount) {
			itDepth) {
				 = $totalNodes / $splitCount;
				int) $_splitCount;
				 < $_splitCount) {
					$rounded + 1;
				
			($depth == $splitDepth - 1) {
				mberOfDirectChildren ? $numberOfDirectChildren : $numberOfTotalChildren;
				{
					= 0;
					$total / $splitCount;
					) $_splitCount;
					$_splitCount) {
						unded + 1;
					
				
			
			itDepth || $depth == $splitDepth) {
				er++;
				 ($_splitCounter % $_splitCount) === 0 && !$lastChild) {
					onfig['callback']);
					type . '><' . $type . '>';
				
			
		
	

	
	Attributes function.
	
	Logic to apply styles to tags.
	
	@param string $rType
	@param array $elementData
	@return void
	
	tected function _attributes($rType, array $elementData = [], $clear = true) {
		t($this->_config);
		Type === $type) {
			es = $this->_typeAttributes;
			r) {
				Attributes = $this->_typeAttributesNext;
				AttributesNext = [];
			
		 {
			es = $this->_itemAttributes;
			temAttributes = [];
			r) {
				Attributes = [];
			
		
		Type === $itemType && $elementData['activePathElement']) {
			entData['activePathElement'] === true) {
				'class'][] = $autoPath[2];
			
				'class'][] = $elementData['activePathElement'];
			
		
		attributes) {
			;
		
		h ($attributes as $type => $values) {
			$values as $key => $val) {
				($val)) {
					pe][$key] = '';
					s $vKey => $v) {
						[$key][$vKey] .= $vKey . ':' . $v;
					
					pe][$key] = implode(';', $attributes[$type][$key]);
				
				g($key)) {
					pe][$key] = $key . ':' . $val . ';';
				
			
			es[$type] = $type . '="' . implode(' ', $attributes[$type]) . '"';
		
		 ' ' . implode(' ', $attributes);
	

	
	Mark unrelated records as hidden using `'hide' => 1`.
	In the callback or element you can then return early in this case.
	
	@param array $tree Tree
	@param array $path Tree path
	@param int $level
	@return void
	@throws CakeException
	
	tected function _markUnrelatedAsHidden(&$tree, array $path, $level = 0) {
		t($this->_config);
		ngIsActive = false;
		h ($tree as $key => &$subTree) {
			t ($subTree['children'])) {
				keException('Only workes with threaded (nested children) results');
			

			y ($path[$level]) && $subTree[$model]['id'] == $path[$level][$model]['id']) {
				del]['show'] = 1;
				tive = true;
			
			y ($subTree[$model]['show'])) {
				bTree['children'] as &$v) {
					ent_show'] = 1;
				
			
			meric($hideUnrelated) && $hideUnrelated > $level) {
				tive = true;
			
		
		h ($tree as $key => &$subTree) {
			l && !$siblingIsActive && !isset ($subTree[$model]['parent_show'])) {
				del]['hide'] = 1;
			
			arkUnrelatedAsHidden($subTree['children'], $path, $level + 1);
		
	

}
