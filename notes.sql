
show databases;
use curso_banco_de_dados;
show tables;

CREATE TABLE `posts` (`id` INT NOT NULL AUTO_INCREMENT, `titulo` VARCHAR(255) NOT NULL,`conteudo` TEXT NOT NULL, autor_id INT NOT NULL, PRIMARY KEY(`id`));
CREATE TABLE `autores` (`id` INT NOT NULL AUTO_INCREMENT, `nome` VARCHAR(255) NOT NULL,`conteudo` TEXT NOT NULL, PRIMARY KEY(`id`));

INSERT INTO `posts` VALUES (null, "First Post", "Content First Post",0);

SELECT * FROM `posts`;

show columns FROM `autores`;

INSERT INTO `autores` VALUES (null, "First Author");

SELECT * FROM `autores`;

UPDATE `autores` SET nome = 'LoremIpsum' WHERE id=1;

INSERT INTO `autores` VALUES (null, "Example Author");

DELETE FROM autores WHERE nome="Example Author" AND id = 2;

-- Order By
SELECT * FROM posts ORDER BY id DESC;
SELECT * FROM posts ORDER BY titulo ASC; 
SELECT * FROM posts ORDER BY titulo DESC;

-- Group By
SELECT * FROM posts GROUP BY autor_id;

-- Order and Group By
SELECT * FROM posts GROUP BY autor_id ORDER BY id desc;

SELECT * FROM posts where titulo = 'First Post' GROUP BY autor_id ORDER BY id desc;

-- Limit
SELECT * FROM posts ORDER BY id desc limit 5;

SELECT * FROM posts limit 2,3;

-- And
SELECT * FROM posts WHERE autor_id = 2 and id > 6;
-- OR
SELECT * FROM posts WHERE autor_id = 1 or id >= 1;

SELECT * FROM posts WHERE (autor_id = 2 or autor_id=0) AND titulo 'First Post';

-- Like
SELECT * FROM posts WHERE conteudo like '%First%';

-- Dominando Joins
SELECT * FROM posts INNER JOIN autores ON posts.autor_id = autores.id;

SELECT * FROM posts INNER JOIN autores ON posts.autor_id = autores.id WHERE posts.id = 10;

-- Left 
SELECT * FROM posts LEFT JOIN autores ON posts.autor_id = autores.id;

SELECT * FROM posts LEFT JOIN autores ON posts.autor_id = autores.id ORDER BY posts.id DESC;

-- RIGHT

SELECT * FROM posts RIGHT JOIN autores ON posts.autor_id = autores.id;


