use iwtl;
drop procedure if exists userInsert;
DELIMITER $$ CREATE PROCEDURE userInsert() BEGIN
declare i INT;
SET i = 100;
forLoop: LOOP IF i < 0 THEN LEAVE forLoop;
END IF;
insert into `user`
values(null, i, i, i, now(), 0, null, 0, null);
SET i = i -1;
END LOOP;
END $$ DELIMITER;