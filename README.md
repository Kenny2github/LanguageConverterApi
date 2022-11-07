# LanguageConverterApi
A tiny MediaWiki extension to provide access to the [LanguageConverter](https://www.mediawiki.org/wiki/Writing_systems#LanguageConverter) mechanisms via an [extension](https://www.mediawiki.org/wiki/API:Extensions) to the [action API](https://www.mediawiki.org/wiki/API:Main_page).

## Installation
```php
wfLoadExtension( 'LanguageConverterApi' );
```
If you want to test with English and Pig Latin, add `$wgUsePigLatinVariant = true;`

## Usage
After installing, see `/path/to/your/api.php?action=help&modules=languageconvert`
