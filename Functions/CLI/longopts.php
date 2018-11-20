<?php

namespace TalkSlipSender\Functions\CLI;

function longopts(array $opts)
{
    return array_map(
        function (array $pair) {
            return $pair[1];
        },
        $opts
    );
}
