<?php
namespace yso\interfaces;

interface UMBFieldBuilderInterface {
	public static function build($field_meta): null | UMBFieldInterface;
}