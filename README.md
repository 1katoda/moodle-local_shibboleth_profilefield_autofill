# local_shibboleth_profilefield_autofill

This plugin allows automatic filling of a profile field when user accesses the Shibboleth-protected endpoint `/local/shibboleth_profilefield_autofill/index.php`

## Use

- administrator adds a required profile field for users to write their shibboleth username
- administrator sets up this plugin with the name of the server-provided attribute and profile field
- administrator adds a link to `/local/shibboleth_profilefield_autofill/index.php` in the profile field description
- users can fill out the profile field by clicking on the provided link

## Install

Plugin installation:
- download / clone the repository
- rename and move the repository to `local/shibboleth_profilefield_autofill`
