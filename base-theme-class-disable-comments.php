<?php
/*
+----------------------------------------------------------------------
| Copyright (c) 2018,2019,2020 Genome Research Ltd.
| This is part of the Wellcome Sanger Institute extensions to
| wordpress.
+----------------------------------------------------------------------
| This extension to Worpdress is free software: you can redistribute
| it and/or modify it under the terms of the GNU Lesser General Public
| License as published by the Free Software Foundation; either version
| 3 of the License, or (at your option) any later version.
|
| This program is distributed in the hope that it will be useful, but
| WITHOUT ANY WARRANTY; without even the implied warranty of
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
| Lesser General Public License for more details.
|
| You should have received a copy of the GNU Lesser General Public
| License along with this program. If not, see:
|     <http://www.gnu.org/licenses/>.
+----------------------------------------------------------------------

# Author         : js5
# Maintainer     : js5
# Created        : 2018-02-09
# Last modified  : 2018-02-12

 * @package   BaseThemeClass/CoAuthorPlus
 * @author    JamesSmith james@jamessmith.me.uk
 * @license   GLPL-3.0+
 * @link      https://jamessmith.me.uk/base-theme-class/
 * @copyright 2018 James Smith
 *
 * @wordpress-plugin
 * Plugin Name: Website Base Theme Class - Disable comments
 * Plugin URI:  https://jamessmith.me.uk/base-theme-class-disable-comments/
 * Description: Enabling this plugin disables comments in Wordpress
 * Version:     0.1.0
 * Author:      James Smith
 * Author URI:  https://jamessmith.me.uk
 * Text Domain: base-theme-class-locale
 * License:     GNU Lesser General Public v3
 * License URI: https://www.gnu.org/licenses/lgpl.txt
 * Domain Path: /lang
*/

namespace BaseThemeClass;

class DisableComments {
  var $self;

  function __construct( $self ) {
    $this->self = $self;
    add_action( 'admin_menu',                 [ $this,      'remove_comments_sidebar'  ] );
    add_action( 'admin_bar_menu',             [ $this,      'remove_comments_adminbar' ], PHP_INT_MAX-1 );
    add_filter( 'manage_edit-post_columns',   [ $this,      'remove_comments_column'   ], 10, 1 );
    add_filter( 'manage_edit-page_columns',   [ $this,      'remove_comments_column'   ], 10, 1 );
    register_activation_hook( __FILE__,       [ __CLASS__,  'deactivate_comments'      ] );
  }

  function remove_comments_adminbar( $wp_admin_bar ) {
    $wp_admin_bar->remove_menu('comments');
  }

  function deactivate_comments() {
    update_option( 'default_comment_status', '' );
    update_option( 'default_ping_status',    '' );
    update_option( 'default_pingback_flag',  '' );
  }

  // Remove comments from post/page listings...
  function remove_comments_sidebar() {
    $this->self->remove_sidebar_entry('edit-comments.php');
  }

  // Remove comments from post/page listings...
  function remove_comments_column($columns) {
    unset($columns['comments']);
    return $columns;
  }
}