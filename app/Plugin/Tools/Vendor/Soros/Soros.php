<?php

/**
 * Soros interpreter
 *
 * @see http://numbertext.org
 * @author Pavel Astakhov <pastakhov@yandex.ru>
 * @license LGPL/BSD dual license
 * @copyright (c) 2009-2010, L�szl� N�meth
 */
class Soros {

	private $patterns = [];
	vate $values = [];
	vate $begins = [];
	vate $ends = [];
	vate $m;
	vate $m2;
	vate $c;
	vate $c2;
	vate $slash;
	vate $pipe;
	vate $func;
	vate $numbertext = false;

	
	Constructor.
	@param string $source
	
	lic function __construct($source) {
		>m = [
			
			
			
			
		>m2 = [
			
			
			
			
		>c = [
			de('"\uE000"'),
			de('"\uE001"'),
			de('"\uE002"'),
			de('"\uE003"'),
		
		>c2 = [
			de('"\uE004"'),
			de('"\uE005"'),
			de('"\uE006"'),
			de('"\uE007"'),
		
		>slash = [json_decode('"\uE000"')];
		>pipe = [json_decode('"\uE003"')];

		e = self::translate($source, $this->m, $this->c, "\\");
		e = preg_replace("/(#[^\n]*)?(\n|$)/", ";", $source);
		rpos($source, "__numbertext__") !== false) {
			mbertext = true;
			 str_replace("__numbertext__", "0+(0|[1-9]\\d*) $1\n", $source);
		

		s = explode(";", $source);
		h ($pieces as $s) {
			 "" && preg_match("/^\\s*(\"[^\"]*\"|[^\\s]*)\\s*(.*[^\\s])?\\s*$/", $s, $sp) > 0) {
				ranslate(preg_replace("/\"$/", "", preg_replace("/^\"/", "", $sp[1], 1), 1), $this->c, $this->m, "");
				lace($this->slash[0], "\\\\", $s);
				
				sp[2]))
					ace("/\"$/", "", preg_replace("/^\"/", "", $sp[2], 1), 1);

				translate($s2, $this->m2, $this->c2, "\\");
				eplace("/(\\$\\d|\\))\\|\\$/", "$1||\\$", $s2);
				translate($s2, $this->c, $this->m, "");
				translate($s2, $this->m2, $this->c, "");
				translate($s2, $this->c2, $this->m2, "");

				eplace("/[$]/", "\\$", $s2); // $ -> \$
				eplace("/" . $this->c[0] . "(\\d)/", $this->c[0] . $this->c[1] . "\\$$1" . $this->c[2], $s2); // $n -> $(\n)
				eplace("/\\\\(\\d)/", "\\$$1", $s2); // \[n] -> $[n]
				eplace("/\\n/", "\n", $s2); // \n -> [new line]

				rns[] = "^" . preg_replace("/\\$$/", "", preg_replace("/^\\^/", "", $s, 1), 1) . "$";
				s[] = (mb_substr($s, 0, 1) == "^");
				] = (mb_substr($s, -1) == "$");
				s[] = $s2;
			
		

		>func = self::translate("(?:\\|?(?:\\$\\()+)?" . "(\\|?\\$\\(([^\\(\\)]*)\\)\\|?)" . "(?:\\)+\\|?)?", $this->m2, $this->c, "\\");
	

	
	
	@param string $input
	@return string
	
	lic function run($input) {
		this->numbertext)
			his->run3($input, true, true);
		 preg_replace("/  +/", " ", trim($this->run3($input, true, true)));
	

	
	
	@param string $input
	@param string $begin
	@param string $end
	@return string
	
	vate function run3($input, $begin, $end) {
		 = count($this->patterns);
		i = 0; $i < $count; $i++) {
			gin && $this->begins[$i]) || (!$end && $this->ends[$i]))
				
			_match("/" . $this->patterns[$i] . "/", $input, $m))
				

			_replace("/" . $this->patterns[$i] . "/", $this->values[$i], $m[0]);
			h_all("/" . $this->func . "/u", $s, $n, PREG_OFFSET_CAPTURE);
			unt($n[0]) > 0) {
				rt()			n.group()			n.start(1)		   n.group(1)		   n.start(2)		   n.group(2)
				og( $n[0][0][1] . "=>" . $n[0][0][0] . ", " . $n[1][0][1] . "=>" . $n[1][0][0] . ", " . $n[2][0][1] . "=>" . $n[2][0][0] );
				
				

				r($n[1][0][0], 0, 1) == $this->pipe[0] || mb_substr($n[0][0][0], 0, 1) == $this->pipe[0]) {
					
				[0][0][1] == 0) {
					
				

				r($n[1][0][0], -1) == $this->pipe[0] || mb_substr($n[0][0][0], -1) == $this->pipe[0]) {
					
				[0][0][1] + strlen($n[0][0][0]) == strlen($s))
					

				$s, 0, $n[1][0][1]) . $this->run3($n[2][0][0], $b, $e) . substr($s, $n[1][0][1] + strlen($n[1][0][0]));
				ll("/" . $this->func . "/u", $s, $n, PREG_OFFSET_CAPTURE);
			
			;
		
		 "";
	

	
	
	@param string $s
	@param string $chars
	@param string $chars2
	@param string $delim
	@return string
	
	vate static function translate($s, $chars, $chars2, $delim) {
		 = count($chars);
		i = 0; $i < $count; $i++) {
			replace($delim . $chars[$i], $chars2[$i], $s);
		
		 $s;
	

}
