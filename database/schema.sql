CREATE TABLE users (
  id INT AUTO_INCREMENT,
  username VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM('guest', 'user', 'admin') NOT NULL DEFAULT 'guest',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY (email)
);

CREATE TABLE patients (
  id INT AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  phone VARCHAR(20),
  address VARCHAR(255),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
);

CREATE TABLE doctors (
  id INT AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  phone VARCHAR(20),
  address VARCHAR(255),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
);

CREATE TABLE medications (
  id INT AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  quantity INT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
);

CREATE TABLE user_permissions (
  id INT AUTO_INCREMENT,
  user_id INT NOT NULL,
  page VARCHAR(255) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES users(id),
  UNIQUE KEY (user_id, page)
);

CREATE TABLE patient_list (
  id INT AUTO_INCREMENT,
  patient_id INT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  FOREIGN KEY (patient_id) REFERENCES patients(id)
);

CREATE TABLE doctor_list (
  id INT AUTO_INCREMENT,
  doctor_id INT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  FOREIGN KEY (doctor_id) REFERENCES doctors(id)
);

CREATE TABLE medication_list (
  id INT AUTO_INCREMENT,
  medication_id INT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  FOREIGN KEY (medication_id) REFERENCES medications(id)
);

INSERT INTO users (username, email, password, role)
VALUES ('admin', 'admin@example.com', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', 'admin');

INSERT INTO patients (name, phone, address)
VALUES ('Patient 1', '1234567890', 'Address 1'),
       ('Patient 2', '0987654321', 'Address 2');

INSERT INTO doctors (name, phone, address)
VALUES ('Doctor 1', '1234567890', 'Address 1'),
       ('Doctor 2', '0987654321', 'Address 2');

INSERT INTO medications (name, quantity)
VALUES ('Medication 1', 100),
       ('Medication 2', 200);

INSERT INTO user_permissions (user_id, page)
VALUES (1, 'الصفحة الرئيسية'),
       (1, 'قائمة المرضى'),
       (1, 'قائمة الفريق الطبي'),
       (1, 'قائمة مخزون الأدوية');

INSERT INTO patient_list (patient_id)
VALUES (1),
       (2);

INSERT INTO doctor_list (doctor_id)
VALUES (1),
       (2);

INSERT INTO medication_list (medication_id)
VALUES (1),
       (2);