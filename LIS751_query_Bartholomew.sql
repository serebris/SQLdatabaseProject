 #SQL Queries:

#(1)	I want to know the information on Editors (their names and email addresses) and how many publications they review. I would like to limit my search to the editors who lead 5 and more publications at once. 

SELECT COUNT(p.PublicationID) AS Count, CONCAT(e.EditorLastName,', ', e.EditorFirstName) AS EditorName, e.EditorEmail
FROM Publications AS p
INNER JOIN EditorPublications AS ep ON p.PublicationID = ep.PublicationID
INNER JOIN Editors AS e ON e.EditorID = ep.EditorID
Group By EditorName
Having Count >=5
Order By Count desc;


#(2)	I need information on posts, publications these posts appear in and names and description of members who wrote them.  

SELECT m.MemName, m.MemDescription, p.PostTitle, pb.PublicationName
FROM Members AS m
INNER JOIN Posts AS p ON m.MemberID = p.MemberID
INNER JOIN Publications AS pb ON pb.PublicationID = p.PublicationID
ORDER BY m.MemName;


#(3)	I want to know what publication has the most posts.

SELECT Count(p.PostID) AS 'Number of Posts', pb.PublicationName, pb.PublicationDescription
From Posts AS p
INNER JOIN Publications AS pb ON p.PublicationID = pb.PublicationID;


#(4)	Who wrote the greatest number of posts?

SELECT Count(p.PostID) AS 'Number of Posts', m.MemName, m.MemDescription
From Posts AS p
INNER JOIN Members AS m ON p.MemberID = m.MemberID;


#(5)	Names and Emails of members who pay yearly subscription fee.

SELECT m.MemName, m.MemEmail, m.SignUpDate, mb.MembershipName NOT IN (select MembershipID from
Memberships where MembershipName = 'free') AS PaidMembership
FROM Members AS m
INNER JOIN Memberships AS mb ON m.MembershipID = mb.MembershipID
ORDER BY m.SignUpDate desc;


