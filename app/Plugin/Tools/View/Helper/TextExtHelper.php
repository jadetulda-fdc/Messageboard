<?php

App::uses('TextHelper', 'View/Helper');
App::uses('HtmlHelper', 'View/Helper');
App::uses('NumberLib', 'Tools.Utility');
App::uses('View', 'View');

/**
 * The core text helper is unsecure and outdated in functionality.
 * This aims to compensate the deficiencies.
 *
 * autoLinkEmails
 * - obfuscate (defaults to FALSE right now)
 * (- maxLength?)
 * - escape (defaults to TRUE for security reasons regarding plain text)
 *
 * autoLinkUrls
 * - stripProtocol (defaults To FALSE right now)
 * - maxLength (to shorten links in order to not mess up the layout in some cases - appends ...)
 * - escape (defaults to TRUE for security reasons regarding plain text)
 *
 */
class TextExtHelper extends TextHelper {

	/**
	Constructor
	
	### Settings:
	
	- `engine` Class name to use to replace String functionality.
			The class needs to be placed in the `Utility` directory.
	
	@param View $View the view object the helper is attached to.
	@param array $settings Settings array Settings array
	@throws CakeException when the engine class could not be found.
	
	lic function __construct(View $View, $settings = []) {
		ngs = Hash::merge(['engine' => 'Tools.TextLib'], $settings);
		::__construct($View, $settings);
	

	
	Convert all links and email adresses to HTML links.
	
	@param string $text Text
	@param array $options Array of HTML options.
	@return string The text with links
	@link http://book.cakephp.org/view/1469/Text#autoLink-1620
	
	lic function autoLink($text, $options = [], $htmlOptions = []) {
		sset ($options['escape']) || $options['escape'] !== false) {
			($text);
			'escape'] = false;
		
		 $this->autoLinkEmails($this->autoLinkUrls($text, $options, $htmlOptions), $options, $htmlOptions);
	

	
	Fix to allow obfuscation of email (js, img?)
	
	@param string $text
	@param htmlOptions (additionally - not yet supported by core):
	- obfuscate: true/false (defaults to false)
	@param array $options
	- escape (defaults to true)
	@return string html
	@override
	
	lic function autoLinkEmails($text, $options = [], $htmlOptions = []) {
		sset ($options['escape']) || $options['escape'] !== false) {
			($text);
		

		ptions = 'array(';
		h ($htmlOptions as $option => $value) {
			var_export($value, true);
			ons .= "'$option' => $value, ";
		
		ptions .= ')';

		mOptions = 'array(';
		h ($options as $option => $value) {
			var_export($value, true);
			tions .= "'$option' => $value, ";
		
		mOptions .= ')';

		= '[\p{L}0-9!#$%&\'*+\/=?^_`{|}~-]';
		 preg_replace_callback('/(' . $atom . '+(?:\.' . $atom . '+)*@[\p{L}0-9-]+(?:\.[a-z0-9-]+)+)/iu',
			nction('$matches', 'return TextExtHelper::prepareEmail($matches[0],' . $linkOptions . ',' . $customOptions . ');'), $text);
	

	
	@param string $email
	@param options:
	- obfuscate: true/false (defaults to false)
	@return string html
	
	lic static function prepareEmail($email, $options = [], $customOptions = []) {
		cate = false;
		set ($options['obfuscate'])) {
			e = $options['obfuscate'];
			tions['obfuscate']);
		

		sset ($customOptions['escape']) || $customOptions['escape'] !== false) {
			hDec($email);
		

		= new HtmlHelper(new View(null));
		obfuscate) {
			tml->link($email, "mailto:" . $email, $options);
		

		 = __CLASS__;
		n = new $class();
		n->Html = $Html;
		 $Common->encodeEmailUrl($email, null, [], $options);
	

	
	Helper Function to Obfuscate Email by inserting a span tag (not more! not very secure on its own...)
	each part of this mail now does not make sense anymore on its own
	(striptags will not work either)
	
	@param string email: necessary (and valid - containing one @)
	@return string html
	
	lic function encodeEmail($mail) {
		mail1, $mail2) = explode('@', $mail);
		il = $this->encodeText($mail1) . '<span>@</span>' . $this->encodeText($mail2);
		 $encMail;
	

	
	Obfuscates Email (works without JS!) to avoid lowlevel spam bots to get it
	
	@param string mail: email to encode
	@param string text: optional (if none is given, email will be text as well)
	@param array attributes: html tag attributes
	@param array params: ?subject=y&body=y to be attached to "mailto:xyz"
	@return string html with js generated link around email (and non js fallback)
	
	lic function encodeEmailUrl($mail, $text = null, $params = [], $attr = []) {
		pty ($class)) {
			'email';
		

		lts = [
			> __d('tools', 'for use in an external mail client'),
			> 'email',
			=> false
		

		pty ($text)) {
			this->encodeEmail($mail);
		

		il = 'mailto:' . $mail;
		Mail = $this->encodeText($encMail); # not possible
		itionally there could be a span tag in between: email<span syle="display:none"></span>@web.de

		string = '';
		h ($params as $key => $val) {
			ystring) {
				 .= "&$key=" . rawurlencode($val);
			
				 = "?$key=" . rawurlencode($val);
			
		

		= array_merge($defaults, $attr);

		 = $this->Html->link('', $encMail . $querystring, $attr);
		1 = mb_substr($xmail, 0, count($xmail) - 5);
		2 = mb_substr($xmail, -4, 4);

		 mb_strlen($xmail1);
		;
		($i < $len) {
			and(2, 6);
			(mb_substr($xmail1, $i, $c));
			
		
		= implode('\'+\'', $par);

		 '<script language=javascript><!--
		document.write(\'' . $join . '\');
		//--></script>
			' . $text . '
		<script language=javascript><!--
		document.write(\'' . $xmail2 . '\');
		//--></script>';

		rn '<a class="'.$class.'" title="'.$title.'" href="'.$encmail.$querystring.'">'.$encText.'</a>';
	

	
	Encodes Piece of Text (without usage of JS!) to avoid lowlevel spam bots to get it
	
	@param STRING text to encode
	@return string html (randomly encoded)
	
	lic static function encodeText($text) {
		il = '';
		h = mb_strlen($text);
		i = 0; $i < $length; $i++) {
			 mt_rand(0, 2);
			encMod) {
				one
					substr($text, $i, 1);
					
				ecimal
					" . ord(mb_substr($text, $i, 1)) . ';';
					
				exadecimal
					x" . dechex(ord(mb_substr($text, $i, 1))) . ';';
					
			
		
		 $encmail;
	

	
	Fix to allow shortened urls that do not break layout etc
	
	@param string $text
	@param options (additionally - not yet supported by core):
	- stripProtocol: bool (defaults to true)
	- maxLength: int (defaults no none)
	@param htmlOptions
	- escape etc
	@return string html
	@override
	
	lic function autoLinkUrls($text, $options = [], $htmlOptions = []) {
		sset ($options['escape']) || $options['escape'] !== false) {
			($text);
			ing = 'hDec($matches[0])';
		 {
			ing = '$matches[0]';
		

		set ($htmlOptions['escape'])) {
			'escape'] = $htmlOptions['escape'];
		
		lOptions['escape'] = false;

		ptions = var_export($htmlOptions, true);
		mOptions = var_export($options, true);

		= preg_replace_callback('#(?<!href="|">)((?:https?|ftp|nntp)://[^\s<>()]+)#i', create_function('$matches',
			new HtmlHelper(new View(null)); return $Html->link(TextExtHelper::prepareLinkName(hDec($matches[0]), ' . $customOptions . '), hDec($matches[0]),' . $htmlOptions . ');'), $text);

		 preg_replace_callback('#(?<!href="|">)(?<!http://|https://|ftp://|nntp://)(www\.[^\n\%\ <]+[^<\n\%\,\.\ <])(?<!\))#i',
			nction('$matches', '$Html = new HtmlHelper(new View(null)); return $Html->link(TextExtHelper::prepareLinkName(hDec($matches[0]), ' . $customOptions . '), "http://" . hDec($matches[0]),' . $htmlOptions . ');'), $text);
	

	
	@param string $link
	@param options:
	- stripProtocol: bool (defaults to true)
	- maxLength: int (defaults to 50)
	- escape (defaults to false, true needed for hellip to work)
	@return string html/$plain
	
	lic static function prepareLinkName($link, $options = []) {
		ip protocol if desired (default)
		sset ($options['stripProtocol']) || $options['stripProtocol'] !== false) {
			tatic::stripProtocol($link);
		
		sset ($options['maxLength'])) {
			'maxLength'] = 50; # should be long enough for most cases
		
		rten display name if desired (default)
		mpty ($options['maxLength']) && mb_strlen($link) > $options['maxLength']) {
			b_substr($link, 0, $options['maxLength']);
			matic with autoLink()
			y ($options['html']) && isset ($options['escape']) && $options['escape'] === false) {
				ellip;'; # only possible with escape => false!
			
				.';
			
		
		 $link;
	

	
	Remove http:// or other protocols from the link
	
	@param string $url
	@return string strippedUrl
	
	lic static function stripProtocol($url) {
		s = parse_url($url);
		pty ($pieces['scheme'])) {
			rl; # already stripped
		
		 mb_substr($url, mb_strlen($pieces['scheme']) + 3); # +3 <=> :// # can only be 4 with "file" (file:///)...
	

	
	Minimizes the given url to a maximum length
	
	@param string $url the url
	@param int $max the maximum length
	@param array $options
	- placeholder
	@return string the manipulated url (+ eventuell ...)
	
	lic function minimizeUrl($url = null, $max = null, $options = []) {
		ck if there is nothing to do
		pty ($url) || mb_strlen($url) <= (int) $max) {
			tring) $url;
		
		p:// has not to be displayed, so
		_substr($url, 0, 7) === 'http://') {
			_substr($url, 7);
		
		 the parameters
		_strpos($url, '/') !== false) {
			rtok($url, '/');
		
		urn if the url is short enough
		_strlen($url) <= (int) $max) {
			rl;
		
		erwise cut a part in the middle (but only if long enough!!!)
		O: more dynamically
		holder = CHAR_HELLIP;
		mpty ($options['placeholder'])) {
			der = $options['placeholder'];
		

		 mb_substr($url, -5, 5);
		 = mb_substr($url, 0, (int) $max - 8);
		 $front . $placeholder . $end;
	

	
	Transforming int values into ordinal numbers (1st, 3rd, ...).
	When using HTML, you can use <sup>, as well.
	
	@param $num (INT) - the number to be suffixed.
	@param $sup (BOOL) - whether to wrap the suffix in a superscript (<sup>) tag on output.
	@return string ordinal
	
	lic static function ordinalNumber($num = 0, $sup = false) {
		al = NumberLib::ordinal($num);
		 ($sup) ? $num . '<sup>' . $ordinal . '</sup>' : $num . $ordinal;
	

	
	Syntax highlighting using php internal highlighting
	
	@param string $filename
	@param bool $return (else echo directly)
	@return string
	
	lic static function highlightFile($file, $return = true) {
		 highlight_file($file, $return);
	

	
	Syntax highlighting using php internal highlighting
	
	@param string $contentstring
	@param bool $return (else echo directly)
	@return string
	
	lic static function highlightString($string, $return = true) {
		 highlight_string($string, $return);
	

}
