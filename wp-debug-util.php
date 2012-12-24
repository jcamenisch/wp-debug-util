<?php
/*
Plugin Name: WpDebugUtil
Plugin URI: http://github.com/jcamenisch/wp-debug-util
Description: Poke around the WordPress environment from the comfort of your Javascript console. Everything in here is pretty dangerous, and not for use in production.
Author: Jonathan Camenisch
Version: 0.2
Author URI: http://github.com/jcamenisch/
*/

add_action('init', 'WpDebugUtil::init');

class WpDebugUtil {
  public static function init() {
    if (current_user_can('update_core')) {

      add_action('wp_ajax_wp-debug-util-eval', 'WpDebugUtil::do_eval');
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

  public static function request($key) {
    return stripslashes($_REQUEST[$key]);
  }

  /**
   * Evals PHP statement(s) provided in $_POST['code']
   * and immediately exits.
   *
   * (designed to be called via WordPress ajax action,
   * and doesn't make much sense in other contexts.)
   *
   * Only works if logged in user has 'update_core' capability; This function
   * would otherwise be very dangerous!
   *
   * @return undefined Only echoes to browser (or buffer, as the case may be).
   */
  public static function do_eval() {
    header("Content-Type: text/plain");

    if (current_user_can('update_core')) {
      if(isset($_REQUEST['code'])) {
        echo "\nEvaling: " . self::request('code') . "\n";
        eval(self::request('code'));
      }
      else echo 'No code provided';
    }

    exit;
  }

  /**
   * Evaluates PHP expression provided in $_POST['code']
   * Outputs result with print_r
   * and immediately exits.
   *
   * (designed to be called via WordPress ajax action,
   * and doesn't make much sense in other contexts.)
   *
   * Only works if logged in user has 'update_core' capability; This function
   * would otherwise be very dangerous!
   *
   * @return undefined Only echoes to browser (or buffer, as the case may be).
   */
  public static function print_r() {
    header("Content-Type: text/plain");

    if (current_user_can('update_core')) {
      if(isset($_REQUEST['code']))   print_r(eval('return ' . self::request('code') . ';'));
      else                           echo 'No code provided';
    }

    exit;
  }
}
