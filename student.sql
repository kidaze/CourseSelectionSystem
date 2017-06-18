-- phpMyAdmin SQL Dump
-- version 3.3.7
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017 年 06 月 18 日 17:18
-- 服务器版本: 5.0.90
-- PHP 版本: 5.2.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `courseselection`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `adminid` int(50) NOT NULL,
  `adminpassword` int(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`adminid`, `adminpassword`) VALUES
(123456, 123456);

-- --------------------------------------------------------

--
-- 表的结构 `collegeid`
--

CREATE TABLE IF NOT EXISTS `collegeid` (
  `collegeid` int(50) NOT NULL,
  `collegename` varchar(50) character set utf8 collate utf8_bin NOT NULL,
  `whichcampus` varchar(50) character set utf8 collate utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `collegeid`
--

INSERT INTO `collegeid` (`collegeid`, `collegename`, `whichcampus`) VALUES
(1, '计算机学院', '厦门');

-- --------------------------------------------------------

--
-- 表的结构 `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `courseid` int(50) NOT NULL auto_increment,
  `coursename` varchar(50) character set utf8 collate utf8_bin NOT NULL,
  `teaid` int(50) NOT NULL,
  `selected` int(50) NOT NULL,
  `total` int(50) NOT NULL,
  `classtime` varchar(50) character set utf8 collate utf8_bin NOT NULL,
  `classroom` varchar(50) character set utf8 collate utf8_bin NOT NULL,
  `credit` int(50) NOT NULL,
  `shangketime` int(50) NOT NULL,
  `shiyantime` int(50) NOT NULL,
  PRIMARY KEY  (`courseid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `course`
--

INSERT INTO `course` (`courseid`, `coursename`, `teaid`, `selected`, `total`, `classtime`, `classroom`, `credit`, `shangketime`, `shiyantime`) VALUES
(6, 'phpä»Žå…¥é—¨åˆ°ç²¾é€š', 10009, 0, 100, 'æ˜ŸæœŸäºŒ', 'd4-102', 3, 50, 10),
(5, 'c++ ä»Žå…¥é—¨åˆ°æ”¾å¼ƒ', 10009, 0, 100, 'æ˜ŸæœŸä¸€', 'd4-101', 3, 50, 10),
(7, 'æ•°æ®ç»“æž„', 10010, 0, 100, 'æ˜ŸæœŸä¸‰', 'd4-103', 4, 50, 10);

-- --------------------------------------------------------

--
-- 表的结构 `stucourse`
--

CREATE TABLE IF NOT EXISTS `stucourse` (
  `stuid` int(50) NOT NULL,
  `stuname` varchar(50) character set utf8 collate utf8_bin NOT NULL,
  `institute` varchar(50) character set utf8 collate utf8_bin NOT NULL,
  `major` varchar(50) character set utf8 collate utf8_bin NOT NULL,
  `class` varchar(50) character set utf8 collate utf8_bin NOT NULL,
  `teaid` int(50) NOT NULL,
  `courseid` int(11) NOT NULL,
  `classtime` varchar(50) character set utf8 collate utf8_bin NOT NULL,
  PRIMARY KEY  (`stuid`,`courseid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `stucourse`
--

INSERT INTO `stucourse` (`stuid`, `stuname`, `institute`, `major`, `class`, `teaid`, `courseid`, `classtime`) VALUES
(10, 'ç†Šå¤§', '2', 'ç½‘ç»œå·¥ç¨‹', '1ç­', 10009, 6, 'æ˜ŸæœŸäºŒ'),
(11, 'ç†ŠäºŒ', '1', 'ç½‘ç»œå·¥ç¨‹', '1ç­', 10010, 7, 'æ˜ŸæœŸä¸‰');

-- --------------------------------------------------------

--
-- 表的结构 `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `stuid` int(50) NOT NULL auto_increment,
  `stuname` varchar(50) collate utf8_bin NOT NULL,
  `collogeid` int(50) NOT NULL,
  `major` varchar(50) collate utf8_bin NOT NULL,
  `sex` varchar(50) collate utf8_bin NOT NULL,
  `class` varchar(50) collate utf8_bin NOT NULL,
  `stupassword` int(50) NOT NULL,
  PRIMARY KEY  (`stuid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `student`
--

INSERT INTO `student` (`stuid`, `stuname`, `collogeid`, `major`, `sex`, `class`, `stupassword`) VALUES
(10, 'ç†Šå¤§', 2, 'ç½‘ç»œå·¥ç¨‹', 'å¥³', '1ç­', 123456),
(11, 'ç†ŠäºŒ', 1, 'ç½‘ç»œå·¥ç¨‹', 'å¥³', '1ç­', 123456);

-- --------------------------------------------------------

--
-- 表的结构 `teacher`
--

CREATE TABLE IF NOT EXISTS `teacher` (
  `teaid` int(50) NOT NULL auto_increment,
  `teaname` varchar(50) collate utf8_bin NOT NULL,
  `sex` varchar(50) collate utf8_bin NOT NULL,
  `collegename` varchar(50) collate utf8_bin NOT NULL,
  `introduction` varchar(50) collate utf8_bin NOT NULL,
  `teapassword` int(50) NOT NULL,
  PRIMARY KEY  (`teaid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=10011 ;

--
-- 转存表中的数据 `teacher`
--

INSERT INTO `teacher` (`teaid`, `teaname`, `sex`, `collegename`, `introduction`, `teapassword`) VALUES
(10010, 'æ¢è€å¸ˆ', 'å¥³', 'è®¡ç®—æœºå­¦é™¢', '', 123456),
(10009, 'ç†Šè€å¸ˆ', 'å¥³', 'è®¡ç®—æœºå­¦é™¢', 'å¥½è€å¸ˆ', 123456);
