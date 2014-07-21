#
# Table structure for table 'tx_savjpgraph_cache'
#
CREATE TABLE tx_savjpgraph_cache (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	cid int(11) DEFAULT '0' NOT NULL,
	cache_timeout int(11) DEFAULT '0' NOT NULL,
	csv int(11) DEFAULT '0' NOT NULL,
  	
	PRIMARY KEY (uid),
	KEY parent (pid)
);