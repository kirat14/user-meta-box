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
		public array $options,
		public string $lable,
		public string $extra_attr = ''
	) {
		parent::__construct($name, $id, $value, $lable, $extra_attr);
	}


	public function field_attr($user_id): array
	{
		$name = " name='{$this->name}[]'";
		$id = " id='{$this->id}'";

		// Retrieve the user meta as an array
		$user_meta = get_user_meta($user_id, $this->name, true);
		if(is_array($user_meta))
			$this->value = ',' . implode(',', $user_meta) . ',';

		return [$name, $id];
	}


	private function get_checkbox_html($option, $name, $id, $checked)
	{
		$html = <<<CHECK
			<label for="{$id}">
				<input type="checkbox" $checked{$name}{$id} value="{$option->value}" />
				{$option->label}
			</label> <br>
		CHECK;

		return $html;
	}

	private function checked($value){
		
		if($this->value && str_contains($this->value, ',' . $value . ','))
				return " checked = checked";
		return '';
	}

	/**
	 * Get field HTML
	 *
	 *
	 * @return string
	 */
	public function genrate_html($user_id): string
	{
		[$name, $id] = $this->field_attr($user_id);
	
		$checkboxs_html = '';
		// $this->value contains checked checkboxes values comma seperated
		foreach ($this->options as $option) {
			$checked = $this->checked($option->value);
			$checkboxs_html .= $this->get_checkbox_html($option, $name, $id, $checked);
		}

		// Generate html
		$html = <<<HTML
			<tr>
				<th>
					<label for="{$this->id}">
						$this->lable
					</label>
				</th>
				<td>
					<fieldset>
						$checkboxs_html
					</fieldset>
				</td>
			</tr>
			HTML;

		return $html;
	}
}
