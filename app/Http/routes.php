<?php

/** Web UI */
$app->get('/', 'OverviewController@overview');
$app->get('/overview', 'OverviewController@overview');

/** API */
$app->post('/api/measurements', 'API\MeasurementController@create');
$app->get('/api/daily-average', 'API\DailyAverageController@get');