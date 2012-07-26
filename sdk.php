<?php
/**
 * @author Christopher Hoult <chris.hoult@datasift.com>
 * @see https://github.com/chrishoult
 */

/**
 * Registers an autoloader for HubSpot_* classes
 *
 * @param string $className
 */
function hubspot_autoload($className) {
	if (strpos($className, 'HubSpot_') == 0) {
		$className = strtolower(str_replace('HubSpot_', '', $className));
		$file = 'class.' . $className . '.php';
		include __DIR__ . DIRECTORY_SEPARATOR . $file;
	}
}

spl_autoload_register('hubspot_autoload');