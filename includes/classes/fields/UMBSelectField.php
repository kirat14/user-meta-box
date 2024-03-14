<?php
namespace yso\fields;

// disable direct file access
if (!defined('ABSPATH')) {
	exit;
}

class UMBSelectField extends UMBField
{
	public function __construct(
		public string $name,
		public string $id,
		public string $value,
		public array $options,
		public string $label,
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

		$counter = -1;
		$select_html = array_map(function ($item) use (&$counter) {
			$selected = '';
			$counter++;
			if ($counter == $this->value)
				$selected = "selected = selected";
			return "<option value=\"$counter\" {$selected}>{$item}</option>";
		}, $this->options);

		$select_html = implode('', $select_html);
		$select_html = "<select {$name_attr}{$id_attr}>" . $select_html . "</select>";

		// Generate html
		$html = <<<HTML
			<tr>
				<th>
					<label for="{$this->id}">
						$this->label
					</label>
				</th>
				<td>
					$select_html
				</td>
			</tr>
			HTML;

		return $html;
	}
}