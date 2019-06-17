<?php
	$conn = new mysqli('localhost', 'root', '', 'votesystem');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	function getDatas($req)
    {
    	global $conn;
    	$query = $conn->query($req);
    	$rows = [];
    	while($row = $query->fetch_assoc()) {
		    $rows[] = $row;
		}
		return $rows;
    }

    function getData($req, $params)
    {
        global $pdo;
        $stmt = $pdo->prepare($req);
        $stmt->execute($params);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    function setData($req, $params)
    {
        try {
            global $pdo;
            $stmt = $pdo->prepare($req);
            return $stmt->execute($params);
        } catch (Exception $e) {
            return $e;
        }
    }
	
?>