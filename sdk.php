<?php
/**
 * Copyright 2012 HubSpot, Inc.
 *
 *   Licensed under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.
 *   You may obtain a copy of the License at
 *
 *       http://www.apache.org/licenses/LICENSE-2.0
 *
 *   Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND,
 * either express or implied.  See the License for the specific
 * language governing permissions and limitations under the
 * License.
 */

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