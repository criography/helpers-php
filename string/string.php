<?php


/**
 * strtocamel
 *
 * transforms a string into a camel case with optionally 1st character as lowercase
 *
 * @param string $str String to be parsed
 * @param bool $firstLower Should first character be lowercase?
 * @return string camelCased string
 * @todo create a helper or whatever you normally do with Nudge.
 */

function strtocamel($str, $firstLower=true){
	$output = '';

	if(is_string($str) && !empty($str)){
		$output = preg_replace( '/(\s|-|_)+/', '', ucwords($str) );
		if($firstLower){
			$output[0] = strtolower($output[0]);
		}
	}

	return $output;
}









/**
 * wrap_words_in_spans
 * --------------------------------------------------
 * Wraps each word in span and optionally gives it a class
 * @param string  $str      Text to process
 * @param bool    $addClass Should class attribute be added?
 * @return string processed string
 */

function wrap_words_in_spans($str, $addClass=false){
	$output = false;

	if(!empty($str)){
		$str = explode(' ', preg_replace('/(\s+?)/m', ' ', trim($str)));
		$output = '';

		foreach($str as $n=>$word){
			$output.= '<span'.($addClass ? ' class="word-'.($n+1).'"' : '').'>'.$word.'</span> ';
		}


	}

	return $output;

}






/**
 * wrap_chars_in_spans
 * --------------------------------------------------
 * parses string and wraps each letter in span with iterated class
 *
 * @param string $string Text to be parsed
 * @return string wrapped string
 */
	function wrap_chars_in_spans($str=''){
		$output = false;

		if($str){
			$output = '';
			$str = str_split($str);
			foreach($str as $k=>$v){
				$output.='<span class="chr-'. ($k+1) .'">'. $v .'</span>';
			}
		}

		return $output;
	}











/**
 * remove_widows
 * --------------------------------------------------
 * parses string and replaces last space with non-breaking
 *
 * @param string $string Text to be parsed
 * @return string dewidowed string
 */

	function remove_widows($string){
		$string = trim($string);

		$pos = strrpos($string, ' ');

		return ($pos !== false) ? substr_replace($string, '&nbsp;', $pos, 1) : $string;
	}

