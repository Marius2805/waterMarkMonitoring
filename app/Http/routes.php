<?php

$app->post('/measurements', 'API\MeasurementController@create');
$app->get('/daily-average', 'API\DailyAverageController@get');