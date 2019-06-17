<?php
	include 'includes/session.php';
	include 'includes/slugify.php';

	function getPourcentageOfVotesPerPosition($positionId) {
		$sql = "SELECT position_id, id FROM candidates where candidates.position_id = " . $positionId;
		$allCandidates = getDatas($sql);
		$sql = "SELECT `candidate_id`, COUNT(*) AS count_votes FROM votes WHERE votes.position_id = " . $positionId . " GROUP BY candidate_id";
		$votesPerCandidate = getDatas($sql);
		$data = [];
		foreach ($allCandidates as $key => $can) {
			$data[$can['id']] = 0;
			foreach ($votesPerCandidate as $key => $vote) {
				if($vote['candidate_id'] == $can['id']) {
					$data[$can['id']] = $vote['count_votes'];
					break;
				}
			}
		}
		$countVotesPerPosition = 0;
		foreach ($data as $key => $item) {
			$countVotesPerPosition += $item;
		}
		$result = [];
		foreach ($data as $key => $element) {
			$result[$key] = [
				'condidateId' => $key,
				'count' => $element,
				'pourcentage' => number_format((float)($element * 100) / $countVotesPerPosition, 2, '.', '')
			];
		}
		return json_encode(array_values($result));
	}

	if(isset($_POST['sentVote'])) {
		// Verefy is not already voted
		$sql = "SELECT * FROM votes WHERE position_id = " . $_POST['positionId'] . " && candidate_id = " . $_POST['condidateId'] . " && voters_id = ". $voter['id'];
		$duplicated = getDatas($sql);
		$sql = "SELECT * FROM positions WHERE positions.id = " . $_POST['positionId'] . " && positions.time_out_date < CURRENT_TIMESTAMP";
		$expiredPositions = getDatas($sql);
		if(($duplicated && count($duplicated) != 0) || ($expiredPositions && count($expiredPositions) != 0)) {
			die;
		}
		$sql = "INSERT INTO votes (voters_id, candidate_id, position_id) VALUES (". $voter['id'] . ", " . $_POST['condidateId'] . ", " . $_POST['positionId'] . ")";
		if($conn->query($sql)) {
			echo getPourcentageOfVotesPerPosition($_POST['positionId']);
			die;
		}
	}

	if(isset($_POST['getPourcentagePositions'])) {
		echo getPourcentageOfVotesPerPosition($_POST['positionId']);
		die;
	}

	if(isset($_POST['vote'])){
		if(count($_POST) == 1){
			$_SESSION['error'][] = 'Please vote atleast one candidate';
		}
		else{
			$_SESSION['post'] = $_POST;
			$sql = "SELECT * FROM positions";
			$query = $conn->query($sql);
			$error = false;
			$sql_array = array();
			while($row = $query->fetch_assoc()){
				$position = slugify($row['description']);
				$pos_id = $row['id'];
				if(isset($_POST[$position])){
					if($row['max_vote'] > 1){
						if(count($_POST[$position]) > $row['max_vote']){
							$error = true;
							$_SESSION['error'][] = 'You can only choose '.$row['max_vote'].' candidates for '.$row['description'];
						}
						else{
							foreach($_POST[$position] as $key => $values){
								$sql_array[] = "INSERT INTO votes (voters_id, candidate_id, position_id) VALUES ('".$voter['id']."', '$values', '$pos_id')";
							}

						}
						
					}
					else{
						$candidate = $_POST[$position];
						$sql_array[] = "INSERT INTO votes (voters_id, candidate_id, position_id) VALUES ('".$voter['id']."', '$candidate', '$pos_id')";
					}

				}
				
			}

			if(!$error){
				foreach($sql_array as $sql_row){
					$conn->query($sql_row);
				}

				unset($_SESSION['post']);
				$_SESSION['success'] = 'Ballot Submitted';

			}

		}

	}
	else{
		$_SESSION['error'][] = 'Select candidates to vote first';
	}

	header('location: home.php');

?>