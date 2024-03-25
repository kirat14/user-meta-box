<?php
namespace yso\fields;

// disable direct file access
if (!defined('ABSPATH')) {
	exit;
}

class UMBRadiobuttonField extends UMBField
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

		$counter = 0;
		$options_size = count($this->options);
		$radioBtn_group_html = array_map(function ($item) use (&$counter, $name_attr, $id_attr, $options_size) {
			$checked = '';
			$radioHtml = '';
			$counter++;
			$item_label = ucfirst($item);

			if ($item == $this->value)
				$checked = 'checked = "checked" ';

			if($counter + 1 != $options_size)
				$radioHtml .= '<br>';

			$radioHtml .= <<<RADIOHTML
				<label>
					<input type="radio" value="$item" $checked{$name_attr}>
					$item_label
				</label>
			RADIOHTML;
			return $radioHtml;
		}, $this->options);

		$radioBtn_group_html = implode('', $radioBtn_group_html);

		// Generate html
		$html = <<<HTML
			<tr>
				<th>
					<label for="{$this->id}">
						$this->label
					</label>
				</th>
				<td>
					$radioBtn_group_html
				</td>
			</tr>
			HTML;

		return $html;
	}
}