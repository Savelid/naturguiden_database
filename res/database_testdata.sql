DELETE FROM guests;
INSERT INTO guests
	VALUES('0', '2015-03-15 07:14:07', 'Verena Heinisch', '0', 'ARN - 3 maj', 'ARN - 7 maj', '40', 'double', 'banana', '25', 'NG', '900 SEK', 'Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.');
INSERT INTO guests
	VALUES('1', '2015-03-14 08:15:17', 'Robin Savelid', '0', 'ARN - 3 maj', 'ARN - 7 maj', '44', 'double', '', '28', 'NG', '900 SEK', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.');

DELETE FROM groups;
INSERT INTO groups
	VALUES('0', '2015-09-15 03:14:07', '12345', 'Group Green', '2015-05-03', '2015-05-07', 'Unconfirmed', 'C1', 'Private Group', 'Amatures', 'Car', 'Comment');
INSERT INTO groups
	VALUES('1', '2015-10-15 03:14:07', '12346', 'Group Blue', '2015-05-11', '2015-05-15', 'Confirmed', 'C2', 'Private Group', 'Experienced', 'Buss', 'Comment');
