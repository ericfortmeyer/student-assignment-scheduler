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
                    38
                ],
                4 => [
                    "position" => [
                        20,
                        67,
                    ],
                    "name" => [
                        134,
                        67
                    ],
                    "counsel_point" => [
                        200,
                        67
                    ]
                ],
                5 => [
                    "position" => [
                        20,
                        86,
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
                        93,
                    ],
                    "name" => [
                        134,
                        93
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
                        100
                    ],
                    "counsel_point" => [
                        200,
                        100
                    ]
                ]
            ],
            //1
            [
                "date" => [
                    20,
                    116
                ],
                4 => [
                    "position" => [
                        20,
                        134,
                    ],
                    "name" => [
                        134,
                        134
                    ],
                ],
                5 => [
                    "position" => [
                        20,
                        153,
                    ],
                    "name" => [
                        134,
                        153
                    ],
                ],
                6 => [
                    "position" => [
                        20,
                        160,
                    ],
                    "name" => [
                        134,
                        160
                    ],
                ],
                7 => [
                    "position" => [
                        20,
                        167,
                    ],
                    "name" => [
                        134,
                        167
                    ],
                ],
                8 => [
                    "position" => [
                        20,
                        174,
                    ],
                    "name" => [
                        134,
                        174
                    ]
                ]
            ],
            //2
            [
                "date" => [
                    20,
                    184
                ],
                4 => [
                    "position" => [
                        20,
                        203,
                    ],
                    "name" => [
                        134,
                        203
                    ],
                ],
                5 => [
                    "position" => [
                        20,
                        222,
                    ],
                    "name" => [
                        134,
                        222
                    ],
                ],
                6 => [
                    "position" => [
                        20,
                        230,
                    ],
                    "name" => [
                        134,
                        230
                    ],
                ],
                7 => [
                    "position" => [
                        20,
                        237,
                    ],
                    "name" => [
                        134,
                        237
                    ],
                ]
            ],
            //3
            [
                "date" => [
                    20,
                    32
                ],
                4 => [
                    "position" => [
                        20,
                        51,
                    ],
                    "name" => [
                        134,
                        51
                    ],
                ],
                5 => [
                    "position" => [
                        20,
                        70,
                    ],
                    "name" => [
                        134,
                        70
                    ],
                ],
                6 => [
                    "position" => [
                        20,
                        77,
                    ],
                    "name" => [
                        134,
                        77
                    ],
                ],
                7 => [
                    "position" => [
                        20,
                        84,
                    ],
                    "name" => [
                        134,
                        84
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
                        134,
                        125
                    ],
                ],
                5 => [
                    "position" => [
                        20,
                        143,
                    ],
                    "name" => [
                        134,
                        143
                    ],
                ],
                6 => [
                    "position" => [
                        20,
                        151,
                    ],
                    "name" => [
                        134,
                        151
                    ],
                ],
                7 => [
                    "position" => [
                        20,
                        159,
                    ],
                    "name" => [
                        134,
                        159
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
                "First Conversation" => [
                    7.8,
                    55
                ],
                "First Return Visit" => [
                    7.8,
                    58.8
                ],
                "Second Return Visit" => [
                    7.8,
                    62.8
                    // 66.5
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
