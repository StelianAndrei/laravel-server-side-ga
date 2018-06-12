<?php

namespace StelianAndrei\LaravelServerSideGA;

use Config;
use GuzzleHttp\Client;

class GoogleAnalytics
{
    /**
     * A generic request payload
     *
     * @var array
     */
    protected $requestPayload = [];

    public function __construct()
    {
        $this->requestPayload = [
            'v'   => 1, // Version
            'tid' => Config::get('analytics.tracking_id'), // Tracking ID / Property ID
            'cid' => 555, // Anonymous Client ID
        ];
    }

    /**
     * Tracks the hits on any page
     *
     * @param string|null $page
     * @param string|null $title
     * @param string|null $hitType
     * @return int
     */
    public function trackPage($page = null, $title = null, $hitType = null)
    {
        // make sure we have a valid hit type
        $allowedHitTypes = ['pageview', 'appview', 'event', 'transaction', 'item', 'social', 'exception', 'timing'];
        if ($hitType === null) {
            $hitType = $allowedHitTypes[0];
        }
        if (!in_array($hitType, $allowedHitTypes)) {
            return;
        }

        // prepare the first hit
        $firstRequest      = $this->requestPayload;
        $firstRequest['t'] = 'pageview';

        // prepare the second hit, if needed
        $secondRequest = null;
        if ($page !== null || $title !== null || $hitType !== null) {
            $secondRequest = $firstRequest;
            if ($page !== null) {
                $secondRequest['dp'] = $page; // Page
            }
            if ($title !== null) {
                $secondRequest['dt'] = $title; // Page title
            }
            if ($hitType !== null) {
                $secondRequest['t'] = $hitType; // Hit type
            }
        }

        // determine how many request we send
        $payload = $secondRequest ? [$firstRequest, $secondRequest] : [$firstRequest];

        // issue the request
        try {
            $client = new Client();
            $result = $client->request('POST', 'https://www.google-analytics.com/batch', ['form_params' => $payload]);
            return $result->getStatusCode();
        } catch (\Exception $e) {
            return $e->getCode();
        }
    }

    /**
     * Track an event, with all the required parameters
     *
     * @param string $category
     * @param string $action
     * @param string|null $label
     * @param float|null $value
     * @return int
     */
    public function trackEvent($category, $action, $label = null, $value = null)
    {
        $this->requestPayload['t']  = 'event'; // Event hit type
        $this->requestPayload['ec'] = $category; // Event category
        $this->requestPayload['ea'] = $action; // Event action

        if ($label !== null) {
            $this->requestPayload['el'] = $label; // Event label
            if ($value !== null && is_numeric($value)) {
                $this->requestPayload['ev'] = $value; // Event value
            }
        }

        // issue the request
        try {
            $client = new Client();
            $result = $client->request('POST', 'https://www.google-analytics.com/collect', ['form_params' => $this->requestPayload]);
            return $result->getStatusCode();
        } catch (\Exception $e) {
            return $e->getCode();
        }
    }
}
