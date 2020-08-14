#				STAR RATING APP

    -This is a product star rating system using PHP, MySQL and CSS.
    -The database name is 'starRatingSystem' which can be created by running the SQL queries found in starRatingSystem.sql or just importing it into your database.
        The database has the following 2 tables:
	        i) product which contains all the products to be rated by visitors to the app
	        ii) ratings which obviously contains the records of reviews given by visitors in the form of a rating score, some comments, and needless to
	            say this table references the product ID of the product the rating refers to.

	    The database connection credentials are found in the constructor of Rating.php

    —On the index page we grab and display all products in the system. We indicate how many reviews each product has had, and the total average of
        these star ratings based on the rating given by each reviewer.
    -Ratings are based on a scale of 1 to 5 stars.
    -Below each product is a list of all the individual ratings in the form of the number of stars given, the comments submitted with the rating
        and the date of submission.

    -There is a link below product for visitors to give a rating.
    -The images screenshot1.png and screenshot2.png show you what the result looks like.