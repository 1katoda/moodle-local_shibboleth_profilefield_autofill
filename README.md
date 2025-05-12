# local_shibboleth_profilefield_autofill

This plugin allows automatic filling of a profile field when user accesses the Shibboleth-protected endpoint `/local/shibboleth_profilefield_autofill/index.php`

## Use

- administrator adds a required profile field for users to write their shibboleth username
- administrator sets up this plugin with the name of the server-provided attribute and profile field
- administrator adds a link to `/local/shibboleth_profilefield_autofill/index.php` in the profile field description
- users can fill out the profile field by clicking on the provided link

### A more specific use-case

Let's say we have a Moodle installation with various users with multiple accounts, some created with manual authentication and some with shibboleth. We want the manual accounts to have a custom profile field that contains a username that corresponds to their shibboleth account for purposes of filtering, modifying or merging manual and shibboleth accounts.

In combination with [profilefield_limitrequired](https://github.com/1katoda/moodle-profilefield_limitrequired), we can set up a profile field that is disabled (so that users cannot manually write an invalid username) and required only for users, created as **manual** accounts, so that they will have to fill out the field on their next login. For this fields description, a link is provided to the `/local/shibboleth_profilefield_autofill/index.php` endpoint, so that the user may click on it to autofill the profile field.

Then, this plugin is set up for the correct shibboleth attribute and the newly created profile field. The endpoint `/local/shibboleth_profilefield_autofill/index.php` has to be protected by Shibboleth (like when setting up `auth_shibboleth`), so that the attributes are pushed to Moodle.

When all is set up, any user with **manual** account that logs in is redirected to their profile editing page, where they have to fill out a disabled but required field. They click on the link to this plugins Shibboleth-protected endpoint in the description, which initiates Shibboleth login, after which the user lands on this plugins endpoint, where the specified profile field is filled with the specified attribute and the user is redirected back to the root page.

## Install

Plugin installation:
- download / clone the repository
- rename and move the repository to `local/shibboleth_profilefield_autofill`
