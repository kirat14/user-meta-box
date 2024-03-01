<?php

namespace yso\classes;

// disable direct file access
if (!defined('ABSPATH')) {
    exit;
}

class UMBFactoryInput
{

    public static function build($properties)
    {
        $field_type = $properties->type;
        $properties = array_values((array) $properties);
        if (in_array($field_type, ['text', 'email', 'password']))
            $field_type = 'InputField';
        elseif ($field_type == 'select') {
            // When destruction the array we should get rid of the select
            // since we don't need it when constructing the selectField
            if(isset($properties[5]) && $properties[5] == 'select'){
                unset($properties[5]);
            }
            $field_type = 'SelectField';
        }



        $field = "\yso\classes\UMB" . ucwords($field_type);


        if (class_exists($field)) {
            return new $field(...$properties);
        } else {
            throw new \Exception("Invalid field type given.");
        }
    }
}
