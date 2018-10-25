<?php

namespace TalkSlipSender\Functions;

function importJson(string $path_to_json): array
{
    return json_decode(
        file_get_contents(
            $path_to_json
        ),
        true
    );
}
