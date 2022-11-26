CREATE TABLE `item`
(
  `id`          int(11) NOT NULL,
  `item_name`   varchar(100) NOT NULL,
  `price`       float        NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `item`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `item`
  MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;
