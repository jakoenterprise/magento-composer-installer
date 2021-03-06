## Change Log
All notable changes to this project will be documented in this file.  
This project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased][unreleased]
- Reverted PR [#34](https://github.com/Cotya/magento-composer-installer/pull/34) in favor of a simpler solution without breaking BC
- Fixed issue [#7](https://github.com/Cotya/magento-composer-installer/issues/7) by filtering out Aliased Packages. This was with branch-aliasing where composer gave us two packages for the same module when it was setup to use branch aliasing
- Fixed issue [#33](https://github.com/Cotya/magento-composer-installer/issues/33) by using the source reference from the composer package as part of the internal version number for tracking packages

## [3.0.4-beta1] - 2015-06-10
- Fixed error when redeploying with no modules, using PHP 5.3.
- Fixed the Patcher throwing an exception if `app/Mage.php` was missing, 
  even when `with-bootstrap-patch` was set to `false`.
- Changed Patcher throwing an exception to just output a *comment* Message
- Add sourceReference support for installed.json, fixes issues with updates for dev-master type repositories
  where version is not a good indication of updates.
- Remove exception for `InstalledPackageFileSystemRepository::add()` method,
  the function is used for both updates and new installs.
- Relaxed the Plugin API constraint to `~1.0` so that the next version 
  bump won't exclude this installer.
- Updated dependencies' versions.

## [3.0.3] - 2015-06-02
- Added a change log file

## [3.0.3-rc.2] - 2015-05-20
- The patching process was changed to _not_ create additional files (`bootstrap.php`, `Mage.class.php` etc.).
  Now, only the native `app/Mage.php` is changed.
- [New documentation](https://github.com/Cotya/magento-composer-installer/blob/3.0/doc/Autoloading.md) about the autoloader patching was added.
- Composer dependencies were updated

## [3.0.3-rc.1] - 2015-05-04
- New boolean `extra` config: `with-bootstrap-patch`. It controls whether the `app/Mage.php`
  file will be patched with the Composer autoloader ability. Defaults to `true`.
- Fixed unit tests calling Composer commands using a hardcoded `composer.phar`, breaking
  for people which had their command renamed to `composer`.
- Added support for modman's style of declaring just the source file (see [example](https://github.com/colinmollenhour/modman/blob/d58b80f2f9e60d3287577480ad78066d44ed530c/modman#L109-L110)).

## 3.0.2 - 2015-03-28

[unreleased]: https://github.com/Cotya/magento-composer-installer/compare/3.0.4-beta1...HEAD
[3.0.4-beta1]: https://github.com/Cotya/magento-composer-installer/compare/3.0.3...3.0.4-beta1
[3.0.3]: https://github.com/Cotya/magento-composer-installer/compare/3.0.3-rc.2...3.0.3
[3.0.3-rc.2]: https://github.com/Cotya/magento-composer-installer/compare/3.0.3-rc.1...3.0.3-rc.2
[3.0.3-rc.1]: https://github.com/Cotya/magento-composer-installer/compare/3.0.2...3.0.3-rc.1
