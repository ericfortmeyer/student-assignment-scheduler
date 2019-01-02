<?php

namespace StudentAssignmentScheduler\Functions;

use PHPUnit\Framework\TestCase;

class GenerateContactsFileTest extends TestCase
{
    /**
     * @var <int,string>[]
     */
    protected $list_of_contacts = [];

    /**
     * @var string
     */
    protected $path_to_data;

    /**
     * @var bool
     */
    protected $should_remove_tmp_folder;

    /**
     * @var string
     */
    protected $tmp_folder;

    protected function setup()
    {
        $this->list_of_contacts = [
            "Joe Black jb@example.com",
            "Jim Brown jbrown@example.com",
            "Jill Brown jilly@example.com",
            "Joe Baloney joeb@example.com"
        ];

        $generate_file_name = bin2hex(\random_bytes(12)) . ".php";

        $this->tmp_folder = __DIR__ . "/../tmp";
        $should_make_tmp_folder = $this->should_remove_tmp_folder = !file_exists($this->tmp_folder);

        $should_make_tmp_folder && mkdir($this->tmp_folder);

        $this->path_to_data = "{$this->tmp_folder}/${generate_file_name}";
    }

    protected function teardown()
    {
        $generated_contact_file = $this->path_to_data;

        file_exists($generated_contact_file)
            && unlink($generated_contact_file);

        $this->should_remove_tmp_folder && unlink($this->tmp_folder);
    }

    public function testGeneratedContactFileHasExpectedData()
    {
        
        $data = $expected = $this->list_of_contacts;

        generateContactsFile($data, $this->path_to_data);
        
        $generated_contact_file = $this->path_to_data;

        $actual = $this->getData($generated_contact_file);

        $this->assertEquals($expected, $actual);
    }

    public function getData(string $filename): array
    {
        return file_exists($filename)
            ? require $filename
            : [];
    }
}
