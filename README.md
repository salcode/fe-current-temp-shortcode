# Current Temperature WordPress Shortcode

This WordPress plugin adds the shortcode `[fe_current_temp]` to display the current temperature at a given Latitude and Longitude using the Dark Sky API and WordPress transients.

## API Key for Dark Sky API Required

This project needs an API Key for the Dark Sky API. They offer a free level of their API.

### Step 1: Get an API Key

Go to the [Dark Sky API](https://darksky.net/dev/) page and sign up for an API key. The API key will be an alphanumeric string that looks something like

```
abcdefghi1234567890jklmnopqrstuv
```

### Step 2: Set the Dark Sky API Key in wp-config.php

In `wp-config.php` add a line like the following:

```
define( 'FE_DARK_SKY_API', 'abcdefghi1234567890jklmnopqrstuv' );
```

replacing `abcdefghi1234567890jklmnopqrstuv` with the API key you got in Step 1.

## Author

[Sal Ferrarello](https://salferrarello.com) / [@salcode](https://twitter.com/salcode)
