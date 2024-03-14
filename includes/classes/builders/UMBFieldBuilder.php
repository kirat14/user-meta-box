<?php

namespace yso\builders;

use yso\fields\UMBCheckboxField;
use yso\interfaces\UMBFieldInterface;

// disable direct file access
if (!defined('ABSPATH')) {
    exit;
}

use yso\interfaces\UMBFieldBuilderInterface;

class UMBFieldBuilder implements UMBFieldBuilderInterface
{

    public static function check_name(&$field_meta)
    {
        // Check if 'name' property is set
        if (!isset($field_meta->name))
            return null;
        else {
            // Set 'id' property to 'name' if 'id' is not explicitly provided
            if (!isset($field_meta->id))
                $field_meta->id = $field_meta->name;
        }
    }

    public static function build($field_meta): null|UMBFieldInterface
    {
        self::check_name($field_meta);
        if ($field_meta->type == 'select') {
            $field_meta->type = 'SelectField';
        } elseif ($field_meta->type == 'radio') {
            $field_meta->type = 'RadiobuttonField';
        } elseif ($field_meta->type == 'checkbox') {
            $field_meta->type = 'CheckboxField';
        }

        $class_name = "\yso\\fields\UMB" . ucwords($field_meta->type);

        // Remove the type property from the field meta
        // to pass the remaining attribute to the constructor
        if (isset($field_meta->type)) {
            unset($field_meta->type);
        }
        $field_meta = array_values((array) $field_meta);
        return new $class_name(...$field_meta);
    }
}
