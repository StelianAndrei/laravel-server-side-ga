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

Then you need to add the service provider to your `config/app.php` file under the _Package Service Providers_ section:

```
  StelianAndrei\LaravelServerSideGA\AnalyticsServiceProvider::class,
```

Also add the Analytics facade to the _aliases_ array in the same file:

```
  'Analytics' => StelianAndrei\LaravelServerSideGA\AnalyticsFacade::class,
```

## Tracking page views

To track page views, use it as follows:

```
Analytics::trackPage($page, $title, $hitType)
```

Where:

- $page - (optional) the url of the page you are tracking (eg: `/about`)
- $title - (optional) the title of the page you are tracking (eg: `About us`)
- $hitType - (optional) the type of hit you are sending (defaults to `pageview`)

## Tracking events

To track an event, use it as follows:

```
Analytics::trackEvent($category, $action, $label = null, $value = null)
```

Where:

- $category - the category of the event (eg: `Account creation`)
- $action - the action you're tracking (eg: `Click button`)
- $label - (optional) the label for the event (eg: `Recover password`)
- $value - (optional) an optional value for the event
