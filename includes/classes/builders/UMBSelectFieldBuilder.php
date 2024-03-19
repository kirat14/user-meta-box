<?php

namespace yso\builders;

use yso\builders\UMBFieldBuilder;
use yso\fields\UMBSelectField;
use yso\interfaces\UMBFieldInterface;

// disable direct file access
if (!defined('ABSPATH')) {
    exit;
}



class UMBSelectFieldBuilder extends UMBFieldBuilder
{
    public static function build($field_meta): null|UMBFieldInterface
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

            return new UMBSelectField(...$field_meta);
        }
    }
}
