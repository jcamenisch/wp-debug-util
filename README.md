WpDebugUtil WordPress Plugin
============================

Poke around the WordPress environment from the comfort of your Javascript console. Everything in here is pretty dangerous, and not for use in production.

Installation
------------

First, download into your plugins directory via your server's shell prompt:

```sh
cd /path/to/Wordpress/plugins/directory
git clone git://github.com/jcamenisch/wp-debug-util.git
```

Then activate the plugin via the WordPress admin panel.

Usage
-----

First, log in to your WordPress site as an administrator. Because of the dangerous
nature of the functions in this plugin, they will not work for a non-admin user.

From any Page in WordPress, open the JavaScript console in your browser of choice.
From there, enter the following commands to interact with the server-side WordPress
environment.

### WpDebug.eval(phpStatements);

Send any PHP code to the server, where it will be run with `eval`. With this, you can
create, edit, and delete data, modify the session—and anything else that you could do
from PHP code in WordPress.

Known issue: PHP's eval seems to have a funny way of handling quote characters. I've
noticed the following raises a parse error:

```javascript
WpDebug.eval("unset($_SESSION['a_key']);");
```

However the following works fine:

```javascript
WpDebug.eval("unset($_SESSION[a_key]);");
```

### WpDebug.print_r(phpExpression);

Send a PHP expression to the server, where it will be evaluated with `eval` and then
output with print_r. The result is then displayed in the console.
