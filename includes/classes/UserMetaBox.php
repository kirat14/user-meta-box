<?php

namespace yso\classes;

// disable direct file access
if (!defined('ABSPATH')) {
    exit;
}


class UserMetaBox
{
    private array $fields;
    private string $html;
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
        HTML;
    }

    private function html_end()
    {
        $this->html .= <<<HTML
        </table>
        HTML;
    }

    // this should be converted to registery/dependency injection pattern
    /**
     * Add fields
     *
     *
     * @param array $fields of type UMBTextField
     */
    public function add_fields(array $fields)
    {
        $this->fields = $fields;
    }

    public function render_html($user)
    {
        foreach ($this->fields as $field) {
            $this->html .= $field->genrate_html($user->ID);
        }
        echo $this->html;
    }

    private function update_meta_boxes(): void
    {
        foreach ($this->fields as $field) {
            // Add the save action to user's own profile editing screen update.
            add_action(
                'personal_options_update',
                array($field, 'update')
            );

            // Add the save action to user profile editing screen update.
            add_action(
                'edit_user_profile_update',
                array($field, 'update')
            );

        }
    }


    public function init()
    {
        if (!is_admin())
        return;
    
        // end html
        $this->html_end();

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

        $this->update_meta_boxes();
    }


}