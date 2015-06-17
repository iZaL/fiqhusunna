<?php

/**
 * Check If the String is RTL ( Arabic, Persian, Hebrew)
 */
if (!function_exists('isRtl')) {

    /**
     * @param $string
     * @return bool
     */
    function isRtl($string)
    {
        $rtl_chars_pattern = '/[\x{0590}-\x{05ff}\x{0600}-\x{06ff}]/u';

        return preg_match($rtl_chars_pattern, $string);
    }

}

/**
 * Make Slug
 */
if (!function_exists('slug')) {

    /**
     * @param null $string
     * @param string $separator
     * @return string
     */
    function slug($string = null, $separator = "-")
    {

        if (isRtl($string)) {
            return slug_rtl($string);
        }

        return str_slug($string);

    }
}


/**
 * Make Slug that Includes RTL chars
 */
if (!function_exists('slug_rtl')) {

    /**
     * @param $string
     * @param string $separator
     * @return mixed|string
     */
    function slug_rtl($string, $separator = "-")
    {
        // Remove spaces from the beginning and from the end of the string
        $string = trim($string);

        // Lower case everything
        // using mb_strtolower() function is important for non-Latin UTF-8 string | more info: http://goo.gl/QL2tzK
        $string = mb_strtolower($string, "UTF-8");;

        // Make alphanumeric (removes all other characters)
        // this makes the string safe especially when used as a part of a URL
        // this keeps latin characters and arabic charactrs as well
        $string = preg_replace("/[^a-z0-9_\s-ءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]/u", "", $string);

        // Remove multiple dashes or whitespaces
        $string = preg_replace("/[\s-]+/", " ", $string);

        // Convert whitespaces and underscore to the given separator
        $string = preg_replace("/[\s_]/", $separator, $string);

        return $string;

    }
}

/**
 * Tidy's the String
 * Removes Extension
 */
if (!function_exists('tidify')) {

    /**
     * @param $value
     * @return string
     */
    function tidify($value)
    {
        $temp = explode('.', $value);

        array_pop($temp);
        $name = implode('.', $temp);
        $name = strip_tags(e($name));

        return $name;
    }
}
if (!function_exists('convertBytesToHumanReadable')) {

    /**
     * @param $bytes
     * @return string
     */
    function convertBytesToHumanReadable($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        /** @var TYPE_NAME $bytes */

        return $bytes;
    }
}