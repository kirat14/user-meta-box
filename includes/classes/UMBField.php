<?php
namespace yso\classes;

// disable direct file access
if (!defined('ABSPATH')) {
    exit;
}

abstract class UMBField
{
    public string $name;
    public string $id;
    public string $value;
    public string $lable;
    public array $rules;
    public string $extra_attr = '';

    protected function __construct(){
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
        $value = esc_attr(get_user_meta($user_id, $this->name, true));


        if (!empty($value))
            $this->value = $value;

        return [$name, $id, $value];
    }

    public function update_field_callback(int $user_id): bool|int
    {
        // check that the current user have the capability to edit the $user_id
        if (!current_user_can('edit_user', $user_id)) {
            return false;
        }

        $new_value = "";
        if (isset($_POST[$this->name]))
            $new_value = $_POST[$this->name];

        $rslt = update_user_meta(
            $user_id,
            $this->name,
            $new_value
        );

        // create/update user meta for the $user_id
        return $rslt;

    }
}