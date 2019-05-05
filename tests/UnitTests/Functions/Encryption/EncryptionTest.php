<?php

namespace StudentAssignmentScheduler\Functions\Encryption;

use PHPUnit\Framework\TestCase;

use StudentAssignmentScheduler\Classes\ListOfContacts;

class EncryptionTest extends TestCase
{
    protected function setup(): void
    {
        $this->where_mock_secret_key_is_stored = __DIR__ . "/../../../mocks/mock_secret_key";
        $this->where_mock_master_key_is_stored = __DIR__ . "/../../../mocks/mock_master_key";
        $this->where_encrypted_data_is_stored = __DIR__ . "/../../../data/encrypted_data";

        createAndStoreMasterKey(
            $this->where_mock_master_key_is_stored
        );

        $this->master_key = masterKey(
            $this->where_mock_master_key_is_stored
        );

        createAndStoreKeyStack(
            $this->where_mock_secret_key_is_stored,
            $this->master_key
        );
    }

    public function testDataBeforeBoxingIsEqualToDataAfterUnboxing()
    {
        $list_of_contacts = new ListOfContacts(
            [
                "John Brown jb@aol.com",
                "Freddie Jackson fred@hotmail.com",
                "Ron Mcdon md@md.com"
            ]
        );

        $list_causing_fail = (new ListOfContacts(
            [
                "Jim Brown jb@aol.com",
                "Freddie Jackson fred@hotmail.com",
                "Ron Mcdon md@md.com"
            ]
        ))->are();

        $expected = $list_of_contacts->are();


        $secret_key = secretKey(
            $this->where_mock_secret_key_is_stored,
            masterKey($this->where_mock_master_key_is_stored)
        );


        box(
            $list_of_contacts,
            $this->where_encrypted_data_is_stored,
            $secret_key
        );

        $actual = unbox(
            $this->where_encrypted_data_is_stored,
            $secret_key
        )->are();

        // we don't want false positives so let's force a failed test
        // then run the test that should pass
        try {
            $this->assertEquals(
                $expected,
                $list_causing_fail
            );    
        } catch (\Exception $e) {
            $this->assertThat(
                $expected,
                $this->logicalNot(
                    $this->equalTo(
                        $list_causing_fail
                    )
                )
            );

            $this->assertEquals(
                $expected,
                $actual
            );
        }
    }

    protected function teardown(): void
    {
        unlink($this->where_mock_secret_key_is_stored);
        unlink($this->where_mock_master_key_is_stored);
        unlink($this->where_encrypted_data_is_stored);
    }
}
