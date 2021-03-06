# Weather plugin for glFusion
Copyright (C) 2011-2021 by Lee Garner  lee@leegarner.com

The Weather plugin allows you to integrate weather informationwith other
plugins such as Locator and Evlist. As of version 2.0.0 there is no longer
a public-facing page for users to look up weather. All access is via API
calls.

The Weather plugin requires either Curl support or `allow_url_fopen` set in php.ini.

## Providers
#### Weatherstack
The free plan only provides for current weather. See https://weatherstack.com
to sign up for a free API key.

#### OpenWeather
Visit https://openweathermap.org/api to sign up for a free API key.
  * Current and forecast weather
  * Free Plan Limits: 60 calls/minute

#### Weather Unlocked
Visit https://developer.weatherunlocked.com/ to sign up for a free API key.
  * Current and forecast weather
  * Free Plan Limits: 75 calls/minute, 25000 calls/month

#### Weatherstack
Visit https://weatherstack.com/product to sign up for a plan.
  * Current and forecast weather
  * Free Plan Limits: 1000 calls/month

## Deprecated Providers
As of version 2.0.0, the following providers have been deprecated as they
are no longer available:
  * Weather Underground
  * World Weather Online

## Administration
There is no administration interface provided other than a link to purge the cache.

## API Usage
To get an embeddable eather widget, call
```PLG_invokeService('weather', 'embed', $args_array, $ouput_var, $svc_msg);
```
The argument array may contain the following elements:
  * `lat` : The location's latitude coordinate
  * `lng` : The location's longitude coordinate
  * `street` : Street address
  * `city` : City name
  * `province` : State or Province name
  * `country` : ISO-3166-1 2-letter Country Code
  * `postal` : Postal code

If both Latitude and Longitude are present then they will generally be used. Otherwise a query will be created from the address fields depending on the weather provider. If not provided, the configured default country will be included for disambiguation.
