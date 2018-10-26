<?php

namespace TalkSlipSender;

use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfParser\StreamReader;

final class PDFAssignmentFormWriter implements AssignmentFormWriterInterface
{
    /**
     * @var Fpdi
     */
    protected $pdfCreator;

    /**
     * @var array
     */
    protected $import_args = [
        0,
        0,
        null,
        null,
        true
    ];

    /**
     * @var array
     */
    protected $config = [];

    public function __construct(array $config)
    {
        $this->config = $config;
    }
    
    protected function initPdfCreator()
    {
        $this->pdfCreator = new Fpdi();
        $this->textColor($this->config["font_color"]);
        $this->font($this->config["font"]);
        $this->import($this->config["assignment_form_template"]);    
    }

    /**
     * @param mixed[]
     * @return void
     */
    public function create(array $data): void
    {
        /**
         * Must do this each time you call the create method.
         * Since the Fpdi object closes the document each time you output a pdf,
         * you will need a new instance of the Fpdi object if you are creating
         * an array of pdf files
         */
        $this->initPdfCreator();


        $this->writeName($data["name"]);
        $this->writeAssistant($data["assistant"]);
        $this->writeDate($data["date"]);

        if ($this->config["talk_slip"]["version"] === "10.17") {
            $this->writeCounselPoint($data["counsel_point"]);
        }

        $this->markAssignment($data["assignment"]);
        $this->createPDF(
            "{$this->config["assignment_forms_destination"]}/{$this->filenameFromStudentName($data["name"])}"
        );
    }

    protected function writeName(string $name): void
    {
        $this->position("name");
        $this->write($name);
    }

    protected function writeAssistant(string $name_of_assistant): void
    {
        $this->position("assistant");
        $this->write($name_of_assistant);
    }

    protected function writeDate(string $date): void
    {
        $this->position("date");
        $this->write($date);
    }

    protected function writeCounselPoint(string $counsel_point): void
    {
        $this->position("counsel_point");
        $this->write($counsel_point);
    }

    protected function markAssignment(string $assignment): void
    {
        $this->position($assignment);
        $this->write(
            $this->config["assignment_mark"]
        );
    }

    protected function createPDF(string $filename): void
    {
        $this->pdfCreator->Output(
            "F",
            $this->shouldAddIncrementedSuffix($filename)
                ? $this->withIncrementedSuffix($filename)
                : $filename
            ,
            true
        );
    }

    protected function shouldAddIncrementedSuffix(string $filename): bool
    {
        return file_exists($filename);
    }

    protected function arrayOfFilenamesWithSuffixes(string $filename)
    {
        return array_map(
            function (int $num) use ($filename) {
                $suffix = $num ? "_${num}" : "";
                return "{$this->addExtension("{$this->removeExtension($filename)}${suffix}")}";
            },
            range(2, 5)
        );
    }

    protected function fileWithGreatestSuffixValue(string $filename): string
    {
        return array_reduce(
            $this->arrayOfFilenamesWithSuffixes($filename),
            function ($carry, $item) {
                return file_exists($item) ? $item : $carry;
            }
        ) ?? $filename;
    }

    protected function withIncrementedSuffix(string $filename): string
    {
        return $this->addExtension(
            "{$this->removeExtension($filename)}_{$this->incrementedSuffix($filename)}"
        );
    }

    protected function parseSuffixValue(string $filename): int
    {
        return sscanf(
            basename(
                $this->fileWithGreatestSuffixValue($filename),
                ".pdf"
            ),
            "%[^_]_%d"
        )[1] ?? 0;
    }
    
    protected function incrementedSuffix(string $filename): int
    {
        return $this->parseSuffixValue($filename)
            ? $this->parseSuffixValue($filename) + 1
            : $this->parseSuffixValue($filename) + 2;
    }

    protected function filenameFromStudentName(string $student_name): string
    {
        return $this->addExtension(
            $this->allCaps(
                $this->firstName(
                    $student_name
                )
            )
        );
    }

    protected function addExtension(string $basename): string
    {
        return "$basename.pdf";
    }

    protected function removeExtension(string $filename): string
    {
        return str_replace(".pdf", "", $filename);
    }

    protected function allCaps(string $string): string
    {
        return strtoupper($string);
    }

    protected function firstName(string $fullname): string
    {
        return current(
            explode(
                " ",
                $fullname
            )
        );
    }

    protected function position(string $position): void
    {
        $this->pdfCreator->SetXY(
            ...$this->setXYFromConfig($position)
        );
    }

    protected function write(string $string): void
    {
        $this->pdfCreator->Write(0, $string);
    }

    protected function setXYFromConfig(string $which_position): array
    {
        return $this->config["talk_slip"]["fields"]["position"][$which_position];
    }

    public function font(string $font): void
    {
        $this->pdfCreator->SetFont($font);
    }

    public function textColor(string $color): void
    {
        $rgb = $this->colorIsAvailable($color)
            ? $this->toRgb($color)
            : $this->toRgb($this->config["font_color"]);


        $this->pdfCreator->setTextColor(...$rgb);
    }

    protected function colorIsAvailable(string $color): bool
    {
        return key_exists(
            $color,
            $this->config["colors"]
        );
    }

    protected function toRgb(string $color): array
    {
        return $this->config["colors"][$color];
    }

    protected function import(string $path_to_template): void
    {
        $this->pdfCreator->AddPage();
        $this->pdfCreator->setSourceFile(StreamReader::createByFile($path_to_template));
        $this->pdfCreator->useImportedPage(
            $this->pdfCreator->importPage(1),
            ...$this->import_args
        );
    }
}
