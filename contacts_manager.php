<?php

function listContacts()
{
	$filename = 'contacts.txt';
	$handle = fopen($filename, 'r');
	$fileContents = trim(fread($handle, filesize($filename)));
	fclose($handle);

	$contacts = explode(PHP_EOL, $fileContents);

	fwrite(STDOUT, PHP_EOL . 'Name | Phone number' . PHP_EOL . '---------------' . PHP_EOL);
	foreach ($contacts as $contact) {
		fwrite(STDOUT, str_replace('|', ' | ', $contact) . PHP_EOL);
	}
	fwrite(STDOUT, PHP_EOL);
}

function addContact()
{
	$filename = 'contacts.txt';
	$handle = fopen($filename, 'a');
	fwrite(STDOUT, PHP_EOL . 'enter name' . PHP_EOL . '>');
	$name = preg_replace('~  +~', ' ', trim(fgets(STDIN)));
	while (preg_match('~[^a-zA-Z ]~', $name) or $name === '') {
		if ($name === '0') {
			fwrite(STDOUT, PHP_EOL);
			return;
		}
		fwrite(STDOUT, PHP_EOL . (!$name ? 'must enter name' : 'name must consist only of letters and spaces') . PHP_EOL . 'enter 0 to cancel' . PHP_EOL . '>');
		$name = trim(fgets(STDIN));
	}
	fwrite(STDOUT, PHP_EOL . 'enter phone number' . PHP_EOL . '>');
	$number = preg_replace('~^\(?(\d{3})\)?[ -]?(\d{3})-?(\d{4})$~', '$1$2$3', trim(fgets(STDIN)));
	while (preg_match('~\D~', $number) or strlen($number) !== 10) {
		if ($number === '0') {
			fwrite(STDOUT, PHP_EOL);
			return;
		}
		fwrite(STDOUT, PHP_EOL . 'must enter valid 10-digit phone number in any common format' . PHP_EOL . 'enter 0 to cancel' . PHP_EOL . '>');
		$number = preg_replace('~^\(?(\d{3})\)?[ -]?(\d{3})-?(\d{4})$~', '$1$2$3', trim(fgets(STDIN)));
	}
	$contact = "$name|$number";
	$success = fwrite($handle, PHP_EOL . $contact);
	fwrite(STDOUT, ($success ? "successfully wrote new contact: $contact" : 'something went wrong!') . PHP_EOL);
	fclose($handle);
}

function searchContacts($args)
{
	$filename = 'contacts.txt';
	$handle = fopen($filename, 'r');
	$fileContents = trim(fread($handle, filesize($filename)));
	fclose($handle);
	$contacts = explode(PHP_EOL, $fileContents);

	$search = '';

	foreach ($args as $key => $arg) {
		if ($key !== 0) $search .= $arg . ' ';
	}
	$search = trim($search);

	while ($search === '') {
		fwrite(STDOUT, PHP_EOL . 'enter search term(s) space separated' . PHP_EOL . '>');
		$search = (trim(fgets(STDIN)));
		$search = preg_replace('~[^\w ]~', '', $search);
	}
	$searchTerms = explode(' ', strtolower($search));
	$searchResults = [];
	foreach ($contacts as $contact) {
		foreach ($searchTerms as $term) {
			if (strpos(strtolower($contact), $term) === false) {
				continue 2;
			}
		}
		$searchResults[] = $contact;
	}
	fwrite(STDOUT, PHP_EOL . $search . PHP_EOL . 'found ' . sizeof($searchResults) . ' results' . (sizeof($searchResults) ? ':' : '') . PHP_EOL);
	foreach ($searchResults as $result) {
		fwrite(STDOUT, "\t" . $result . PHP_EOL);
	}
	fwrite(STDOUT, PHP_EOL);
}

function deleteContact()
{
	$filename = 'contacts.txt';
	$handle = fopen($filename, 'r');
	$fileContents = trim(fread($handle, filesize($filename)));
	fclose($handle);
	$contacts = explode(PHP_EOL, $fileContents);

	fwrite(STDOUT, PHP_EOL . 'enter contact name to delete' . PHP_EOL . 'enter -list to see all or 0 to cancel' . PHP_EOL);
	while (true) {
		fwrite(STDOUT, '>');
		$input = strtolower(trim(fgets(STDIN)));
		$input = preg_replace(['~[^\w -]~', '~  +~', '~--+~', '~([^^])-~'], ['', ' ', '-', '$1'], $input);
		switch ($input) {
			case '-list':
				listContacts();
				break;
			case '':
			case '-help':
				fwrite(STDOUT, PHP_EOL . 'enter contact name to delete' . PHP_EOL . 'enter -list to see all or 0 to cancel' . PHP_EOL);
				break;
			case '0':
				return;
			default:
				$input = preg_replace('~-~', '', $input);

				$searchTerms = explode(' ', $input);
				foreach ($contacts as $key => $contact) {
					foreach ($searchTerms as $term) {
						if (strpos(strtolower($contact), $term) === false) {
							continue 2;
						}
					}
					$searchResults[] = $contact;
				}

				$toDelete = [];
				foreach ($contacts as $key => $contact) {
					if (strpos(strtolower($contact), $input) !== false) {
						$toDelete[] = ['name' => $contact, 'key' => $key];
					}
				}
				fwrite(STDOUT, '')
				if ($toDelete) {
					fwrite(STDOUT, PHP_EOL . "really delete {$toDelete['name']}? (y/n)" . PHP_EOL . '>');
					$confirm = strtolower(trim(fgets(STDIN)));
					while (!preg_match('~[(y(es)?)(no?)]~', $confirm)) {
						fwrite(STDOUT, '(y/n)' . PHP_EOL . '>');
						$confirm = strtolower(trim(fgets(STDIN)));
					}
					if (preg_match('~y(es)?~', $confirm)) {
						unset($contacts[$toDelete['key']]);
						$fileContents = implode(PHP_EOL, $contacts);
						$handle = fopen($filename, 'w');
						$success = fwrite($handle, $fileContents);
						fwrite(STDOUT, ($success ? "successfully deleted contact: {$toDelete['name']}" : 'something went wrong!') . PHP_EOL);
						fclose($handle);
					}
				}
				break 2;
		}
	}
}

function menu()
{
	$menu = PHP_EOL . '  ┌───────────────────┐' . PHP_EOL . '  │     MAIN MENU     │' . PHP_EOL . '  ├───────────────────┤' . PHP_EOL;
	$commands = ['menu', 'help', 'list', 'add', 'search', 'delete', 'exit'];
	foreach ($commands as $key => $command) {
		$line = '  │    ' . ($key + 1) . ". $command";
		while (strlen($line) < 24) $line .= ' ';
		$line .= '│';
		$menu .= $line . PHP_EOL;
	}
	$menu .= '  └───────────────────┘';
	return $menu;
//  ┌───────────────────┐
//  │     MAIN MENU     │
//  ├───────────────────┤
//  │    1. menu        │
//  │    2. help        │
//  │    3. list        │
//  │    4. add         │
//  │    5. search      │
//  │    6. delete      │
//  │    7. exit        │
//  └───────────────────┘
}

function help($command)
{
	isset($command[1]) ?: $command[1] = NULL;
	switch ($command[1]) {
		case NULL:
			$message = 'usage: "help [command]" or "2 [command]"';
			break;
		case '1':
		case 'menu':
			$message = 'menu: list commands';
			break;
		case '2':
		case 'help':
			$message = 'help: get description of command';
			break;
		case '3':
		case 'list':
			$message = 'list: list all contacts';
			break;
		case '4':
		case 'add':
			$message = 'add: add contact';
			break;
		case '5':
		case 'search':
			$message = 'search: search by contact name';
			break;
		case '6':
		case 'delete':
			$message = 'delete: delete contact';
			break;
		case '7':
		case 'exit':
			$message = 'exit: terminate application';
			break;
		default:
			$message = "cannot offer help on unrecognized command: $command";
			break;
	}
	fwrite(STDOUT, $message . PHP_EOL . PHP_EOL);
}

fwrite(STDOUT, menu() . PHP_EOL . PHP_EOL);

while (true) {
	clearstatcache();
	fwrite(STDOUT, '>');
	$input = strtolower(trim(fgets(STDIN)));
	$input = preg_replace(['~  +~', '~[^\w ]~'], [' ', ''], $input);
	$command = explode(' ', $input);
	switch ($command[0]) {
		case '1':
		case 'menu':
			fwrite(STDOUT, menu() . PHP_EOL . PHP_EOL);
			break;
		case '2':
		case 'help':
			help($command);
			break;
		case '3':
		case 'list':
			listContacts();
			break;
		case '4':
		case 'add':
			addContact();
			break;
		case '5':
		case 'search':
			searchContacts($command);
			break;
		case '6':
		case 'delete':
			deleteContact();
			break;
		case '7':
		case 'exit':
			break 2;
		default:
			fwrite(STDOUT, PHP_EOL . 'command not recognized -- type "menu" for commands' . PHP_EOL);
			break;
	}
}

exit(0);