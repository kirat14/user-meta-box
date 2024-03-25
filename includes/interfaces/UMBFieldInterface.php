<?php
namespace yso\interfaces;

interface UMBFieldInterface {
	/**
	 * Generate current field html.
	 *
	 * @param  int    $user_id.
	 * @return string
	 */
	public function generate_html($user_id): string;

	public function update_user_meta($user_id): void;
}