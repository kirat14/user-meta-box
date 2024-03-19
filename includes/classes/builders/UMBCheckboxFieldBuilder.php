<?php

namespace yso\builders;

use yso\builders\UMBFieldBuilder;
use yso\fields\UMBCheckboxField;
use yso\interfaces\UMBFieldInterface;

// disable direct file access
if (!defined('ABSPATH')) {
    exit;
}



class UMBCheckboxFieldBuilder extends UMBFieldBuilder
{
    public static function build($field_meta): null|UMBFieldInterface
    {
        if (!self::has_required_properties($field_meta, ['name', 'value', 'label']))
            return null;
        else {
            if (!isset($field_meta->id))
                $field_meta->id = $field_meta->name;

            self::unset_type($field_meta);
            $field_meta = (array) $field_meta;

            return new UMBCheckboxField(...$field_meta);
        }
    }
}
