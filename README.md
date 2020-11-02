# local plugin to test mdl-69954 patch
* install given patch (see patch sub directory)
## unit tests
Just to test what is necessary
```bash
/moodle_patch/vendor/bin/phpunit "local_mdl_69954_patch_testcase" local/mdl_69954/tests/patch_test.php
```

## functional tests
* in case of patch installed run
```bash
cd /moodle_path
vendor/bin/behat --config /mdl_farm_path/behatrun/behat/behat.yml  /moodle_path/local/mdl_69954/tests/behat/edit_user_roles_with_patch.feature
```
should succeed, fail without patch installed
* in case of patch not installed
```bash
cd /moodle_path
vendor/bin/behat --config /mdl_farm_path/behatrun/behat/behat.yml  /moodle_path/local/mdl_69954/tests/behat/edit_user_roles_without_patch.feature
```
should succed, if patched fail