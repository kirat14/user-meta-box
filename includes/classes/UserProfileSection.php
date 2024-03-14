<?php

namespace yso\classes;

use yso\builders\UMBFieldBuilder;
use yso\builders\UMBGroupCheckboxBuilder;
use Valitron\Validator;
use yso\builders\UMBInputBuilder;
use yso\fields\UMBGroupField;

// disable direct file access
if (!defined('ABSPATH')) {
    exit;
}



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


    /**
     * Creates fields for the current section based on the 'fields' property of the provided JSON object.
     *
     * This method creates field instances from the 'fields' property of the given JSON object, where each sub-property represents a field.
     * Different field types inherit from the UMBField class, and this function utilizes the Factory pattern
     * to dynamically instantiate field objects based on their types.
     *
     * @since 1.0.0
     *
     * @see UserMetaData::init()
     *
     * @param mixed $json_obj JSON object containing a 'fields' property with sub-properties representing fields for the current section.
     *                        Each sub-property should include necessary information for field creation.
     * @return void
     */
    public function create_fields($fields)
    {

        foreach ($fields as $field_meta) {
            if (isset($field_meta->group_label))
                $this->fields[] = UMBGroupCheckboxBuilder::build($field_meta);
            else if (isset($field_meta->type) && in_array($field_meta->type, ['text', 'email', 'password']))
                $this->fields[] = UMBInputBuilder::build($field_meta);
            else
                $this->fields[] = UMBFieldBuilder::build($field_meta);
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
            $this->html .= $field->generate_html($user->ID);
        }
        // end html
        $this->html_end();
        echo $this->html;
    }

    private function validate(&$validated_fields)
    {
        // Setup the validation params
        foreach ($this->fields as $field) {
            if ($field instanceof UMBGroupField) {
                foreach ($field->fields as $group_item) {
                    if (isset($_POST[$group_item->name]))
                        $validated_fields["skipped"][$group_item->name] = is_array($_POST[$group_item->name]) ? $_POST[$group_item->name] : sanitize_text_field($_POST[$group_item->name]);
                    else
                        $validated_fields["skipped"][$group_item->name] = '';
                }
                continue;
            }

           
            $validated_fields["values"][$field->name] = is_array($_POST[$field->name]) ? $_POST[$field->name] : sanitize_text_field($_POST[$field->name]);
            $validated_fields["labels"][$field->name] = $field->label;
            
        }

        $this->validator = new Validator($validated_fields["values"]);

        $this->validator->labels($validated_fields["labels"]);
        $this->validator->rules($this->rules);

        return $this->validator->validate();
    }

    public function update_custom_meta($errors, $update, $user)
    {
        if (isset($user)) {

            $validated_fields = [];

            if (!$this->validate($validated_fields)) {
                $validator_errors = $this->validator->errors();
                foreach ($validator_errors as $field_name => $list_of_errors) {
                    for ($i = 0; $i < count($list_of_errors); $i++) {
                        $errors->add("invalid_{$field_name}", $list_of_errors[$i]);
                    }
                }
            } else {
                foreach ($validated_fields["values"] as $key => $value) {
                    // Valid phone number, save it
                    update_user_meta($user->ID, $key, $value);
                }

                foreach ($validated_fields["skipped"] as $key => $value) {
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
