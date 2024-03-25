<?php

namespace yso\Test\PHPUnit;

use yso\fields\UFCGroupField;

class UFCGroupFieldTest extends CheckboxFieldCommonTestSetup
{

    protected static UFCGroupField $group_field;
    public static function set_up_before_class(): void
    {
        parent::set_up_before_class();
        self::$group_field = new UFCGroupField("Skills", [self::$checkboxFieldMale, self::$checkboxFieldFemale]);
    }


    public function tear_down()
    {
        parent::tear_down();
        unload_textdomain(USERFIELDCREATORDOMAIN);
    }

    /** @test */
    public function generate_html(): void
    {
        $checkboxFieldMale = self::$checkboxFieldMale;
        $checkboxFieldFemale = self::$checkboxFieldFemale;
        $expectedCheckboxHTML = self::get_expected_checkbox_html($checkboxFieldMale);
        $expectedFemaleCheckboxHTML = self::get_expected_checkbox_html($checkboxFieldFemale, '');

        $group_field = self::$group_field;
        $expected = "
        <tr>
            <th scope=\"row\">
                {$group_field->label}
            </th>
            <td>
                <fieldset>
                    $expectedCheckboxHTML
                    $expectedFemaleCheckboxHTML
                </fieldset>
            </td>
        </tr>
        ";


        $expected = self::minify_html($expected);

        // When we call get_checkbox_html method
        $rslt = self::$group_field->generate_html(self::$user_id);
        $rslt = self::minify_html($rslt);

        // then we assert both values are equal
        $this->assertEquals($expected, $rslt);
    }

}