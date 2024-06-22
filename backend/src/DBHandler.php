<?php
namespace App;
use SQLite3;

/**
 * Class DbHandler
 *
 * This class is responsible for handling database operations.
 */
class DbHandler {
    private SQLite3 $db;
    private int $pageSize;

    public function __construct($dbFile) {
        $this->db = new SQLite3($dbFile);
        $this->pageSize = ServiceProvider::getInstance()->get(Config::class)->getPageSize();
    }

    /**
     * Fetches contacts from the database.
     *
     * @param int $pageNumber The page number to fetch.
     * @param string|null $startDate The start date to filter contacts.
     * @param string|null $endDate The end date to filter contacts.
     * @return array Returns an array containing contacts, total count of contacts and page count.
     */
    public function getContacts($pageNumber, $startDate, $endDate) {
        $offset = ($pageNumber - 1) * $this->pageSize;
        $query = "SELECT * FROM contacts";
        $countQuery = "SELECT COUNT(*) as totalCount FROM contacts";
        $whereClauses = [];
        $params = [];

        if ($startDate) {
            $whereClauses[] = "becameACustomerDate >= :minDate";
            $params[':minDate'] = $startDate;
        }

        if ($endDate) {
            $whereClauses[] = "becameACustomerDate <= :maxDate";
            $params[':maxDate'] = $endDate;
        }

        if ($whereClauses) {
            $query .= " WHERE " . implode(" AND ", $whereClauses);
            $countQuery .= " WHERE " . implode(" AND ", $whereClauses);
        }

        $query .= " ORDER BY becameACustomerDate DESC LIMIT :limit OFFSET :offset";
        $params[':limit'] = $this->pageSize;
        $params[':offset'] = $offset;

        $stmt = $this->db->prepare($query);
        $countStmt = $this->db->prepare($countQuery);

        foreach ($params as $key => $value) {
            if ($key == ':limit' || $key == ':offset') {
                $stmt->bindValue($key, $value, SQLITE3_INTEGER);
            } else {
                $stmt->bindValue($key, $value, SQLITE3_TEXT);
                $countStmt->bindValue($key, $value, SQLITE3_TEXT);
            }
        }

        $result = $stmt->execute();
        $countResult = $countStmt->execute();

        $contacts = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $contacts[] = $row;
        }

        $totalCount = $countResult->fetchArray(SQLITE3_ASSOC)['totalCount'];

        $pageCount = ceil($totalCount / $this->pageSize);

        return ['contacts' => $contacts, 'totalCount' => $totalCount, 'pageCount' => $pageCount];
    }

    /**
     * Fetches statistics from contacts table the database.
     *
     * @return DBStat Returns an instance of DBStat containing the statistics.
     */
    function getStatsFromDatabase(): DBStat {

        $query = "
            SELECT 
                MAX(becameACustomerDate) AS maxDate,
                MIN(becameACustomerDate) AS minDate,
                strftime('%Y', datetime(becameACustomerDate, 'unixepoch')) AS year
            FROM 
                contacts
    ";

        $result = $this->db->query($query);

        $stats = $result->fetchArray(SQLITE3_ASSOC);

        $yearQuery = "
            SELECT DISTINCT strftime('%Y', becameACustomerDate) AS year
            FROM contacts
            ORDER BY year ASC
        ";

        $yearResult = $this->db->query($yearQuery);

        $years = [];
        while ($year = $yearResult->fetchArray(SQLITE3_ASSOC)) {
            $years[] = $year['year'];
        }

        return new DBStat(
            $stats['maxDate'] ?? null,
            $stats['minDate'] ?? null,
            $years,
            $this->pageSize
        );
    }

    public function close(): void
    {
        $this->db->close();
    }
}
