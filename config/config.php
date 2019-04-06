<?php

namespace StudentAssignmentScheduler;

use StudentAssignmentScheduler\Classes\Language;
use function StudentAssignmentScheduler\Functions\Localization\Language\PublicationReferences\{
    mnemonic,
    worksheetFilenamePrefix,
    assignmentForm,
    scheduleTemplate
};

require_once __DIR__. "/../autoload.php";

$useragent = "LAMM-Scheduler";

$api_url = "https://apps.jw.org/GETPUBMEDIALINKS";

$my_meeting_night = "Thursday";

$meeting_language = Language::ASL;

$default_written_language = Language::ENGLISH;

$written_language = Language::SPANISH;

$assignment_form_language = $written_language;

$assignment_form_date_format = "%B %d"; // April 01 or abril 01

$workbook_format = "rtf";

$monthly_schedule_format = "pdf";

$do_not_assign_these = [
    "Apply Yourself to Reading and Teaching",
];

$path_to_templates = __DIR__ . "/../Utils/templates";

return [
    "language" => $meeting_language,
    "written_language" => $written_language,
    "mnemonic" => mnemonic($meeting_language),
    "worksheet_filename_prefix" => worksheetFilenamePrefix($meeting_language),
    "meeting_night" => $my_meeting_night,
    "monthly_schedule_format" => $monthly_schedule_format,
    "workbook_format" => $workbook_format,
    "workbook_download_destination" => __DIR__ . "/../workbooks/$workbook_format",
    "workbook_parser_implementations" => [
        "pdf" => __NAMESPACE__ . "\\Utils\\" . "PdfParser",
        "rtf" => __NAMESPACE__ . "\\Utils\\" . "RtfParser"
    ],
    /// api options
    "apiUrl" => $api_url,
    "useragent" => $useragent,
    "apiOpts" => [
        CURLOPT_HEADER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_USERAGENT => $useragent
    ],
    "apiQueryParams" => [
        "output" => "json",
        "fileformat" => "RTF",
        "pub" => WORKBOOK_ABBR,
        "alllangs" => 0,
        "langwritten" => $meeting_language
    ],
    "skip_assignments_with_these_titles" => $do_not_assign_these,
    "make_these_directories" => [
        __DIR__ . "/../data/assignments",
        __DIR__ . "/../data/forms",
        __DIR__ . "/../data/schedules",
        __DIR__ . "/../workbooks/pdf",
        __DIR__ . "/../workbooks/rtf",
        __DIR__ . "/../tmp",
        __DIR__ . "/../log"
    ],
    "assignment_form_template" => assignmentForm($written_language, $path_to_templates),
    "assignment_form_date_format" => $assignment_form_date_format,
    // "schedule_template" => scheduleTemplate($written_language, $path_to_templates),
    "schedule_template" => scheduleTemplate(Language::ENGLISH, $path_to_templates),
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
                    24,
                    16
                ],
                "assistant" => [
                    26,
                    24
                ],
                "date" => [
                    22,
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
