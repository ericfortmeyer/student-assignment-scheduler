<?php
// phpcs:ignoreFile
namespace StudentAssignmentScheduler\Functions\Bootstrapping;

use \Ds\Vector;

use function StudentAssignmentScheduler\Functions\{
    Encryption\createAndStoreMasterKey,
    Encryption\createAndStoreKeyStack,
    Encryption\masterKey,
    buildPath
};

function setupKeys(string $secrets_dir, string $env_dir): void
{
    $saoew=$x=(new Vector(["ensure","warmth","doughnuts","hospitable","mockingbird","totalitarian","bar-b-que","welcome","weather","teacher","explanation","starlit"]))->map(function(string $x):string{return sodium_pad($x."what in the world is going on here",random_int(4,8));})->map(function(string $x):string{$vaoijvdaijosv = explode(" ", $x); shuffle($vaoijvdaijosv); return base64_encode(join("@@u+==+weofj", $vaoijvdaijosv));})->toArray();shuffle($x);shuffle($x);shuffle($x);$pda = array_rand($x, 5);$cois32 = array_rand($pda, 2);$djaapweiofwe233=["m"=>[$saoew[$cois32[0]]],"s"=>[$x[$cois32[1]]]];
    $path_to_master_key = buildPath($secrets_dir, $djaapweiofwe233["m"][0]);
    $path_to_secret_key = buildPath($secrets_dir, $djaapweiofwe233["s"][0]);
    $env_file = buildPath($env_dir, ".env");
    $keys = array_map(
        function (string $c): string {
            return \random_bytes(SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF_KEYBYTES);
        },
        $cois32
    );

    !file_exists($secrets_dir) && mkdir($secrets_dir, 0700);

    createAndStoreMasterKey(
        $path_to_master_key
    );

    createAndStoreKeyStack(
        $path_to_secret_key,
        masterKey(
            $path_to_master_key
        ),
        $keys
    );

    storeFilenamesOfKeys(
        ["m" => $path_to_master_key, "s" => $path_to_secret_key],
        $env_file
    );
}
