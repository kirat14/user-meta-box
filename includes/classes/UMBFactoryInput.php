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
        else {
            // When destruction the array we should get rid of the select
            // since we don't need it when constructing the selectField
            if (isset($properties[5]) && in_array($properties[5], ['select', 'radio', 'check'])) {
                unset($properties[5]);
            }
            if ($field_type == 'select') {
                $field_type = 'SelectField';
            } elseif ($field_type == 'radio') {
                $field_type = 'RadiobuttonField';
            } elseif ($field_type == 'check') {
                $field_type = 'CheckboxField';
            }
        }



        $field = "\yso\classes\UMB" . ucwords($field_type);


        if (class_exists($field)) {
            return new $field(...$properties);
        } else {
            throw new \Exception("Invalid field type given.");
        }
    }
}
