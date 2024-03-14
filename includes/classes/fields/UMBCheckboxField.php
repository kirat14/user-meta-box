<?php

namespace yso\fields;

// disable direct file access
if (!defined('ABSPATH')) {
	exit;
}

class UMBCheckboxField extends UMBField
{
	public function __construct(
		public string $name,
		public string $id,
		public string $value,
		public string $label,
		public string $extra_attr = ''
	) {
		parent::__construct($name, $id, $value, $label, $extra_attr);
	}


	public function get_checkbox_html($user_id)
	{
		[$name_attr, $id_attr] = $this->field_attr($user_id, false);
		$saved_meta = esc_attr(get_user_meta($user_id, $this->name, true));

		$checked = $this->value == $saved_meta ? ' checked = checked' : '';

		$html = "
        <label for=\"{$this->id}\">
            <input type=\"checkbox\" $checked {$name_attr}{$id_attr} value=\"{$this->value}\" />
            {$this->label}
        </label><br>
    ";

		return $html;
	}

	/**
	 * Get field HTML
	 *
	 *
	 * @return string
	 */
	public function generate_html($user_id): string
	{
		$checkbox_html .= $this->get_checkbox_html($user_id);

		// Generate html
        $html = "
		<tr>
			<th scope=\"row\">
                $this->label
			</th>
			<td>
				<fieldset>
					$checkbox_html
				</fieldset>
			</td>
		</tr>";

		return $html;
	}
}
