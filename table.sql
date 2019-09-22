CREATE TABLE `employees` (
  `id` smallint(6) NOT NULL,
  `first_name` char(20) NOT NULL,
  `last_name` char(20) NOT NULL,
  `sex` enum('male','female') NOT NULL,
  `age` tinyint(3) NOT NULL,
  `CREATED_AT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `employees`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT;COMMIT;