# hiqdev/asset-packagist

## [1.0.0] - 2018-05-23

- Fixed XSS vulnerabilities ([@SilverFire])
- Added patch version support for `bower-asset/angular` ([@hiqsol])
- Added redirect to package page when its full name given ([@hiqsol])
- Refactored internals: RegistryFactory, Mutex <- Locker, logging ([@hiqsol], [@edgardmessias])
- Updated documentation ([@hiqsol], [@SilverFire], [@edgardmessias])
- Fixed use of `hidev` ([@hiqsol])
- Implemented package management using queues with [zhuravljov/yii2-queue] ([@SilverFire], [@edgardmessias], [@hiqsol], [@zhuravljov])
- Improved look, moved search form to NavBar, added color by stability in package details page ([@hiqsol], [@edgardmessias], [@SilverFire], [@tafid])
- Added order for packages releases ([@edgardmessias], [@SilverFire])
- Added `version_normalized` ([@SilverFire], [@edgardmessias])
- Added providing `require` to support dependencies of bower/npm packages ([@hiqsol])
- Added DB layer to store packages and their properties ([@SilverFire])
- Added dependencies auto resolving for new packages ([@SilverFire])
- Added automatic package avoiding for corrupted packages, enhanced error handling ([@SilverFire])
- Fixed minor issues ([@SilverFire], [@hiqsol], [yatsenco@gmail.com], [@edgardmessias], [et.coder@gmail.com], [jo@surikat.pro])

## [0.1.0] - 2016-05-31

- Fixed minor issues for first release ([@hiqsol], [sam@rmcreative.ru])
- Implemented package details page ([@SilverFire])
- Added and improved texts and package description ([@hiqsol], [@SilverFire])
- Added Top-1000 Bower packages ([@SilverFire], [@hiqsol])
- Changed: rearranged config files to new scheme ([@hiqsol])
- Changed: redone to `hiqdev/asset-packagist` ([@hiqsol])
- Added list operations ([@hiqsol])
- Added search ([@hiqsol])
- Chandged: redone with `Storage` and `Locker` ([@hiqsol])
- Added basics ([@hiqsol])

## [Development started] - 2016-04-02

[zhuravljov/yii2-queue]: https://github.com/zhuravljov/yii2-queue
[fxpio/composer-asset-plugin]: https://github.com/fxpio/composer-asset-plugin
[@hiqsol]: https://github.com/hiqsol
[sol@hiqdev.com]: https://github.com/hiqsol
[@SilverFire]: https://github.com/SilverFire
[d.naumenko.a@gmail.com]: https://github.com/SilverFire
[@tafid]: https://github.com/tafid
[andreyklochok@gmail.com]: https://github.com/tafid
[@BladeRoot]: https://github.com/BladeRoot
[bladeroot@gmail.com]: https://github.com/BladeRoot
[@edgardmessias]: https://github.com/edgardmessias
[edgardmessias@gmail.com]: https://github.com/edgardmessias
[@zhuravljov]: https://github.com/zhuravljov
[zhuravljov@gmail.com]: https://github.com/zhuravljov
[Under development]: https://github.com/hiqdev/asset-packagist/compare/0.1.0...HEAD
[0.1.0]: https://github.com/hiqdev/asset-packagist/releases/tag/0.1.0
[1.0.0]: https://github.com/hiqdev/asset-packagist/compare/0.1.0...1.0.0
