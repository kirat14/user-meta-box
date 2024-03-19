<?php

namespace yso\builders;

use yso\fields\UMBGroupField;
use yso\interfaces\UMBFieldInterface;
use yso\interfaces\UMBFieldBuilderInterface;

// disable direct file access
if (!defined('ABSPATH')) {
    exit;
}

class UMBGroupCheckboxBuilder implements UMBFieldBuilderInterface
{

    public static function build($field_meta): null|UMBFieldInterface
    {
        $group_fields = array_map(function ($checkbox_meta) {
            return UMBCheckboxFieldBuilder::build($checkbox_meta);
        }, $field_meta->options);

        return new UMBGroupField($field_meta->group_label, $group_fields);
    }
}
