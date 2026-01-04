v0.10.1 - 2026-01-03
====================
Updated
-------
- Switching the way factories are injected into the helpers.


v0.10.0 - 2026-01-01
====================
Added
-----
- Added a factory method for injecting custom helpers into the PHP Engine.

v0.9.1 - 2025-08-07
===================
Fixed
-----
- Fixed bugs in the form sub system.

v0.9.0 - 2025-04-05
===================
Added
-----
- Extended the reach of typehints.
- A static method for creating an instance of the template renderer with default dependencies. 

v0.8.0 - 2024-07-13
===================
Added
-----
- Type hints to most methods

Fixed
-----
- The password field, to prevent it from showing as a plain text field.

v0.7.0 - 2023-03-31
===================
Changed
-------
- Completely rewrote the forms helper of the PHPEngine. The new forms helper uses less code and provides a simpler API. Completely shed all the weight from the WYF codebase.
- The PHPEngine's menu helper no longer generates default HTML classes and ids. Moving forward, these have to be explicitly added to the top level.

Fixed
-----
- Finally switched the smarty dependency to track `v4.x` releases. This helps keep up with the vulnerabilities in the code.
- Issues with internal variables leaking into the PHPEngine's rendering. This may need to be checked further for potential RCE vulnerabilities.

v0.6.5 - 2021-11-29
===================
Fixed
-----
- The `smarty` dependency to track the `v3.1.x` releases. Might consider switching to the PHP 8.0 version later.

Changed
-------
- The `PHPEngine` now uses the eval method to execute instrings instead of including the files directly.


v0.6.4 - 2020-05-15
===================
Fixed
-----
 - The `Template` can now be used without injecting its dependencies.
 - Styling and unset item notifications in pagination helper.
 - Issue with form input helpers that cause exceptions to be thrown in some cases where a form's value is `null`.
 - Pagination unit tests

v0.6.3 - 2020-02-06
===================
Fixed
-----
 - Fixed broken dependencies in previous release.

v0.6.2 - 2019-11-23
===================
Added
-----
 - Before attempting to resolve a template file, a check is made to find out if the file exists. If it does, it is used to render, and time is saved from template path resolution.

v0.6.1 - 2019-11-17
===================
Added
-----
 - Added a `Template` class to act as an access point to all the underlying template functions. You can consider this a facade of some sort.
 - Added a getter and setter for the path hierarchy in the template file resolver.

Fixed
-----
 - Broken comparison in the input template for the form helper

v0.6.0 - 2019-05-27
===================
First release with a changelog
