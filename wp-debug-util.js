WpDebug = {
  do: function(action, data, success) {
    jQuery.ajax({
      type:    'POST',
      url:     WpDebug.ajax_url,
      data:    _.extend(data, {action: 'wp-debug-util-' + action}),
      success: success,
      error:   WpDebug.error
    });
  },
  error: function() {
    if (!WpDebug.errors) Baddger.errors = [];

    WpDebug.errors.push(arguments);
  },
  print_r: function(code) {
    WpDebug.do('print_r', {code: code},
      function(data) {
        console.log(data);
      }
    );
  }
}
