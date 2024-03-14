<?php

namespace yso\classes;

// disable direct file access
if (!defined('ABSPATH')) {
    exit;
}

class UserMetaData
{
    private string $json;
    private function __construct()
    {
        $this->init();
        // activation
        register_activation_hook(__FILE__, array($this, 'activate'));
        // deactivation
        register_activation_hook(__FILE__, array($this, 'deactivate'));
    }

    public static function instance()
    {
        static $instance = null;

        if (is_null($instance)) {
            $instance = new UserMetaData();
        }

        return $instance;
    }

    public function init()
    {
        $this->read_json_user_data();
        // Check if a json file exists
        if ($this->json !== false) {
            $json_objs = json_decode($this->json);


            foreach ($json_objs as $json_obj) {

                $rules = [];
                if (property_exists($json_obj, 'rules'))
                    $rules = $json_obj->rules;

                $userProfileSection = new UserProfileSection($json_obj->boxTitle, $rules);
                try {
                    $userProfileSection->create_fields($json_obj->fields);
                }
                catch(\Exception $e){
                    error_log('There is a great chance that your json is not well structred ' . $e->getMessage());
                }
                $userProfileSection->init();
            }
        }
    }

    function read_json_user_data()
    {
        $jsonFieldsPath = dirname(USERMETABOXPATH);
        $this->json = file_get_contents($jsonFieldsPath . "\demo-data.json");
        $this->json = str_replace("{*}", "umb-", $this->json);
    }


    public function activate()
    {
    }

    public function deactivate()
    {
    }
    public function uninstall()
    {
    }
}