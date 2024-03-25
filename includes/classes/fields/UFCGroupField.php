<?php

namespace yso\fields;

use yso\interfaces\UFCFieldInterface;

// disable direct file access
if (!defined('ABSPATH')) {
    exit;
}

// There should be a compistion relation
// to the UFCField
class UFCGroupField implements UFCFieldInterface
{
    public function __construct(public string $label, public array $fields)
    {

    }
    public function generate_html($user_id): string
    {
        $checkboxes_html = '';

        foreach ($this->fields as $field) {
            $checkboxes_html .= $field->get_checkbox_html($user_id);
        }
        // Generate html
        $html = "
		<tr>
			<th scope=\"row\">
                $this->label
			</th>
			<td>
				<fieldset>
                    $checkboxes_html
				</fieldset>
			</td>
		</tr>";

        return $html;
    }

    public function update_user_meta($user_id): void{
        foreach ($this->fields as $field) {
            $field->update_user_meta($user_id);
        }
    }
}