Team 3 ZOO project
http://zoonika.com/        
https://github.com/4zmir/UH-Zoo.git    //code + nika_zoo.sql
zoonika.com is an internal application. It is made with the administration of a zoo in mind. We have 6 different types of administrators: 
Admin Role:        Username:    	Password:
animal admin:	       animal	       animal
member admin:       	member      	member
product admin:      	product	      product
ride admin:          	ride	         ride
sale admin:         	sale	          sale
super admin:        	super          	super

Product Admin is in charge of inserting new items that are to be sold or ridden. The have the ability the add new products to the database, update products, remove products, list and view all products, and make reports based on a time scale and a product type. There are 4 types of products: gift shop, rides tickets and rides. Any product for sale belongs to one of that types.
Sale Admin is responsible for all sales in the zoo.  They can add new sales (multiple sales using shopping  cart) to the database, update member sales, delete sales, search for a specific sale by any character or list them all, and create a report based on a specified start and end date. Sale Admin has the most advanced report system in out zoo.
Super Admin has the authority over all the employees of the zoo. This person manages adding new employee record in the database as well as updating/deleting existing employees, including their username and password. Finally, super admin can request reports on employees according to their created dates. It also gets a notification on an unusual sale performed in sale department on its dashboard, that has to be acknowledged. 
Member Admin is in charge of activating sold memberships. They have the ability to add new members to the database, update member data, delete members, list all members, and create a report based on a specified start and end date.
Animal Admin is responsible for adding, deleting, updating new animals. Can also perform search, list and simple count report for the time interval.
Ride Admin is responsible for adding, deleting, updating new rides. Can also perform search, list and simple count report for the time interval.

Weird Sale Trigger
Event: After insertion on sale table.
Condition: If the sale involves a product with a price greater than or equal to $5 and at least 100 quantity.
Action: Make an insertion on the unusual_sale table and send a notification to the super admin. Upon logging in, the superadmin will receive a message regarding the sale, sale time, and selling user. Then, the superadmin would be asked to acknowledge the weird sale.

Max Employee Trigger
Event: Before insertion on user table.
Condition: If the department that the user is being added too already has a maximum number of employees (3 for super admin department and 10 for all other departments).
Action: Prevent the insertion and notify the super admin.
