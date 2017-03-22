<?php

function parseContacts($filename)
{
	$contacts = [];

	$handle = fopen($filename, 'r');

	$fileContents = trim(fread($handle, filesize($filename)));

	$contacts = explode("\n", $fileContents);

	foreach($contacts as &$contact) {
		$contact = explode('|', $contact);
		$contact['name'] = $contact[0];
		unset($contact[0]);
		$contact['number'] = $contact[1];
		unset($contact[1]);

		$contact['number'] = substr($contact['number'], 0, 3) . '-' . substr($contact['number'], 3, 3) . '-' . substr($contact['number'], 6);
	}

	return $contacts;
}

var_dump(parseContacts('contacts.txt'));