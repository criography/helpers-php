<?php

/**
 * drop_single_body_class
 * --------------------------
 * Removes 'single' class from the body and replaces it with 'singular'
 *
 * @param array $classes all body classes
 * @return modified class array
 */

    function drop_single_body_class( $classes )
    {

        /* add singular class */
        if( is_singular() && !is_home() && !is_page_template('showcase.php') && !is_page_template('sidebar-page.php') )
            $classes[ ] = 'singular';

        /* remove single class */
        if( $key = array_search('single', $classes) )
        {
            unset( $classes[ $key ] );
        }

        return $classes;
    }

    add_filter('body_class', 'drop_single_body_class');