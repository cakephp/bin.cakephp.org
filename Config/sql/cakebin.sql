-- phpMyAdmin SQL Dump
-- version 2.6.2-rc1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Oct 13, 2006 at 11:33 AM
-- Server version: 4.1.13
-- PHP Version: 5.1.6
-- 
-- Database: `cakebin`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `pastes`
-- 

CREATE TABLE `pastes` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `nick` varchar(250) NOT NULL default '',
  `lang` varchar(50) NOT NULL default '',
  `note` text NOT NULL,
  `body` longtext NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `save` tinyint(1) NOT NULL default '0',
  `remove` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `pastes_tags`
-- 

CREATE TABLE `pastes_tags` (
  `paste_id` int(10) unsigned NOT NULL default '0',
  `tag_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`paste_id`,`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `tags`
-- 

CREATE TABLE `tags` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `linked` int(10) unsigned default NULL,
  `name` varchar(20) default NULL,
  `keyname` varchar(20) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `KEYNAME_UNIQUE_INDEX` (`keyname`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `versions`
-- 

CREATE TABLE `versions` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `paste_id` int(11) unsigned NOT NULL default '0',
  `nick` varchar(250) NOT NULL default '',
  `lang` varchar(50) NOT NULL default '',
  `note` text NOT NULL,
  `body` longtext NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `remove` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `paste_id` (`paste_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
