<?php

use yso\builders\UMBFieldBuilder;
use yso\fields\UMBCheckboxField;
use yso\fields\UMBSelectField;
use yso\fields\UMBTextField;

class UMBFieldBuilderTest extends WP_UnitTestCase
{
    public function testBuildSelectField()
    {
        $field_meta = (object) array(
            'name' => 'student-degree',
            'id' => 'student-degree',
            'defaultValue' => 0,
            'options' => array(
                'Bachelor',
                'Master'
            ),
            'label' => 'Student Degree',
            'type' => 'select',
            'extraAttr' => ''
        );


        $field = UMBFieldBuilder::build($field_meta);

        $this->assertInstanceOf(UMBSelectField::class, $field);
    }

    // Add more test methods to cover other scenarios and edge cases

    public function testBuildWithoutName()
    {
        $field_meta = (object) array(
            'defaultValue' => 0,
            'options' => array(
                'Bachelor',
                'Master'
            ),
            'label' => 'Student Degree',
            'type' => 'select',
            'extraAttr' => ''
        );

        $field = UMBFieldBuilder::build($field_meta);

        $this->assertNull($field);
    }
}