/* Make a booking to occur every day + weeks*7 */
CREATE TABLE recurring_booking (
	username VARCHAR(255) NOT NULL,
	resource_table VARCHAR(255) NOT NULL,
	column_name VARCHAR(255) NOT NULL,
	day VARCHAR(255) NOT NULL,
	jump INT NOT NULL
);
