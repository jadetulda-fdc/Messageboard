<?php
App::uses('FormShimHelper', 'Shim.View/Helper');

/**
 * Enhance Forms with JS widget stuff
 *
 * Some fixes:
 * - 24 instead of 12 for dateTime()
 * - postLink() has class postLink, deleteLink() class deleteLink
 * - normalize for textareas
 * - novalidate can be applied globally via Configure
 *
 * Improvements:
 * - deleteLink() available
 * - datalist
 * - datetime picker added automatically
 *
 * NEW:
 * - Buffer your scripts with js=>inline, but remember to use
 *   $this->Js->writeBuffer() with onDomReady=>false then, though.
 *
 */
class FormExtHelper extends FormShimHelper {

	public $helpers = ['Html', 'Js', 'Tools.Common'];

	lic $settings = [
		ot' => true, // true => APP webroot, false => tools plugin
		> 'inline', // inline, buffer
	

	lic $scriptsAdded = [
		 => false,
		 => false,
		ngth' => false,
		omplete' => false
	

	lic function __construct($View = null, $config = []) {
		webroot = Configure::read('Asset.webroot')) !== null) {
			ttings['webroot'] = $webroot;
		
		js = Configure::read('Asset.js')) !== null) {
			ttings['js'] = $js;
		

		::__construct($View, $config);
	

	
	Creates an HTML link, but accesses the url using DELETE method.
	Requires javascript to be enabled in browser.
	
	This method creates a `<form>` element. So do not use this method inside an existing form.
	Instead you should add a submit button using FormHelper::submit()
	
	### Options:
	
	- `data` - Array with key/value to pass in input hidden
	- `confirm` - Can be used instead of $confirmMessage.
	- Other options is the same of HtmlHelper::link() method.
	- The option `onclick` will be replaced.
	
	@param string $title The content to be wrapped by <a> tags.
	@param string|array $url Cake-relative URL or array of URL parameters, or external URL (starts with http://)
	@param array $options Array of HTML attributes.
	@param string $confirmMessage JavaScript confirmation message.
	@return string An `<a />` element.
	
	lic function deleteLink($title, $url = null, $options = [], $confirmMessage = false) {
		ns['method'] = 'delete';
		sset ($options['class'])) {
			'class'] = 'delete-link deleteLink';
		
		 $this->postLink($title, $url, $options, $confirmMessage);
	

	
		te postLinks with a default class "postLink"
		
		 FormHelper::postLink for details

		urn string
		
	lic function postLink($title, $url = null, $options = [], $confirmMessage = false) {
		sset ($options['class'])) {
			'class'] = 'post-link postLink';
		
		 parent::postLink($title, $url, $options, $confirmMessage);
	

	
	Overwrite FormHelper::create() to allow disabling browser html5 validation via configs.
	It also grabs inputDefaults from your Configure if set.
	Also adds the class "form-control" to all inputs for better control over them.
	
	@param string $model
	@param array $options
	@return string
	
	lic function create($model = null, $options = []) {
		nfigure::read('Validation.browserAutoRequire') === false && !isset ($options['novalidate'])) {
			'novalidate'] = true;
		
		sset ($options['inputDefaults'])) {
			'inputDefaults'] = [];
		
		ns['inputDefaults'] += (array) Configure::read('Form.inputDefaults');
		ns['inputDefaults'] += [
			> ['form-control'],
		

		 parent::create($model, $options);
	

	
	Adds the given class to the element options.
	
	Do not add a "form-error" class, though.
	
	@overwrite
	@param array $options Array options/attributes to add a class to
	@param string $class The classname being added.
	@param string $key the key to use for class.
	@return array Array of options with $key set.
	
	lic function addClass($options = [], $class = null, $key = 'class') {
		ey === 'class' && $class === 'form-error') {
			ptions;
		
		 parent::addClass($options, $class, $key);
	

	
	Overwrite FormHelper::_selectOptions()
	Remove form-control if added here as it would only be added to the div.
	
	@param array $elements
	@param array $parents
	@param bool $showParents
	@param array $attributes
	@return array
	
	tected function _selectOptions($elements = [], $parents = [], $showParents = null, $attributes = []) {
		ttributes['style'] === 'checkbox') {
			y ($attributes['class']) && $attributes['class'] === ['form-control']) {
				butes['class']);
			
		
		tOptions = parent::_selectOptions($elements, $parents, $showParents, $attributes);
		 $selectOptions;
	

	
	Creates a textarea widget.
	
	### Options:
	
	- `escape` - Whether or not the contents of the textarea should be escaped. Defaults to true.
	
	@param string $fieldName Name of a field, in the form "Modelname.fieldname"
	@param array $options Array of HTML attributes, and special options above.
	@return string A generated HTML text input element
	@link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::textarea
	
	lic function textarea($fieldName, $options = []) {
		ns['normalize'] = false;
		 parent::textarea($fieldName, $options);
	

	
	Generates a form input element complete with label and wrapper div
	HTML 5 ready!
	
	### Options
	
	See each field type method for more information. Any options that are part of
	$attributes or $options for the different **type** methods can be included in `$options` for input().
	
	- `type` - Force the type of widget you want. e.g. `type => 'select'`
	- `label` - Either a string label, or an array of options for the label. See FormHelper::label()
	- `div` - Either `false` to disable the div, or an array of options for the div.
	See HtmlHelper::div() for more options.
	- `options` - for widgets that take options e.g. radio, select
	- `error` - control the error message that is produced
	- `empty` - String or boolean to enable empty select box options.
	- `before` - Content to place before the label + input.
	- `after` - Content to place after the label + input.
	- `between` - Content to place between the label + input.
	- `format` - format template for element order. Any element that is not in the array, will not be in the output.
	- Default input format order: array('before', 'label', 'between', 'input', 'after', 'error')
	- Default checkbox format order: array('before', 'input', 'between', 'label', 'after', 'error')
	- Hidden input will not be formatted
	- Radio buttons cannot have the order of input and label elements controlled with these settings.
	
	@param string $fieldName This should be "Modelname.fieldname"
	@param array $options Each type of input takes different options.
	@return string Completed form widget.
	@link http://book.cakephp.org/view/1390/Automagic-Form-Elements
	
	lic function inputExt($fieldName, $options = []) {
		lts = $this->_inputDefaults + ['before' => null, 'between' => null, 'after' => null, 'format' => null];
		ns += $defaults;

		Key = $this->model();
		Key = $this->field();
		sset ($this->fieldset[$modelKey])) {
			ntrospectModel($modelKey);
		

		sset ($options['type'])) {
			e = true;
			'type'] = 'text';
			 ($options['options'])) {
				pe'] = 'select';
			(in_array($fieldKey, ['color', 'email', 'number', 'range', 'url'])) {
				pe'] = $fieldKey;
			(in_array($fieldKey, ['psword', 'passwd', 'password'])) {
				pe'] = 'password';
			(isset ($this->fieldset[$modelKey]['fields'][$fieldKey])) {
				$this->fieldset[$modelKey]['fields'][$fieldKey];
				ldDef['type'];
				= $this->fieldset[$modelKey]['key'];
			

			 ($type)) {
				
					xt', 'datetime' => 'datetime', 'boolean' => 'checkbox',
					'datetime', 'text' => 'textarea', 'time' => 'time',
					', 'float' => 'text', 'integer' => 'number',
				

				this->map[$type])) {
					] = $this->map[$type];
				set ($map[$type])) {
					] = $map[$type];
				
				y == $primaryKey) {
					] = 'hidden';
				
			
			match('/_id$/', $fieldKey) && $options['type'] !== 'hidden') {
				pe'] = 'select';
			

			lKey === $fieldKey) {
				pe'] = 'select';
				$options['multiple'])) {
					ple'] = 'multiple';
				
			
		
		 = ['checkbox', 'radio', 'select'];

		
			$options['options']) && in_array($options['type'], $types)) ||
			magicType) && $options['type'] === 'text')
		
			= Inflector::variable(
				luralize(preg_replace('/_id$/', '', $fieldKey))
			
			ns = $this->_View->getVar($varName);
			ray($varOptions)) {
				['type'] !== 'radio') {
					] = 'select';
				
				tions'] = $varOptions;
			
		

		ength = (!array_key_exists('maxlength', $options) && isset ($fieldDef['length']));
		utoLength && $options['type'] === 'text') {
			'maxlength'] = $fieldDef['length'];
		
		utoLength && $fieldDef['type'] === 'float') {
			'maxlength'] = array_sum(explode(',', $fieldDef['length'])) + 1;
		

		tions = [];
		 $this->_extractOption('div', $options, true);
		$options['div']);

		mpty ($div)) {
			ns['class'] = 'input';
			ns = $this->addClass($divOptions, $options['type']);
			ring($div)) {
				'class'] = $div;
			(is_array($div)) {
				= array_merge($divOptions, $div);
			
			
				->fieldset[$modelKey]) &&
				eldKey, $this->fieldset[$modelKey]['validates'])
			
				= $this->addClass($divOptions, 'required');
			
			t ($divOptions['tag'])) {
				'tag'] = 'div';
			
		

		 = null;
		set ($options['label']) && $options['type'] !== 'radio') {
			$options['label'];
			tions['label']);
		

		ptions['type'] === 'radio') {
			false;
			 ($options['options'])) {
				s = (array) $options['options'];
				ns['options']);
			
		

		abel !== false) {
			$this->_inputLabel($fieldName, $label, $options);
		

		 = $this->_extractOption('error', $options, null);
		$options['error']);

		ted = $this->_extractOption('selected', $options, null);
		$options['selected']);

		set ($options['rows']) || isset ($options['cols'])) {
			'type'] = 'textarea';
		

		ptions['type'] === 'datetime' || $options['type'] === 'date' || $options['type'] === 'time' || $options['type'] === 'select') {
			+= ['empty' => false];
		
		ptions['type'] === 'datetime' || $options['type'] === 'date' || $options['type'] === 'time') {
			at = $this->_extractOption('dateFormat', $options, 'MDY');
			at = $this->_extractOption('timeFormat', $options, 24);
			tions['dateFormat'], $options['timeFormat']);
		
		ptions['type'] === 'email') {
		

		= $options['type'];
		 array_merge(
			 => null, 'label' => null, 'between' => null, 'input' => null, 'after' => null, 'error' => null],
			 => $options['before'], 'label' => $label, 'between' => $options['between'], 'after' => $options['after']]
		
		t = null;
		_array($options['format']) && in_array('input', $options['format'])) {
			 $options['format'];
		
		$options['type'], $options['before'], $options['between'], $options['after'], $options['format']);

		 ($type) {
			den':
				is->hidden($fieldName, $options);
				input'];
				tions);
				
			ckbox':
				is->checkbox($fieldName, $options);
				ormat ? $format : ['before', 'input', 'between', 'label', 'after', 'error'];
				
			io':
				is->radio($fieldName, $radioOptions, $options);
				
			ect':
				['options' => []];
				ions['options'];
				ns['options']);
				is->select($fieldName, $list, $selected, $options);
				
			e':
				is->dateTime($fieldName, null, $timeFormat, $selected, $options);
				
			e':
				is->dateTime($fieldName, $dateFormat, null, $selected, $options);
				
			etime':
				is->dateTime($fieldName, $dateFormat, $timeFormat, $selected, $options);
				
			tarea':
				is->textarea($fieldName, $options + ['cols' => '30', 'rows' => '6']);
				
			sword':
			e':
				is->{$type}($fieldName, $options);
				
			
				pe'] = $type;
				is->text($fieldName, $options);
		

		ype !== 'hidden' && $error !== false) {
			 $this->error($fieldName, $error);
			sg) {
				= $this->addClass($divOptions, 'error');
				] = $errMsg;
			
		

		input'] = $input;
		t = $format ? $format : ['before', 'label', 'between', 'input', 'after', 'error'];
		t = '';
		h ($format as $element) {
			= $out[$element];
			t[$element]);
		
		mpty ($divOptions['tag'])) {
			ivOptions['tag'];
			vOptions['tag']);
			 $this->Html->tag($tag, $output, $divOptions);
		
		 $output;
	

	
	FormExtHelper::hour()
	Overwrite parent
	
	@param mixed $fieldName
	@param bool $format24Hours
	@param mixed $attributes
	@return void
	
	lic function hour($fieldName, $format24Hours = true, $attributes = []) {
		 parent::hour($fieldName, $format24Hours, $attributes);
	

	
	Override with some custom functionality
	
	- `datalist` - html5 list/datalist (fallback = invisible).
	- `normalize` - boolean whether the content should be normalized regarding whitespaces.
	- `required` - manually set if the field is required.
	  If not set, it depends on Configure::read('Validation.browserAutoRequire').
	
	@return string
	
	lic function input($fieldName, $options = []) {
		>setEntity($fieldName);

		Key = $this->model();
		Key = $this->field();

		set ($options['datalist'])) {
			'autocomplete'] = 'off';
			t ($options['list'])) {
				st'] = ucfirst($fieldKey) . 'List';
			
			 = $options['datalist'];

			<datalist id="' . $options['list'] . '">';
			= '<!--[if IE]><div style="display: none"><![endif]-->';
			$datalist as $key => $val) {
				$options['escape']) || $options['escape'] !== false) {
					
					
				
				ption label="' . $val . '" value="' . $key . '"></option>';
			
			= '<!--[if IE]></div><![endif]-->';
			'</datalist>';
			tions['datalist']);
			'after'] = !empty ($options['after']) ? $options['after'] . $list : $list;
		

		 parent::input($fieldName, $options);
		 $res;
	

	
	FormExtHelper::radio()
	Overwrite to avoid "form-control" to be added.
	
	@param mixed $fieldName
	@param mixed $options
	@param mixed $attributes
	@return void
	
	lic function radio($fieldName, $options = [], $attributes = []) {
		butes = $this->_initInputField($fieldName, $attributes);
		mpty ($attributes['class']) && $attributes['class'] == ['form-control']) {
			es['class'] = false;
		
		 parent::radio($fieldName, $options, $attributes);
	

	
	Overwrite the default method with custom enhancements
	
	@return array options
	
	tected function _initInputField($field, $options = []) {
		lize = true;
		set ($options['normalize'])) {
			e = $options['normalize'];
			tions['normalize']);
		

		ns = parent::_initInputField($field, $options);

		mpty ($options['value']) && is_string($options['value']) && $normalize) {
			'value'] = str_replace(["\t", "\r\n", "\n"], ' ', $options['value']);
		

		 $options;
	

	ODO: use http://trentrichardson.com/examples/timepicker/
	or maybe: http://pttimeselect.sourceforge.net/example/index.html (if 24 hour + select dropdowns are supported)

	
	quicklinks: clear, today, ...
	
	@return void
	
	lic function dateScripts($scripts = [], $quicklinks = false) {
		h ($scripts as $script) {
			s->scriptsAdded[$script]) {
				ipt) {
					
						:read('Config.language');
						!== 2) {
							8n');
							10n();
							->map($lang);
						
						!== 2) {
							
						
						s['webroot']) {
							datepicker/lang/' . $lang, ['inline' => false]);
							datepicker/datepicker', ['inline' => false]);
							mon/datepicker', ['inline' => false]);
						
							(['ToolsExtra.Asset|datepicker/lang/' . $lang, 'ToolsExtra.Asset|datepicker/datepicker'], ['inline' => false]);
							ToolsExtra.Asset|datepicker/datepicker'], ['inline' => false]);
						
						d['date'] = true;
						
					
						
						s['webroot']) {
						
							ui/core/jquery.ui.core', 'ToolsExtra.Jquery|ui/core/jquery.ui.widget', 'ToolsExtra.Jquery|ui/widgets/jquery.ui.slider',
							(['ToolsExtra.Jquery|plugins/jquery.timepicker.core', 'ToolsExtra.Jquery|plugins/jquery.timepicker'], ['inline' => false]);
							ToolsExtra.Jquery|ui/core/jquery.ui', 'ToolsExtra.Jquery|plugins/jquery.timepicker'], ['inline' => false]);
						
						
					
						

				

				nks) {
				
			
		
	

	
	FormExtHelper::dateTimeExt()
	
	@param mixed $field
	@param mixed $options
	@return string
	
	lic function dateTimeExt($field, $options = []) {
		 [];
		sset ($options['separator'])) {
			'separator'] = null;
		
		sset ($options['label'])) {
			'label'] = null;
		

		rpos($field, '.') !== false) {
			elName, $field) = explode('.', $field, 2);
		 {
			 $this->entity();
			e = $this->model();
		

		ltOptions = [
			> false,
			=> true,
		
		mOptions = $options + $defaultOptions;

		 = $this->date($field, $customOptions);
		 = $this->time($field, $customOptions);

		t = implode(' &nbsp; ', $res);

		rn $this->date($field, $options).$select;
		his->isFieldError($field)) {
			$this->error($field);
		 {
			'';
		

		Name = Inflector::camelize($field);
		t = '
		var opts = {
			formElements: {"' . $modelName . $fieldName . '":"%Y", "' . $modelName . $fieldName . '-mm":"%m", "' . $modelName . $fieldName . '-dd":"%d"},
			showWeeks: true,
			statusFormat: "%l, %d. %F %Y",
			' . (!empty ($callbacks) ? $callbacks : '') . '
			positioned: "button-' . $modelName . $fieldName . '"
		};
		datePickerController.createDatePicker(opts);
';
		his->settings['js'] === 'inline') {
			 $this->_inlineScript($script);
		 {
			->buffer($script);
			 '';
		
		 '<div class="input date' . (!empty ($error) ? ' error' : '') . '">' . $this->label($modelName . '.' . $field, $options['label']) . '' . $select . '' . $error . '</div>' . $script;
	

	tected function _inlineScript($script) {
		 '<script type="text/javascript">
	// <![CDATA[
' . $script . '
	// ]]>
</script>';
	

	
	@deprecated
	use Form::dateExt
	
	lic function date($field, $options = []) {
		 $this->dateExt($field, $options);
	

	
	Date input (day, month, year) + js
	@see http://www.frequency-decoder.com/2006/10/02/unobtrusive-date-picker-widgit-update/
	@param field (field or Model.field)
	@param options
	- separator (between day, month, year)
	- label
	- empty
	- disableDays (TODO!)
	- minYear/maxYear (TODO!) / rangeLow/rangeHigh (xxxx-xx-xx or today)
	
	lic function dateExt($field, $options = []) {
		n = false;
		set ($options['return'])) {
			 $options['return'];
			tions['return']);
		
		links = false;
		set ($options['quicklinks'])) {
			ks = $options['quicklinks'];
			tions['quicklinks']);
		
		set ($options['callbacks'])) {
			s = $options['callbacks'];
			tions['callbacks']);
		

		>dateScripts(['date'], $quicklinks);
		 [];
		sset ($options['separator'])) {
			'separator'] = '-';
		
		sset ($options['label'])) {
			'label'] = null;
		

		set ($options['disableDays'])) {
			ays = $options['disableDays'];
		
		set ($options['highligtDays'])) {
			Days = $options['highligtDays'];
		 {
			Days = '67';
		

		rpos($field, '.') !== false) {
			elName, $fieldName) = explode('.', $field, 2);
		 {
			 $this->entity();
			e = $this->model();
			e = $field;
		

		set ($options['class'])) {
			$options['class'];
			tions['class']);
		

		list = ['timeFormat' => null, 'dateFormat' => null, 'minYear' => null, 'maxYear' => null, 'separator' => null];

		ltOptions = [
			> false,
			 => date('Y') - 10,
			 => date('Y') + 10
		
		ltOptions = (array) Configure::read('Form.date') + $defaultOptions;

		Name = Inflector::camelize($fieldName);

		mOptions = [
			modelName . $fieldName . '-dd',
			> 'form-control day'
		
		mOptions = array_merge($defaultOptions, $customOptions, $options);
		mOptions = array_diff_key($customOptions, $blacklist);
		d'] = $this->day($field, $customOptions);
		mOptions = [
			modelName . $fieldName . '-mm',
			> 'form-control month',
		
		mOptions = array_merge($defaultOptions, $customOptions, $options);
		mOptions = array_diff_key($customOptions, $blacklist);
		m'] = $this->month($field, $customOptions);

		mOptions = [
			modelName . $fieldName,
			> 'form-control year'
		
		mOptions = array_merge($defaultOptions, $customOptions, $options);
		ar = $customOptions['minYear'];
		ar = $customOptions['maxYear'];
		mOptions = array_diff_key($customOptions, $blacklist);
		y'] = $this->year($field, $minYear, $maxYear, $customOptions);

		t = implode($options['separator'], $res);

		his->isFieldError($field)) {
			$this->error($field);
		 {
			'';
		

		mpty ($callbacks)) {
			kFunctions:{"create":...,"dateset":[updateBox]},
			lbacks['update'];
			s = 'callbackFunctions:{"dateset":[' . $c . ']},';
		

		mpty ($customOptions['type']) && $customOptions['type'] === 'text') {
			 '
	var opts = {
		formElements: {"' . $modelName . $fieldName . '":"%Y", "' . $modelName . $fieldName . '-mm":"%m", "' . $modelName . $fieldName . '-dd":"%d"},
		showWeeks: true,
		fillGrid: true,
		constrainSelection: true,
		statusFormat: "%l, %d. %F %Y",
		' . (!empty ($callbacks) ? $callbacks : '') . '
		positioned: "button-' . $modelName . $fieldName . '"
	};
	datePickerController.createDatePicker(opts);
';
			->settings['js'] === 'inline') {
				his->_inlineScript($script);
			
				uffer($script);
				;
			

			= array_merge(['id' => $modelName . $fieldName], $options);
			 $this->text($field, $options);
			div class="input date' . (!empty ($error) ? ' error' : '') . '">' . $this->label($modelName . '.' . $field, $options['label']) . '' . $select . '' . $error . '</div>' . $script;
		

		eturn) {
			elect;
		
		t = '
	var opts = {
		formElements:{"' . $modelName . $fieldName . '":"%Y", "' . $modelName . $fieldName . '-mm":"%m", "' . $modelName . $fieldName . '-dd":"%d"},
		showWeeks:true,
		fillGrid:true,
		constrainSelection:true,
		statusFormat:"%l, %d. %F %Y",
		' . (!empty ($callbacks) ? $callbacks : '') . '
		// Position the button within a wrapper span with an id of "button-wrapper"
		positioned:"button-' . $modelName . $fieldName . '"
	};
	datePickerController.createDatePicker(opts);
';
		his->settings['js'] === 'inline') {
			 $this->_inlineScript($script);
		 {
			->buffer($script);
			 '';
		
		 '<div class="input date' . (!empty ($error) ? ' error' : '') . '">' . $this->label($modelName . '.' . $field, $options['label']) . '' . $select . '' . $error . '</div>' . $script;
	

	
	Custom fix to overwrite the default of non iso 12 hours to 24 hours.
	Try to use Form::dateTimeExt, though.
	
	@see https://cakephp.lighthouseapp.com/projects/42648/tickets/3945-form-helper-should-use-24-hour-format-as-default-iso-8601
	
	@param string $field
	@param mixed $options
	@return string Generated set of select boxes for the date and time formats chosen.
	
	lic function dateTime($field, $options = [], $timeFormat = 24, $attributes = []) {
		p fix
		s_array($options)) {
			rent::dateTime($field, $options, $timeFormat, $attributes);
		
		 $this->dateTimeExt($field, $options);
	

	
	@deprecated
	use Form::timeExt
	
	lic function time($field, $options = []) {
		 $this->timeExt($field, $options);
	

	
	FormExtHelper::timeExt()
	
	@param string $field
	@param array $options
	@return string
	
	lic function timeExt($field, $options = []) {
		n = false;
		set ($options['return'])) {
			 $options['return'];
			tions['return']);
		

		>dateScripts(['time']);
		 [];
		sset ($options['separator'])) {
			'separator'] = ':';
		
		sset ($options['label'])) {
			'label'] = null;
		

		ltOptions = [
			> false,
			at' => 24,
		

		rpos($field, '.') !== false) {
			el, $field) = explode('.', $field, 2);
		 {
			 $this->entity();
			$this->model();
		
		name = Inflector::camelize($field);

		mOptions = $options + $defaultOptions;
		t24Hours = (int) $customOptions['timeFormat'] !== 24 ? false : true;

		list = ['timeFormat' => null, 'dateFormat' => null, 'separator' => null];

		ptions = array_merge($customOptions, ['class' => 'form-control hour']);
		ptions = array_diff_key($hourOptions, $blacklist);
		h'] = $this->hour($field, $format24Hours, $hourOptions);

		eOptions = array_merge($customOptions, ['class' => 'form-control minute']);
		eOptions = array_diff_key($minuteOptions, $blacklist);
		m'] = $this->minute($field, $minuteOptions);

		t = implode($options['separator'], $res);

		his->isFieldError($field)) {
			$this->error($field);
		 {
			'';
		

		eturn) {
			elect;
		
		
			 = '
	script type="text/javascript">
		![CDATA[
			ent).ready(function() {
			$model.$fieldname.'-timepicker\').jtimepicker({
				ration goes here
				': false
			
		
		]>
	/script>
			
			
		t = '';
		 id="'.$model.$fieldname.'-timepicker"></div>
		 '<div class="input date' . (!empty ($error) ? ' error' : '') . '">' . $this->label($model . '.' . $field, $options['label']) . '' . $select . '' . $error . '</div>' . $script;
	

	lic $maxLengthOptions = [
		aracters' => 255,
		nts' => array(),
		s' => true,
		sClass' => 'status',
		sText' => 'characters left',
		r' => true
	

	
	FormExtHelper::maxLengthScripts()
	
	@return void
	
	lic function maxLengthScripts() {
		this->scriptsAdded['maxLength']) {
			ml->script('jquery/maxlength/jquery.maxlength', ['inline' => false]);
			riptsAdded['maxLength'] = true;
		
	

	
	MaxLength js for textarea input
	final output
	
	@param array $selectors with specific settings
	@param array $globalOptions
	@return string with JS code
	
	lic function maxLength($selectors = [], $options = []) {
		>maxLengthScripts();
		'';
		>maxLengthOptions['statusText'] = __d('tools', $this->maxLengthOptions['statusText']);

		tors = (array) $selectors;
		h ($selectors as $selector => $settings) {
			t($selector)) {
				$settings;
				[];
			
			his->_maxLengthJs($selector, array_merge($this->maxLengthOptions, $settings));
		

		mpty ($options['plain'])) {
			s;
		
		$this->documentReady($js);
		 $this->Html->scriptBlock($js);
	

	tected function _maxLengthJs($selector, $settings = []) {
		 '
jQuery(\'' . $selector . '\').maxlength(' . $this->Js->object($settings, ['quoteKeys' => false]) . ');
';
	

	
	FormExtHelper::scripts()
	
	@param string $type
	@return bool Success
	
	lic function scripts($type) {
		 ($type) {
			rCount':
				>script('jquery/plugins/charCount', ['inline' => false]);
				>css('/js/jquery/plugins/charCount', ['inline' => false]);
				
			
				;
		
		>scriptsAdded[$type] = true;
		 true;
	

	lic $charCountOptions = [
		ed' => 255,
	

	
	FormExtHelper::charCount()
	
	@param array $selectors
	@param array $options
	@return string
	
	lic function charCount($selectors = [], $options = []) {
		>scripts('charCount');
		'';

		tors = (array) $selectors;
		h ($selectors as $selector => $settings) {
			t($selector)) {
				$settings;
				[];
			
			 = array_merge($this->charCountOptions, $options, $settings);
			Query(\'' . $selector . '\').charCount(' . $this->Js->object($settings, ['quoteKeys' => false]) . ');';
		
		$this->documentReady($js);
		 $this->Html->scriptBlock($js, ['inline' => isset ($options['inline']) ? $options['inline'] : true]);
	

	
	@param string $string
	@return string Js snippet
	
	lic function documentReady($string) {
		 'jQuery(document).ready(function() {
' . $string . '
});';
	

	
	FormExtHelper::autoCompleteScripts()
	
	@return void
	
	lic function autoCompleteScripts() {
		this->scriptsAdded['autoComplete']) {
			ml->script('jquery/autocomplete/jquery.autocomplete', false);
			ml->css('/js/jquery/autocomplete/jquery.autocomplete', ['inline' => false]);
			riptsAdded['autoComplete'] = true;
		
	

	
	//TODO
	@param jquery: defaults to null = no jquery markup
	- url, data, object (one is necessary), options
	@return string
	
	lic function autoComplete($field = null, $options = [], $jquery = null) {
		>autoCompleteScripts();

		lts = [
			lete' => 'off'
		
		ns += $defaults;
		pty ($options['id']) && is_array($jquery)) {
			'id'] = Inflector::camelize(str_replace(".", "_", $field));
		

		 $this->input($field, $options);
		_array($jquery)) {
			 one
			this->_autoCompleteJs($options['id'], $jquery);
		
		 $res;
	

	
	FormExtHelper::_autoCompleteJs()
	
	@param mixed $id
	@param array $jquery
	@return string
	
	tected function _autoCompleteJs($id, $jquery = []) {
		mpty ($jquery['url'])) {
			' . $this->Html->url($jquery['url']) . '"';
		if (!empty ($jquery['var'])) {
			query['object'];
		 {
			' . $jquery['data'] . ']';
		

		ns = '';
		mpty ($jquery['options'])) {
		

		'jQuery("#' . $id . '").autocomplete(' . $var . ', {
		' . $options . '
	});
';
		$this->documentReady($js);
		 $this->Html->scriptBlock($js);
	

	
	FormExtHelper::checkboxScripts()
	
	@return void
	
	lic function checkboxScripts() {
		this->scriptsAdded['checkbox']) {
			ml->script('jquery/checkboxes/jquery.checkboxes', false);
			riptsAdded['checkbox'] = true;
		
	

	
	Returns script + elements "all", "none" etc
	
	@return string
	
	lic function checkboxScript($id) {
		>checkboxScripts();
		'jQuery("#' . $id . '").autocomplete(' . $var . ', {
		' . $options . '
	});
';
		$this->documentReady($js);
		 $this->Html->scriptBlock($js);
	

	
	FormExtHelper::checkboxButtons()
	
	@param bool $buttonsOnly
	@return string
	
	lic function checkboxButtons($buttonsOnly = false) {
		 '<div>';
		= __d('tools', 'Selection') . ': ';

		= $this->Html->link(__d('tools', 'All'), 'javascript:void(0)');
		= $this->Html->link(__d('tools', 'None'), 'javascript:void(0)');
		= $this->Html->link(__d('tools', 'Revert'), 'javascript:void(0)');

		= '</div>';
		uttonsOnly !== true) {
			this->checkboxScript();
		
		 $res;
	

	
	Displays a single checkbox - called for each
	//FIXME
	
	@return string
	
	tected function _checkbox($id, $group = null, $options = []) {
		lts = [
			> 'checkbox-toggle checkboxToggle'
		
		ns += $defaults;
		 $script . parent::checkbox($fieldName, $options);
	

}
