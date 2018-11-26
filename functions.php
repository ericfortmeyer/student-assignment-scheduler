<?php

use function TalkSlipSender\Functions\includeFilesInDirectory;

require "Functions/includeFilesInDirectory.php";

includeFilesInDirectory(__DIR__ . "/Functions");
includeFilesInDirectory(__DIR__ . "/FileRegistry/Functions");
