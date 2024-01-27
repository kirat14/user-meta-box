<?php
namespace yso\classes;

// disable direct file access
if (!defined('ABSPATH')) {
	exit;
}

class UMBRadioButtonGroup extends UMBField
{
	public function __construct(
		public string $name,
		public string $id,
		public string $value,
		public array $options,
		public string $lable,
		public array $rules,
		public string $extra_attr = ''
	) {
		parent::__construct();
	}

	/**
	 * Get field HTML
	 *
	 *
	 * @return string
	 */
	public function genrate_html($user_id): string
	{
		[$name, $id, $value] = $this->field_attr($user_id);

		$counter = -1;
		$options_size = count($this->options);
		$radioBtn_group_html = array_map(function ($item) use (&$counter, $name, $id, $value, $options_size) {
			$checked = '';
			$radioHtml = '';
			$counter++;

			if ($counter == $this->value)
				$checked = "checked = checked";

			if($counter + 1 == $options_size)
				$radioHtml .= '<br>';

			$radioHtml .= <<<RADIOHTML
				<label>
					<input type="radio" value="$counter" $checked{$name}>
					$item
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
						$this->lable
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