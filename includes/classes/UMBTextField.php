<?php
namespace yso\classes;

// disable direct file access
if (!defined('ABSPATH')) {
	exit;
}

use \yso\interfaces\UMBField;

class UMBTextField implements UMBField
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
		$name = " name='{$this->name}'";
		$id = " id='{$this->id}'";
		// Check if the user meta has been already added
		$value = esc_attr( get_user_meta( $user_id, $this->name, true ) );
		
		if(!empty($this->value))
			$this->value = $value;

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

	public function update_field_callback(int $user_id): bool|int
	{
		// check that the current user have the capability to edit the $user_id
		if (!current_user_can('edit_user', $user_id)) {
			return false;
		}
		$rslt = update_user_meta(
			$user_id,
			$this->name,
			$_POST[$this->name]
		);
		// create/update user meta for the $user_id
		return $rslt;


	}
}