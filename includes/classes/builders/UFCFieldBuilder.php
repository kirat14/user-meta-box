<?php

namespace yso\builders;

use yso\interfaces\UFCFieldInterface;
use yso\interfaces\UFCFieldBuilderInterface;

// disable direct file access
if (!defined('ABSPATH')) {
    exit;
}



class UFCFieldBuilder implements UFCFieldBuilderInterface
{

    public static string $type;
    // @param $required_properties :Define the required properties for the SelectField constructor as a string    
    public static function has_required_properties($field_meta, array $required_properties): bool
    {
        // Get the properties of the $field_meta object as an array
        $field_properties = array_keys((array) $field_meta);

        $result = array_diff($required_properties, $field_properties);

        return count($result) > 0 ? false : true;
    }

    public static function unset_type(&$field_meta)
    {
        self::$type = $field_meta->type;

        // Remove the type property from the field meta
        // to pass the remaining attribute to the constructor
        if (isset ($field_meta->type)) {
            unset($field_meta->type);
        }
    }

    public static function build($field_meta): null|UFCFieldInterface
    {
        // Implementation to be done in each FieldBuilder instance
        return null;
    }
}
