<?php

namespace yso\builders;

use yso\fields\UFCGroupField;
use yso\interfaces\UFCFieldInterface;
use yso\interfaces\UFCFieldBuilderInterface;

// disable direct file access
if (!defined('ABSPATH')) {
    exit;
}

class UFCGroupCheckboxBuilder implements UFCFieldBuilderInterface
{

    public static function build($field_meta): null|UFCFieldInterface
    {
        $group_fields = array_map(function ($checkbox_meta) {
            return UFCCheckboxFieldBuilder::build($checkbox_meta);
        }, $field_meta->options);

        return new UFCGroupField($field_meta->group_label, $group_fields);
    }
}
