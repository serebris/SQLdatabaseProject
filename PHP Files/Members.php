<?php # Script 9.5 - register.php #2
// This script performs an INSERT query to add a record to the users table.

$page_title = 'New Member';
include ('includes/header.html');

// Check for form submission:

// echo $_SERVER['REQUEST_METHOD'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	//echo '1';

	require('mysqli_connect.php'); // Connect to the db.
	
	//echo '2';

	$errors = array(); // Initialize an error array.

	//echo '3';

	// Check for a MemberID:
	if (empty($_POST['MemberID'])) {
		echo 'You forgot to enter your MemberID.';
		$errors[] = 'You forgot to enter your MemberID.';
	} else {
		$MemberID = mysqli_real_escape_string($dbc, trim($_POST['MemberID']));
		$mid=intval($MemberID);
	}


	// Check for a name:
	if (empty($_POST['name'])) {
		echo 'You forgot to enter your Name.';
		$errors[] = 'You forgot to enter your Name.';
	} else {
		$fn = mysqli_real_escape_string($dbc, trim($_POST['name']));
	}
	
	// Check for a login:
	if (empty($_POST['login'])) {
		$errors[] = 'You forgot to enter your login.';
	} else {
		$ln = mysqli_real_escape_string($dbc, trim($_POST['login']));
	}
	
			
	if (empty($_POST['description'])) {
		$errors[] = 'You forgot to enter your descroption.';
	} else {
		$d = mysqli_real_escape_string($dbc, trim($_POST['description']));
	}

	// Check for an email address:
	if (empty($_POST['email'])) {
		$errors[] = 'You forgot to enter your email address.';
	} else {
		$e = mysqli_real_escape_string($dbc, trim($_POST['email']));
	}
	
	if (empty($_POST['membershipID'])) {
		$errors[] = 'You forgot to enter your membershipID.';
	} else {
		$memid = mysqli_real_escape_string($dbc, trim($_POST['membershipID']));
	}
	
	if (empty($_POST['date'])) {
		$errors[] = 'You forgot to enter the date.';
	} else {
		$dt = mysqli_real_escape_string($dbc, trim($_POST['date']));
	}

	// Check for a password:
	if (empty($_POST['password'])) {
		$errors[] = 'You forgot to enter your password.';
	} else {
		$ps = mysqli_real_escape_string($dbc, trim($_POST['password']));
	}
	
	if (empty($errors)) { // If everything's OK.
	
		// Register the lecturer in the database...
		
		// Make the query:
		$q = "INSERT INTO Members (MemberID, MemName, MemLogin, MemDescription, MemEmail, MembershipID, SignUpDate, MemPassword) VALUES (
			$mid, '$fn', '$ln', '$d', '$e', '$memid', '$dt', '$ps')";		
		$r = @mysqli_query ($dbc, $q); // Run the query.
		if ($r) { // If it ran OK.
		
			// Print a message:
			echo '<h1>Thank you!</h1>
		<p>You are now in the database.</p><p><br /></p>';	
		
		} else { // If it did not run OK.
			
			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>'; 
			
			// Debugging message:
			echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
						
		} // End of if ($r) IF.
		
		mysqli_close($dbc); // Close the database connection.

		// Include the footer and quit the script:
		include ('includes/footer.html'); 
		exit();
		
	} else { // Report the errors.
	
		echo '<h1>Error!</h1>
		<p class="error">The following error(s) occurred:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		}
		echo '</p><p>Please try again.</p><p><br /></p>';
		
	} // End of if (empty($errors)) IF.
	
	mysqli_close($dbc); // Close the database connection.

} // End of the main Submit conditional.

?>
<h1>Register</h1>
<form action="Members.php" method="post">

	<p>MemberID: <input type="text" name="MemberID" size="15" maxlength="20" value="<?php if (isset($_POST['MemberID'])) echo $_POST['MemberID']; ?>" /></p>
	<p>Name: <input type="text" name="name" size="15" maxlength="50" value="<?php if (isset($_POST['name'])) echo $_POST['name']; ?>" /></p>
	<p>Login: <input type="text" name="login" size="15" maxlength="20" value="<?php if (isset($_POST['login'])) echo $_POST['login']; ?>" /></p>


	<p>Description: <input type="textarea" name="description" size="20" rows="3" cols="40" value="<?php if (isset($_POST['description'])) echo $_POST['description']; ?>"  /> </p>



	<p>Email Address: <input type="text" name="email" size="10" maxlength="20" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"  /></p>

	<p>MembershipID: <input type="text" name="membershipID" size="10" maxlength="20" value="<?php if (isset($_POST['membershipID'])) echo $_POST['membershipID']; ?>"  /></p>
	<p>Date: <input type="date" name="date"  min="2022-02-20" max="2032-02-20" value="<?php if (isset($_POST['date'])) echo $_POST['date']; ?>"  /></p>

	
	<p>Password: <input type="text" name="password" size="10" maxlength="20" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>"  /></p>
	<p><input type="submit" name="submit" value="Register" /></p>
</form>
<?php include ('includes/footer.html'); ?>
