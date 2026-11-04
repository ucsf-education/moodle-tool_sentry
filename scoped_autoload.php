<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Scoped Composer autoloader for tool_sentry.
 *
 * This wrapper keeps the plugin's Composer autoloader behind Moodle's
 * autoloader. Composer\InstalledVersions uses registered loaders to determine
 * the root package, so prepending the plugin loader can make Moodle report the
 * plugin's Composer installation instead of its own (MDL-88782).
 *
 * @package    tool_sentry
 * @copyright  (c) The Regents of the University of California
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if (defined('TOOL_SENTRY_AUTOLOADER_REGISTERED')) {
    return;
}

define('TOOL_SENTRY_AUTOLOADER_REGISTERED', true);

$loader = require(__DIR__ . '/vendor/autoload.php');

if ($loader instanceof \Composer\Autoload\ClassLoader) {
    // Keep Moodle's Composer loader first to avoid MDL-88782.
    $loader->unregister();
    $loader->register(false);
}

unset($loader);
