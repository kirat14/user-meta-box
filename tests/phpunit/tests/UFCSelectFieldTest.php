<?php
use yso\fields\UFCSelectField;


class UFCSelectFieldTest extends WP_UnitTestCase
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
    public function generate_html_for_input_text()
    {
        // setup
        $selectField = new UFCSelectField('sexe', 'sexe', '616006', ['male', 'female'], 'Sexe');
        update_user_meta(self::$user_id, $selectField->name, '0');

        // Get actual value
        $actual = $selectField->generate_html(self::$user_id);
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
                <select name=\"UFC-sexe\" id=\"UFC-sexe\">
                    <option value=\"0\" selected = \"selected\">male</option>
                    <option value=\"1\">female</option>
                </select>
            </td>
        </tr>";

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