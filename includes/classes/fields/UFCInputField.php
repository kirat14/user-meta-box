<?php
namespace yso\fields;

// disable direct file access
if (!defined('ABSPATH')) {
	exit;
}


class UFCInputField extends UFCField
{	
	public function __construct(
		public string $name,
		public string $id,
		public string $value,
		public string $label,
		public string $type,
		public string $extra_attr = ''
	) {
		parent::__construct($name, $id, $value, $label, $extra_attr);
	}

	/**
	 * Get field HTML
	 *
	 *
	 * @return string
	 */
	public function generate_html($user_id): string
	{
		[$name_attr, $id_attr] = $this->field_attr($user_id);

		// Generate html
		$html = "
			<tr>
				<th>
					<label for=\"{$this->id}\">
						$this->label
					</label>
				</th>
				<td>
					<input type=\"{$this->type}\" class='regular-text' {$name_attr} {$id_attr} value=\"{$this->value}\" />
				</td>
			</tr>
			";

		return $html;
	}
}