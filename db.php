<?php
/*
 * @author Skully
 * A further improved and simplified usage of the MySQLi driver achieved by
 * using overload functions that provide simplistic usage and a shorter syntax.
 */

require_once 'config/database.php'; // Require database details for connection.

$GLOBALS['database'] = false; // Define super global variable to hold database object, initialize as false for now.

// Primary connection function which creates a connection to the database.
function connect()
{
    $db = new mysqli(
        DB_HOST,
        DB_USER,
        DB_PASS,
        DB_NAME
    );

    if ($db->connect_error)
    {
        die("FATAL ERROR: Failed to connect to database: \n"
            . $db->connect_error . "\n"
            . $db->connect_errno
        );
    }

    // Enable MySQL error reporting.
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $GLOBALS['database'] = $db;
    return $db;
}

// Establish the connection to test connectivity, will throw errors if there is any issues connecting.
connect();

//---------------------------- [MySQLi Functions] --------------------------------------

/*
 * Executes the provided query and returns the respective result.
 * @param String $query
 * @return Fetch result if a result exists, false otherwise.
 */
function fetch($query)
{
    $data = false;

    $query = mysqli_query($GLOBALS['database'], $query);
    $result = mysqli_fetch_assoc($query);
    if ($result)
    {
        $data = $result;
    }

    return $data;
}

/*
 * Executes teh provided query and returns an array of all results.
 * @param String $query
 * @return Array containing all results.
 */
function fetchAll($query)
{
    $db = connect();
    $data = [];

    $results = $db->query($query);
    if ($results->num_rows > 0)
    {
        while($row = $results->fetch_assoc())
        {
            $data[] = $row;
        }
    }
    return $data;

}

/*
 * Executes the provided query.
 * @param String $query
 * @return The mysqli database connection.
 */
function execute($query)
{
    $GLOBALS['database']->query($query);
    return $GLOBALS['database'];
}

/*
 * Used to string escaping within queries.
 * @param String $data
 * @return The escaped mysqli data.
 */
function escape($data)
{
    return $GLOBALS['database']->real_escape_string($data);
}