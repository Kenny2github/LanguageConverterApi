<?php

namespace MediaWiki\Extension\LanguageConverterApi;
use MediaWiki\MediaWikiServices;
use ApiBase;
use LanguageConverter;
use Wikimedia\ParamValidator\ParamValidator;

class ApiLanguageConvert extends ApiBase {
	public function execute() {
		$params = $this->extractRequestParams();
		$lang = $params['lang'];
		$text = $params['text'];
		$converter = self::getConverter($lang);
		$variants = $converter->getVariants();
		if ($params['variants']) {
			$variants = array_intersect($variants, $params['variants']);
		}
		$result = $this->getResult();
		foreach ($variants as $variant) {
			$converted = $converter->convertTo($text, $variant);
			$result->addValue( 'languageconvert', $variant, $converted );
		}
	}

	private static function getConverter($lang) {
		return MediaWikiServices::getInstance()->getLanguageFactory()
			->getLanguage($lang)->getConverter();
	}

	public function getAllowedParams() {
		$all_variants = [];
		foreach (LanguageConverter::$languagesWithVariants as $lang) {
			$converter = self::getConverter($lang);
			$all_variants = array_merge($all_variants, $converter->getVariants());
		}
		return [
			'text' => [
				ParamValidator::PARAM_TYPE => 'text',
				ParamValidator::PARAM_REQUIRED => true,
			],
			'lang' => [
				ParamValidator::PARAM_TYPE => LanguageConverter::$languagesWithVariants,
				ParamValidator::PARAM_REQUIRED => true,
			],
			'variants' => [
				ParamValidator::PARAM_TYPE => $all_variants,
				ParamValidator::PARAM_ISMULTI => true,
			]
		];
	}

	public function getHelpUrls() {
		return 'https://github.com/Kenny2github/LanguageConverterApi';
	}

	public function isWriteMode() {
		return false;
	}
	public function mustBePosted() {
		return true;
	}
	public function needsToken() {
		return false;
	}
}
