<?php

namespace yso\builders;

use yso\builders\UMBFieldBuilder;
use yso\fields\UMBRadiobuttonField;
use yso\interfaces\UMBFieldInterface;

// disable direct file access
if (!defined('ABSPATH')) {
    exit;
}



class UMBRadiobuttonFieldBuilder extends UMBFieldBuilder
{
    public static function build($field_meta): null|UMBFieldInterface
    {
        if (!self::has_required_properties($field_meta, ['name', 'value', 'options', 'label']))
            return null;
        else {
            if (!isset($field_meta->id))
                $field_meta->id = $field_meta->name;

            self::unset_type($field_meta);
            $field_meta = (array) $field_meta;

            return new UMBRadiobuttonField(...$field_meta);
        }
    }
}
