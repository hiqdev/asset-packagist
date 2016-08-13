hiqdev/asset-packagist commits history
--------------------------------------

## [Under development]

- Added providing `require` to support dependencies of bower/npm packages
    - [03c8992] 2016-08-13 added providing `require` to AssetPackage #14 [sol@hiqdev.com]
- Fixed different issues
    - [c8357d5] 2016-07-06 fixed `AssetPackage::checkName()` [sol@hiqdev.com]
    - [25011fc] 2016-07-06 added `@composer` alias [sol@hiqdev.com]
    - [8ee6ad3] 2016-06-23 merged [sol@hiqdev.com]
    - [5935538] 2016-06-24 Merge pull request #9 from redcatphp/master [sol@hiqdev.com]
    - [4b7abfa] 2016-06-23 minor issues fixes from Jo Surikat [sol@hiqdev.com]
    - [75f260a] 2016-06-23 fixed getting Storage object [sol@hiqdev.com]
    - [b13b523] 2016-06-23 add missing getInstance, return excpected type when empty, check isset [jo@surikat.pro]
    - [2ea4464] 2016-06-23 csfixed [sol@hiqdev.com]
    - [38dba2f] 2016-06-23 Merge pull request #8 from redcatphp/master [sol@hiqdev.com]
    - [344c0d7] 2016-06-23 avoid undefined index "dist" or "source" error [jo@surikat.pro]
    - [e23568a] 2016-06-23 avoid undefined index "searchQuery" error [jo@surikat.pro]
    - [ec4c66d] 2016-06-23 improved storage create and chmod [sol@hiqdev.com]
    - [5939201] 2016-06-23 + packageStorage component to hidev config [sol@hiqdev.com]
    - [f105752] 2016-06-23 Merge pull request #6 from redcatphp/master [sol@hiqdev.com]
    - [78ca261] 2016-06-23 typo fix class hiqdev\assetpackagist\components\AssetPackage not found [jo@surikat.pro]
    - [4986993] 2016-06-16 fixed #3 removed search option from packages.json [sol@hiqdev.com]
    - [5138f54] 2016-06-16 added displaying last updated at package details [sol@hiqdev.com]
    - [d35611e] 2016-06-16 fixed problems with character case [sol@hiqdev.com]
    - [ecf5aef] 2016-06-16 removed breadcrumbs [sol@hiqdev.com]
- Added more description
    - [2dd8b25] 2016-06-16 added Yii2 section to about page [sol@hiqdev.com]
    - [a607125] 2016-06-09 added Installing to a custom path manual [sol@hiqdev.com]
    - [e3cb136] 2016-06-03 added how it works on about page [sol@hiqdev.com]

## [0.1.0] - 2016-05-31

- Fixed minor issues for first release
    - [4471376] 2016-05-30 + notFound page [sol@hiqdev.com]
    - [1f862c1] 2016-05-30 + buildPackageUrl() [sol@hiqdev.com]
    - [80fb19c] 2016-05-26 fixing chmod-storage goal [sol@hiqdev.com]
    - [6f6392a] 2016-05-26 added aliases to composer-config-plugin [sol@hiqdev.com]
    - [ffd2ad5] 2016-05-26 redoing to composer-config-plugin [sol@hiqdev.com]
    - [a1478ad] 2016-05-26 redoing to `composer-config-plugin` [sol@hiqdev.com]
    - [133a210] 2016-05-05 fixed dependencies constraints [sol@hiqdev.com]
    - [e0c6316] 2016-05-04 added `params-local.php` [sol@hiqdev.com]
    - [305b331] 2016-05-04 fixed version constraints [sol@hiqdev.com]
    - [fcfa683] 2016-05-04 Merge pull request #1 from samdark/patch-1 [sol@hiqdev.com]
    - [fa7bcae] 2016-05-04 Better front page wording [sam@rmcreative.ru]
    - [a90a482] 2016-05-04 fixed version constraints [sol@hiqdev.com]
- Implemented package details page
    - [5fad211] 2016-05-19 Implemented package details page [d.naumenko.a@gmail.com]
    - [2195919] 2016-05-19 Update styles [d.naumenko.a@gmail.com]
    - [00e23b9] 2016-05-18 Fixed search form submit url [d.naumenko.a@gmail.com]
    - [f3f873f] 2016-05-18 Implemented package update from the we application [d.naumenko.a@gmail.com]
    - [7183235] 2016-05-17 Added passing of searchQuery to view params [d.naumenko.a@gmail.com]
- Added and improved texts and package description
    - [97e289c] 2016-05-14 added empty counters template to be themed in real site [sol@hiqdev.com]
    - [9b6ed61] 2016-05-14 added Usage description [sol@hiqdev.com]
    - [00ff6f1] 2016-05-14 improved description: added logo [sol@hiqdev.com]
    - [7baf614] 2016-05-14 added package description [sol@hiqdev.com]
    - [cfb3ae4] 2016-05-14 fixed dependencies [sol@hiqdev.com]
    - [dd4f37d] 2016-05-14 removed web dir [sol@hiqdev.com]
    - [71631fe] 2016-05-14 added/improved texts [sol@hiqdev.com]
    - [63c7c89] 2016-05-12 Added error handling for asset-package/update and update-list [d.naumenko.a@gmail.com]
    - [c9bd8a4] 2016-05-12 Updated PHPDocs, minor [d.naumenko.a@gmail.com]
- Added Top-1000 Bower packages
    - [591f219] 2016-05-12 Added try/catch to AssetPackageController::actionUpdate [d.naumenko.a@gmail.com]
    - [e01d992] 2016-05-11 Added creating of runtime directory in BowerPackageController [d.naumenko.a@gmail.com]
    - [f66e733] 2016-05-11 Added BowerPackageController and actionFetchTop [d.naumenko.a@gmail.com]
    - [082935a] 2016-05-11 Added TOP-100 Bower components to bower.list [d.naumenko.a@gmail.com]
    - [2728344] 2016-05-11 Updated composer.json - added guzzle dependency [d.naumenko.a@gmail.com]
    - [26c30b0] 2016-05-11 Fixed wrong namespaces in Locker; [d.naumenko.a@gmail.com]
    - [4e28d86] 2016-05-11 Updated Usage block on index.php [d.naumenko.a@gmail.com]
    - [9499664] 2016-05-10 + `asset-package/update-all` action [sol@hiqdev.com]
    - [b4d5c47] 2016-05-10 fixed default lastId [sol@hiqdev.com]
    - [4678f67] 2016-05-10 removed obsolete PackagesController [sol@hiqdev.com]
    - [54a8f54] 2016-05-10 added check exitcode when running hidev update package [sol@hiqdev.com]
- Changed: rearranged config files to new scheme
    - [c77aa60] 2016-05-10 fixed typo [sol@hiqdev.com]
    - [569947f] 2016-05-10 + `chmod-storage` goal [sol@hiqdev.com]
    - [b4cf57b] 2016-05-10 still rearranging configs [sol@hiqdev.com]
    - [c9665bb] 2016-05-10 csfixed [sol@hiqdev.com]
    - [6a38eb9] 2016-05-10 still rearranging configs [sol@hiqdev.com]
    - [54ede7d] 2016-05-09 added `config/common.php` [sol@hiqdev.com]
    - [46631a7] 2016-05-09 redone configs to hidev and hisite [sol@hiqdev.com]
    - [d2e0f0f] 2016-05-09 moved logos to AppAsset [sol@hiqdev.com]
- Changed: redone to `hiqdev/asset-packagist`
    - [a85830f] 2016-05-08 changed to hisite-config [sol@hiqdev.com]
    - [f6aa46d] 2016-05-08 csfixed [sol@hiqdev.com]
    - [9f7d0b6] 2016-05-08 + hisite-web extension config [sol@hiqdev.com]
    - [cf2d54d] 2016-05-07 fixed asset-packagist/test action to check storage dir existance [sol@hiqdev.com]
    - [e7be6b1] 2016-05-05 redone to `hiqdev/asset-packagist` [sol@hiqdev.com]
    - [08aeb23] 2016-05-05 splitted out `.hidev/goals.yml` [sol@hiqdev.com]
- Added list operations
    - [1af8dc9] 2016-05-05 + `packages.list` instead of `min_packages.sh` [sol@hiqdev.com]
    - [37d40a7] 2016-05-05 + list and update-list actions [sol@hiqdev.com]
    - [a6214a3] 2016-05-05 + read and list functions [sol@hiqdev.com]
    - [2460d3e] 2016-05-05 + AssetPackage::splitFullName [sol@hiqdev.com]
- Added search
    - [8afec1f] 2016-04-25 fixed tests [sol@hiqdev.com]
    - [01d5501] 2016-04-25 + search. it all works now [sol@hiqdev.com]
    - [f9c3cb1] 2016-04-25 + storage and clean-storage goals [sol@hiqdev.com]
    - [411bbea] 2016-04-25 + ignore storage files [sol@hiqdev.com]
    - [d84636c] 2016-04-25 used local hidev [sol@hiqdev.com]
    - [868e934] 2016-04-24 added `buildHashedPath` [sol@hiqdev.com]
- Chandged: redone with `Storage` and `Locker`
    - [a48dfb0] 2016-04-24 renamed `do` goal -> `asset-packagist` in `min_packages.sh` [sol@hiqdev.com]
    - [9a1769d] 2016-04-24 redone buildPath and used Locker [sol@hiqdev.com]
    - [9f38225] 2016-04-24 added locking [sol@hiqdev.com]
    - [12b17af] 2016-04-23 renamed `do` goal -> `asset-packagist` [sol@hiqdev.com]
    - [f9dfeee] 2016-04-23 still redoing with `Storage` NOT FINISHED [sol@hiqdev.com]
    - [0deab6f] 2016-04-23 inited tests [sol@hiqdev.com]
    - [48f69b5] 2016-04-23 redoing storage BROKEN [sol@hiqdev.com]
    - [3134a13] 2016-04-17 + search form [sol@hiqdev.com]
    - [2a6f9ff] 2016-04-16 + downloaded logos [sol@hiqdev.com]
    - [afcfcce] 2016-04-16 + bower matchheight to `min_packages` [sol@hiqdev.com]
- Added basics
    - [ac04710] 2016-04-15 redone to local hidev installation [sol@hiqdev.com]
    - [9b89c15] 2016-04-15 moved DoController to console dir [sol@hiqdev.com]
    - [d75181d] 2016-04-15 + set main package alias to bootstrap [sol@hiqdev.com]
    - [54434bf] 2016-04-10 phpcsfixed [sol@hiqdev.com]
    - [065c211] 2016-04-10 added basic site pages [sol@hiqdev.com]
    - [52d05bd] 2016-04-10 used asset-packagist [sol@hiqdev.com]
    - [519b20d] 2016-04-06 phpcsfixed [sol@hiqdev.com]
    - [a292a67] 2016-04-06 refactored with fxp registries [sol@hiqdev.com]
    - [4dfea1c] 2016-04-04 phpcsfixed [sol@hiqdev.com]
    - [5b163f7] 2016-04-04 inited tests [sol@hiqdev.com]
    - [8960530] 2016-04-04 + ssl [sol@hiqdev.com]
    - [b0747e6] 2016-04-04 + `min_packages.sh` [sol@hiqdev.com]
    - [6e6e8dc] 2016-04-04 small fix [sol@hiqdev.com]
    - [f0f0054] 2016-04-04 something working [sol@hiqdev.com]
    - [2d9e89f] 2016-04-02 inited [sol@hiqdev.com]

## [Development started] - 2016-04-02

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
