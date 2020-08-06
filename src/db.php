<?php
/**
 * @author  Skully (https://github.com/ImSkully)
 * @website http://skully.tech
 * @email   skully@ultranetwork.net
 * @updated 06/08/2020 (dd/mm/yyyy)
 *
 * A simplified API for the PHP mysqli driver, combining the usage of
 * a single connection per database; supports multiple database connections!
 */

require_once __DIR__ . '/../config/database.php'; // Require database details for connection.

// Array containing all of the mysqli database elements, and their respective database credentials.
$DATABASES = array(
    "primary" => array(
        "host" => DB_PRIMARY_HOST,
        "name" => DB_PRIMARY_NAME,
        "username" => DB_PRIMARY_USER,
        "password" => DB_PRIMARY_PASS,
        "db" => false,
    ),
    /* Uncomment for another database.
    "secondary" => array(
        "host" => DB_SECONDARY_HOST,
        "name" => DB_SECONDARY_NAME,
        "username" => DB_SECONDARY_USER,
        "password" => DB_SECONDARY_PASS,
        "db" => false,
    ),*/
);

// Primary connection function which establishes a connection to all databases.
function connect()
{
    global $DATABASES;
    foreach ($DATABASES as $dbName => $credentials)
    {
        $db = new mysqli(
            $credentials["host"],
            $credentials["username"],
            $credentials["password"],
            $credentials["name"]
        );

        if ($db->connect_error)
        {
            die("FATAL ERROR: Failed to connect to database '" . $dbName ."': \n"
                . $db->connect_error . "\n"
                . $db->connect_errno
            );
        }

        $DATABASES[$dbName]["db"] = $db;
    }

    // Enable MySQL error reporting.
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
}
connect(); // Establish the connection to test connectivity, will throw errors if there is any issues connecting.

/* -------------------------------------- [API Functions] -------------------------------------- */

/**
 * Executes the specified query and returns the first result.
 * @param   $db     String  The database name to use for this query.
 * @param   $query  String  The SQL query.
 * @return  bool|string[]   The mysqli response if fetch was successful, false otherwise.
 */
function fetch($db, $query)
{
    if (!$db || !$query) { return false; } // Parse parameters, ensure both exist.

    global $DATABASES;
    if (empty($DATABASES[$db])) { return false; } // Ensure a database connection exists for the requested database.

    $data = false; // The data to return.
    $query = mysqli_query($DATABASES[$db]["db"], $query); // Run the query on the provided database.
    $result = mysqli_fetch_assoc($query);
    if ($result) $data = $result; // If we have a result.

    mysqli_free_result($query); // Free the memory that was allocated to this query.
    return $data; // Return the data.
}

/**
 * Executes the provided query and returns an array of all results.
 * @param   $db     String  The database name.
 * @param   $query  String  The SQL query.
 * @return  array|bool      An array containing the mysqli response if fetch was successful, false otherwise.
 */
function fetchAll($db, $query)
{
    if (!$db || !$query) { return false; } // Parse parameters, ensure both exist.

    global $DATABASES;
    if (empty($DATABASES[$db])) { return false; } // Ensure a database connection exists for the requested database.

    $data = []; // The data to return.

    $results = $DATABASES[$db]["db"]->query($query);

    // If we have at least one row in the result, continue to iterate through the rows and add it to the data table.
    if ($results->num_rows > 0) while($row = $results->fetch_assoc()) $data[] = $row;

    mysqli_free_result($results); // Free the memory that was allocated to this query.
    return $data; // Return the data.
}

/**
 * Executes the provided query.
 * @param   $db     String  The database name.
 * @param   $query  String  The SQL query.
 * @return  bool            Returns true if the query executed, false otherwise.
 */
function execute($db, $query)
{
    if (!$db || !$query) { return false; } // Parse parameters, ensure both exist.

    global $DATABASES;
    if (empty($DATABASES[$db])) { return false; } // Ensure a database connection exists for the requested database.

    $DATABASES[$db]["db"]->query($query); // Execute the query.
    return true;
}

/**
 * Runs the mysqli_escape_string to escape special characters from the string.
 * @param   $data   String  The variable or data to escape.
 * @param   string  $db     The database of which charset to use, if none provided then the default server is used.
 * @return  String          Returns the data escaped.
 */
function escape($data, $db = "primary") // Adjust the default server to for escaping strings here.
{
    global $DATABASES;
    return $DATABASES[$db]["db"]->real_escape_string($data);
}