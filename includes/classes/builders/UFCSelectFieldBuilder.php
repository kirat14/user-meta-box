<?php

namespace yso\builders;

use yso\builders\UFCFieldBuilder;
use yso\fields\UFCSelectField;
use yso\interfaces\UFCFieldInterface;

// disable direct file access
if (!defined('ABSPATH')) {
    exit;
}



class UFCSelectFieldBuilder extends UFCFieldBuilder
{
    public static function build($field_meta): null|UFCFieldInterface
    {
        if (!self::has_required_properties($field_meta, ['name', 'options', 'label']))
            return null;
        else {
            if (!isset($field_meta->value))
                $field_meta->value = 0;
            if (!isset($field_meta->id))
                $field_meta->id = $field_meta->name;

            self::unset_type($field_meta);
            $field_meta = (array) $field_meta;

            return new UFCSelectField(...$field_meta);
        }
    }
}
