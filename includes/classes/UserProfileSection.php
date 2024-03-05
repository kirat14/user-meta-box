<?php

namespace yso\classes;

// disable direct file access
if (!defined('ABSPATH')) {
    exit;
}

use Valitron\Validator;

class UserProfileSection
{
    public array $fields;
    private string $html;
    private Validator $validator;
    public function __construct(private string $box_title, private $rules)
    {
        // Determines whether the current request is for an administrative interface page.
        if (!is_admin())
            return;
        $this->html_start();
    }


    public function add_fields($fields)
    {
        foreach ($fields as $field) {

            // Check if name or id is set
            if (!isset($field->name))
                continue;
            else {
                if (!isset($field->id))
                    $field->id = $field->name;
            }

            $this->fields[] = UMBFactoryInput::build($field);
        }
    }



    private function html_start()
    {
        $this->html = <<<HTML
        <h3>$this->box_title</h3>
        <table class="form-table">
            <tbody>
        HTML;
    }

    private function html_end()
    {
        $this->html .= <<<HTML
            </tbody>
        </table>
        HTML;
    }

    public function render_html($user)
    {
        foreach ($this->fields as $field) {
            $this->html .= $field->genrate_html($user->ID);
        }
        // end html
        $this->html_end();
        echo $this->html;
    }

    private function validate(&$fields_values, &$fields_labels)
    {
        // Setup the validation params
        foreach ($this->fields as $field) {

            if (isset($_POST[$field->name])) {
                $fields_values[$field->name] = is_array($_POST[$field->name]) ? $_POST[$field->name] : sanitize_text_field($_POST[$field->name]);
                $fields_labels[$field->name] = $field->label;
            } else {
                $_POST[$field->name] = '';
                $fields_values[$field->name] = '';
            }
        }

        $this->validator = new Validator($fields_values);

        $this->validator->labels($fields_labels);
        $this->validator->rules($this->rules);

        return $this->validator->validate();
    }

    public function update_custom_meta($errors, $update, $user)
    {
        if (isset($user)) {

            $fields_values = [];
            $fields_labels = [];

            if (!$this->validate($fields_values, $fields_labels)) {
                $validator_errors = $this->validator->errors();
                foreach ($validator_errors as $field_name => $list_of_errors) {
                    for ($i = 0; $i < count($list_of_errors); $i++) {
                        $errors->add("invalid_{$field_name}", $list_of_errors[$i]);
                    }
                }
            } else {
                foreach ($fields_values as $key => $value) {
                    // Valid phone number, save it
                    update_user_meta($user->ID, $key, $value);
                }
            }

            return $errors;
        }
        return false;
    }

    public function init()
    {
        if (!is_admin())
            return;

        // Add the field to user's own profile editing screen.
        add_action(
            'show_user_profile',
            array($this, 'render_html')
        );

        // Add the field to user profile editing screen.
        add_action(
            'edit_user_profile',
            array($this, 'render_html')
        );

        // hooks the validation functionality for each field
        add_filter('user_profile_update_errors', array($this, 'update_custom_meta'), 10, 3);
    }
}
