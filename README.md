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
FlTools.calc_tod    /calc_tod         // Top Of Descent Calculation page

```

Usage example with module [Disposable Basic (By FatihKoz)](https://github.com/FatihKoz/DisposableBasic "Disposable Basic :: Github") on nav_menu.blade.php;

```php

{{-- FlightTools --}}
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
      <i class="fas fa-screwdriver-wrench {{ $icon_style }}"></i>
      FlightTools
    </a>
    <ul class="dropdown-menu {{ $border }}" aria-labelledby="offcanvasNavbarDropdown">
      <li>
        <a class="dropdown-item" href="{{ route('FlTools.calc_trl') }}" title="@lang('FlTools::tools.CalcTrl_menu')">
          <i class="fas fa-calculator {{ $icon_style }}"></i>
          @lang('FlTools::tools.CalcTrl_menu')
        </a>
      </li>
      <li>
        <a class="dropdown-item" href="{{ route('FlTools.calc_tod') }}" title="@lang('FlTools::tools.CalcTod_menu')">
          <i class="fas fa-calculator {{ $icon_style }}"></i>
          @lang('FlTools::tools.CalcTod_menu')
        </a>
      </li>
    </ul>
  </li>

```

## Use of Tools

## Calculate Transition Level

Enter the Qnh as well as the transition altitude of an airport, 
click on calculate... and the tool will calculate and return the transition level

## Calculate Top Of Descent

Enter the current flight level, desired flight level, and ground speed during descent. Then, click calculate... and the tool will compute and return the distance to the Top of Descent and the required vertical speed to reach the desired flight level.

Enter you

## License Compatibility & Attribution Link

As per the license, **addon name should be always visible in all Tools footer**. And link **SHOULD BE** always visible.

```html
Enhanced by <a href="https://aircotedivoirevirtuel.com/" target="_blank"><strong>ACIV</strong></a>

```
_Not providing attribution link will result in removal of access and no support is provided afterwards._

## Release / Update Notes

22.JUN.24
* Fix Typo
* Add new tool : Calculate ToD

21.JUN.24

* Add menu title Calculate Trl (multi-Lang)

20.JUN.24

* Update README.md
* adding of request data validation rule

16.JUN.24

* Correct Use of Tools (Calculate Transition Level)
* Initial Release