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
    public function __construct(private string $box_title)
    {
        // Determines whether the current request is for an administrative interface page.
        if (!is_admin())
            return;
        $this->html_start();
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

    private function update_meta_boxes(): void
    {
        foreach ($this->fields as $field) {
            // Add the save action to user's own profile editing screen update.
            add_action(
                'personal_options_update',
                array($field, 'update_field_callback')
            );

            // Add the save action to user profile editing screen update.
            add_action(
                'edit_user_profile_update',
                array($field, 'update_field_callback')
            );

        }
    }

    public function validate($errors, $update, $user)
    {
        if (isset($user)) {
            $fields_value = array();
            $rules = array();

            foreach ($this->fields as $field) {
                if (isset($_POST[$field->name])) {
                    $fields_value[$field->name] = sanitize_text_field($_POST[$field->name]);
                    $rules = array_merge_recursive($rules, $field->rules);
                }
            }

            $this->validator = new Validator($fields_value);
            
            $this->validator->rules($rules);
            

            if (!$this->validator->validate()) {
                $validator_errors = $this->validator->errors();
                foreach ($validator_errors as $field_name => $list_of_errors) {
                    for ($i = 0; $i < count($list_of_errors); $i++) {
                        $errors->add("invalid_{$field_name}", $list_of_errors[$i]);
                    }
                }
            } else {
                foreach ($fields_value as $key => $value) {
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

        // hooks the update functionality for each field
        $this->update_meta_boxes();

        // hooks the validation functionality for each field
        add_filter('user_profile_update_errors', array($this, 'validate'), 10, 3);
    }


}