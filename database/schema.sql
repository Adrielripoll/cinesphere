USE movies_db;

CREATE TABLE favorites (
    id INT NOT NULL PRIMARY KEY auto_increment,
    movieId VARCHAR(100) NOT NULL, 
    movieTitle VARCHAR(50) NOT NULL, 
    imageUrl VARCHAR(255) NOT NULL, 
    cast VARCHAR(200) NOT NULL, 
    movieRelease DATE NOT NULL 
    watched TINYINT NOT NULL DEFAULT 0;
);
