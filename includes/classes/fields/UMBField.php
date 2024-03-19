<?php

namespace yso\fields;

// disable direct file access
if (!defined('ABSPATH')) {
    exit;
}

use yso\interfaces\UMBFieldInterface;

abstract class UMBField implements UMBFieldInterface
{

    protected function __construct(
        public string $name,
        public string $id,
        public string $value,
        public string $label,
        public string $extra_attr = ''
    ) {
        $this->name = FIELDPREFIX . $this->name;
        $this->id = FIELDPREFIX . $this->id;
    }

    public function field_attr($user_id, $set_value = true): array
    {
        $name_attr = " name=\"{$this->name}\"";
        $id_attr = " id=\"{$this->id}\"";

        if($set_value)
            $this->value = esc_attr(get_user_meta($user_id, $this->name, true));

        return [$name_attr, $id_attr];
    }

    public function update_user_meta($user_id): void {
        if(isset($_POST[$this->name]))
            $this->value = is_array($_POST[$this->name]) ? $_POST[$this->name] : sanitize_text_field($_POST[$this->name]);
        else // When checkbox not checked, update meta with empty string
            $this->value = '';
        update_user_meta($user_id, $this->name, $this->value);
    }
}
