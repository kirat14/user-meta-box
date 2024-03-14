<?php

namespace yso\builders;
use yso\fields\UMBInputField;


// disable direct file access
if (!defined('ABSPATH')) {
    exit;
}

use yso\builders\UMBFieldBuilder;
use yso\interfaces\UMBFieldInterface;

class UMBInputBuilder extends UMBFieldBuilder
{

    public static function build($field_meta): null|UMBFieldInterface
    {

        self::check_name($field_meta);
        $field_meta = array_values((array) $field_meta);

        return new UMBInputField(...$field_meta);
    }
}
