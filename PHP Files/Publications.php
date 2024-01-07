<?php # Script 9.5 - register.php #2
// This script performs an INSERT query to add a record to the users table.

$page_title = 'Publications';
include ('includes/header.html');

// Check for form submission:

// echo $_SERVER['REQUEST_METHOD'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') { //remember the difference between post and get?

	require ('./mysqli_connect.php'); // Connect to the db.
		
	$errors = array(); // Initialize an error array.
	
	// Check for an email address:
	if (empty($_POST['publication_name'])) {  //$_POST is a global variable. empty() method determines whether a variable is considered to be empty.
		$errors[] = 'You forgot to enter the publication name';
	} else {
		$pn = mysqli_real_escape_string($dbc, trim($_POST['publication_name'])); //mysqli_real_escape_strin()escapes special characters in a string for use in an SQL statement.
	}
	
    if (empty($errors)) { // If there is no errors. If everything's OK.
      // Make the query:
		$q = "SELECT PublicationName AS Publication, PublicationDescription AS Description, CONCAT (EditorLastName, ', ', EditorFirstName) AS Name, EditorEmail AS Email FROM Publications, Editors, EditorPublications
  WHERE Publications.PublicationID=EditorPublications.PublicationID AND
  Editors.EditorID=EditorPublications.EditorID AND
  PublicationName='$pn'";	
		$r = @mysqli_query ($dbc, $q); // Run the query.
		$num = mysqli_num_rows($r); //return the number of rows selected
		
	   if ($num > 0) { // If it ran OK, display the records.

	// Print how many users there are:
	   echo "<p>There is the information for the publication you are looking for.</p>\n";

	// Table header.
	   echo '<table align="center" cellspacing="3" cellpadding="3" width="75%">
	    <tr><td align="left"><b>Publication</b></td><td align="left"><b>Description</b></td><td align="left"><b>Editor Name</b></td><td align="left"><b>Editor Email</b></td></tr>
';
	
	// Fetch and print all the records:
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) { //MYSQLI_ASSOC makes the returned array assortative. 
		echo '<tr><td align="left">' . $row['Publication'] . '</td><td align="left">' . $row['Description'] . '</td><td align="left">' . $row['Name'] . '</td><td align="left">' . $row['Email'] . '</td></tr>
		';
	   }

	echo '</table>'; // Close the table.
			} 
			else { // If it did not run OK.

				// Public message:
				echo '<h1>Error</h1>
				<p class="error">There is no publication name match with the information you provided</p>'; 
	
			}
			}
			
			mysqli_close($dbc); // Close the database connection.
		} // End of the main Submit conditional.
?>

<h1>Search Pubblication Information by Publication title</h1>
<form action="Publications.php" method="post">
	<p>Publication Title <input type="text" name="publication_name" size="15" maxlength="25" value="<?php if (isset($_POST['publication_name'])) echo $_POST['publication_name']; ?>" /></p> 
	<p><input type="submit" name="submit" value="Search Publication Information" /></p>
	</form>

<?php include ('includes/footer.html'); ?>
