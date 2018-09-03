/* Make a booking to occur every 'jump' days */
CREATE TABLE recurring_booking (
	resource_table VARCHAR(255) NOT NULL,
	column_name VARCHAR(255) NOT NULL,
	username VARCHAR(255) NOT NULL,
	start_day VARCHAR(255) NOT NULL, /* stomps with current date('y-m-d') */
	jump VARCHAR(255) NOT NULL /* jump = "1 week" || "2 week" || "1 month" etc... */
);
