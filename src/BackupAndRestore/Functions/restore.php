<?php declare(strict_types=1);

namespace StudentAssignmentScheduler\BackupAndRestore\Functions;

use StudentAssignmentScheduler\BackupAndRestore\RestoreConfig;
use function StudentAssignmentScheduler\Functions\{
    Encryption\hashOfFile,
    Encryption\registerFile
};
use \ZipArchive;
use \Ds\Queue;

function restore(RestoreConfig $config): bool
{
    $config->extractToTmpDir(new ZipArchive());
    $file_moving_queue = new Queue();
    mapOfOldNamesToNewNames($config)->apply(
        function (string $oldname, string $newname) use ($file_moving_queue) {
            $file_moving_queue->push(
                (function (string $oldname, string $newname): \Closure {
                    return function () use ($oldname, $newname) {
                        $target_directory = dirname($newname);
                        !\file_exists($target_directory) && mkdir($target_directory, 0777, true);
                        $moveFile = function (string $oldname, string $newname): bool {
                            return moveFile($oldname, $newname);
                        };
                        $putOriginalFileBack = file_exists($newname)
                            ? (function (string $original_filename) {
                                $original_file_contents = \file_get_contents($original_filename);
                                return function () use ($original_filename, $original_file_contents) {
                                    file_put_contents($original_filename, $original_file_contents);
                                };
                            })($newname)
                            : function () {
                                //no op
                            };
                        $file_that_was_moved = $newname;
                        return $moveFile($oldname, $newname)
                            ? function () use ($file_that_was_moved, $putOriginalFileBack) {
                                unlink($file_that_was_moved);
                                $putOriginalFileBack();
                            }
                            : false;
                    };
                })((string) $oldname, $newname)
            );
        }
    );

    return moveAllFilesOrRollback($file_moving_queue, $config);
}
