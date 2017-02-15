<?php

// autoload_real_52.php generated by xrstf/composer-php52

class ComposerAutoloaderInit188d12e9015c7bb23981c678373962fc {
	private static $loader;

	public static function loadClassLoader($class) {
		if ('xrstf_Composer52_ClassLoader' === $class) {
			require dirname(__FILE__).'/ClassLoader52.php';
		}
	}

	/**
	 * @return xrstf_Composer52_ClassLoader
	 */
	public static function getLoader() {
		if (null !== self::$loader) {
			return self::$loader;
		}

		spl_autoload_register(array('ComposerAutoloaderInit188d12e9015c7bb23981c678373962fc', 'loadClassLoader'), true /*, true */);
		self::$loader = $loader = new xrstf_Composer52_ClassLoader();
		spl_autoload_unregister(array('ComposerAutoloaderInit188d12e9015c7bb23981c678373962fc', 'loadClassLoader'));

		$vendorDir = dirname(dirname(__FILE__));
		$baseDir   = dirname($vendorDir);
		$dir       = dirname(__FILE__);

		$map = require $dir.'/autoload_namespaces.php';
		foreach ($map as $namespace => $path) {
			$loader->add($namespace, $path);
		}

		$classMap = require $dir.'/autoload_classmap.php';
		if ($classMap) {
			$loader->addClassMap($classMap);
		}

		$loader->register(true);

//		require $vendorDir . '/symfony/polyfill-mbstring/bootstrap.php'; // disabled because of PHP 5.3 syntax
//		require $vendorDir . '/guzzlehttp/psr7/src/functions_include.php'; // disabled because of PHP 5.3 syntax
//		require $vendorDir . '/guzzlehttp/promises/src/functions_include.php'; // disabled because of PHP 5.3 syntax
//		require $vendorDir . '/guzzlehttp/guzzle/src/functions_include.php'; // disabled because of PHP 5.3 syntax
		require $vendorDir . '/paragonie/random_compat/lib/random.php';
//		require $vendorDir . '/illuminate/support/helpers.php'; // disabled because of PHP 5.3 syntax
		require $vendorDir . '/ramsey/array_column/src/array_column.php';
		require $vendorDir . '/mustangostang/spyc/Spyc.php';
//		require $vendorDir . '/wp-cli/php-cli-tools/lib/cli/cli.php'; // disabled because of PHP 5.3 syntax
		require $vendorDir . '/lucatume/wp-browser/src/tad/WPBrowser/functions.php';
//		require $vendorDir . '/smarty/smarty/libs/bootstrap.php'; // disabled because of PHP 5.3 syntax

		return $loader;
	}
}
