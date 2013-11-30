<?php
/*
Plugin Name: Team Portfolio
Plugin URI: http://to be determined
Description: A brief description of the Plugin.
Version: The Plugin's Version Number, e.g.: 1.0
Author: Name Of The Plugin Author
Author URI: http://URI_Of_The_Plugin_Author
License:
    Copyright 2013  Adam Visser  (email : adamvissers@gmail.com )

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA



Side Note: We always Love OOP but not always OP.

Execution setup:
1. include all of the library files (once)
2. call any library file initializers
3. ????
4. profit
*/
if ( ! defined( 'BBROKENDOOR_BASE_FILE' ) )
    define( 'BBROKENDOOR_BASE_FILE', __FILE__ );
if ( ! defined( 'BROKENDOOR_BASE_DIR' ) )
    define( 'BROKENDOOR_BASE_DIR', dirname( BBROKENDOOR_BASE_FILE ) );
if ( ! defined( 'BROKENDOOR_PLUGIN_URL' ) )
    define( 'BROKENDOOR_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once('skillposts.php');
require_once('projectposts.php');
require_once('portfoliotags.php');
require_once('memeberposts.php');
require_once('portfoliowidgets.php');
function portfolio_page_template( $template_path ) {
    if ( get_post_type() == 'projects' ) {
        if ( is_single() ) {
            if ( $theme_file = locate_template( array( 'single-projects.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) .'single-projects.php';
            }
        }
    }else if ( get_post_type() == 'members' ) {
        if ( is_single() ) {
            if ( $theme_file = locate_template( array( 'single-members.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) .'single-members.php';
            }
        }
    }else if ( get_post_type() == 'skills' ) {
        if ( is_single() ) {
            if ( $theme_file = locate_template( array( 'single-skills.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) .'single-skills.php';
            }
        }
    }
    return $template_path;
}

add_filter( 'template_include', 'portfolio_page_template', 1 );
//that should be all that this file has to handle
?>