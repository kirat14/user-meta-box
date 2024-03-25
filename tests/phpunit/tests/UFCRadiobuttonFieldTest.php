<?php
use yso\fields\UFCRadiobuttonField;

class UFCRadiobuttonFieldTest extends WP_UnitTestCase
{
    public static int $user_id;
    public static function set_up_before_class()
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

        self::$user_id = $factory->user->create($userdata);
    }
    /** @test */
    public function generate_html()
    {
        // setup
        $radiobutton_field = new UFCRadiobuttonField('sexe', 'sexe', 'male', ['male', 'female'], 'Sexe');
        update_user_meta(self::$user_id, $radiobutton_field->name, $radiobutton_field->value);

        // Get actual value
        $actual = $radiobutton_field->generate_html(self::$user_id);
        $actual = self::minify_html($actual);

        // Expected value
        $expected_value = "
        <tr>
            <th>
                <label for=\"UFC-sexe\">
                    Sexe
                </label>
            </th>
            <td>
                <label>
					<input type=\"radio\" value=\"male\" checked = \"checked\" name=\"$radiobutton_field->name\">
					Male
				</label><br>
                <label>
					<input type=\"radio\" value=\"female\" name=\"$radiobutton_field->name\">
					Female
				</label>
            </td>
        </tr>
        ";

        $expected_value = self::minify_html($expected_value);

        // then we assert both values are equal
        $this->assertEquals($expected_value, $actual);
    }

    protected static function minify_html($html)
    {
        // Remove extra spaces and line breaks
        return preg_replace('/\s+(?=<)|(?<=>)\s+/s', '', $html);
    }
}