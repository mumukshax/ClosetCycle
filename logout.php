<?php

require_once __DIR__ .
    '/config/app.php';


Auth::logout();


header(
    'Location: ' .
    BASE_URL .
    '/'
);

exit();