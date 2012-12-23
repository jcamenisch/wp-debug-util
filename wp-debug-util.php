<?php
/*
Plugin Name: WpDebugUtil
Plugin URI: http://github.com/jcamenisch/wp-debug-util
Description: Debugging utilities for WordPress development
Author: Jonathan Camenisch
Version: 0.1
Author URI: http://github.com/jcamenisch/
*/

add_action('init', 'WpDebugUtil::init');

class WpDebugUtil {
  public static function init() {
    if (current_user_can('update_core')) {

      add_action('wp_ajax_wp-debug-util-print_r', 'WpDebugUtil::print_r');

      wp_register_script('wp-debug-util',
        plugins_url(
          preg_replace('/php$/', 'js', plugin_basename(__FILE__))
        )
      );
      wp_enqueue_script('wp-debug-util');

      add_action('wp_footer', 'WpDebugUtil::wp_footer');
    }
  }

  public static function wp_footer() {
    ?>
      <script>
        WpDebug.ajax_url = '<?php echo admin_url("admin-ajax.php"); ?>';
      </script>
    <?php
  }

  public static function print_r() {
    header("Content-Type: text/plain");

    if(isset($_POST['code'])) {
      print_r(eval('return ' . $_POST['code'] . ';'));
    } else {
      echo 'No code provided';
    }

    exit;
  }
}
