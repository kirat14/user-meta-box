<?php

namespace yso\builders;

use yso\builders\UFCFieldBuilder;
use yso\fields\UFCCheckboxField;
use yso\interfaces\UFCFieldInterface;

// disable direct file access
if (!defined('ABSPATH')) {
    exit;
}



class UFCCheckboxFieldBuilder extends UFCFieldBuilder
{
    public static function build($field_meta): null|UFCFieldInterface
    {
        if (!self::has_required_properties($field_meta, ['name', 'value', 'label']))
            return null;
        else {
            if (!isset($field_meta->id))
                $field_meta->id = $field_meta->name;

            self::unset_type($field_meta);
            $field_meta = (array) $field_meta;

            return new UFCCheckboxField(...$field_meta);
        }
    }
}
