<?php
// disable direct file access
if (!defined('ABSPATH')) {

    exit;

}

function is_phone_number($phone_number)
{
    // Remove any non-numeric characters
    $cleaned_phone_number = preg_replace('/[^0-9]/', '', $phone_number);

    // Check if the cleaned number is exactly 10 digits and starts with '0'
    if (strlen($cleaned_phone_number) === 10 && $cleaned_phone_number[0] === '0') {
        return true;
    } else {
        return false;
    }
}


function isDatetimeFormat($input) {
    return strtotime($input) !== false;
}



/**
 * Determines whether the given phone number exists.
 *
 *
 * @since 1.0.0
 *
 * @param string $phone_number The email to check for existence.
 * @return int|false The user ID on success, false on failure.
 */
function phone_exists($phone_number)
{
    $users = get_user_by_meta_data('phone', $phone_number);
    $flag = false;
    if (is_array($users) && count($users) > 0) {
        $flag = true;
    }
    return $flag;
}



function get_user_by_meta_data($meta_key, $meta_value)
{

    // Query for users based on the meta data
    $user_query = new WP_User_Query(
        array(
            'meta_key' => $meta_key,
            'meta_value' => $meta_value
        )
    );
    // Get the results from the query, returning the first user
    $users = $user_query->get_results();

    return $users;

} // end get_user_by_meta_data
