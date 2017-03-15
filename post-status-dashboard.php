<?php
/**
 * Plugin Name: Post Status Dashboard
 * Plugin URI: http://www.fuzzguard.com.au/plugins/post-status-dashboard
 * Description: Used to display post status in the admin dashboard
 * Version: 1.3
 * Author: Benjamin Guy
 * Author URI: http://www.fuzzguard.com.au
 * Text Domain: post-status-dashboard
 * License: GPL2

    Copyright 2014-2016  Benjamin Guy  (email: beng@fuzzguard.com.au)

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

*/


/**
* Don't display if wordpress admin class is not found
* Protects code if wordpress breaks
* @since 0.1
*/
if ( ! function_exists( 'is_admin' ) ) {
    header( 'Status: 403 Forbidden' );
    header( 'HTTP/1.1 403 Forbidden' );
    exit();
}



class postStatusDash {

	     public $postStatusOption = 'post_status_dashboard';
	
        /**
        * Loads localization files for each language
        * @since 1.4
        */
        function _action_init()
        {
                // Localization
                load_plugin_textdomain('post-status-dashboard', false, 'post-status-dashboard/lang/');
        }


function post_status_dashboard_widgets() {
        global $wp_meta_boxes;
        wp_add_dashboard_widget('post_status_dashboard', 'Post Status Dashboard', array( $this, 'post_status_dashboard_content' ), array( $this, 'post_status_dashboard_handle' ));
}

function post_status_dashboard_content() {
   # get saved data
    if( !$post_status_dashboard = get_option( $this->postStatusOption ) )
        $post_status_dashboard = array('category' => -1, 'status' => 'any');


    # default output
    $output = sprintf(
        '<h2 style="text-align:right">%s</h2>',
        __( 'Please, configure the widget ?' )
    );
if ($post_status_dashboard['category'] <= 0 ) {
	$category = '';
} else {
	$category = $post_status_dashboard['category'];
}
$posts_array = get_posts(array(
        'posts_per_page'   => 5,
		'category'         => $category,
        'orderby'          => 'post_date',
        'order'            => 'DESC',
        'post_type'        => 'post',
        'post_status'      => $post_status_dashboard['status']
));

                $today    = date( 'Y-m-d', current_time( 'timestamp' ) );
                $tomorrow = date( 'Y-m-d', strtotime( '+1 day', current_time( 'timestamp' ) ) );


    # custom content saved by control callback, modify output
    if( !empty($posts_array) ) {
                $output = '<div class="activity-block"><ul>';
                foreach ( $posts_array as $post ) {

                        $time = strtotime($post->post_date);
                        if ( date( 'Y-m-d', $time ) == $today ) {
                                $relative = __( 'Today' );
                        } elseif ( date( 'Y-m-d', $time ) == $tomorrow ) {
                                $relative = __( 'Tomorrow' );
                        } else {
                                /* translators: date and time format for recent posts on the dashboard, see http://php.net/date */
                                $relative = date_i18n( __( 'M jS' ), $time );
                        }
                        $relative .= ", ".date( 'g:i a' );
                        $output .= '
                        <li>
                                <span style="margin-right: 11px;">'.$relative.'</span>
                                <span class="dashicons dashicons-admin-post"></span>
                                <a href="'.get_home_url().'/?p='.$post->ID.'">'.$post->post_title.'</a>
                                 - <a href="'.get_admin_url().'post.php?post='.$post->ID.'&amp;action=edit">edit</a>
                        </li>';
                }
                $output .= '</ul></div>';
    } else if (empty($posts_array)) {
                    $output = sprintf(
        '<h2 style="text-align:right">%s</h2>',
        __( 'No posts to load' )
    );
        }
    echo "<div class='feature_post_class_wrap'>";
    if (!empty($post_status_dashboard['category'])) {
    	echo "<div class='feature_post_class_wrap'><label><strong>".__('Category', 'post-status-dashboard' ).":</strong> ".get_cat_name($post_status_dashboard['category'])."</label></div>";
    }
    echo "<div class='feature_post_class_wrap'><label><strong>".__('Status', 'post-status-dashboard' ).":</strong> ".$post_status_dashboard['status']."</label></div>
        <label style='background:#ccc;'>$output</label>
    </div>
    ";

}

function post_status_dashboard_handle()
{
    # get saved data
    if( !$post_status_dashboard = get_option( $this->postStatusOption ) )
        $post_status_dashboard = array('category' => -1, 'status' => 'any');



    # process update
    if( 'POST' == $_SERVER['REQUEST_METHOD'] && isset( $_POST['post_status_dashboard'] ) ) {
        # minor validation
        $post_status_dashboard['category'] = absint( $_POST['post_status_dashboard']['category'] );
        $post_status_dashboard['status'] = sanitize_text_field( $_POST['post_status_dashboard']['status'] );
        # save update
        update_option( $this->postStatusOption, $post_status_dashboard );
    }

    # set defaults  
    if( !isset( $post_status_dashboard['category'] ) )
        $post_status_dashboard['category'] = 'All';
		$categories =     wp_dropdown_categories( array(
        	'orderby'            => 'name',
        	'order'              => 'ASC',
        	'selected'         => $post_status_dashboard['category'],
        	'name'             => 'post_status_dashboard[category]',
        	'taxonomy'           => 'category',
    		'show_option_all'    =>  __('All Categories', 'post-status-dashboard'),
    		'hide_empty'         => 1,
			'hide_if_empty'      => 1,
			'echo'				 => 0
    	) );
		$post_status = get_post_stati();
		$post_status['any'] = 'Any';
    echo "<p><strong>".__('Select a options below', 'post-status-dashboard' )."</strong></p>";
	if (!empty($categories)) {
    echo "<div class='feature_post_class_wrap'>
        <label style='display: inline-block; width: 75px;'>".__('Category', 'post-status-dashboard' ).":</label>".$categories."</div>";
	}
    echo" <div class='feature_post_class_wrap'>
        <label style='display: inline-block; width: 75px;'>".__('Status', 'post-status-dashboard' ).":</label>
<select style='margin-left: -2px;' class='postform' id='post_status_dashboard[status]' name='post_status_dashboard[status]'>";
    foreach ($post_status as $key => $value) {
?>
    <option <?php if ($post_status_dashboard['status']==$key) { echo "selected='selected'"; } ?> value='<?php echo $key; ?>' class='level-0'><?php echo $value; ?></option>
<?php
}
echo "</select></div>";
}


}

/**
* Define the Class
* @since 0.1
*/
$mypostStatusDashboard = new postStatusDash();

/**
* Action of what function to call on wordpress initialization
* @since 0.1
*/
add_action('plugins_loaded', array($mypostStatusDashboard, '_action_init'));

/**
* Action of what function to call to display Dashboard Widget
* Register the new dashboard widget with the 'wp_dashboard_setup' action
* @since 0.1
*/
add_action('wp_dashboard_setup', array( $mypostStatusDashboard, 'post_status_dashboard_widgets' ));
?>
