<?php
/*
 * @author Skully
 * A further improved and simplified usage of the MySQLi driver achieved by
 * using overload functions that provide simplistic usage and a shorter syntax.
 */

require_once 'config/database.php'; // Require database details for connection.

// Primary connection function which creates a connection to the database.
function connect()
{
    $db = new mysqli(
        DB_HOST,
        DB_USER,
        DB_PASS,
        DB_NAME
    );

    if ($db->connect_error) {
        die("FATAL ERROR: Failed to connect to database: \n"
            . $db->connect_error . "\n"
            . $db->connect_errno
        );
    }
    return $db;
}

// Establish the connection and set it to the variable $db so it can be used.
$db = connect();

//---------------------------- [MySQLi Functions] --------------------------------------

/*
 * Executes the provided query and returns the respective result.
 * @param mysqli $db
 * @param String $query
 * @return Fetch result if a result exists, false otherwise.
 */
function fetch(mysqli $db, $query)
{
    $data = false;

    $query = mysqli_query($db, $query);
    $result = mysqli_fetch_assoc($query);
    if ($result)
    {
        $data = $result;
    }

    return $data;
}

/*
 * Executes teh provided query and returns an array of all results.
 * @param mysqli $db
 * @param String $query
 * @return Array containing all results.
 */
function fetchAll(mysqli $db, $query)
{
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
 * @param mysqli $db
 * @param String $query
 * @return The mysqli database connection.
 */
function execute(mysqli $db, $query)
{
    $db->query($query);
    return $db;
}

/*
 * Used to string escaping within queries.
 * @param mysqli $db
 * @param String $data
 * @return The escaped mysqli data.
 */
function escape(mysqli $db, $data)
{
    return $db->real_escape_string($data);
}