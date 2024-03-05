<?php

namespace yso\classes;

// disable direct file access
if (!defined('ABSPATH')) {
    exit;
}

use Valitron\Validator;

abstract class UMBField
{

    protected function __construct(
        public string $name,
        public string $id,
        public string $value,
        public string $label,
        public string $extra_attr = ''
    ) {
        $this->name = 'umb-' . $this->name;
    }

    /**
     * Get field HTML
     *
     *
     * @return string
     */
    abstract public function genrate_html($user_id): string;

    public function field_attr($user_id): array
    {
        $name = " name='{$this->name}'";
        $id = " id='{$this->id}'";
        // Check if the user meta has been already added
        $this->value = esc_attr(get_user_meta($user_id, $this->name, true));

        return [$name, $id];
    }
}
