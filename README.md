# Laravel Server Side Google Analytics

This is a simple package that allows you to track Google Analytics page views and
events from your Laravel application.

It was created because I needed a simple way to track these when certain actions
occured server-side or when specific actions were triggered from the frontend
and I din't want to mingle the JavaScript logic with the tracking part.

## Installation

First thing you need to do is require the package using composer.

```
composer require stelianandrei/laravel-server-side-ga
```

Then you need to add the service provider to your `config/app.php` file:

```
  /*
   * Package Service Providers...
   */

  StelianAndrei\LaravelServerSideGA\AnalyticsServiceProvider::class,
```

Also add the Analytics facade to the **aliases** array in the same file:

```
  'Analytics' => StelianAndrei\LaravelServerSideGA\AnalyticsFacade::class,
```

## Tracking page views

_TODO_

## Tracking events

_TODO_
