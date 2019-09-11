<?php declare(strict_types=1);
/**
 * This file is a part of JW Virtual Assistant Login Account Management.
 * 
 * Copywright (c) Eric Fortmeyer.
 * See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace jwvirtualassistant\AccountManagement;

loadEnvVars();

define(__NAMESPACE__ . "\\DATABASE_FILE", getenv("DATABASE_FILE"));
define(__NAMESPACE__ . "\\USERS_TABLE", getenv("USERS_TABLE"));
define(__NAMESPACE__ . "\\ERROR_PAGE", getenv("ERROR_PAGE"));
