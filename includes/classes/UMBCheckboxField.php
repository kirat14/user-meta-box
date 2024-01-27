<?php
namespace yso\classes;

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
		public string $lable,
		public string $prepend,
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

		$checked = $this->value == 'on' ? 'checked = checked' : '';

		// Generate html
		$html = <<<HTML
			<tr>
				<th>
					<label for="{$this->id}">
						$this->lable
					</label>
				</th>
				<td>
				<label for="{$id}">
					<input type="checkbox" $checked{$name}{$id}{$value} />
					$this->prepend							</label>
				</td>
			</tr>
			HTML;

		return $html;
	}
}