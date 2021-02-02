<?html
/*
Plugin Name: Tiny Buddha Quotes
Plugin URI: http://tinybuddha.com/quote-widget/
Description: Get Tiny Buddha quotes delivered daily to your website.
Version: 1.0
Author: Tiny Buddha
Author URI: http://tinybuddha.com/
License: GPL2

Coded by http://www.problogdesign.com/

    Copyright 2011 TinyBuddha.com

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
 * Register the new widget.
 */
add_action('widgets_init', 'tb_widgets_register');

function tb_widgets_register() {
	register_widget('TB_Wisdom');
}

/**
 * Add the stylesheet to the site.
 */
if(!is_admin() )
	wp_enqueue_style(
		'tinybuddha',
		WP_PLUGIN_URL . '/tiny-buddha-quotes/tinybuddha.css',
		array(),
		'1.0',
		'screen'
	);


/**
 * Create the widget.
 */
class TB_Wisdom extends WP_Widget {
	
	//
	// Construct the widget
	//
	function TB_Wisdom() {
		// Widget settings
		$widget_ops = array(
			'classname' => 'tb-wisdom',
			'description' => 'Embed tiny wisdom.'
		);

		// Create the widget.
		$this->WP_Widget('tb-wisdom', 'Tiny Buddha Quotes', $widget_ops);
	}

	//
	// Widget ouput
	//
	function widget($args, $instance) {
		extract($args);

		// Get the settings
		$formatting = $instance['formatting'];
		
		if($formatting)
			echo $before_widget;
		
			// Create the widget box.
			tb_wisdom_view();
		
		if($formatting)
			echo $after_widget;
	}

	//
	// Update the settings
	//
	function update($new_instance, $old_instance) {
		$instance = $old_instance;

		/* Get the new value. */
		$instance['formatting'] = strip_tags($new_instance['formatting']);

		return $instance;
	}

	//
	// Settings form for the widget
	//
	function form($instance) {

		/* Set up some default widget settings. */
		$defaults = array('formatting' => false );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<!-- Display widget formatting? : Checkbox -->
		<p>
			<input class="checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'formatting' ); ?>" name="<?php echo $this->get_field_name( 'formatting' ); ?>" value="display" <?php if($instance['formatting']) { echo 'checked="checked" '; } ?>/> 
			<label for="<?php echo $this->get_field_id( 'formatting' ); ?>"> Display widget formatting?</label>
		</p>

	<?php
	}
}

/**
 * Create the HTML for the widget and output it.
 */
function tb_wisdom_view() { ?>	
	<div id="tinybuddha">
		<p><?php echo tb_get_wisdom(); ?></p>
		<a href="http://tinybuddha.com/" title="Simple wisdom for complex lives." id="tb-logo" target="_blank">Tiny Buddha</a>
		<a href="http://tinybuddha.com/quote-widget/" title="Get this widget." id="tb-get" target="_blank">Get</a>
	</div>
<?php }


/**
 * Get a quote. If our cached quote is out of date, fetch a new one.
 * @return String. The quote.
 */
function tb_get_wisdom() {

	// Configuration
	$fileURL = 'http://tinybuddha.com/wp-content/plugins/tiny-buddha-host/wisdom.txt';
	$transName = 'tiny-buddha-wisdom'; // Name of value in database.
	$cacheTime = 60 * 24; // Time in minutes between updates.
	
	// Do we already have a saved commenter?
	$wisdom = get_transient($transName);
	 
	// If not, lets get one.
	if($wisdom === false) :
	
		// Use wp_remote_get to get the text file with the quote.
		$file = wp_remote_get($fileURL);
		
		// Get the text from the file.
		if(!is_wp_error($response) ) {
			// We got the file.
			$wisdom = $file['body'];
			
			// Sanitize, just to be sure.
			$wisdom = esc_attr($wisdom);
			
			// Save our new transient.
			set_transient($transName, $wisdom, 60 * $cacheTime);
			
		} else {
			// It failed, so use a sample quote and try again in 10 minutes!
			// Let's give them a quote about patience. :D
			
			$wisdom = '"If you are patient in one moment of anger, you will escape one hundred days of sorrow." -Chinese Proverb';
			
			// Save our new transient for a shorter time.
			set_transient($transName, $wisdom, 60 * 10);
		}
		 
	endif;
	
	// Now send back the result.
	return $wisdom;
}


?>
