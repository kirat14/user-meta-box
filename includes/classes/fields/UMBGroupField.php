<?php

namespace yso\fields;

use yso\interfaces\UMBFieldInterface;

// disable direct file access
if (!defined('ABSPATH')) {
    exit;
}

// There should be a compistion relation
// to the UMBField
class UMBGroupField implements UMBFieldInterface
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
}