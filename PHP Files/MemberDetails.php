<?php # Script 9.5 - ClassRoster.php #2
// This script performs an INSERT query to add a record to the users table.

$page_title = 'Member Details';
include ('includes/header.html');

// Check for form submission:

// echo $_SERVER['REQUEST_METHOD'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') { //remember the difference between post and get?

	require ('./mysqli_connect.php'); // Connect to the db.
		
	$errors = array(); // Initialize an error array.
	
	// Check for an courese information:
	if (empty($_POST['member_name'])) {  //$_POST is a global variable. empty() method determines whether a variable is considered to be empty.
		$errors[] = 'You forgot to enter the name';
	} else {
		$mn = mysqli_real_escape_string($dbc, trim($_POST['member_name'])); //mysqli_real_escape_strin()escapes special characters in a string for use in an SQL statement.
	}
	
    if (empty($errors)) { // If there is no errors. If everything's OK.
      // Make the query:
		$q = "SELECT MemName as Name, MemDescription as Description, MemEmail as Email, MembershipName from Members, Memberships
		WHERE Members.MembershipID=Memberships.MembershipID AND MemName='$mn'";	
		$r = @mysqli_query ($dbc, $q); // Run the query.
		$num = mysqli_num_rows($r);
		
	   if ($num > 0) { // If it ran OK, display the records.

	   
	   
	   
	   
	// Print how many users there are:
	   echo "<p>There is the information for the member you are looking for.</p>\n";

	// Table header.
	   echo '<table align="center" cellspacing="3" cellpadding="4" width="100%">
	    <tr><td align="left"><b>Name</b></td><td align="left"><b>Description</b></td><td align="left"><b>Email</b></td><td align="left"><b>Membership</b></td></tr>';
	
	// Fetch and print all the records:
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) { //MYSQLI_ASSOC makes the returned array assortative. 
		echo '<tr><td align="left">' . $row['Name'] . '</td><td align="left">' . $row['Description'] . '</td><td align="left">' . $row['Email'] . '</td><td align="left">' . $row['MembershipName'] . '</td></tr>
		';
	   }

	echo '</table>'; // Close the table.
			} 
			else { // If it did not run OK.

				// Public message:
				echo '<h1>Error</h1>
				<p class="error">There is no member match with the information you provided</p>'; 
	
			}
			}
			
			mysqli_close($dbc); // Close the database connection.
		} // End of the main Submit conditional.
?>
<h1>Member Details</h1>
<form action="MemberDetails.php" method="post">
	<p>Member Name <input type="text" name="member_name" size="15" maxlength="50" value="<?php if (isset($_POST['member_name'])) echo $_POST['member_name']; ?>" /></p>
	<p><input type="submit" name="submit" value="Show Member Details" /></p>
	</form>


<?php include ('includes/footer.html'); ?>
