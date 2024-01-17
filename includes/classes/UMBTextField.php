<?php
namespace yso\classes;

// disable direct file access
if (!defined('ABSPATH')) {
	exit;
}

class UMBTextField extends UMBField
{
	public function __construct(
		public string $name,
		public string $id,
		public string $value,
		public string $lable,
		public array $rules,
		public string $extra_attr = ''
	) {

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


		$value = " value='{$this->value}'";
		// Generate html
		$html = <<<HTML
			<tr>
				<th>
					<label for="{$this->id}">
						$this->lable
					</label>
				</th>
				<td>
					<input type='text' class='regular-text'{$name}{$id}{$value} />
				</td>
			</tr>
			HTML;

		return $html;
	}
}