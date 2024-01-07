<?php # Script 9.5 - register.php #2
// This script performs an INSERT query to add a record to the users table.

$page_title = 'Search Posts';
include ('includes/header.html');

// Check for form submission:

// echo $_SERVER['REQUEST_METHOD'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') { //remember the difference between post and get?

	require ('./mysqli_connect.php'); // Connect to the db.
		
	$errors = array(); // Initialize an error array.
	
	// Check for an email address:
	if (empty($_POST['title'])) {  //$_POST is a global variable. empty() method determines whether a variable is considered to be empty.
		$errors[] = 'You forgot to enter the title';
	} else {
		$fn = mysqli_real_escape_string($dbc, trim($_POST['title'])); //mysqli_real_escape_strin()escapes special characters in a string for use in an SQL statement.
	}
	
    if (empty($errors)) { // If there is no errors. If everything's OK.
      // Make the query:
		$q = "SELECT PostTitle AS Title, PublicationName AS Publication, MemName AS Name FROM Posts, Publications, Members where 
		Posts.PublicationID=Publications.PublicationID AND 
		Posts.MemberID=Members.MemberID and PostTitle='$fn'";	
		$r = @mysqli_query ($dbc, $q); // Run the query.
		$num = mysqli_num_rows($r);
		
	   if ($num > 0) { // If it ran OK, display the records.

	// Print how many users there are:
	   echo "<p>There is the information for the title you are looking for.</p>\n";

	// Table header.
	   echo '<table align="center" cellspacing="3" cellpadding="3" width="75%">
	    <tr><td align="left"><b>Title</b></td><td align="left"><b>Publication</b></td><td align="left"><b>Name</b></td></tr>
';
	
	// Fetch and print all the records:
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) { //MYSQLI_ASSOC makes the returned array assortative. 
		echo '<tr><td align="left">' . $row['Title'] . '</td><td align="left">' . $row['Publication'] . '</td><td align="left">' . $row['Name'] . '</td></tr>
		';
	   }

	echo '</table>'; // Close the table.
			} 
			else { // If it did not run OK.

				// Public message:
				echo '<h1>Error</h1>
				<p class="error">There is no post to match with the information you provided</p>'; 
	
			}
			}
			
			mysqli_close($dbc); // Close the database connection.
		} // End of the main Submit conditional.
?>
<h1>Search Posts by Title</h1>
<form action="search.php" method="post">
	<p>Title <input type="text" name="title" size="15" maxlength="100" value="<?php if (isset($_POST['title'])) echo $_POST['title']; ?>" /></p> 
	<p><input type="submit" name="submit" value="Search Posts" /></p>
	</form>
<?php include ('includes/footer.html'); ?>
