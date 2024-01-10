<?php
namespace yso\interfaces;

interface UMBField {
	/**
	 * Generate current field html.
	 *
	 * @param  int    $user_id.
	 * @return string
	 */
	public function genrate_html(int $user_id): string;

    /**
	 * Invokes update_user_meta.
	 *
	 * @param  int    $user_id.
	 * @return bool|int
	 */
	public function update_field_callback(int $user_id): bool|int;
}