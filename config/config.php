<?php

namespace TalkSlipSender;

$my_meeting_night = "Thursday";

$my_language = "ASL";

$workbook_format = "rtf";

$do_not_assign_these = [
    "Apply Yourself to Reading and Teaching",
];

return [
    "language" => $my_language,
    "mnemonic" => [
        "ASL" => "mwbsl",
        "English" => "mwb"
    ],
    "worksheet_filename_prefix" => [
        "ASL" => "mwb_ASL_",
    ],
    "meeting_night" => $my_meeting_night,
    "workbook_format" => $workbook_format,
    "workbook_parser_implementations" => [
        "pdf" => __NAMESPACE__ . "\\Utils\\" . "PdfParser",
        "rtf" => __NAMESPACE__ . "\\Utils\\" . "RtfParser"
    ],
    "skip_assignments_with_these_titles" => $do_not_assign_these,
    "assignment_form_template" => __DIR__ . "/../Utils/templates/S-89-E.pdf",
    "schedule_template" => __DIR__ . "/../Utils/templates/S-140-E.pdf",
    "assignment_forms_destination" => __DIR__ . "/../data/forms",
    "schedules_destination" => __DIR__ . "/../data/schedules",
    "email_log" => __DIR__ . "/../log/email.log",
    "file_save_log" => __DIR__ . "/../log/info.log",
    "file_import_log" => __DIR__ . "/../log/info.log",
    "schedule_font_size" => 10,
    "font" => "Helvetica",
    "font_color" => "blue",
    "assignment_mark" => "x",
    "colors" => [
        "black" => [
            0,
            0,
            0
        ],
        "blue" => [
            0,
            0,
            255
        ],
        "green" => [
            0,
            200,
            0
        ],
        "red" => [
            255,
            0,
            0,
        ]
    ],
    "schedule" => [
        "week" => [
            //0
            [
                "date" => [
                    20,
                    42
                ],
                4 => [
                    "position" => [
                        20,
                        67,
                    ],
                    "name" => [
                        134,
                        57
                    ],
                    "counsel_point" => [
                        200,
                        67
                    ]
                ],
                5 => [
                    "position" => [
                        20,
                        76,
                    ],
                    "name" => [
                        134,
                        86
                    ],
                    "counsel_point" => [
                        200,
                        86
                    ]
                ],
                6 => [
                    "position" => [
                        20,
                        83,
                    ],
                    "name" => [
                        134,
                        83
                    ],
                    "counsel_point" => [
                        200,
                        93
                    ]
                ],
                7 => [
                    "position" => [
                        20,
                        100,
                    ],
                    "name" => [
                        134,
                        90
                    ],
                    "counsel_point" => [
                        200,
                        90
                    ]
                ]
            ],
            //1
            [
                "date" => [
                    20,
                    111
                ],
                4 => [
                    "position" => [
                        20,
                        134,
                    ],
                    "name" => [
                        134,
                        126
                    ],
                ],
                5 => [
                    "position" => [
                        20,
                        144,
                    ],
                    "name" => [
                        134,
                        144
                    ],
                ],
                6 => [
                    "position" => [
                        20,
                        152,
                    ],
                    "name" => [
                        134,
                        152
                    ],
                ],
                7 => [
                    "position" => [
                        20,
                        160,
                    ],
                    "name" => [
                        134,
                        160
                    ],
                ],
                8 => [
                    "position" => [
                        20,
                        168,
                    ],
                    "name" => [
                        134,
                        168
                    ]
                ]
            ],
            //2
            [
                "date" => [
                    20,
                    186
                ],
                4 => [
                    "position" => [
                        20,
                        201,
                    ],
                    "name" => [
                        134,
                        200
                    ],
                ],
                5 => [
                    "position" => [
                        20,
                        219,
                    ],
                    "name" => [
                        134,
                        220
                    ],
                ],
                6 => [
                    "position" => [
                        20,
                        227,
                    ],
                    "name" => [
                        134,
                        226
                    ],
                ],
                7 => [
                    "position" => [
                        20,
                        234,
                    ],
                    "name" => [
                        134,
                        234
                    ],
                ]
            ],
            //3
            [
                "date" => [
                    20,
                    23
                ],
                4 => [
                    "position" => [
                        20,
                        51,
                    ],
                    "name" => [
                        134,
                        37
                    ],
                ],
                5 => [
                    "position" => [
                        20,
                        56,
                    ],
                    "name" => [
                        134,
                        70
                    ],
                ],
                6 => [
                    "position" => [
                        20,
                        63,
                    ],
                    "name" => [
                        137,
                        63
                    ],
                ],
                7 => [
                    "position" => [
                        20,
                        71,
                    ],
                    "name" => [
                        137,
                        71
                    ],
                ]
            ],
            //4
            [
                "date" => [
                    20,
                    104
                ],
                4 => [
                    "position" => [
                        20,
                        125,
                    ],
                    "name" => [
                        137,
                        115
                    ],
                ],
                5 => [
                    "position" => [
                        20,
                        143,
                    ],
                    "name" => [
                        137,
                        133
                    ],
                ],
                6 => [
                    "position" => [
                        20,
                        141,
                    ],
                    "name" => [
                        137,
                        141
                    ],
                ],
                7 => [
                    "position" => [
                        20,
                        149,
                    ],
                    "name" => [
                        134,
                        149
                    ],
                ]
            ],
        ]
    ],
    "talk_slip" => [
        "version" => "10.18",
        "fields" => [
            "position" => [
                "name" => [
                    18,
                    16
                ],
                "assistant" => [
                    26,
                    24
                ],
                "date" => [
                    16,
                    33
                ],
                "bible_reading" => [
                    7.8,
                    51
                ],
                "Bible Reading" => [
                    7.8,
                    51
                ],
                "First Return Visit" => [
                    7.8,
                    58.8
                ],
                "Initial Call" => [
                    7.8,
                    55
                ],
                "Second Return Visit" => [
                    7.8,
                    62.8
                ],
                "Bible Study" => [
                    48.4,
                    51
                ],
                "Talk" => [
                    48.4,
                    55
                ]
            ]
        ]
    ]
];
