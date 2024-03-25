<?php

class UserFieldCreatorTest extends WP_UnitTestCase {

    public function test_constants () {
        $this->assertSame( 'user-field-creator', USERFIELDCREATORDOMAIN );
    }
}