<?php
namespace yso\interfaces;

interface UFCFieldBuilderInterface {
	public static function build($field_meta): null | UFCFieldInterface;
}