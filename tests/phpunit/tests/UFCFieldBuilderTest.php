<?php

use yso\builders\UFCFieldBuilder;
use yso\fields\UFCCheckboxField;
use yso\fields\UFCSelectField;
use yso\fields\UFCTextField;

class UFCFieldBuilderTest extends WP_UnitTestCase
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


        $field = UFCFieldBuilder::build($field_meta);

        $this->assertInstanceOf(UFCSelectField::class, $field);
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

        $field = UFCFieldBuilder::build($field_meta);

        $this->assertNull($field);
    }
}