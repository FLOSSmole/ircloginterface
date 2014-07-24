ircloginterface
===============

An interface for showing IRC log messages via text search. Part of the FLOSSmole project.


ircnewtest.php - This file allows the user to search IRC channels and add entries to the database. They can also view user results that were previously input in this same page.

messageDisplay2.php - This file allows the user to view a specific chunk of IRC logs and submit the certain lines that they want into the talk_twss database, which can be displayed on the page in ircnewtest.php.

tablestyle2.css - CSS styling code for the messageDisplay2.php page

newStyle.css - CSS styling code for the ircnewtest.php page

login2.php - the login credentials to connect to your server/database

This code relies on the following table structure:



This table holds the results of the user input:

CREATE TABLE IF NOT EXISTS `talk_twss` (
  `datasource_id` int(11) NOT NULL,
  `set_line_num` int(11) DEFAULT NULL,
  `punch_line_num` int(11) NOT NULL,
  `search_keyword` varchar(50) NOT NULL,
  `joke_type` varchar(50) NOT NULL,
  `user` varchar(50) NOT NULL,
  PRIMARY KEY (`datasource_id`,`punch_line_num`,`user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

This table holds the lists of IRC channels:

CREATE TABLE IF NOT EXISTS `IRCtablelist` (
  `list_id` int(11) NOT NULL,
  `table_name` varchar(100) NOT NULL,
  `display_name` varchar(100) NOT NULL,
  PRIMARY KEY (`list_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

This table is used for storing IRC channel logs:

CREATE TABLE IF NOT EXISTS `wp_irc` (
  `datasource_id` int(11) NOT NULL,
  `line_num` int(11) NOT NULL,
  `line_message` varchar(500) NOT NULL,
  `date_of_entry` date NOT NULL,
  `time_of_entry` time NOT NULL,
  `type` enum('message','system') NOT NULL,
  `send_user` varchar(50) NOT NULL,
  `last_updated` datetime NOT NULL,
  PRIMARY KEY (`line_num`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
