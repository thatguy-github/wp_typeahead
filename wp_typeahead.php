<?php
/**
 * Plugin Name: wp_typeahead
 * Plugin URI: https://ethereal.ai
 * Description: Plugin to add a wp_typeahead to your WordPress site
 * Version: 1.0.00
 * Author URI:
 * License: GPL2
 */

function typeahead_search() {
  $query = $_POST['query'];

  // Perform the necessary search based on the user's input
  // and return the suggestions as a JSON response
  $suggestions = array('Suggestion 1', 'Suggestion 2', 'Suggestion 3');
  wp_send_json($suggestions);
}
add_action('wp_ajax_typeahead_search', 'typeahead_search');
add_action('wp_ajax_nopriv_typeahead_search', 'typeahead_search');

function typeahead_enqueue_scripts() {
  // Enqueue the necessary scripts with dependencies
  wp_enqueue_script('jquery');
  wp_enqueue_script('bootstrap-js', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.min.js', array('jquery'), '4.6.0', true);
  wp_enqueue_script('typeahead-js', 'https://cdnjs.cloudflare.com/ajax/libs/corejs-typeahead/1.3.1/typeahead.bundle.min.js', array('jquery', 'bootstrap-js'), '0.11.1', true);
  wp_enqueue_script('wp-typeahead-js', plugin_dir_url(__FILE__) . 'typeahead.js', array('jquery', 'typeahead-js', 'bootstrap-js'), '1.0.0', true);

  // Localize the AJAX URL for use in the JavaScript file
  wp_localize_script('wp-typeahead-js', 'typeaheadAjax', array(
    'ajaxurl' => admin_url('admin-ajax.php'),
    'action' => 'typeahead_search'
  ));
}
add_action('wp_enqueue_scripts', 'typeahead_enqueue_scripts');

function typeahead_shortcode() {
    ob_start(); // Start output buffering
    ?>
    <div class="input-group search">
                            <input type="search" class="form-control search-input" placeholder="Type to search">
      <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="button">search</button>
      </div>
                        </div>
    <?php
    return ob_get_clean(); // Return the shortcode content
}
add_shortcode('typeahead', 'typeahead_shortcode');

function your_plugin_enqueue_styles() {
    wp_enqueue_style( 'your-plugin-styles', plugins_url( 'wp_typeahead.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'your_plugin_enqueue_styles' );

