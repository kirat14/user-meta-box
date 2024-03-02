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
		public array $rules,
		public string $extra_attr = ''
	) {
		parent::__construct($name, $id, $value, $lable, $rules, $extra_attr);
	}


	public function field_attr($user_id): array
	{
		$name = " name='{$this->name}[]'";
		$id = " id='{$this->id}'";

		// Retrieve the user meta as an array
		$this->value = get_user_meta($user_id, $this->name, true);
		$this->value = get_user_meta($user_id, $this->name, true);

		return [$name, $id];
	}


	/* public function update_field_callback(int $user_id): bool|int
	{

		// check that the current user has the capability to edit the $user_id
		if (!current_user_can('edit_user', $user_id)) {
			return false;
		}

		$new_value = isset($_POST[$this->name]) ? $_POST[$this->name] : array();
		
		// Sanitize each value in the array
		//$sanitized_values = array_map('sanitize_text_field', $new_value);

		$rslt = update_user_meta(
			$user_id,
			$this->name,
			'Tarik'
		);

		// create/update user meta for the $user_id
		return $rslt;
	} */




	private function get_checkbox_html($item, $name, $id, $checked)
	{
		$html = <<<CHECK
			<label for="{$id}">
				<input type="checkbox" $checked{$name}{$id} value="{$item->value}" />
				{$item->lable}
			</label> <br>
		CHECK;

		return $html;
	}

	/**
	 * Get field HTML
	 *
	 *
	 * @return string
	 */
	public function genrate_html($user_id): string
	{
		[$name, $id] = $this->field_attr($user_id, '[]');

		$checkboxs_html = array_map(function ($item) use (&$name, &$id) {
			$checked = '';
			if ($item->value == $this->value)
				$checked = "checked = checked";


			return $this->get_checkbox_html($item, $name, $id, $checked);
		}, $this->options);

		$checkboxs_html = implode($checkboxs_html);

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
