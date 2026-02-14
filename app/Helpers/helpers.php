<?php

/**
 * Return an HTTPS-aware url to a asset.
 * This function is to show the styles and scripts of the template on both ngrok deployment and localhost.
 *
 * @param  string  $path
 * @return string
 */
if (!function_exists('safe_asset')) {
    function safe_asset($path)
    {
        return request()->secure()
            ? secure_asset($path)
            : asset($path);
    }
}
