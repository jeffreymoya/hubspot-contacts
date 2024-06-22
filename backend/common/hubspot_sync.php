<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$env = $dotenv->load();
$hubspotApiKey = $env['HUBSPOT_API_KEY'];
$hubspotApiEndpoint = $env['HUBSPOT_CONTACTS_URL'];
$dbFile = $env['SQLITE_DB'];

function getAllHubSpotContacts($apiKey)
{
    global $hubspotApiEndpoint;
    $allContacts = [];
    $after = null;
    do {
        $url = $hubspotApiEndpoint . '?limit=100&properties=email,firstname,lastname';
        if ($after) {
            $url .= '&after=' . $after;
        }


        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $apiKey
        ));

        $response = curl_exec($ch);

        curl_close($ch);

        $responseData = json_decode($response, true);

        if (isset($responseData['results'])) {
            $allContacts = array_merge($allContacts, $responseData['results']);
        }


        $after = $responseData['paging']['next']['after'] ?? null;

    } while ($after);

    return $allContacts;
}

function setupDatabase($dbFile)
{
    $db = new SQLite3($dbFile);

    $db->exec("CREATE TABLE IF NOT EXISTS contacts (
        id INTEGER PRIMARY KEY,
        email TEXT,
        firstName TEXT,
        lastName TEXT,
        becameACustomerDate TEXT,
        becameALeadDate TEXT
    )");

    $db->exec("CREATE UNIQUE INDEX IF NOT EXISTS idx_id ON contacts (id)");

    return $db;
}

function insertContactsIntoDatabase($db, $contacts)
{
    $stmt = $db->prepare('INSERT OR REPLACE INTO contacts (id, email, firstName, lastName, becameACustomerDate, becameALeadDate) VALUES (:id, :email, :firstName, :lastName, :becameACustomerDate, :becameALeadDate)');

    foreach ($contacts as $contact) {

        $id = $contact['id'] ?? null;
        $email = $contact['properties']['email'] ?? null;
        $firstName = $contact['properties']['firstname'] ?? '';
        $lastName = $contact['properties']['lastname'] ?? '';
        $becameACustomerDate = date('Y-m-d H:i:s', strtotime($contact['createdAt']));
        $becameALeadDate = date('Y-m-d H:i:s', strtotime($contact['updatedAt']));


        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        $stmt->bindValue(':email', $email, SQLITE3_TEXT);
        $stmt->bindValue(':firstName', $firstName, SQLITE3_TEXT);
        $stmt->bindValue(':lastName', $lastName, SQLITE3_TEXT);
        $stmt->bindValue(':becameACustomerDate', $becameACustomerDate);
        $stmt->bindValue(':becameALeadDate', $becameALeadDate);
        $stmt->execute();
    }
}


function countAllContactsInDatabase($db)
{
    $result = $db->query('SELECT COUNT(*) as count FROM contacts');
    $row = $result->fetchArray(SQLITE3_ASSOC);
    return $row['count'];
}


$allContacts = getAllHubSpotContacts($hubspotApiKey);

$db = setupDatabase($dbFile);

insertContactsIntoDatabase($db, $allContacts);

$totalContacts = countAllContactsInDatabase($db);

echo "Total HubSpot Contacts in Database: " . $totalContacts . "\n";


$db->close();
