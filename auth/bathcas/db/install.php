<?php

function xmldb_auth_bathcas_install() {
    global $CFG, $DB;

    // upgrade from 1.9.x, introducing version.php

    // remove cached passwords, we do not need them for this plugin
    $DB->set_field('user', 'password', 'not cached', array('auth'=>'bathcas'));

    // We kept the LDAP version used to connect to the server in
    // $config->version. In 2.0, $config->version is overwritten with
    // the plugin version number, so we need to change the setting
    // name. Let's call it 'ldap_version' and remove the old setting.
    //
    // This works by pure luck, as the plugin version number is stored in
    // config_plugins table before we get called. The good news is the new
    // version number is stored for 'auth_bathcas' plugin name, while the old ldap
    // version setting is stored for 'auth/bathcas' plugin name. Yay!
    if ($ldap_version = get_config('auth/bathcas', 'version')) {
        set_config('ldap_version', $ldap_version, 'auth/bathcas');
        unset_config('version', 'auth/bathcas');
    }
}