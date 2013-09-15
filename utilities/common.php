<?php


/**
 * cgy_or
 * --------------------------------------------------
 * equivalent of JS's a||b||c returns first nonempty value
 *
 * @param mixed $arg array or comma separated argument list: all arguments
 * @return string or number
 */

function cgy_or(){
	$args = func_get_args();
	return current(array_filter( is_array($args[0]) ? $args[0] : $args ));
}


