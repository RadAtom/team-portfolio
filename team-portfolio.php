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
require_once ('library-admin-pages.php');
require_once ('library-database-mapper.php');
require_once ('library-plugin-settings.php');
require_once ('library-plugin-tags');

team_portfolio_adamin_pages_initialize();
team_portfolio_database_mapper_initialize();
team_portfolio_plugin_settings_initialize();
team_portfolio_plugin_tags_initialize();

//that should be all that this file has to handle
?>