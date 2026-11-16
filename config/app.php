<?php

// Load the main configuration.
require_once __DIR__ . '/config.php';


// Load authentication support.
require_once __DIR__ . '/../models/Auth.php';


// Start the session for the application.
Auth::startSession();

// Return the correct public URL for
// either the default image or an uploaded image.
function itemImageUrl($imageName)
{
    if (
        !$imageName ||
        $imageName === 'default-item.png'
    ) {

        return BASE_URL .
            '/public/images/default-item.png';
    }


    return BASE_URL .
        '/public/uploads/' .
        rawurlencode($imageName);
}