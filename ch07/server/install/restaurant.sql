set names utf8;
--
-- Database: `restaurant`
--

-- --------------------------------------------------------

--
-- 表的结构 `category`
--
DROP TABLE `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL,
  `label` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `updated_at` int(10) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='Table types';

--
-- 转存表中的数据 `category`
--

INSERT INTO `category` (`id`, `label`, `description`, `updated_at`) VALUES
(1, 'A', '1-2人', 1483248040),
(2, 'B', '3-4人', 1483259332),
(3, 'C', '5-10人', 1483248550),
(4, 'D', '10人以上', 1483248590);

-- --------------------------------------------------------

--
-- 表的结构 `menu`
--
DROP TABLE `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `price` float NOT NULL,
  `description` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `updated_at` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `menu`
--

INSERT INTO `menu` (`id`, `name`, `image`, `price`, `description`, `status`, `updated_at`) VALUES
(1, '泰国炒面', 'http://localhost/restaurant/Public/attachments/2017-01-01/58690f1236d2c.jpg', 10, '经典泰式小吃', 1, 1486293789),
(2, '寿司', 'http://localhost/restaurant/Public/attachments/2017-01-01/5869108daaf1a.jpg', 15, '日本寿司', 1, 1486292818),
(3, '烤虾', 'http://localhost/restaurant/Public/attachments/2017-01-01/5869118ee6e0d.jpg', 38, '青岛大虾', 1, 1486292831),
(4, '鲜虾番茄意面', 'http://localhost/restaurant/Public/attachments/2017-01-01/586911fb0999a.jpg', 20, '鲜虾番茄意面', 1, 1486295025),
(5, '西兰花炒牛肉', 'http://localhost/restaurant/Public/attachments/2017-01-01/586912780258c.jpg', 35, '西兰花炒牛肉', 1, 1486292789),
(6, '披萨', 'http://localhost/restaurant/Public/attachments/2017-01-01/586912f268b10.jpg', 30, '披萨', 1, 1486292796),
(7, '空心粉', 'http://localhost/restaurant/Public/attachments/2017-01-01/58691372316dd.jpg', 12, '空心粉', 1, 1486292802);

-- --------------------------------------------------------

--
-- 表的结构 `queue`
--
DROP TABLE `queue`;
CREATE TABLE IF NOT EXISTS `queue` (
  `id` int(11) NOT NULL,
  `guest_id` char(28) NOT NULL,
  `nickname` varchar(100) NOT NULL,
  `number` int(10) NOT NULL,
  `table_id` int(10) NOT NULL,
  `category_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `updated_at` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `queue`
--

INSERT INTO `queue` (`id`, `guest_id`, `nickname`, `number`, `table_id`, `category_id`, `status`, `updated_at`) VALUES
(18, 'oU9sY0fnMXahWIfy_w2K2pRj61xk', 'david', 1, 0, 1, 2, 1485005301),
(19, 'oU9sY0fnMXahWIfy_w2K2pRj6yxk', 'david', 1, 0, 2, 2, 1485006051),
(20, 'oU9sY0fnMXahWIfy_w2K2pR86y0k', 'david', 2, 0, 2, 2, 1485006496),
(21, 'oU9sY0fnMXahWIfy_w2K2pRj6yxk', 'david', 3, 0, 2, 1, 1486287922),
(22, 'oU9sY0fnMXahWIfy_w2K2pRj7yxk', 'david', 2, 0, 1, 1, 1486295135),
(23, 'oU9sY0fnMXahWIfy_w2K2pRj6yxk', 'david', 3, 0, 1, 0, 1486298191);

-- --------------------------------------------------------

--
-- 表的结构 `tables`
--
DROP TABLE `tables`;
CREATE TABLE IF NOT EXISTS `tables` (
  `id` int(11) NOT NULL,
  `inner_number` varchar(100) NOT NULL,
  `category_id` int(10) NOT NULL,
  `updated_at` int(10) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tables`
--

INSERT INTO `tables` (`id`, `inner_number`, `category_id`, `updated_at`, `status`) VALUES
(1, '001', 1, 1483250374, 0),
(2, '002', 1, 1483259116, 0),
(3, '003', 1, 1483259124, 0),
(4, '004', 1, 1483259128, 0),
(5, '005', 2, 1483259136, 0),
(6, '006', 2, 1483259144, 0),
(7, '007', 2, 1483259160, 0),
(8, '008', 2, 1483259253, 1),
(9, '009', 3, 1483259265, 0),
(10, '010', 3, 1483259275, 0),
(11, '011', 3, 1483259285, 0),
(12, '012', 4, 1483259292, 0);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--
DROP TABLE `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) NOT NULL,
  `session_key` char(24) NOT NULL,
  `openid` char(28) NOT NULL,
  `expires_in` int(10) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `session_key`, `openid`, `expires_in`, `created_at`) VALUES
(1, 'DHjiK5DaAPr0LO4Q++KQUw==', 'oU9sY0fnMXahWIfy_w2K2pRj6yxk', 2592000, 1486297638);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `queue`
--
ALTER TABLE `queue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT for table `queue`
--
ALTER TABLE `queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;