<?php

namespace yso\classes;

use yso\builders\UMBCheckboxFieldBuilder;
use yso\builders\UMBFieldBuilder;
use yso\builders\UMBGroupCheckboxBuilder;
use Valitron\Validator;
use yso\builders\UMBInputBuilder;
use yso\builders\UMBRadiobuttonFieldBuilder;
use yso\builders\UMBSelectFieldBuilder;
use yso\fields\UMBGroupField;
use yso\fields\UMBRadiobuttonField;
use yso\fields\UMBSelectField;

// disable direct file access
if (!defined('ABSPATH')) {
    exit;
}



class UserProfileSection
{
    public array $fields;
    private array $validated_fields;
    private string $html;
    private Validator $validator;
    public function __construct(private string $box_title, private array $rules)
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
     * @see UserFieldCreator::init()
     *
     * @param mixed $json_obj JSON object containing a 'fields' property with sub-properties representing fields for the current section.
     *                        Each sub-property should include necessary information for field creation.
     * @return void
     */
    public function create_fields($fields)
    {

        foreach ($fields as $field_meta) {
            if (isset ($field_meta->group_label))
                $this->fields[] = UMBGroupCheckboxBuilder::build($field_meta);
            else {
                if (isset ($field_meta->type)) {
                    if (in_array($field_meta->type, ['text', 'email', 'password']))
                        $this->fields[] = UMBInputBuilder::build($field_meta);
                    else if ($field_meta->type == 'select')
                        $this->fields[] = UMBSelectFieldBuilder::build($field_meta);
                    else if ($field_meta->type == 'checkbox')
                        $this->fields[] = UMBCheckboxFieldBuilder::build($field_meta);
                    else if ($field_meta->type == 'radiobutton')
                        $this->fields[] = UMBRadiobuttonFieldBuilder::build($field_meta);
                }
            }
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

    private function validate()
    {
        $this->validated_fields["values"] = [];
        $this->validated_fields["labels"] = [];

        // Setup the validation params
        foreach ($this->fields as $field) {

            if ($field instanceof UMBGroupField) {
                foreach ($field->fields as $group_item) {
                        $this->set_up_validation_array($group_item);
                }
                continue;
            }

            $this->set_up_validation_array($field);

        }

        // Should invoke set_up_validation
        if (count($this->rules) == 0)
            return true;

        $this->validator = new Validator($this->validated_fields["values"]);

        $this->validator->labels($this->validated_fields["labels"]);
        $this->validator->rules($this->rules);

        return $this->validator->validate();
    }

    // Remove the prefix from the field name to match the names in the rules array
    private function set_up_validation_array($field)
    {
        $field_name_unprefixed = substr($field->name, 4, strlen($field->name));
        $this->validated_fields["values"][$field_name_unprefixed] = is_array($_POST[$field->name]) ? $_POST[$field->name] : sanitize_text_field($_POST[$field->name]);
        $this->validated_fields["labels"][$field_name_unprefixed] = $field->label;
    }

    public function update_user_custom_meta($errors, $update, $user)
    {
        if (isset ($user)) {
            if (!$this->validate()) {
                $validator_errors = $this->validator->errors();
                foreach ($validator_errors as $field_name => $list_of_errors) {
                    for ($i = 0; $i < count($list_of_errors); $i++) {
                        $errors->add("invalid_{$field_name}", $list_of_errors[$i]);
                    }
                }
            } else {
                foreach ($this->fields as $field) {
                    $field->update_user_meta($user->ID);
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
        add_filter('user_profile_update_errors', array($this, 'update_user_custom_meta'), 10, 3);
    }
}
