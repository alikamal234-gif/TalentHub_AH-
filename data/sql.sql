CREATE TABLE roles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  created_at DATE,
  deleted_at DATE
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  role_id INT NOT NULL,
  name VARCHAR(255) NOT NULL,
  speciality VARCHAR(255),
  email VARCHAR(255) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  phone VARCHAR(50),
  image LONGBLOB,
  created_at DATE,
  deleted_at DATE,
  FOREIGN KEY (role_id) REFERENCES roles(id)
);

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  created_at DATE,
  deleted_at DATE
);

CREATE TABLE offers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT NOT NULL,
  owner_id INT NOT NULL,
  name VARCHAR(255) NOT NULL,
  description TEXT,
  salary FLOAT,
  city VARCHAR(255),
  contact VARCHAR(255),
  company VARCHAR(255),
  created_at DATE,
  deleted_at DATE,
  FOREIGN KEY (category_id) REFERENCES categories(id),
  FOREIGN KEY (owner_id) REFERENCES users(id)
);

CREATE TABLE tags (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  created_at DATE,
  deleted_at DATE
);

CREATE TABLE candidatures (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  offer_id INT NOT NULL,
  message TEXT,
  cv LONGBLOB,
  status ENUM('pending','accepted','rejected') DEFAULT 'pending',
  created_at DATE,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (offer_id) REFERENCES offers(id)
);

CREATE TABLE offer_tag (
  offer_id INT NOT NULL,
  tag_id INT NOT NULL,
  PRIMARY KEY (offer_id, tag_id),
  FOREIGN KEY (offer_id) REFERENCES offers(id),
  FOREIGN KEY (tag_id) REFERENCES tags(id)
);

CREATE TABLE user_tag (
  user_id INT NOT NULL,
  tag_id INT NOT NULL,
  PRIMARY KEY (user_id, tag_id),
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (tag_id) REFERENCES tags(id)
);
