<?php

use yso\Test\PHPUnit\CheckboxFieldCommonTestSetup;

class UFCCheckboxFieldTest extends CheckboxFieldCommonTestSetup
{

    public static function set_up_before_class(): void
    {
        parent::set_up_before_class();
    }


    public function tear_down()
    {
        parent::tear_down();
        unload_textdomain(USERFIELDCREATORDOMAIN);
    }


    /** @test */
    public function get_checkbox_html(): string
    {
        // setup
        $checkboxField = self::$checkboxFieldMale;
        $expectedCheckboxHTML = self::get_expected_checkbox_html($checkboxField);

        // When we call get_checkbox_html method
        $rslt = $checkboxField->get_checkbox_html(self::$user_id);
        $rslt = UFCCheckboxFieldTest::minify_html($rslt);

        // then we assert both values are equal
        $this->assertEquals($expectedCheckboxHTML, $rslt);

        return $expectedCheckboxHTML;
    }

    /** 
     * @test 
     * @depends get_checkbox_html
     */
    public function generate_html($expectedCheckboxHTML): void
    {
        $checkboxField = self::$checkboxFieldMale;
        $expected = "
    <tr>
        <th scope=\"row\">
            {$checkboxField->label}
        </th>
        <td>
            <fieldset>
                $expectedCheckboxHTML
            </fieldset>
        </td>
    </tr>
";


        $expected = UFCCheckboxFieldTest::minify_html($expected);

        // When we call get_checkbox_html method
        $rslt = $checkboxField->generate_html(self::$user_id);
        $rslt = UFCCheckboxFieldTest::minify_html($rslt);

        // then we assert both values are equal
        $this->assertEquals($expected, $rslt);
    }


}