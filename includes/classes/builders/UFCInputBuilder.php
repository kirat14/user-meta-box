<?php

namespace yso\builders;
use yso\fields\UFCInputField;


// disable direct file access
if (!defined('ABSPATH')) {
    exit;
}

use yso\builders\UFCFieldBuilder;
use yso\interfaces\UFCFieldInterface;

class UFCInputBuilder extends UFCFieldBuilder
{

    public static function build($field_meta): null|UFCFieldInterface
    {

        $field_meta = array_values((array) $field_meta);

        return new UFCInputField(...$field_meta);
    }
}
