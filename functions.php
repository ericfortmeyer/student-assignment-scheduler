<?php

use function StudentAssignmentScheduler\Functions\includeFilesInDirectory;

require "Functions/includeFilesInDirectory.php";

includeFilesInDirectory(__DIR__ . "/Functions");
includeFilesInDirectory(__DIR__ . "/FileRegistry/Functions");
includeFilesInDirectory(__DIR__ . "/Utils/MWBDownloader/Functions");
