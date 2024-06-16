# FlightTool

phpVMS v7 module for useful VA tools

* Module supports **only** php8.1+ and laravel10
* Minimum required phpVMS v7 version is `phpVms 7.0.0-dev+240524.84ecc6` / 24.MAY.2024
* _php8.0 and laravel9 compatible latest version: v3.3.1_
* _php7.4 and laravel8 compatible latest version: v3.0.19_

Module blades are designed for themes using **Bootstrap v5.x** and **FontAwesome v6.x** icons.

This module pack contains the following tools;

* Transition Level Calculation (real calculation based on QNH and Transition Altitude)


## Compatibility with other addons

This addon is fully compatible with phpVMS v7 and it will work with any other addon, specially acars softwares which are %100 compatible with phpVMS v7 too.  

## Installation and Updates

* Manual Install : Upload contents of the package to your phpvms root `/modules` folder via ftp or your control panel's file manager
* GitHub Clone : Clone/pull repository to your phpvms root `/modules/FlightTools` folder
* PhpVms Module Installer : Go to admin -> addons/modules , click Add New , select downloaded file then click Add Module
*
* Go to admin > addons/modules enable the module
* Go to admin > maintenance and clean `application` cache

:information_source: *There is a known bug in v7 core, which causes an error/exception when enabling/disabling modules manually. If you see a server error page or full stacktrace debug window when you enable a module just close that page and re-visit admin area in a different browser tab/window. You will see that the module is enabled and active, to be sure just clean your `application` cache*

# Module links and routes

The module does not provide automatic links to your phpvms theme, so below you will find the routes and the respective URL of each tool.

Named Routes and Url's

```php
FlTools.calc_trl    /calc_trl         // Transition Level Calculation page

```

Usage examples;

```html
<a class="nav-link" href="{{ route('FlTools.calc_trl') }}" title="Calculate_Trl">
  Calculate Trl
  <i class="fas fa-calculator mx-1"></i>
</a>

```

## Use of Tools

## Calculate Transition Level

Module offers below endpoints for API Access with authorization, so data can be placed on landing pages easily. Check module admin page to define your service key, which is needed for authorization.


## License Compatibility & Attribution Link

As per the license, **addon name should be always visible in all Tools footer**. And link **SHOULD BE** always visible.

```html
Enhanced by <a href="https://aircotedivoirevirtuel.com/" target="_blank"><strong>ACIV</strong></a>

```
_Not providing attribution link will result in removal of access and no support is provided afterwards._

## Release / Update Notes

16.JUN.24

* Initial Release