# hiqdev/asset-packagist

## [Under development]

- Fixed XSS vulnerabilities
    - [92c0fd7] 2017-12-11 Fixed XSS vulnerabilities [@SilverFire]
- Added patch version support for `bower-asset/angular`
    - [be126d4] 2017-10-01 added converting patch version to RC for bower-asset/angular [@hiqsol]
- Added redirect to package page when its full name given
    - [eb93960] 2017-07-04 improved search: added redirect to package page when full name given [@hiqsol]
- Refactored internals: RegistryFactory, Mutex <- Locker, logging
    - [cd0f3cc] 2017-05-18 csfixed [@hiqsol]
    - [b76fbcd] 2017-05-18 Merge pull request #50 from edgardmessias/refactored [@hiqsol]
    - [dc47aff] 2017-05-16 Added comments [@edgardmessias]
    - [863dea3] 2017-05-16 Refactored RegistryFactory [@edgardmessias]
    - [1f0abde] 2017-05-12 Merge pull request #48 from `edgardmessias/locker_to_mutex` [@hiqsol]
    - [035f1ea] 2017-05-12 Merge pull request #49 from `edgardmessias/queue_jobs` [@hiqsol]
    - [6f7aaae] 2017-05-11 Serialize only the name of package for more performance in queue jobs [@edgardmessias]
    - [ab5e2bd] 2017-05-11 Switch Locker to Mutex (Close #47) [@edgardmessias]
    - [257b2f5] 2017-05-10 csfixed [@hiqsol]
    - [b1a7d9c] 2017-05-10 Merge pull request #44 from `edgardmessias/composer_log` [@hiqsol]
    - [0aa27f6] 2017-05-08 Added composer log into Yii [@edgardmessias]
- Updated documentation
    - [5b5f435] 2017-05-10 docs [@hiqsol]
    - [2dd8b25] 2016-06-16 added Yii2 section to about page [@hiqsol]
    - [a607125] 2016-06-09 added Installing to a custom path manual [@hiqsol]
    - [e3cb136] 2016-06-03 added how it works on about page [@hiqsol]
    - [ec7bbcd] 2017-04-27 Enhanced wording [@SilverFire]
    - [d4fee59] 2017-04-25 Update documentation to use oomphinc/composer-installers-extender [@SilverFire]
    - [87e2662] 2017-04-25 Fixed syntax error in AssetPackage [@SilverFire]
    - [5a70619] 2017-04-24 Merge pull request #30 from edgardmessias/patch-1 [@SilverFire]
    - [de93971] 2017-04-20 Updated example in about page [@edgardmessias]
- Fixed use of `hidev`
    - [eabafbb] 2017-05-10 fixed storage actions in goals [@hiqsol]
    - [d8b5b87] 2017-05-10 added require hidev (to substitute yii) [@hiqsol]
    - [4c94e8f] 2017-05-08 fixed tests [@hiqsol]
    - [122874e] 2017-05-08 csfixed [@hiqsol]
    - [5390524] 2017-05-05 fixed config for controllers [@hiqsol]
    - [d89b68c] 2017-05-04 fixed hidev config for hidev 0.6 [@hiqsol]
    - [b850cba] 2017-05-05 renamed configs `web`, `console` <- hisite, hidev [@hiqsol]
- Implemented package management using queues with [zhuravljov/yii2-queue]
    - [9f54f52] 2017-09-29 Updated to use `yiisoft/yii2-queue`, implemented sequention jobs execution limit [@SilverFire]
    - [2ba21ee] 2017-09-29 Switched to yiisoft/yii2-queue [@SilverFire]
    - [9b7d7ff] 2017-09-21 Added migration to follow yii2-queue API changes [@SilverFire]
    - [88b96a6] 2018-05-23 Updated `QueueController` to follow yii2-queue API changes [@SilverFire]
    - [ace352d] 2017-05-05 Merge pull request #42 from edgardmessias/fix-queue [@SilverFire]
    - [7c5d01d] 2017-05-05 Fixed [zhuravljov/yii2-queue] API changes [@edgardmessias]
    - [b07d11b] 2017-05-04 Updated to follow [zhuravljov/yii2-queue] API changes [@SilverFire]
    - [a72bade] 2017-05-05 csfixed [@hiqsol]
    - [7a3380c] 2017-05-05 Merge pull request #41 from edgardmessias/patch-6 [@hiqsol]
    - [b781661] 2017-05-04 Ignored AliasPackage (Close #40) [@edgardmessias]
    - [7fb4ac1] 2017-03-30 Merge pull request #29 from zhuravljov/master [@SilverFire]
    - [9e4c259] 2017-03-30 Last changes for [zhuravljov/yii2-queue] [@zhuravljov]
    - [c0bfeb1] 2016-12-19 Do not save succesfully finished jobs in Queue [@SilverFire]
    - [9eb09aa] 2016-12-07 Updated to follow changes [zhuravljov/yii2-queue] [@zhuravljov]
    - [cb803cb] 2016-12-06 Updated QueueController to follow changes in [zhuravljov/yii2-queue] [@SilverFire]
    - [5ff526c] 2016-12-01 Added maintenance/update-expired action [@SilverFire]
    - [9515fd0] 2016-12-01 Refactored Storage - added StorageInterface, changes visibiliy of some method [@SilverFire]
    - [bc20b98] 2016-11-30 Fixed typo [@SilverFire]
- Improved look, moved search form to NavBar, added color by stability in package details page
    - [d428eef] 2017-05-27 added require yii2-hiart-librariesio and yii2-hiart-guzzle [@hiqsol]
    - [2ec9f08] 2017-05-27 Merge pull request #52 from edgardmessias/improved_search [@hiqsol]
    - [b9972eb] 2017-05-24 Added image by platform in result search [@edgardmessias]
    - [9f04bf5] 2017-05-24 Added "Powered by libraries.io" [@edgardmessias]
    - [3511c98] 2017-05-23 Improved Search using libraries.io (Close #36) [@edgardmessias]
    - [33befd4] 2017-05-11 added container class in outer div [@hiqsol]
    - [856c104] 2017-05-10 added breadcrumbs and subtitle for pages [@hiqsol]
    - [6aa8285] 2017-05-10 fixed navbar menu [@hiqsol]
    - [7f3a5b4] 2017-05-10 removed flat theme tuning views [@hiqsol]
    - [bbbb7b5] 2017-05-10 added NavbarMenu with search form [@hiqsol]
    - [ca928cf] 2017-05-10 moved theme tuning to views/themes [@hiqsol]
    - [cd5c912] 2017-05-10 added search form into main menu [@hiqsol]
    - [300594c] 2017-05-10 removed original theme tuning [@hiqsol]
    - [6438a47] 2017-05-04 Revert "Fixed styles" [@SilverFire]
    - [b599663] 2017-05-04 Fixed styles [@SilverFire]
    - [404f689] 2017-04-28 Code style adjustment [@SilverFire]
    - [c226cff] 2017-04-28 Moved `_after_header` to Flat theme layout [@tafid]
    - [7f43b83] 2017-04-28 Changed css styles [@tafid]
    - [1ed2835] 2017-04-28 Added AppAsset bundle to config [@tafid]
    - [5b0a29f] 2017-04-28 Added FontAwesome like defer [@tafid]
    - [f5f7713] 2017-04-28 Added layouts for Original theme [@tafid]
    - [9a8db4a] 2017-04-28 Added layouts for Flat theme [@tafid]
    - [1aa2d23] 2017-04-28 Merge pull request #35 from edgardmessias/patch-5 [@SilverFire]
    - [edcc58c] 2017-04-28 Added color by stability [@edgardmessias]
- Added order for packages releases
    - [8542c16] 2017-05-16 Refactored package sort [@edgardmessias]
    - [f87848c] 2017-04-27 Merge pull request #32 from edgardmessias/patch-3 [@SilverFire]
    - [0ea6a4a] 2017-04-27 Code style fixed [@SilverFire]
    - [1ae0b89] 2017-04-27 Added order for packages releases [@edgardmessias]
- Added `version_normalized`
    - [76f75df] 2017-04-27 Merge pull request #31 from edgardmessias/patch-2 [@SilverFire]
    - [383e494] 2017-04-27 Updated changelog [@SilverFire]
    - [85a5314] 2017-04-26 Added `version_normalized` [@edgardmessias]
- Added providing `require` to support dependencies of bower/npm packages
    - [03c8992] 2016-08-13 added providing `require` to AssetPackage #14 [@hiqsol]
- Added DB layer to store packages and their properties
    - [d1130a1] 2016-11-30 Added packages table. Added duplication prevention. [@SilverFire]
- Added dependencies auto resolving for new packages
    - [22ab667] 2016-11-30 Added Package dependencies resolving [@SilverFire]
    - [5a29a01] 2016-11-29 Added common config [@SilverFire]
- Added automatic package avoiding for corrupted packages, enhanced error handling
    - [257eb43] 2017-04-27 csfixed [@SilverFire]
    - [6330bce] 2016-12-19 Enhanced Storage to report file system errors [@SilverFire]
    - [e482226] 2016-11-30 Enhanced error handling in PackageUpdateCommand [@SilverFire]
    - [0437aee] 2017-04-26 Refactored UpdateController, enhanced error handling [@SilverFire]
    - [a0562a3] 2017-04-24 Added package avoiding [@SilverFire]
    - [bb771de] 2017-04-24 Added migration for package avoiding [@SilverFire]
    - [a96ef4b] 2017-04-27 Added AssetPackageController::actionAvoid [@SilverFire]
    - [bd5dca3] 2017-04-27 Enhanced error handling, implemented auto-ignoring [@SilverFire]
    - [cfd2352] 2017-04-27 Added AssetPackageController::actionAddUpdateCommand() [@SilverFire]
    - [e22d364] 2017-04-27 Fixed PackageRepository::getExpiredForUpdate() [@SilverFire]
    - [7d20e30] 2017-04-26 Enhanced error handling [@SilverFire]
    - [bdc0fb1] 2017-04-26 Enhanced package info displaying [@SilverFire]
    - [1c947e1] 2017-04-26 Bootstarap log module [@SilverFire]
- Fixed minor issues
    - [ea55b5c] 2017-06-30 switched icons to fixed weight fontawesome [@hiqsol]
    - [8a5882e] 2017-06-30 csfixed [@hiqsol]
    - [a5f52c5] 2017-06-30 added AppAsset to be registered by themeManager at startup [@hiqsol]
    - [f4dc2fc] 2017-06-16 Merge pull request #56 from anyt/add_license_information_to_package_info [@hiqsol]
    - [b2c50d1] 2017-06-15 Added license information to package info. [yatsenco@gmail.com]
    - [38e5b4b] 2017-05-27 added icon for License at _search_item [@hiqsol]
    - [8ea9f6b] 2017-05-27 redone to use `yii2-hiart-librariesio` [@hiqsol]
    - [68e6592] 2017-05-27 added AssetPackage::isAvailable and buildNormalName [@hiqsol]
    - [eb5f5d9] 2017-10-01 added `normalizeScopedName` [@hiqsol]
    - [052b795] 2017-07-17 moved `yiisoft/yii2-debug` to require-dev closes #46 [@hiqsol]
    - [e1f21c7] 2017-12-16 Merge pull request #75 from and800/master [@hiqsol]
    - [0365f77] 2017-10-20 Merge pull request #73 from SilverFire/master [@hiqsol]
    - [27ad14d] 2017-10-20 Updated fxp/composer-asset-plugin constraint to ^1.4.2 [@SilverFire]
    - [843800f] 2018-02-17 typo [@hiqsol]
    - [59e4260] 2017-04-24 Fixed to follow FXP/composer-asset-plugin API changes [@SilverFire]
    - [c95600b] 2017-05-08 Merge pull request #43 from `edgardmessias/fix_urls` [@SilverFire]
    - [2c47200] 2017-05-08 Fixed urls for use in urlManager [@edgardmessias]
    - [399d379] 2017-03-02 Merge pull request #27 from githubjeka/patch-1 [@hiqsol]
    - [0afdfd2] 2017-03-02 improved query param [et.coder@gmail.com]
    - [1a3454c] 2017-01-12 add github issue template [@hiqsol]
    - [dc4ccd1] 2016-12-08 Merge pull request #22 from zhuravljov/master [@SilverFire]
    - [e14172c] 2017-04-27 Added STAT cache cleaning in Storage [@SilverFire]
    - [a5fb28b] 2017-04-27 Enhanced Storage::writePackagesJson() to touch file after update [@SilverFire]
    - [d34e57b] 2017-04-23 csfixed [@hiqsol]
    - [e547396] 2017-04-21 removed require theme, moved to root package [@hiqsol]
    - [5de31be] 2017-04-21 Fixed DIC configuration [@SilverFire]
    - [bb6c7ad] 2017-04-21 removed outdated config/web [@hiqsol]
    - [90d9aee] 2017-04-21 added default `favicon.ico` (empty for the moment) [@hiqsol]
    - [5918e90] 2017-04-21 fixed namespace [@hiqsol]
    - [73f4c57] 2017-04-21 updated config, removed Bootstrap [@hiqsol]
    - [d212aec] 2017-04-20 Added package type [@edgardmessias]
    - [c8357d5] 2016-07-06 fixed `AssetPackage::checkName()` [@hiqsol]
    - [25011fc] 2016-07-06 added `@composer` alias [@hiqsol]
    - [8ee6ad3] 2016-06-23 merged [@hiqsol]
    - [5935538] 2016-06-24 Merge pull request #9 from redcatphp/master [@hiqsol]
    - [4b7abfa] 2016-06-23 minor issues fixes from Jo Surikat [@hiqsol]
    - [75f260a] 2016-06-23 fixed getting Storage object [@hiqsol]
    - [b13b523] 2016-06-23 add missing getInstance, return excpected type when empty, check isset [jo@surikat.pro]
    - [2ea4464] 2016-06-23 csfixed [@hiqsol]
    - [38dba2f] 2016-06-23 Merge pull request #8 from redcatphp/master [@hiqsol]
    - [344c0d7] 2016-06-23 avoid undefined index "dist" or "source" error [jo@surikat.pro]
    - [e23568a] 2016-06-23 avoid undefined index "searchQuery" error [jo@surikat.pro]
    - [ec4c66d] 2016-06-23 improved storage create and chmod [@hiqsol]
    - [5939201] 2016-06-23 + packageStorage component to hidev config [@hiqsol]
    - [f105752] 2016-06-23 Merge pull request #6 from redcatphp/master [@hiqsol]
    - [78ca261] 2016-06-23 typo fix class hiqdev\assetpackagist\components\AssetPackage not found [jo@surikat.pro]
    - [4986993] 2016-06-16 fixed #3 removed search option from packages.json [@hiqsol]
    - [5138f54] 2016-06-16 added displaying last updated at package details [@hiqsol]
    - [d35611e] 2016-06-16 fixed problems with character case [@hiqsol]
    - [ecf5aef] 2016-06-16 removed breadcrumbs [@hiqsol]
    - [5be5f6b] 2016-09-29 moved and moved menus to own folder [@hiqsol]
    - [ddfa3ac] 2016-09-29 + more ignores [@hiqsol]
    - [224f496] 2016-09-29 csfixed [@hiqsol]
    - [db4966b] 2016-09-01 used PoweredBy widget [@hiqsol]
    - [e69ed1c] 2016-08-31 redoing to hisite [@hiqsol]
    - [b5b2fa7] 2016-08-22 + footer menu [@hiqsol]
    - [41033a6] 2016-08-22 + standart actions: error and captcha [@hiqsol]
    - [e72a72a] 2016-08-22 + require `yii2-pnotify` [@hiqsol]
    - [6452275] 2016-08-22 added noTitle param for flat theme [@hiqsol]
    - [cf3855f] 2016-08-22 added menu, simplified config [@hiqsol]
    - [62c099e] 2016-08-21 + require hisite-core and themes [@hiqsol]
    - [442259c] 2016-08-20 + `session_write_close` in site/update [@hiqsol]
    - [55e1777] 2016-08-13 redone bumping to use `chkipper` [@hiqsol]

## [0.1.0] - 2016-05-31

- Fixed minor issues for first release
    - [4471376] 2016-05-30 + notFound page [@hiqsol]
    - [1f862c1] 2016-05-30 + buildPackageUrl() [@hiqsol]
    - [80fb19c] 2016-05-26 fixing chmod-storage goal [@hiqsol]
    - [6f6392a] 2016-05-26 added aliases to composer-config-plugin [@hiqsol]
    - [ffd2ad5] 2016-05-26 redoing to composer-config-plugin [@hiqsol]
    - [a1478ad] 2016-05-26 redoing to `composer-config-plugin` [@hiqsol]
    - [133a210] 2016-05-05 fixed dependencies constraints [@hiqsol]
    - [e0c6316] 2016-05-04 added `params-local.php` [@hiqsol]
    - [305b331] 2016-05-04 fixed version constraints [@hiqsol]
    - [fcfa683] 2016-05-04 Merge pull request #1 from samdark/patch-1 [@hiqsol]
    - [fa7bcae] 2016-05-04 Better front page wording [sam@rmcreative.ru]
    - [a90a482] 2016-05-04 fixed version constraints [@hiqsol]
- Implemented package details page
    - [5fad211] 2016-05-19 Implemented package details page [@SilverFire]
    - [2195919] 2016-05-19 Update styles [@SilverFire]
    - [00e23b9] 2016-05-18 Fixed search form submit url [@SilverFire]
    - [f3f873f] 2016-05-18 Implemented package update from the we application [@SilverFire]
    - [7183235] 2016-05-17 Added passing of searchQuery to view params [@SilverFire]
- Added and improved texts and package description
    - [97e289c] 2016-05-14 added empty counters template to be themed in real site [@hiqsol]
    - [9b6ed61] 2016-05-14 added Usage description [@hiqsol]
    - [00ff6f1] 2016-05-14 improved description: added logo [@hiqsol]
    - [7baf614] 2016-05-14 added package description [@hiqsol]
    - [cfb3ae4] 2016-05-14 fixed dependencies [@hiqsol]
    - [dd4f37d] 2016-05-14 removed web dir [@hiqsol]
    - [71631fe] 2016-05-14 added/improved texts [@hiqsol]
    - [63c7c89] 2016-05-12 Added error handling for asset-package/update and update-list [@SilverFire]
    - [c9bd8a4] 2016-05-12 Updated PHPDocs, minor [@SilverFire]
- Added Top-1000 Bower packages
    - [591f219] 2016-05-12 Added try/catch to AssetPackageController::actionUpdate [@SilverFire]
    - [e01d992] 2016-05-11 Added creating of runtime directory in BowerPackageController [@SilverFire]
    - [f66e733] 2016-05-11 Added BowerPackageController and actionFetchTop [@SilverFire]
    - [082935a] 2016-05-11 Added TOP-100 Bower components to bower.list [@SilverFire]
    - [2728344] 2016-05-11 Updated composer.json - added guzzle dependency [@SilverFire]
    - [26c30b0] 2016-05-11 Fixed wrong namespaces in Locker; [@SilverFire]
    - [4e28d86] 2016-05-11 Updated Usage block on index.php [@SilverFire]
    - [9499664] 2016-05-10 + `asset-package/update-all` action [@hiqsol]
    - [b4d5c47] 2016-05-10 fixed default lastId [@hiqsol]
    - [4678f67] 2016-05-10 removed obsolete PackagesController [@hiqsol]
    - [54a8f54] 2016-05-10 added check exitcode when running hidev update package [@hiqsol]
- Changed: rearranged config files to new scheme
    - [c77aa60] 2016-05-10 fixed typo [@hiqsol]
    - [569947f] 2016-05-10 + `chmod-storage` goal [@hiqsol]
    - [b4cf57b] 2016-05-10 still rearranging configs [@hiqsol]
    - [c9665bb] 2016-05-10 csfixed [@hiqsol]
    - [6a38eb9] 2016-05-10 still rearranging configs [@hiqsol]
    - [54ede7d] 2016-05-09 added `config/common.php` [@hiqsol]
    - [46631a7] 2016-05-09 redone configs to hidev and hisite [@hiqsol]
    - [d2e0f0f] 2016-05-09 moved logos to AppAsset [@hiqsol]
- Changed: redone to `hiqdev/asset-packagist`
    - [a85830f] 2016-05-08 changed to hisite-config [@hiqsol]
    - [f6aa46d] 2016-05-08 csfixed [@hiqsol]
    - [9f7d0b6] 2016-05-08 + hisite-web extension config [@hiqsol]
    - [cf2d54d] 2016-05-07 fixed asset-packagist/test action to check storage dir existance [@hiqsol]
    - [e7be6b1] 2016-05-05 redone to `hiqdev/asset-packagist` [@hiqsol]
    - [08aeb23] 2016-05-05 splitted out `.hidev/goals.yml` [@hiqsol]
- Added list operations
    - [1af8dc9] 2016-05-05 + `packages.list` instead of `min_packages.sh` [@hiqsol]
    - [37d40a7] 2016-05-05 + list and update-list actions [@hiqsol]
    - [a6214a3] 2016-05-05 + read and list functions [@hiqsol]
    - [2460d3e] 2016-05-05 + AssetPackage::splitFullName [@hiqsol]
- Added search
    - [8afec1f] 2016-04-25 fixed tests [@hiqsol]
    - [01d5501] 2016-04-25 + search. it all works now [@hiqsol]
    - [f9c3cb1] 2016-04-25 + storage and clean-storage goals [@hiqsol]
    - [411bbea] 2016-04-25 + ignore storage files [@hiqsol]
    - [d84636c] 2016-04-25 used local hidev [@hiqsol]
    - [868e934] 2016-04-24 added `buildHashedPath` [@hiqsol]
- Chandged: redone with `Storage` and `Locker`
    - [a48dfb0] 2016-04-24 renamed `do` goal -> `asset-packagist` in `min_packages.sh` [@hiqsol]
    - [9a1769d] 2016-04-24 redone buildPath and used Locker [@hiqsol]
    - [9f38225] 2016-04-24 added locking [@hiqsol]
    - [12b17af] 2016-04-23 renamed `do` goal -> `asset-packagist` [@hiqsol]
    - [f9dfeee] 2016-04-23 still redoing with `Storage` NOT FINISHED [@hiqsol]
    - [0deab6f] 2016-04-23 inited tests [@hiqsol]
    - [48f69b5] 2016-04-23 redoing storage BROKEN [@hiqsol]
    - [3134a13] 2016-04-17 + search form [@hiqsol]
    - [2a6f9ff] 2016-04-16 + downloaded logos [@hiqsol]
    - [afcfcce] 2016-04-16 + bower matchheight to `min_packages` [@hiqsol]
- Added basics
    - [ac04710] 2016-04-15 redone to local hidev installation [@hiqsol]
    - [9b89c15] 2016-04-15 moved DoController to console dir [@hiqsol]
    - [d75181d] 2016-04-15 + set main package alias to bootstrap [@hiqsol]
    - [54434bf] 2016-04-10 phpcsfixed [@hiqsol]
    - [065c211] 2016-04-10 added basic site pages [@hiqsol]
    - [52d05bd] 2016-04-10 used asset-packagist [@hiqsol]
    - [519b20d] 2016-04-06 phpcsfixed [@hiqsol]
    - [a292a67] 2016-04-06 refactored with fxp registries [@hiqsol]
    - [4dfea1c] 2016-04-04 phpcsfixed [@hiqsol]
    - [5b163f7] 2016-04-04 inited tests [@hiqsol]
    - [8960530] 2016-04-04 + ssl [@hiqsol]
    - [b0747e6] 2016-04-04 + `min_packages.sh` [@hiqsol]
    - [6e6e8dc] 2016-04-04 small fix [@hiqsol]
    - [f0f0054] 2016-04-04 something working [@hiqsol]
    - [2d9e89f] 2016-04-02 inited [@hiqsol]

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
[4471376]: https://github.com/hiqdev/asset-packagist/commit/4471376
[1f862c1]: https://github.com/hiqdev/asset-packagist/commit/1f862c1
[80fb19c]: https://github.com/hiqdev/asset-packagist/commit/80fb19c
[6f6392a]: https://github.com/hiqdev/asset-packagist/commit/6f6392a
[ffd2ad5]: https://github.com/hiqdev/asset-packagist/commit/ffd2ad5
[a1478ad]: https://github.com/hiqdev/asset-packagist/commit/a1478ad
[133a210]: https://github.com/hiqdev/asset-packagist/commit/133a210
[e0c6316]: https://github.com/hiqdev/asset-packagist/commit/e0c6316
[305b331]: https://github.com/hiqdev/asset-packagist/commit/305b331
[fcfa683]: https://github.com/hiqdev/asset-packagist/commit/fcfa683
[fa7bcae]: https://github.com/hiqdev/asset-packagist/commit/fa7bcae
[a90a482]: https://github.com/hiqdev/asset-packagist/commit/a90a482
[5fad211]: https://github.com/hiqdev/asset-packagist/commit/5fad211
[2195919]: https://github.com/hiqdev/asset-packagist/commit/2195919
[00e23b9]: https://github.com/hiqdev/asset-packagist/commit/00e23b9
[f3f873f]: https://github.com/hiqdev/asset-packagist/commit/f3f873f
[7183235]: https://github.com/hiqdev/asset-packagist/commit/7183235
[97e289c]: https://github.com/hiqdev/asset-packagist/commit/97e289c
[9b6ed61]: https://github.com/hiqdev/asset-packagist/commit/9b6ed61
[00ff6f1]: https://github.com/hiqdev/asset-packagist/commit/00ff6f1
[7baf614]: https://github.com/hiqdev/asset-packagist/commit/7baf614
[cfb3ae4]: https://github.com/hiqdev/asset-packagist/commit/cfb3ae4
[dd4f37d]: https://github.com/hiqdev/asset-packagist/commit/dd4f37d
[71631fe]: https://github.com/hiqdev/asset-packagist/commit/71631fe
[63c7c89]: https://github.com/hiqdev/asset-packagist/commit/63c7c89
[c9bd8a4]: https://github.com/hiqdev/asset-packagist/commit/c9bd8a4
[591f219]: https://github.com/hiqdev/asset-packagist/commit/591f219
[e01d992]: https://github.com/hiqdev/asset-packagist/commit/e01d992
[f66e733]: https://github.com/hiqdev/asset-packagist/commit/f66e733
[082935a]: https://github.com/hiqdev/asset-packagist/commit/082935a
[2728344]: https://github.com/hiqdev/asset-packagist/commit/2728344
[26c30b0]: https://github.com/hiqdev/asset-packagist/commit/26c30b0
[4e28d86]: https://github.com/hiqdev/asset-packagist/commit/4e28d86
[9499664]: https://github.com/hiqdev/asset-packagist/commit/9499664
[b4d5c47]: https://github.com/hiqdev/asset-packagist/commit/b4d5c47
[4678f67]: https://github.com/hiqdev/asset-packagist/commit/4678f67
[54a8f54]: https://github.com/hiqdev/asset-packagist/commit/54a8f54
[c77aa60]: https://github.com/hiqdev/asset-packagist/commit/c77aa60
[569947f]: https://github.com/hiqdev/asset-packagist/commit/569947f
[b4cf57b]: https://github.com/hiqdev/asset-packagist/commit/b4cf57b
[c9665bb]: https://github.com/hiqdev/asset-packagist/commit/c9665bb
[6a38eb9]: https://github.com/hiqdev/asset-packagist/commit/6a38eb9
[54ede7d]: https://github.com/hiqdev/asset-packagist/commit/54ede7d
[46631a7]: https://github.com/hiqdev/asset-packagist/commit/46631a7
[d2e0f0f]: https://github.com/hiqdev/asset-packagist/commit/d2e0f0f
[a85830f]: https://github.com/hiqdev/asset-packagist/commit/a85830f
[f6aa46d]: https://github.com/hiqdev/asset-packagist/commit/f6aa46d
[9f7d0b6]: https://github.com/hiqdev/asset-packagist/commit/9f7d0b6
[cf2d54d]: https://github.com/hiqdev/asset-packagist/commit/cf2d54d
[e7be6b1]: https://github.com/hiqdev/asset-packagist/commit/e7be6b1
[08aeb23]: https://github.com/hiqdev/asset-packagist/commit/08aeb23
[1af8dc9]: https://github.com/hiqdev/asset-packagist/commit/1af8dc9
[37d40a7]: https://github.com/hiqdev/asset-packagist/commit/37d40a7
[a6214a3]: https://github.com/hiqdev/asset-packagist/commit/a6214a3
[2460d3e]: https://github.com/hiqdev/asset-packagist/commit/2460d3e
[8afec1f]: https://github.com/hiqdev/asset-packagist/commit/8afec1f
[01d5501]: https://github.com/hiqdev/asset-packagist/commit/01d5501
[f9c3cb1]: https://github.com/hiqdev/asset-packagist/commit/f9c3cb1
[411bbea]: https://github.com/hiqdev/asset-packagist/commit/411bbea
[d84636c]: https://github.com/hiqdev/asset-packagist/commit/d84636c
[868e934]: https://github.com/hiqdev/asset-packagist/commit/868e934
[a48dfb0]: https://github.com/hiqdev/asset-packagist/commit/a48dfb0
[9a1769d]: https://github.com/hiqdev/asset-packagist/commit/9a1769d
[9f38225]: https://github.com/hiqdev/asset-packagist/commit/9f38225
[12b17af]: https://github.com/hiqdev/asset-packagist/commit/12b17af
[f9dfeee]: https://github.com/hiqdev/asset-packagist/commit/f9dfeee
[0deab6f]: https://github.com/hiqdev/asset-packagist/commit/0deab6f
[48f69b5]: https://github.com/hiqdev/asset-packagist/commit/48f69b5
[3134a13]: https://github.com/hiqdev/asset-packagist/commit/3134a13
[2a6f9ff]: https://github.com/hiqdev/asset-packagist/commit/2a6f9ff
[afcfcce]: https://github.com/hiqdev/asset-packagist/commit/afcfcce
[ac04710]: https://github.com/hiqdev/asset-packagist/commit/ac04710
[9b89c15]: https://github.com/hiqdev/asset-packagist/commit/9b89c15
[d75181d]: https://github.com/hiqdev/asset-packagist/commit/d75181d
[54434bf]: https://github.com/hiqdev/asset-packagist/commit/54434bf
[065c211]: https://github.com/hiqdev/asset-packagist/commit/065c211
[52d05bd]: https://github.com/hiqdev/asset-packagist/commit/52d05bd
[519b20d]: https://github.com/hiqdev/asset-packagist/commit/519b20d
[a292a67]: https://github.com/hiqdev/asset-packagist/commit/a292a67
[4dfea1c]: https://github.com/hiqdev/asset-packagist/commit/4dfea1c
[5b163f7]: https://github.com/hiqdev/asset-packagist/commit/5b163f7
[8960530]: https://github.com/hiqdev/asset-packagist/commit/8960530
[b0747e6]: https://github.com/hiqdev/asset-packagist/commit/b0747e6
[6e6e8dc]: https://github.com/hiqdev/asset-packagist/commit/6e6e8dc
[f0f0054]: https://github.com/hiqdev/asset-packagist/commit/f0f0054
[2d9e89f]: https://github.com/hiqdev/asset-packagist/commit/2d9e89f
[03c8992]: https://github.com/hiqdev/asset-packagist/commit/03c8992
[c8357d5]: https://github.com/hiqdev/asset-packagist/commit/c8357d5
[25011fc]: https://github.com/hiqdev/asset-packagist/commit/25011fc
[8ee6ad3]: https://github.com/hiqdev/asset-packagist/commit/8ee6ad3
[5935538]: https://github.com/hiqdev/asset-packagist/commit/5935538
[4b7abfa]: https://github.com/hiqdev/asset-packagist/commit/4b7abfa
[75f260a]: https://github.com/hiqdev/asset-packagist/commit/75f260a
[b13b523]: https://github.com/hiqdev/asset-packagist/commit/b13b523
[2ea4464]: https://github.com/hiqdev/asset-packagist/commit/2ea4464
[38dba2f]: https://github.com/hiqdev/asset-packagist/commit/38dba2f
[344c0d7]: https://github.com/hiqdev/asset-packagist/commit/344c0d7
[e23568a]: https://github.com/hiqdev/asset-packagist/commit/e23568a
[ec4c66d]: https://github.com/hiqdev/asset-packagist/commit/ec4c66d
[5939201]: https://github.com/hiqdev/asset-packagist/commit/5939201
[f105752]: https://github.com/hiqdev/asset-packagist/commit/f105752
[78ca261]: https://github.com/hiqdev/asset-packagist/commit/78ca261
[4986993]: https://github.com/hiqdev/asset-packagist/commit/4986993
[5138f54]: https://github.com/hiqdev/asset-packagist/commit/5138f54
[2dd8b25]: https://github.com/hiqdev/asset-packagist/commit/2dd8b25
[d35611e]: https://github.com/hiqdev/asset-packagist/commit/d35611e
[ecf5aef]: https://github.com/hiqdev/asset-packagist/commit/ecf5aef
[a607125]: https://github.com/hiqdev/asset-packagist/commit/a607125
[e3cb136]: https://github.com/hiqdev/asset-packagist/commit/e3cb136
[257eb43]: https://github.com/hiqdev/asset-packagist/commit/257eb43
[a96ef4b]: https://github.com/hiqdev/asset-packagist/commit/a96ef4b
[ec7bbcd]: https://github.com/hiqdev/asset-packagist/commit/ec7bbcd
[bd5dca3]: https://github.com/hiqdev/asset-packagist/commit/bd5dca3
[cfd2352]: https://github.com/hiqdev/asset-packagist/commit/cfd2352
[e14172c]: https://github.com/hiqdev/asset-packagist/commit/e14172c
[a5fb28b]: https://github.com/hiqdev/asset-packagist/commit/a5fb28b
[e22d364]: https://github.com/hiqdev/asset-packagist/commit/e22d364
[7d20e30]: https://github.com/hiqdev/asset-packagist/commit/7d20e30
[bdc0fb1]: https://github.com/hiqdev/asset-packagist/commit/bdc0fb1
[0437aee]: https://github.com/hiqdev/asset-packagist/commit/0437aee
[1c947e1]: https://github.com/hiqdev/asset-packagist/commit/1c947e1
[d4fee59]: https://github.com/hiqdev/asset-packagist/commit/d4fee59
[87e2662]: https://github.com/hiqdev/asset-packagist/commit/87e2662
[5a70619]: https://github.com/hiqdev/asset-packagist/commit/5a70619
[bb771de]: https://github.com/hiqdev/asset-packagist/commit/bb771de
[a0562a3]: https://github.com/hiqdev/asset-packagist/commit/a0562a3
[59e4260]: https://github.com/hiqdev/asset-packagist/commit/59e4260
[d34e57b]: https://github.com/hiqdev/asset-packagist/commit/d34e57b
[e547396]: https://github.com/hiqdev/asset-packagist/commit/e547396
[5de31be]: https://github.com/hiqdev/asset-packagist/commit/5de31be
[bb6c7ad]: https://github.com/hiqdev/asset-packagist/commit/bb6c7ad
[90d9aee]: https://github.com/hiqdev/asset-packagist/commit/90d9aee
[5918e90]: https://github.com/hiqdev/asset-packagist/commit/5918e90
[73f4c57]: https://github.com/hiqdev/asset-packagist/commit/73f4c57
[de93971]: https://github.com/hiqdev/asset-packagist/commit/de93971
[d212aec]: https://github.com/hiqdev/asset-packagist/commit/d212aec
[7fb4ac1]: https://github.com/hiqdev/asset-packagist/commit/7fb4ac1
[9e4c259]: https://github.com/hiqdev/asset-packagist/commit/9e4c259
[399d379]: https://github.com/hiqdev/asset-packagist/commit/399d379
[0afdfd2]: https://github.com/hiqdev/asset-packagist/commit/0afdfd2
[1a3454c]: https://github.com/hiqdev/asset-packagist/commit/1a3454c
[c0bfeb1]: https://github.com/hiqdev/asset-packagist/commit/c0bfeb1
[6330bce]: https://github.com/hiqdev/asset-packagist/commit/6330bce
[dc4ccd1]: https://github.com/hiqdev/asset-packagist/commit/dc4ccd1
[9eb09aa]: https://github.com/hiqdev/asset-packagist/commit/9eb09aa
[cb803cb]: https://github.com/hiqdev/asset-packagist/commit/cb803cb
[5ff526c]: https://github.com/hiqdev/asset-packagist/commit/5ff526c
[9515fd0]: https://github.com/hiqdev/asset-packagist/commit/9515fd0
[bc20b98]: https://github.com/hiqdev/asset-packagist/commit/bc20b98
[e482226]: https://github.com/hiqdev/asset-packagist/commit/e482226
[d1130a1]: https://github.com/hiqdev/asset-packagist/commit/d1130a1
[22ab667]: https://github.com/hiqdev/asset-packagist/commit/22ab667
[5a29a01]: https://github.com/hiqdev/asset-packagist/commit/5a29a01
[5be5f6b]: https://github.com/hiqdev/asset-packagist/commit/5be5f6b
[ddfa3ac]: https://github.com/hiqdev/asset-packagist/commit/ddfa3ac
[224f496]: https://github.com/hiqdev/asset-packagist/commit/224f496
[db4966b]: https://github.com/hiqdev/asset-packagist/commit/db4966b
[e69ed1c]: https://github.com/hiqdev/asset-packagist/commit/e69ed1c
[b5b2fa7]: https://github.com/hiqdev/asset-packagist/commit/b5b2fa7
[41033a6]: https://github.com/hiqdev/asset-packagist/commit/41033a6
[e72a72a]: https://github.com/hiqdev/asset-packagist/commit/e72a72a
[6452275]: https://github.com/hiqdev/asset-packagist/commit/6452275
[cf3855f]: https://github.com/hiqdev/asset-packagist/commit/cf3855f
[62c099e]: https://github.com/hiqdev/asset-packagist/commit/62c099e
[442259c]: https://github.com/hiqdev/asset-packagist/commit/442259c
[55e1777]: https://github.com/hiqdev/asset-packagist/commit/55e1777
[Under development]: https://github.com/hiqdev/asset-packagist/compare/0.1.0...HEAD
[0.1.0]: https://github.com/hiqdev/asset-packagist/releases/tag/0.1.0
[257b2f5]: https://github.com/hiqdev/asset-packagist/commit/257b2f5
[5b5f435]: https://github.com/hiqdev/asset-packagist/commit/5b5f435
[b1a7d9c]: https://github.com/hiqdev/asset-packagist/commit/b1a7d9c
[d8b5b87]: https://github.com/hiqdev/asset-packagist/commit/d8b5b87
[eabafbb]: https://github.com/hiqdev/asset-packagist/commit/eabafbb
[c95600b]: https://github.com/hiqdev/asset-packagist/commit/c95600b
[0aa27f6]: https://github.com/hiqdev/asset-packagist/commit/0aa27f6
[2c47200]: https://github.com/hiqdev/asset-packagist/commit/2c47200
[4c94e8f]: https://github.com/hiqdev/asset-packagist/commit/4c94e8f
[122874e]: https://github.com/hiqdev/asset-packagist/commit/122874e
[b850cba]: https://github.com/hiqdev/asset-packagist/commit/b850cba
[ace352d]: https://github.com/hiqdev/asset-packagist/commit/ace352d
[7c5d01d]: https://github.com/hiqdev/asset-packagist/commit/7c5d01d
[5390524]: https://github.com/hiqdev/asset-packagist/commit/5390524
[a72bade]: https://github.com/hiqdev/asset-packagist/commit/a72bade
[7a3380c]: https://github.com/hiqdev/asset-packagist/commit/7a3380c
[d89b68c]: https://github.com/hiqdev/asset-packagist/commit/d89b68c
[b781661]: https://github.com/hiqdev/asset-packagist/commit/b781661
[6438a47]: https://github.com/hiqdev/asset-packagist/commit/6438a47
[b599663]: https://github.com/hiqdev/asset-packagist/commit/b599663
[b07d11b]: https://github.com/hiqdev/asset-packagist/commit/b07d11b
[1aa2d23]: https://github.com/hiqdev/asset-packagist/commit/1aa2d23
[404f689]: https://github.com/hiqdev/asset-packagist/commit/404f689
[c226cff]: https://github.com/hiqdev/asset-packagist/commit/c226cff
[7f43b83]: https://github.com/hiqdev/asset-packagist/commit/7f43b83
[1ed2835]: https://github.com/hiqdev/asset-packagist/commit/1ed2835
[5b0a29f]: https://github.com/hiqdev/asset-packagist/commit/5b0a29f
[f5f7713]: https://github.com/hiqdev/asset-packagist/commit/f5f7713
[9a8db4a]: https://github.com/hiqdev/asset-packagist/commit/9a8db4a
[edcc58c]: https://github.com/hiqdev/asset-packagist/commit/edcc58c
[f87848c]: https://github.com/hiqdev/asset-packagist/commit/f87848c
[0ea6a4a]: https://github.com/hiqdev/asset-packagist/commit/0ea6a4a
[1ae0b89]: https://github.com/hiqdev/asset-packagist/commit/1ae0b89
[76f75df]: https://github.com/hiqdev/asset-packagist/commit/76f75df
[383e494]: https://github.com/hiqdev/asset-packagist/commit/383e494
[85a5314]: https://github.com/hiqdev/asset-packagist/commit/85a5314
[cd0f3cc]: https://github.com/hiqdev/asset-packagist/commit/cd0f3cc
[b76fbcd]: https://github.com/hiqdev/asset-packagist/commit/b76fbcd
[dc47aff]: https://github.com/hiqdev/asset-packagist/commit/dc47aff
[8542c16]: https://github.com/hiqdev/asset-packagist/commit/8542c16
[863dea3]: https://github.com/hiqdev/asset-packagist/commit/863dea3
[1f0abde]: https://github.com/hiqdev/asset-packagist/commit/1f0abde
[035f1ea]: https://github.com/hiqdev/asset-packagist/commit/035f1ea
[6f7aaae]: https://github.com/hiqdev/asset-packagist/commit/6f7aaae
[ab5e2bd]: https://github.com/hiqdev/asset-packagist/commit/ab5e2bd
[33befd4]: https://github.com/hiqdev/asset-packagist/commit/33befd4
[856c104]: https://github.com/hiqdev/asset-packagist/commit/856c104
[6aa8285]: https://github.com/hiqdev/asset-packagist/commit/6aa8285
[7f3a5b4]: https://github.com/hiqdev/asset-packagist/commit/7f3a5b4
[bbbb7b5]: https://github.com/hiqdev/asset-packagist/commit/bbbb7b5
[ca928cf]: https://github.com/hiqdev/asset-packagist/commit/ca928cf
[cd5c912]: https://github.com/hiqdev/asset-packagist/commit/cd5c912
[300594c]: https://github.com/hiqdev/asset-packagist/commit/300594c
[88b96a6]: https://github.com/hiqdev/asset-packagist/commit/88b96a6
[843800f]: https://github.com/hiqdev/asset-packagist/commit/843800f
[e1f21c7]: https://github.com/hiqdev/asset-packagist/commit/e1f21c7
[92c0fd7]: https://github.com/hiqdev/asset-packagist/commit/92c0fd7
[0365f77]: https://github.com/hiqdev/asset-packagist/commit/0365f77
[27ad14d]: https://github.com/hiqdev/asset-packagist/commit/27ad14d
[be126d4]: https://github.com/hiqdev/asset-packagist/commit/be126d4
[eb5f5d9]: https://github.com/hiqdev/asset-packagist/commit/eb5f5d9
[9f54f52]: https://github.com/hiqdev/asset-packagist/commit/9f54f52
[2ba21ee]: https://github.com/hiqdev/asset-packagist/commit/2ba21ee
[9b7d7ff]: https://github.com/hiqdev/asset-packagist/commit/9b7d7ff
[052b795]: https://github.com/hiqdev/asset-packagist/commit/052b795
[eb93960]: https://github.com/hiqdev/asset-packagist/commit/eb93960
[ea55b5c]: https://github.com/hiqdev/asset-packagist/commit/ea55b5c
[8a5882e]: https://github.com/hiqdev/asset-packagist/commit/8a5882e
[a5f52c5]: https://github.com/hiqdev/asset-packagist/commit/a5f52c5
[f4dc2fc]: https://github.com/hiqdev/asset-packagist/commit/f4dc2fc
[b2c50d1]: https://github.com/hiqdev/asset-packagist/commit/b2c50d1
[38e5b4b]: https://github.com/hiqdev/asset-packagist/commit/38e5b4b
[8ea9f6b]: https://github.com/hiqdev/asset-packagist/commit/8ea9f6b
[68e6592]: https://github.com/hiqdev/asset-packagist/commit/68e6592
[d428eef]: https://github.com/hiqdev/asset-packagist/commit/d428eef
[2ec9f08]: https://github.com/hiqdev/asset-packagist/commit/2ec9f08
[b9972eb]: https://github.com/hiqdev/asset-packagist/commit/b9972eb
[9f04bf5]: https://github.com/hiqdev/asset-packagist/commit/9f04bf5
[3511c98]: https://github.com/hiqdev/asset-packagist/commit/3511c98
