<?php

// located in app/Helpers/translations.php

function translations($json, $route = null)
{
    if (!file_exists($json)) {
        return [];
    }
    $translation = json_decode(file_get_contents($json), true);

    if (isset($translation[$route])) {
        return $translation[$route];
    }
    return $translation['general'];
}
