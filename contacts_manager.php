<?php

function getContacts()
{
	$filename = 'contacts.txt';
	$handle = fopen($filename, 'r');
	$fileContents = trim(fread($handle, filesize($filename)));
	fclose($handle);
	if (empty($fileContents)) return NULL;

	$contacts = explode(PHP_EOL, $fileContents);
	array_unshift($contacts, NULL);
	unset($contacts[0]);

	return $contacts;
}

function getContactIndexes()
{
	$contacts = getContacts();
	if ($contacts === NULL) {
		return NULL;
	}
	$indexes = [];
	foreach ($contacts as $index => $contact) {
		$indexes[] = $index;
	}
	array_unshift($indexes, NULL);
	unset($indexes[0]);
	return $indexes;
}

function parseContacts($contacts)
{
	if (is_array($contacts)) {
		foreach ($contacts as &$contact) {
			$contact = explode('|', $contact);
			$contact['name'] = $contact[0];
			unset($contact[0]);
			$contact['number'] = preg_replace('~^(\d{3})(\d{3})(\d{4})$~', '$1-$2-$3', $contact[1]);
			unset($contact[1]);
		}
	} elseif (is_string($contacts)) {
		$contacts = explode('|', $contacts);
		$contacts['name'] = $contacts[0];
		unset($contacts[0]);
		$contacts['number'] = preg_replace('~^(\d{3})(\d{3})(\d{4})$~', '$1-$2-$3', $contacts[1]);
		unset($contacts[1]);
	}
	return $contacts;
}

function generateList($title, $parsedContacts, $last = false)
{
	$longest = 1;

	$list = [];
	$list[] = ['  ┌─────────────────────────────', '┐'];
	$list[] = ['  │       ', "$title       ", '│'];
	$list[] = ['  ├──────────', '┬──────────────────┤'];
	$list[] = ['  │   ', 'Name   ', '│   Phone number   │'];
	$list[] = ['  ├──────────', '┼──────────────────┤'];
	foreach ($parsedContacts as $index => $contact) {
		if (strlen($contact['name']) > $longest) $longest = strlen($contact['name']);
		$list[] = ['  │ ' . str_pad('', 3 - strlen($index)) . "{$index}. {$contact['name']}   ", "│   {$contact['number']}   │"];
	}
	if ($last) {
		$list[] = ['  ├──────────', '┴──────────────────┤'];
		$list[] = ['  │   0. cancel                 ', '│'];
		$list[] = ['  └─────────────────────────────', '┘'];
	} else {
		$list[] = ['  └──────────', '┴──────────────────┘'];
	}

	$linelength = $longest % 2 === 1 ? $longest + 32 : $longest + 33;

	foreach ($list as $index => &$line) {
		while (mb_strlen(implode('', $line)) < $linelength) {
			switch ($index) {
				case sizeof($list) - 3:
					if (!$last) goto end;
				case 0:
				case 2:
				case 4:
				case sizeof($list) - 1:
					$line[0] .= '─';
					break;
				case 1:
				case 3:
					$line[1] .= ' ';
				default:
					end:
					$line[0] .= ' ';
					break;
			}
		}
		$line = implode('', $line);
	}
	$list = implode(PHP_EOL, $list);

	return $list;
	//  ┌─────────────────────────────┐
	//  │        CONTACTS LIST        │
	//  ├──────────┬──────────────────┤
	//  │   Name   │   Phone number   │
	//  ├──────────┼──────────────────┤
	//  │   1. a   │   111-111-1111   │
	//  │   2. j   │                  │
	//  │   3. z   │                  │
	//  │   4. n   │                  │
	//  │   5. q   │                  │
	//  │   6. u   │                  │
	//  │   7. f   │                  │
	//  │   8. p   │                  │
	//  │   9. t   │                  │
	//  │  10. b   │                  │
	//  ├──────────┴──────────────────┤
	//  │   0. cancel                 │
	//  └─────────────────────────────┘
}

function generateMenu($title, $commands)
{
	array_unshift($commands, NULL);
	unset($commands[0]);
	$longest = strlen($title);

	$menu = [];
	$menu[] = ['  ┌───────────', '┐'];
	$menu[] = ['  │     ', "$title     ", '│'];
	$menu[] = ['  ├───────────────────', '┤'];
	foreach ($commands as $index => $command) {
		if (strlen($command) + 3 > $longest) $longest = strlen($command) + 3;
		if ($index === sizeof($commands)) {
			$menu[] = ['  ├───────────', '┤'];
			$menu[] = ["  │    0. $command      ", '│'];
			$menu[] = ['  └───────────', '┘'];
		} else {
			$menu[] = ['  │  ' . str_pad('', 3 - strlen($index)) . "{$index}. $command      ", '│'];
		}
	}

	$linelength = ($longest % 2 === 0 or $longest === strlen($title)) ? $longest + 14 : $longest + 15;

	foreach ($menu as $index => &$line) {
		while (mb_strlen(implode('', $line)) < $linelength) {
			switch ($index) {
				case 0:
				case 2:
				case sizeof($menu) - 3:
				case sizeof($menu) - 1:
					$line[0] .= '─';
					break;
				case 1:
					$line[1] .= ' ';
				default:
					$line[0] .= ' ';
					break;
			}
		}
		$line = implode('', $line);
	}
	$menu = implode(PHP_EOL, $menu);
	return $menu;

	//  ┌───────────────────┐
	//  │     MAIN MENU     │
	//  ├───────────────────┤
	//  │    1. menu        │
	//  │    2. help        │
	//  │    3. list        │
	//  │    4. search      │
	//  │    5. add         │
	//  │    6. delete      │
	//  ├───────────────────┤
	//  │    0. exit        │
	//  └───────────────────┘
}

function showMainMenu()
{
	$commands = ['menu', 'help', 'list', 'search', 'add', 'delete', 'exit'];
	$menu = generateMenu('MAIN MENU', $commands);
	echo PHP_EOL . $menu . PHP_EOL . PHP_EOL;
}

function listContacts($title, $parsedContacts, $last = false)
{
	if ($parsedContacts === NULL) {
		echo PHP_EOL . 'no contacts found' . PHP_EOL . 'press enter to return to main menu' . PHP_EOL;
		return;
	}
	echo PHP_EOL . generateList($title, $parsedContacts, $last) . PHP_EOL . PHP_EOL;
}

function confirm()
{
	$confirm = strtolower(trim(fgets(STDIN)));
	while (!preg_match('~^[(y(es)?)(no?)]$~', $confirm)) {
		echo '(y/n)' . PHP_EOL . '>';
		$confirm = strtolower(trim(fgets(STDIN)));
	}
	if (preg_match('~^y(es)?$~', $confirm)) {
		return true;
	} elseif (preg_match('~^no?$~', $confirm)) {
		return false;
	}
}

function deleteFromList($indexes, $parsedContacts)
{
	if ($parsedContacts === NULL) {
		echo PHP_EOL . 'no contacts found' . PHP_EOL . 'press enter to return to delete menu' . PHP_EOL;
		fgets(STDIN);
		return;
	}

	listContacts('SEARCH  RESULTS', $parsedContacts, true);

	echo 'which to delete?' . PHP_EOL . PHP_EOL;

	while (true) {
		echo '>';
		$input = strtolower(trim(fgets(STDIN)));
		$input = preg_replace(['~[^\w ]~', '~  +~'], ['', ' '], $input);
		if ($input === '0') {
			return;
		}

		$deleteRequest = NULL;
		foreach ($parsedContacts as $index => $contact) {
			if ($input == $index or $input == strtolower($contact['name']) or $input == $index . strtolower($contact['name'])) {
				$deleteRequest = $index;
			}
		}

		if ($deleteRequest !== NULL) {
			$toDelete = $indexes[$deleteRequest];
			echo PHP_EOL . 'really delete "' . implode(' | ', $parsedContacts[$deleteRequest]) . '"?' . PHP_EOL . '(y/n)' . PHP_EOL . '>';
			$confirm = confirm();

			if ($confirm) {
				$allContacts = getContacts();
				unset($allContacts[$toDelete]);
				$filename = 'contacts.txt';
				$fileContents = implode(PHP_EOL, $allContacts);
				$handle = fopen($filename, 'w');
				$success = fwrite($handle, $fileContents);
				fclose($handle);
				echo PHP_EOL . ($success ? 'successfully deleted contact: ' . implode(' | ', $parsedContacts[$deleteRequest]) : 'something went wrong!') . PHP_EOL . 'press enter to return to delete menu' . PHP_EOL;
				fgets(STDIN);
				return;
			} else {
				return;
			}
		} else {
			echo 'must pick vaid option from list' . PHP_EOL . PHP_EOL;
		}
	}
}

function searchAndDelete()
{
	$searchResults = searchContacts();

	if ($searchResults === NULL) return;

	if (empty($searchResults)) {
		echo PHP_EOL . 'no results found' . PHP_EOL . 'press enter to return to delete menu';
		fgets(STDIN);
		return;
	}

	$parsedContacts = [];
	$indexes = [];

	foreach ($searchResults as $result) {
		$parsedContacts[] = ['name' => $result['name'], 'number' => $result['number']];
		$indexes[] = $result['index'];
	}
	deleteFromList($indexes, $parsedContacts);
}

function checkForDuplicates($name)
{
	$contacts = getContacts();
	$parsedContacts = parseContacts($contacts);
	if ($parsedContacts === NULL) return NULL;

	$duplicate = NULL;

	foreach ($parsedContacts as $index => $contact) {
		if ($name === $contact['name']) {
			$duplicate = ['index' => $index, 'contact' => $contact];
			break;
		}
	}

	if ($duplicate !== NULL) {
		echo PHP_EOL . "contact \"{$duplicate['contact']['name']}\" already exists" . PHP_EOL . 'overwrite? (y/n)' . PHP_EOL . '>';
		$confirm = confirm();
		if ($confirm) {
			unset($contacts[$duplicate['index']]);
			$fileContents = implode(PHP_EOL, $contacts);
			$filename = 'contacts.txt';
			$handle = fopen($filename, 'w');
			fwrite($handle, $fileContents);
			fclose($handle);
			return true;
		} else {
			return false;
		}
	}
}

function addContact()
{
	echo PHP_EOL . 'enter name' . PHP_EOL . '>';
	$name = preg_replace('~  +~', ' ', trim(fgets(STDIN)));
	while (preg_match('~[^a-zA-Z ]~', $name) or $name === '') {
		if ($name === '0') {
			echo PHP_EOL;
			return;
		}
		echo PHP_EOL . (!$name ? 'must enter name' : 'name must consist only of letters and spaces') . PHP_EOL . 'enter 0 to cancel' . PHP_EOL . '>';
		$name = trim(fgets(STDIN));
	}

	$duplicate = checkForDuplicates($name);
	if ($duplicate === false) {
		echo PHP_EOL . 'contact was not overwritten' . PHP_EOL . 'press enter to return to main menu' . PHP_EOL;
		fgets(STDIN);
		return;
	}

	echo PHP_EOL . 'enter phone number' . PHP_EOL . '>';
	$number = preg_replace('~^\(?(\d{3})\)?[ -]?(\d{3})-?(\d{4})$~', '$1$2$3', trim(fgets(STDIN)));
	while (preg_match('~\D~', $number) or strlen($number) !== 10) {
		if ($number === '0') {
			echo PHP_EOL;
			return;
		}
		echo PHP_EOL . 'must enter valid 10-digit phone number in any common format' . PHP_EOL . 'enter 0 to cancel' . PHP_EOL . '>';
		$number = preg_replace('~^\(?(\d{3})\)?[ -]?(\d{3})-?(\d{4})$~', '$1$2$3', trim(fgets(STDIN)));
	}

	$contact = "$name|$number";
	$filename = 'contacts.txt';
	$handle = fopen($filename, 'a');
	$success = fwrite($handle, PHP_EOL . $contact);
	fclose($handle);
	if ($success) {
		$resultMessage = 'successfully wrote ' . ($duplicate ? '' : 'new ') . 'contact: ' . implode(' | ', parseContacts($contact));
	} else {
		$resultMessage = 'something went wrong!';
	}
	echo PHP_EOL . $resultMessage . PHP_EOL . 'press enter to return to main menu' . PHP_EOL;
	fgets(STDIN);
}

function searchContacts()
{
	$parsedContacts = parseContacts(getContacts());
	if ($parsedContacts === NULL) {
		echo PHP_EOL . 'no contacts found' . PHP_EOL . 'press enter to return to previous menu' . PHP_EOL;
		fgets(STDIN);
		return NULL;
	}
	$search = '';
	while ($search === '') {
		echo PHP_EOL . 'enter search term(s) space separated' . PHP_EOL . '>';
		$search = (trim(fgets(STDIN)));
		$search = preg_replace(['~[^\w ]~', '~  +~'], ['', ' '], $search);
		if ($search == '0') return NULL;
		$search = preg_replace('~[^a-zA-Z ]~', '', $search);
	}

	$searchTerms = explode(' ', strtolower($search));
	$searchResults = [NULL];

	foreach ($parsedContacts as $index => $contact) {
		foreach ($searchTerms as $term) {
			if (strpos(strtolower($contact['name']), $term) === false) {
				continue 2;
			}
		}
		$searchResults[] = ['name' => $contact['name'], 'number' => $contact['number'], 'index' => $index];
	}

	unset($searchResults[0]);

	return $searchResults;
}

function showDeleteMenu()
{
	$commands = ['menu', 'help', 'list', 'remembered', 'search', 'back'];
	$menu = generateMenu('DELETE', $commands);
	echo PHP_EOL . $menu . PHP_EOL . PHP_EOL;
}

function deleteMenu()
{
	showDeleteMenu();
	while (true) {
		clearstatcache();
		echo '>';
		$input = strtolower(trim(fgets(STDIN)));
		$input = preg_replace(['~  +~', '~[^\w ]~'], [' ', ''], $input);
		$command = explode(' ', $input);
		isset($command[1]) ?: $command[1] = NULL;
		switch ($command[0]) {
			case '1':
			case 'menu':
				showDeleteMenu();
				break;
			case '2':
			case 'help':
				help('delete', $command[1]);
				break;
			case '3':
			case 'list':
				deleteFromList(getContactIndexes(), parseContacts(getContacts()));
				showDeleteMenu();
				break;
			case '4':
			case 'remembered':
				echo PHP_EOL . 'not yet implemented' . PHP_EOL . PHP_EOL;
				break;
			case '5':
			case 'search':
				searchAndDelete();
				showDeleteMenu();
				break;
			case '0':
			case 'back':
				return;
			case 'exit':
				exit(0);
				break;
			default:
				echo 'command not recognized -- type "menu" for commands' . PHP_EOL . PHP_EOL;
				break;
		}
	}
}

function help($mode, $command)
{
	switch ($mode) {
		case 'main':
			switch ($command) {
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
			break;
		}
		case 'delete':
			switch ($command) {
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
					$message = 'choose contact from list to delete';
					break;
				case '4':
				case 'remembered':
					$message = 'remembered: delete remembered contact';
					break;
				case '5':
				case 'search':
					$message = 'search: search for contact to delete';
					break;
				case '0':
				case 'back':
					$message = 'back: return to main menu';
					break;
				case 'exit':
					$message = 'exit: terminate application';
				default:
					$message = "cannot offer help on unrecognized command: $command";
					break;
			}
			break;
	}
	echo $message . PHP_EOL . PHP_EOL;
}

function mainMenu()
{
	showMainMenu();

	while (true) {
		clearstatcache();
		echo '>';
		$input = strtolower(trim(fgets(STDIN)));
		$input = preg_replace(['~  +~', '~[^\w ]~'], [' ', ''], $input);
		$command = explode(' ', $input);
		isset($command[1]) ?: $command[1] = NULL;
		switch ($command[0]) {
			case '1':
			case 'menu':
				showMainMenu();
				break;
			case '2':
			case 'help':
				help('main', $command[1]);
				break;
			case '3':
			case 'list':
				listContacts('CONTACTS LIST', parseContacts(getContacts()));
				break;
			case '4':
			case 'add':
				addContact();
				showMainMenu();
				break;
			case '5':
			case 'search':
				$searchResults = searchContacts();
				if ($searchResults !== NULL) listContacts('SEARCH  RESULTS', $searchResults);
				break;
			case '6':
			case 'delete':
				deleteMenu();
				showMainMenu();
				break;
			case '0':
			case 'exit':
				return;
			default:
				echo 'command not recognized -- type "menu" for commands' . PHP_EOL . PHP_EOL;
				break;
		}
	}
}

mb_internal_encoding('UTF-8');
mainMenu();

exit(0);