-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2021-04-27 03:18:09
-- 服务器版本： 5.5.68-MariaDB
-- PHP 版本： 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `vpndata`
--

-- --------------------------------------------------------

--
-- 表的结构 `app_admin`
--

CREATE TABLE `app_admin` (
  `id` int(11) NOT NULL,
  `op` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `app_admin`
--

INSERT INTO `app_admin` (`id`, `op`, `username`, `password`) VALUES
(1, '0', 'kangmladmin', 'kangmlpass');

-- --------------------------------------------------------

--
-- 表的结构 `app_bbs`
--

CREATE TABLE `app_bbs` (
  `id` int(11) NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `time` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `username` text NOT NULL,
  `to` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `app_bbs`
--

INSERT INTO `app_bbs` (`id`, `name`, `content`, `time`, `username`, `to`) VALUES
(1, '', '啦啦啦啦啦啦啦', '1486670176', '18233360137', '0');

-- --------------------------------------------------------

--
-- 表的结构 `app_config`
--

CREATE TABLE `app_config` (
  `id` int(11) NOT NULL,
  `system` text NOT NULL,
  `qq` text NOT NULL,
  `top_content` text NOT NULL,
  `no_limit` text NOT NULL,
  `reg` int(11) NOT NULL,
  `col1` text NOT NULL,
  `col2` text NOT NULL,
  `col3` text NOT NULL,
  `col4` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `app_daili`
--

CREATE TABLE `app_daili` (
  `id` int(11) NOT NULL,
  `qq` text NOT NULL COMMENT 'qq',
  `content` text,
  `type` int(11) DEFAULT '1' COMMENT '代理等级',
  `balance` text NOT NULL COMMENT '（元）',
  `name` text NOT NULL,
  `pass` text NOT NULL,
  `lock` int(11) NOT NULL,
  `endtime` int(11) NOT NULL,
  `time` int(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `app_daili_type`
--

CREATE TABLE `app_daili_type` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `per` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `app_daili_type`
--

INSERT INTO `app_daili_type` (`id`, `name`, `per`) VALUES
(1, 'VIP1', 80),
(2, 'VIP2', 75);

-- --------------------------------------------------------

--
-- 表的结构 `app_data`
--

CREATE TABLE `app_data` (
  `id` int(11) NOT NULL,
  `key` char(255) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `app_feedback`
--

CREATE TABLE `app_feedback` (
  `id` int(11) NOT NULL,
  `line_id` int(11) NOT NULL,
  `content` text COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `app_gg`
--

CREATE TABLE `app_gg` (
  `id` int(11) NOT NULL,
  `daili` int(11) DEFAULT '0',
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `time` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `app_gg`
--

INSERT INTO `app_gg` (`id`, `daili`, `name`, `content`, `time`) VALUES
(1, 0, '欢迎使用康师傅流控', '康师傅流控欢迎您的使用，此公告管理员请自行更改或删除！', '1528041043');

-- --------------------------------------------------------

--
-- 表的结构 `app_kms`
--

CREATE TABLE `app_kms` (
  `id` int(11) NOT NULL,
  `daili` int(11) DEFAULT '0',
  `km` varchar(64) DEFAULT NULL,
  `isuse` tinyint(1) DEFAULT '0',
  `user_id` int(50) DEFAULT NULL,
  `usetime` int(11) DEFAULT NULL,
  `addtime` int(11) DEFAULT NULL,
  `type_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `app_note`
--

CREATE TABLE `app_note` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `ipport` varchar(64) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` text NOT NULL,
  `count` int(11) NOT NULL,
  `order` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `app_note`
--

INSERT INTO `app_note` (`id`, `name`, `ipport`, `time`, `description`, `count`, `order`) VALUES
(1, '默认节点', '服务器IP', '2017-05-03 12:58:32', '不限速/看视频/聊天/刷网页', 140, 1);

-- --------------------------------------------------------

--
-- 表的结构 `app_read`
--

CREATE TABLE `app_read` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `readid` text NOT NULL,
  `time` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `app_tc`
--

CREATE TABLE `app_tc` (
  `id` int(11) NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `time` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `jg` text NOT NULL,
  `limit` text NOT NULL,
  `rate` text NOT NULL COMMENT '（单位M）'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `app_tc`
--

INSERT INTO `app_tc` (`id`, `name`, `content`, `time`, `jg`, `limit`, `rate`) VALUES
(3, '超值套餐', '即刻享受超速流量', '1488272300', '30', '30', '102400');

-- --------------------------------------------------------

--
-- 表的结构 `auth_fwq`
--

CREATE TABLE `auth_fwq` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `ipport` varchar(64) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `auth_fwq`
--

INSERT INTO `auth_fwq` (`id`, `name`, `ipport`, `time`) VALUES
(4, '默认服务器', '服务器IP:1234', '2018-06-03 15:49:55');

-- --------------------------------------------------------

--
-- 表的结构 `dash`
--

CREATE TABLE `dash` (
  `id` int(11) NOT NULL,
  `name` varchar(10) NOT NULL,
  `content` text NOT NULL,
  `modifyTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `dash`
--

INSERT INTO `dash` (`id`, `name`, `content`, `modifyTime`) VALUES
(1, 'ef_user', '[0,0,0,0,0,0,0,0,0,0]', '2021-04-27 03:10:05'),
(2, 'daili', '[0,0,0,0,0,0,0,0,0,0]', '2021-04-27 03:10:11');

-- --------------------------------------------------------

--
-- 表的结构 `line`
--

CREATE TABLE `line` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `content` text NOT NULL,
  `type` text NOT NULL,
  `group` text NOT NULL,
  `show` int(11) NOT NULL,
  `label` text NOT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `time` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `line`
--

INSERT INTO `line` (`id`, `name`, `content`, `type`, `group`, `show`, `label`, `order`, `time`) VALUES
(2, 'UDP 线路 示例', 'client\r\ndev tun\r\nproto udp\r\nremote  [domain] 53\r\nresolv-retry infinite\r\nnobind\r\npersist-key\r\npersist-tun\r\nsetenv IV_GUI_VER &quot;de.blinkt.openvpn 0.6.17&quot;\r\nmachine-readable-output\r\nconnect-retry-max 5\r\nconnect-retry 5\r\nresolv-retry 60\r\nauth-user-pass\r\nns-cert-type server\r\ncomp-lzo\r\nverb 3\r\n\r\n## 证书\r\n&lt;ca&gt;\r\n-----BEGIN PRIVATE KEY-----\r\nMIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQDFKE9O7qhOYeqb\r\nWm++f+prJnxgXboAURy3UE/zAUEg9M3Ec/rpzmMio4RmNxozCIqWeB8/5xLcDy3j\r\ntxbxlmpwOC5I5KKI5qD7PLaJMfkfHIdpiIjakCnnmtiXHdA5fCvKsGJzTp50PslI\r\nY1h5efuQ47xWImhyU5NIIJBNMkG+o2GJ8jLfmrFy54PTvlHP/90AlSGv5Bf2LG0r\r\nzXlpJ4fb43KpjBiFreXpnsq0WBvy94p1j1MADimNVf0jaJWmf57NA8PF0EMc3gFz\r\nwya4gSsTNU4hTErdPNfGRLK4JIqm8MU0oQhNwijYBmI/LD07FjN9JtPeKUDOgrIQ\r\nWD9YJeXHAgMBAAECggEAVINkA8TgFsF4bOHGdtWkagwUUsa6nbonYhkmPFe0UGk/\r\n7098Jk9XRZjsf1htfaTSq4+Qbbci6XwEQtHQHv1IYRRkGtEPLzoVlby/zm3CiWiU\r\nT1O8vlv/6o0A/T5FbO7iYr9bZGw2FkR3yfT0DxaQFNrad93GAgP7ZXa4BK9faVUk\r\n/+frPO9OjCDJ3CkSOJ/8bhSDjAWyerTU347hTs6Mv9l7NNV9hLIO2Wbz+SXaHNFk\r\nD9ZUIN1BXWjh9IIPODw4uigBfK/8jqQjefGi2GlGrTVhjSU38lL6T3b5emmcAlKm\r\n8AbkKJuETKQ6ixZl8x11fQsZBFx8G1+mPzZ2+i/9qQKBgQDrbFuGPE6sqh9ExMW8\r\nE024tPcZJjj8ByTqdzDNRT+fxX0xbLPpJEtWDrbas/89we6EfZvIRv8O9IlXXcmX\r\n38CmGHyfLSz76iEWqbh8MjomR924wqFr78Hw3z9730zNzPPlup+uvCSwZeuR6zBr\r\n0330OGK2TURRwVRJxT1NnisaKwKBgQDWY79FB3B5SOlJ5yZO9AjkpLGCppSWW5EK\r\npxdWlcKH4dqolv0t0gno4YOyEj7ws8Tcu2UFcxIgjz9FgMQlVNf8ZHCVW7Tq+RqF\r\nRjMeawLtvCtMaNuA/Xku2fWdL+BTuF2LyhtDr1fljvWh+oH2zqLbmYIAyxnWVI/6\r\ntzqQLetg1QKBgGVPtTdYPpcpgtlKQLnGKN1C609kVoOG44kPD+5WTaIJD+40FFxR\r\nZSY8oM4PRdki2u0jTOXsP5kE/RGe58E25iXURdUOUNx8Dg89rImt575PkQgQofzc\r\nKb7po90/5EJwX8lN/afpiXRr9+tMpgLQ+dQea8R+DdeM9iPlAJOlbHEPAoGAbISe\r\n630BhJLQazUSogJKghmPNJfHPHhq6V58pLo3dnpvKMkMrGXV2EhWVguASmxkaGp+\r\njwyZD1wS5cZxAoh4r2vTxPZflFS1BOLsuyflmpqVvB6ThS5IaduvxHnYbegzia+q\r\nr08RCcScNvpLULd1nfyM3oPvtxqkqn6WqSZlL2UCgYAV/xUn7XgDOr4gAwLqJjHN\r\nnR+GJQ97/avj9rqI0cj4wsVE2TLz3hQ0WynjVSDU7fPhObYHlfFuQeaHjAWhwiSm\r\ngq6iq1xC++FHtLIiX+u8rFTJ5eG7ey4NgkF00pTd2YlIIETRKwuFCboHhH6k+Ht5\r\nOug1gG4RGZcwY3YzAa3/zQ==\r\n-----END PRIVATE KEY-----\r\n&lt;/ca&gt;\r\nkey-direction 1\r\n&lt;tls-auth&gt;\r\n-----BEGIN OpenVPN Static key V1-----\r\n07a0c4fdc79e45b6d7d69abee82a3dca\r\n7026125b063bb19d79ff443ec144dfcd\r\n6df565ad2449cb928a89f2959e32305e\r\n86cc150c1c6e1d24e25bbdbd716b0b34\r\nce5d92f5c8133812759ca8b10295d624\r\n5e6659dafbbe31fd20971b3287fc3762\r\n555cc9cd10eaf1b2570339295ded9e61\r\ncbce6d29bd8e5c7d4aea86027beb8d3c\r\n323a5dc803ef5d574b8d5c08a981ca8d\r\n3754d34a7d60896b295823cde4bb6ab7\r\n57757ab750b06352b7a218d6814ae433\r\n4a6b1570cb680cd854aad74196cda45b\r\nb69acb97de87f1ec6cc01a2034bd7e8c\r\n3e0ffea1cccf722716bcf387e56baf04\r\n369dde778a5544ada640c15c65ec5389\r\n2ba0834a78302fab9b214bfc3dddd80e\r\n-----END OpenVPN Static key V1-----\r\n&lt;/tls-auth&gt;\r\n', '更新时间：2021.05.01', '1', 1, '全国必免', 0, '1486721267'),
(3, 'TCP 线路 示例', 'client\r\ndev tun\r\nproto tcp\r\nremote [domain] 80\r\nhttp-proxy [domain] 8080\r\nresolv-retry infinite\r\nnobind\r\npersist-key\r\npersist-tun\r\nsetenv IV_GUI_VER &quot;de.blinkt.openvpn 0.6.17&quot;\r\nmachine-readable-output\r\nconnect-retry-max 5\r\nconnect-retry 5\r\nresolv-retry 60\r\nauth-user-pass\r\nns-cert-type server\r\ncomp-lzo\r\nverb 3\r\n\r\n## 证书\r\n&lt;ca&gt;\r\n[证书]\r\n&lt;/ca&gt;\r\nkey-direction 1\r\n&lt;tls-auth&gt;\r\n[证书]\r\n&lt;/tls-auth&gt;', '更新时间：2021.05.01', '1', 1, '全国必免', 0, '1486721267');

-- --------------------------------------------------------

--
-- 表的结构 `line_grop`
--

CREATE TABLE `line_grop` (
  `id` int(11) NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `show` int(11) NOT NULL,
  `order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `line_grop`
--

INSERT INTO `line_grop` (`id`, `name`, `show`, `order`) VALUES
(1, '中国移动', 1, 1),
(2, '中国电信', 1, 1),
(3, '中国联通', 1, 1),
(4, '电信停机保号', 1, 1),
(5, '校园WIFI', 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `map`
--

CREATE TABLE `map` (
  `id` int(11) NOT NULL,
  `key` text NOT NULL,
  `value` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `type` text CHARACTER SET utf8 COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `map`
--

INSERT INTO `map` (`id`, `key`, `value`, `type`) VALUES
(1, 'versionCode', '100', 'cfg_sj'),
(2, 'url', 'http://abc.com/a.apk', 'cfg_sj'),
(3, 'content', '测试', 'cfg_sj'),
(4, 'opens', 'success', 'cfg_sj'),
(5, 'spic', '', 'cfg_sj'),
(6, 'reg_type', 'default', 'cfg_app'),
(7, 'content', '欢迎使用康师傅流控', 'cfg_app'),
(8, 'max_limit', '100', 'cfg_app'),
(9, 'SMS_T', '0', 'cfg_app'),
(10, 'SMS_L', '0', 'cfg_app'),
(11, 'SMS_I', '0', 'cfg_app'),
(12, 'Auth_Token', 'cee182005162750e23855d63ed92188d', 'cfg_app'),
(13, 'Account_Sid', '3b7004e5f782a6e4f1f195bc52990b', 'cfg_app'),
(14, 'APP_ID', 'fff126cf55e545439dfd1c16aa63d95a', 'cfg_app'),
(15, 'Template_ID', '29317', 'cfg_app'),
(16, 'APP_NAME', '康师傅云', 'cfg_app'),
(17, 'ca', '&lt;ca&gt;\r\n-----BEGIN CERTIFICATE-----\r\nMIIE7jCCA9agAwIBAgIJAJLzuFmEowyMMA0GCSqGSIb3DQEBCwUAMIGqMQswCQYD\r\nVQQGEwJDTjELMAkGA1UECBMCQ0ExFTATBgNVBAcTDFNhbkZyYW5jaXNjbzEVMBMG\r\nA1UEChMMRm9ydC1GdW5zdG9uMRUwEwYDVQQLEwx3d3cuZGluZ2QuY24xGDAWBgNV\r\nBAMTD0ZvcnQtRnVuc3RvbiBDQTEQMA4GA1UEKRMHRWFzeVJTQTEdMBsGCSqGSIb3\r\nDQEJARYOYWRtaW5AZGluZ2QuY24wHhcNMTcwMjIxMDMzNzE4WhcNMjcwMjE5MDMz\r\nNzE4WjCBqjELMAkGA1UEBhMCQ04xCzAJBgNVBAgTAkNBMRUwEwYDVQQHEwxTYW5G\r\ncmFuY2lzY28xFTATBgNVBAoTDEZvcnQtRnVuc3RvbjEVMBMGA1UECxMMd3d3LmRp\r\nbmdkLmNuMRgwFgYDVQQDEw9Gb3J0LUZ1bnN0b24gQ0ExEDAOBgNVBCkTB0Vhc3lS\r\nU0ExHTAbBgkqhkiG9w0BCQEWDmFkbWluQGRpbmdkLmNuMIIBIjANBgkqhkiG9w0B\r\nAQEFAAOCAQ8AMIIBCgKCAQEAxShPTu6oTmHqm1pvvn/qayZ8YF26AFEct1BP8wFB\r\nIPTNxHP66c5jIqOEZjcaMwiKlngfP+cS3A8t47cW8ZZqcDguSOSiiOag+zy2iTH5\r\nHxyHaYiI2pAp55rYlx3QOXwryrBic06edD7JSGNYeXn7kOO8ViJoclOTSCCQTTJB\r\nvqNhifIy35qxcueD075Rz//dAJUhr+QX9ixtK815aSeH2+NyqYwYha3l6Z7KtFgb\r\n8veKdY9TAA4pjVX9I2iVpn+ezQPDxdBDHN4Bc8MmuIErEzVOIUxK3TzXxkSyuCSK\r\npvDFNKEITcIo2AZiPyw9OxYzfSbT3ilAzoKyEFg/WCXlxwIDAQABo4IBEzCCAQ8w\r\nHQYDVR0OBBYEFCBcOM8ljbd8B+J6Xjwj13iK7fBxMIHfBgNVHSMEgdcwgdSAFCBc\r\nOM8ljbd8B+J6Xjwj13iK7fBxoYGwpIGtMIGqMQswCQYDVQQGEwJDTjELMAkGA1UE\r\nCBMCQ0ExFTATBgNVBAcTDFNhbkZyYW5jaXNjbzEVMBMGA1UEChMMRm9ydC1GdW5z\r\ndG9uMRUwEwYDVQQLEwx3d3cuZGluZ2QuY24xGDAWBgNVBAMTD0ZvcnQtRnVuc3Rv\r\nbiBDQTEQMA4GA1UEKRMHRWFzeVJTQTEdMBsGCSqGSIb3DQEJARYOYWRtaW5AZGlu\r\nZ2QuY26CCQCS87hZhKMMjDAMBgNVHRMEBTADAQH/MA0GCSqGSIb3DQEBCwUAA4IB\r\nAQBwZvIQU4d7XD1dySjCHej+i5QhK1y2BTrmYSemLnMQp9PT/wQ7bwzZjoO9jTeJ\r\nx2sMfhp0EVQCZvBFGqArNu1Ysh00mMQfWWb8K3LWbmThEkNpwoGniHBgDkPJOITM\r\nrA2HSIh53mkQt5u9H4/vmVWElhGakgEzgfNrzxj6goX5klXxRL/JqAjAJhjS06sS\r\nJPNVSZv0tdE+XaO02sPjK7/KWbwAGf4mO2v71Q+oYJdoRmAcge+gbBMg2s6rPCfv\r\nBp2g84FhG04f5KyJIVzzQ+0sCx94XE7P5HN/zjO+3QPDd7dxGZ6ia1Z5nnSRSJVa\r\nyBNWh3h8PAaAQQi7qkuJB+iF\r\n-----END CERTIFICATE-----\r\n&lt;/ca&gt;', 'cfg_zs'),
(18, 'tls', '&lt;tls-auth&gt;\r\n-----BEGIN OpenVPN Static key V1-----\r\n07a0c4fdc79e45b6d7d69abee82a3dca\r\n7026125b063bb19d79ff443ec144dfcd\r\n6df565ad2449cb928a89f2959e32305e\r\n86cc150c1c6e1d24e25bbdbd716b0b34\r\nce5d92f5c8133812759ca8b10295d624\r\n5e6659dafbbe31fd20971b3287fc3762\r\n555cc9cd10eaf1b2570339295ded9e61\r\ncbce6d29bd8e5c7d4aea86027beb8d3c\r\n323a5dc803ef5d574b8d5c08a981ca8d\r\n3754d34a7d60896b295823cde4bb6ab7\r\n57757ab750b06352b7a218d6814ae433\r\n4a6b1570cb680cd854aad74196cda45b\r\nb69acb97de87f1ec6cc01a2034bd7e8c\r\n3e0ffea1cccf722716bcf387e56baf04\r\n369dde778a5544ada640c15c65ec5389\r\n2ba0834a78302fab9b214bfc3dddd80e\r\n-----END OpenVPN Static key V1-----\r\n&lt;/tls-auth&gt;', 'cfg_zs'),
(19, 'onoff', '1', 'cfg_zs'),
(20, 'domain', '服务器IP', 'cfg_zs'),
(21, 'LINE', 'abs', 'cfg_app'),
(22, 'noteoff', '1', 'cfg_app'),
(23, 'connect_unlock', '1', 'cfg_app');

-- --------------------------------------------------------

--
-- 表的结构 `openvpn`
--

CREATE TABLE `openvpn` (
  `id` int(11) NOT NULL,
  `iuser` varchar(16) NOT NULL,
  `isent` bigint(128) DEFAULT '0',
  `irecv` bigint(128) DEFAULT '0',
  `maxll` bigint(128) NOT NULL,
  `pass` varchar(18) NOT NULL,
  `i` int(1) NOT NULL,
  `starttime` varchar(10) DEFAULT NULL,
  `endtime` int(11) DEFAULT '0',
  `daili` int(11) DEFAULT '0',
  `online` int(11) DEFAULT '0',
  `old` int(11) DEFAULT '0',
  `last_ip` text,
  `proto` text,
  `login_time` int(11) NOT NULL DEFAULT '0',
  `remote_port` int(11) DEFAULT NULL,
  `note_id` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `pay_order`
--

CREATE TABLE `pay_order` (
  `id` int(11) NOT NULL,
  `trade_no` varchar(20) NOT NULL COMMENT '订单编号',
  `tid` int(11) NOT NULL COMMENT '商品编号',
  `name` varchar(20) NOT NULL COMMENT '账户名称',
  `money` text NOT NULL COMMENT '金额',
  `addtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '订单时间',
  `status` tinyint(2) NOT NULL COMMENT '订单状态',
  `type` text NOT NULL COMMENT '发起端'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `top`
--

CREATE TABLE `top` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `data` bigint(20) NOT NULL,
  `time` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转储表的索引
--

--
-- 表的索引 `app_admin`
--
ALTER TABLE `app_admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- 表的索引 `app_bbs`
--
ALTER TABLE `app_bbs`
  ADD KEY `id` (`id`);

--
-- 表的索引 `app_config`
--
ALTER TABLE `app_config`
  ADD KEY `id` (`id`);

--
-- 表的索引 `app_daili`
--
ALTER TABLE `app_daili`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- 表的索引 `app_daili_type`
--
ALTER TABLE `app_daili_type`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `app_data`
--
ALTER TABLE `app_data`
  ADD UNIQUE KEY `key` (`key`),
  ADD KEY `id` (`id`);

--
-- 表的索引 `app_feedback`
--
ALTER TABLE `app_feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- 表的索引 `app_gg`
--
ALTER TABLE `app_gg`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_2` (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `id_3` (`id`);

--
-- 表的索引 `app_kms`
--
ALTER TABLE `app_kms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `km` (`km`),
  ADD KEY `type_id` (`type_id`);

--
-- 表的索引 `app_note`
--
ALTER TABLE `app_note`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- 表的索引 `app_read`
--
ALTER TABLE `app_read`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- 表的索引 `app_tc`
--
ALTER TABLE `app_tc`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_2` (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `id_3` (`id`);

--
-- 表的索引 `auth_fwq`
--
ALTER TABLE `auth_fwq`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `dash`
--
ALTER TABLE `dash`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `line`
--
ALTER TABLE `line`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- 表的索引 `line_grop`
--
ALTER TABLE `line_grop`
  ADD UNIQUE KEY `id_2` (`id`),
  ADD KEY `id` (`id`);

--
-- 表的索引 `map`
--
ALTER TABLE `map`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `openvpn`
--
ALTER TABLE `openvpn`
  ADD PRIMARY KEY (`id`),
  ADD KEY `iuser` (`iuser`);

--
-- 表的索引 `pay_order`
--
ALTER TABLE `pay_order`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `top`
--
ALTER TABLE `top`
  ADD UNIQUE KEY `id_2` (`id`),
  ADD KEY `id` (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `app_bbs`
--
ALTER TABLE `app_bbs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `app_config`
--
ALTER TABLE `app_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `app_daili`
--
ALTER TABLE `app_daili`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `app_daili_type`
--
ALTER TABLE `app_daili_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `app_data`
--
ALTER TABLE `app_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `app_feedback`
--
ALTER TABLE `app_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `app_gg`
--
ALTER TABLE `app_gg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `app_kms`
--
ALTER TABLE `app_kms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `app_note`
--
ALTER TABLE `app_note`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `app_read`
--
ALTER TABLE `app_read`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `app_tc`
--
ALTER TABLE `app_tc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `auth_fwq`
--
ALTER TABLE `auth_fwq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `dash`
--
ALTER TABLE `dash`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `line`
--
ALTER TABLE `line`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `line_grop`
--
ALTER TABLE `line_grop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `map`
--
ALTER TABLE `map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- 使用表AUTO_INCREMENT `openvpn`
--
ALTER TABLE `openvpn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `pay_order`
--
ALTER TABLE `pay_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `top`
--
ALTER TABLE `top`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
