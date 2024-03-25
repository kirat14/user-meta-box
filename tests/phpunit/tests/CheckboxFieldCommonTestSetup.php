<?php

namespace yso\Test\PHPUnit;

use WP_UnitTestCase;
use yso\fields\UFCCheckboxField;

class CheckboxFieldCommonTestSetup extends WP_UnitTestCase
{
    protected static UFCCheckboxField $checkboxFieldMale;
    protected static UFCCheckboxField $checkboxFieldFemale;
    protected static int $user_id;
    protected static string $expectedCheckboxHTML;

    public static function set_up_before_class()
    {
        parent::set_up_before_class();
        self::$user_id = self::get_user_id();

        self::$checkboxFieldMale = new UFCCheckboxField('student-sex-male', 'student-sex-male', 'male', 'Male');
        self::$checkboxFieldFemale = new UFCCheckboxField('student-sex-female', 'student-sex-female', 'female', 'Female');

        update_user_meta(self::$user_id, self::$checkboxFieldMale->name, self::$checkboxFieldMale->value);
    }

    protected static function get_user_id(): int
    {
        $factory = new \WP_UnitTest_Factory();
        $userdata = array(
            'ID' => 1, 	//(int) User ID. If supplied, the user will be updated.
            'user_pass' => 'test', 	//(string) The plain-text user password.
            'user_login' => 'test_login', 	//(string) The user's login username.
            'user_email' => 'test@gmail.com', 	//(string) The user email address.
            'display_name' => 'test', 	//(string) The user's display name. Default is the user's username.
            'first_name' => 'test', 	//(string) The user's first name. For new users, will be used to build the first part of the user's display name if $display_name is not specified.
            'last_name' => 'test', 	//(string) The user's last name. For new users, will be used to build the second part of the user's display name if $display_name is not specified.
            'role' => 'admin', 	//(string) User's role.        
        );

        $user_id = $factory->user->create($userdata);
        return $user_id;
    }


    protected static function minify_html($html)
    {
        // Remove extra spaces and line breaks
        return preg_replace('/\s+(?=<)|(?<=>)\s+/s', '', $html);
    }

    protected static function get_expected_checkbox_html(UFCCheckboxField $checkbox, $checked = ' checked = "checked"'): string {

        $expectedCheckboxHTML = "
        <label for=\"{$checkbox->id}\">
            <input type=\"checkbox\" name=\"{$checkbox->name}\" id=\"{$checkbox->id}\" value=\"{$checkbox->value}\"$checked />
            {$checkbox->label}
        </label><br>
        ";

        $expectedCheckboxHTML = self::minify_html($expectedCheckboxHTML);

        return $expectedCheckboxHTML;
    }

    /** @test */
    public function checkbox_value_equals_male(): void
    {
        $this->assertEquals('male', self::$checkboxFieldMale->value);
    }
}