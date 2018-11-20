<?php

namespace TalkSlipSender\Functions\Exporting;

use \Ds\Map;

use function TalkSlipSender\Functions\CLI\red;

function exportFiles(array $files, string $yearDir, Map $destination_map): void
{
    $destination_map->hasKey(EXPORT_REMOTE)
        ? exportRemote(
            $files,
            $yearDir,
            $destination_map->remove(EXPORT_REMOTE)
        )
        : exportLocal(
            $files,
            $yearDir,
            $destination_map->remove(EXPORT_LOCAL)
        );
}

function exportRemote(array $files, string $yearDir, string $destination): void
{
    array_map(
        function (string $file) use ($yearDir, $destination) {
            $path = "${yearDir}/${file}";
            
            $command = implode(
                " ",
                [
                    "scp",
                    //SECURITY
                    escapeshellarg($path),
                    //SECURITY
                    escapeshellarg($destination)
                ]
            );

            !file_exists($path)
                ? exit(red("Can't find file " . escapeshellarg($path)) . PHP_EOL)
                : passthru($command);
        },
        $files
    );
}

function exportLocal(array $files, string $yearDir, string $destination): void
{
    !file_exists($destination) && mkdir($destination);
    array_map(
        function (string $file) use ($yearDir, $destination) {
            //SECURITY
            $path = "${yearDir}/${file}";
            !file_exists($path)
                ? exit(red("Can't find file " . escapeshellarg($path)) . PHP_EOL)
                : copy($path, "${destination}/${file}");
        },
        $files
    );
}
