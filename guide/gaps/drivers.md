# Drivers

The following drivers are currently provided:

* `text` as default driver for non-relationship attributes.
* `textarea` for textareas.
* [`select`]/drivers/select) for selects.
* `password` for password inputs.
* [`file`](drivers/file) for file upload.
* [`bool`](drivers/bool) for checkboxes.
* [`password_confirm`](drivers/password-confirm) for password creation including a password input to confirm the entered password.
* [`belongs_to`](drivers/belongs-to) as default driver for `belongs_to` relationships.
* [`has_many`](drivers/has-many) as default driver for `has_many` relationships using checkboxes.
* `has_many_select` uses a select for `has_many` relationships.

For some of the drivers additional configuration is needed in addition to the [driver independant configuration](model-configuration.md) options.