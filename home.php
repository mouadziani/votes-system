<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<?php 
	$sql = "SELECT * FROM positions ORDER BY priority ASC";
	$positions = getDatas($sql);

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
		$countVotesPerPosition = ($countVotesPerPosition == 0) ? 1 : $countVotesPerPosition;
		$result = [];
		foreach ($data as $key => $element) {
			$result[$key] = [
				'condidateId' => $key,
				'count' => $element,
				'pourcentage' => number_format((float)($element * 100) / $countVotesPerPosition, 2, '.', '')
			];
		}
		return $result;
	}
?>
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper" id="vote-page">

	<?php include 'includes/navbar.php'; ?>
	 
	  <div class="content-wrapper">
	    <div class="container">

	      <!-- Main content -->
	      <section class="content">
	      	<?php
	      		$parse = parse_ini_file('admin/config.ini', FALSE, INI_SCANNER_RAW);
    			$title = $parse['election_title'];
	      	?>
	      	<h1 class="page-header text-center title"><b><?php echo strtoupper($title); ?></b></h1>
	        <div class="row">
	        	<div class="col-sm-12">
	        		<?php
				        if(isset($_SESSION['error'])){
				        	?>
				        	<div class="alert alert-danger alert-dismissible">
				        		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					        	<ul>
					        		<?php
					        			foreach($_SESSION['error'] as $error){
					        				echo "
					        					<li>".$error."</li>
					        				";
					        			}
					        		?>
					        	</ul>
					        </div>
				        	<?php
				         	unset($_SESSION['error']);

				        }
				        if(isset($_SESSION['success'])){
				          	echo "
				            	<div class='alert alert-success alert-dismissible'>
				              		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				              		<h4><i class='icon fa fa-check'></i> Success!</h4>
				              	".$_SESSION['success']."
				            	</div>
				          	";
				          	unset($_SESSION['success']);
				        }

				    ?>
 
				    <div class="alert alert-danger alert-dismissible" id="alert" style="display:none;">
		        		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			        	<span class="message"></span>
			        </div>
	    			<!-- Voting Ballot -->
				    <form method="POST" id="ballotForm" action="submit_ballot.php">
				    	<div id="test"></div>
				    	<?php foreach ($positions as $key => $position): ?>
				    		<?php 
				    			$sql = "SELECT * FROM votes WHERE votes.voters_id = " . $voter['id'] . " && position_id = " . $position['id'];
				    			$votedPositions = getDatas($sql);
				    			$sql = "SELECT * FROM positions WHERE positions.id = " . $position['id'] . " && positions.time_out_date < CURRENT_TIMESTAMP";
				    			$expiredPositions = getDatas($sql);
				    		?>
				    		<?php if (($votedPositions && count($votedPositions) > 0) || ($expiredPositions && count($expiredPositions) > 0)): ?>
				    			<?php 
				    				$result = getPourcentageOfVotesPerPosition($position['id']);
				    			 ?>
						    	<div class="box">
						    		<div class="box-header with-border">
						    			<?php echo $position['description'] ?>
						    			<span class="pull-right  position-date-time-out" id="position-element-id-<?php echo $position['id'] ?>"></span>
						    		</div>
						    		<div class="box-body" id="position-<?php echo $position['id'] ?>">
						        		<div class="row">
						        			<?php
						        				$sql = "SELECT * FROM candidates WHERE position_id='".$position['id']."'";
						        				$condidates = getDatas($sql);
						        			 ?>
						        			<?php foreach ($condidates as $condidate): ?>
						        				<?php $image = (!empty($condidate['photo'])) ? 'images/'.$condidate['photo'] : 'images/profile.jpg'; ?>
												<div class="col-md-3">
													<div class="thumbnail" id="candidate-<?php echo $condidate['id'] ?>">
														<div class="thumbnail-content">
															<img src="<?php echo $image ?>">
															<div class="votes-pourcentage" style="height: <?php echo $result[$condidate['id']]['pourcentage'] ?>%"></div>
															<h3 class="pourcentage-label"><?php echo $result[$condidate['id']]['pourcentage'] ?>%</h3>
														</div>
														<div class="caption">
															<button <?php echo isset($result[$condidate['id']]) ? 'disabled' : '' ?> data-condidate-id="<?php echo $condidate['id'] ?>" data-condidate-name="<?php echo $condidate['firstname'] . ' ' . $condidate['lastname'] ?>" id="btn-vote-candidate-<?php echo $condidate['id'] ?>" data-position-id="<?php echo $condidate['position_id'] ?>" class="btn btn-primary btn-block btn-flat vote-btn">
																<?php echo $condidate['firstname'] . ' ' . $condidate['lastname'] ?> - <?php echo $result[$condidate['id']]['count'] ?> Votes
															</button>
														</div>
													</div>
												</div>
						        			<?php endforeach ?>
						        		</div>
						    		</div>
						    	</div>
				    		<?php else: ?>
				    			<div class="box">
						    		<div class="box-header with-border">
						    			<?php echo $position['description'] ?>
						    			<span class="pull-right  position-date-time-out" id="position-element-id-<?php echo $position['id'] ?>"></span>
						    		</div>
						    		<div class="box-body" id="position-<?php echo $position['id'] ?>">
						        		<div class="row">
						        			<?php
						        				$sql = "SELECT * FROM candidates WHERE position_id='".$position['id']."'";
						        				$condidates = getDatas($sql);
						        			 ?>
						        			<?php foreach ($condidates as $condidate): ?>
						        				<?php $image = (!empty($condidate['photo'])) ? 'images/'.$condidate['photo'] : 'images/profile.jpg'; ?>
												<div class="col-md-3">
													<div class="thumbnail" id="candidate-<?php echo $condidate['id'] ?>">
														<div class="thumbnail-content">
															<img src="<?php echo $image ?>">
															<div class="votes-pourcentage"></div>
															<h3 class="pourcentage-label"></h3>
														</div>
														<div class="caption">
															<button data-condidate-id="<?php echo $condidate['id'] ?>" data-condidate-name="<?php echo $condidate['firstname'] . ' ' . $condidate['lastname'] ?>" id="btn-vote-candidate-<?php echo $condidate['id'] ?>" data-position-id="<?php echo $condidate['position_id'] ?>" class="btn btn-primary btn-block btn-flat vote-btn">
																<?php echo $condidate['firstname'] . ' ' . $condidate['lastname'] ?>
															</button>
														</div>
													</div>
												</div>
						        			<?php endforeach ?>
						        		</div>
						    		</div>
						    	</div>
				    		<?php endif ?>
				    	<?php endforeach ?>
		        	</form>
		        	<!-- End Voting Ballot -->
	        	</div>
	        </div>
	      </section>
	    </div>
	  </div>
  
  	<?php include 'includes/footer.php'; ?>
  	<?php include 'includes/ballot_modal.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>
<script>
$(function() {
	// init
	<?php foreach ($positions as $key => $position): ?>
		var positionTimeOutDate = "<?php echo $position['time_out_date'] ?>";
		var positionElement = "<?php echo $position['id'] ?>";
		createCountDown('position-element-id-' + positionElement, positionTimeOutDate);
	<?php endforeach ?>

	var votedCondidates = [];
	$('.vote-btn').click(function (event) {
		event.preventDefault();
		var positionId = $(this).data('position-id');
		var condidateId = $(this).data('condidate-id');

		$.ajax({
			type: 'POST',
			url: 'submit_ballot.php',
			data: {sentVote: true, condidateId: condidateId, positionId: positionId},
			dataType: 'json',
			success: function(response) {
				for (var i = 0; i < response.length; i++) {
					$('#position-' + positionId + ' #candidate-' + response[i].condidateId + ' .votes-pourcentage').css('height', response[i].pourcentage + '%');
					$('#position-' + positionId + ' #candidate-' + response[i].condidateId + ' .pourcentage-label').text(response[i].pourcentage + '%');
					$('#btn-vote-candidate-' + response[i].condidateId).attr('disabled', true);
					var oldText = $('#btn-vote-candidate-' + response[i].condidateId).data('condidate-name');
					$('#btn-vote-candidate-' + response[i].condidateId).text(oldText + ' - ' + response[i].count + " Votes");
				}
			}
		});
	});
});
</script>
<script>
	function createCountDown(elementId, date) 
    {
    	console.log(elementId, date);
	    var countDownDate = new Date(date).getTime();
	    var x = setInterval(function()  {
			var now = new Date().getTime();
			var distance = (countDownDate) - (now);
			var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			var seconds = Math.floor((distance % (1000 * 60)) / 1000);
			$("#" + elementId).html(days + "d " + hours + "h " + minutes + "m " + seconds + "s ");
			if (distance < 0) {
				clearInterval(x);
				$("#" + elementId).html("Vote Expired");
			}
	    }, 1000);
	}
</script>
</body>
</html>