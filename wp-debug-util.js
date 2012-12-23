WpDebug = {
  ajax_action: function(action, data) {
    jQuery.ajax({
      type:    'POST',
      url:     WpDebug.ajax_url,
      data:    _.extend(data, {action: 'wp-debug-util-' + action}),
      success: function(data) {
        console.log(data);
      },
      error:   WpDebug.error
    });
  },
  error: function() {
    if (!WpDebug.errors) Baddger.errors = [];

    WpDebug.errors.push(arguments);
  },
  print_r: function(code) {
    WpDebug.ajax_action('print_r', {code: code});
  },
  eval: function(code) {
    WpDebug.ajax_action('eval', {code: code});
  }
}
