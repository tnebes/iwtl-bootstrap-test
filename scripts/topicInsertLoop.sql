use iwtl;

drop procedure if exists topicInsert;
DELIMITER $$

CREATE PROCEDURE topicInsert()
BEGIN
   declare i INT;
   SET i = 100;
   forLoop: LOOP
      IF i < 0 THEN
         LEAVE forLoop;
      END IF;
      insert into `topic` values(null, 'This is a very serious question under 255 chars.', 'This is a very serious description of my problem. my problem.  my problem. my problem.  my problem. my problem.  my problem. my problem.  my problem. my problem.  my problem. my problem.  my problem. my problem.  my problem. my problem. ', now(), 2, null);
      SET i = i - 1;
   END LOOP;
END $$
DELIMITER ;  