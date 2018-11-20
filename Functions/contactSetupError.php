<?php

namespace TalkSlipSender\Functions;

function contactSetupError(string $contact_file)
{
    return "Contacts haven't been set up yet. Set them up in $contacts_file\r\n";
}
