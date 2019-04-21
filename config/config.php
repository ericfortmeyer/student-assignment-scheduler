<?php

namespace StudentAssignmentScheduler;

$my_meeting_night = "Thursday";

$my_language = "ASL";

$special_events = [
    "CO Visit",
    "Assembly",
    "Regional Convention",
    "Memorial"
];

$special_events_registry_filename = \base64_encode("registry");

$workbook_format = "rtf";

$monthly_schedule_format = "pdf";

$do_not_assign_these = [
    "Apply Yourself to Reading and Teaching",
];

$useragent = "LAMM-Scheduler";

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
    "special_events" => $special_events,
    "monthly_schedule_format" => $monthly_schedule_format,
    "workbook_format" => $workbook_format,
    "workbook_download_destination" => __DIR__ . "/../workbooks/$workbook_format",
    "workbook_parser_implementations" => [
        "pdf" => __NAMESPACE__ . "\\Utils\\" . "PdfParser",
        "rtf" => __NAMESPACE__ . "\\Utils\\" . "RtfParser"
    ],
    /// api options
    "apiUrl" => "https://apps.jw.org/GETPUBMEDIALINKS",
    "useragent" => $useragent,
    "apiOpts" => [
        CURLOPT_HEADER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_USERAGENT => $useragent
    ],
    "apiQueryParams" => [
        "output" => "json",
        "fileformat" => "RTF",
        "pub" => "mwb",
        "alllangs" => 0,
        "langwritten" => "ASL"
    ],
    "skip_assignments_with_these_titles" => $do_not_assign_these,
    "make_these_directories" => [
        __DIR__ . "/../data/assignments",
        __DIR__ . "/../data/forms",
        __DIR__ . "/../data/schedules",
        $special_events_location = __DIR__ . "/../data/special_events",
        __DIR__ . "/../workbooks/pdf",
        __DIR__ . "/../workbooks/rtf",
        __DIR__ . "/../tmp",
        __DIR__ . "/../log"
    ],
    "special_events_location" => $special_events_location,
    "special_events_registry_filename" => $special_events_registry_filename,
    "assignment_form_template" => __DIR__ . "/../Utils/templates/S-89-E.pdf",
    "schedule_template" => __DIR__ . "/../Utils/templates/S-140-E.pdf",
    "assignment_forms_destination" => __DIR__ . "/../data/forms",
    "schedules_destination" => __DIR__ . "/../data/schedules",
    "email_log" => __DIR__ . "/../log/email.log",
    "file_save_log" => __DIR__ . "/../log/info.log",
    "file_import_log" => __DIR__ . "/../log/info.log",
    "invalid_file_log" => __DIR__ . "/../log/invalid_file.log",
    "schedule_font_size" => 10,
    "font" => "Helvetica",
    "font_color" => "blue",
    "assignment_mark" => "x",
    "assignments_requiring_assignment_number_on_form" => [
        "Initial Call",
        "First Return Visit",
        "Second Return Visit"
    ],
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
                "bible_reading_number" => [
                    5,
                    51
                ],
                "Bible Reading" => [
                    7.8,
                    51
                ],
                "Bible Reading_number" => [
                    5,
                    51
                ],
                "Initial Call" => [
                    7.8,
                    55
                ],
                "Initial Call_number" => [
                    2.5,
                    55
                ],
                "First Return Visit" => [
                    7.8,
                    58.8
                ],
                "First Return Visit_number" => [
                    2.5,
                    58.8
                ],
                "Second Return Visit" => [
                    7.8,
                    62.8
                ],
                "Second Return Visit_number" => [
                    2.5,
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
