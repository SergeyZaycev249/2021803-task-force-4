CREATE DATABASE taskForce DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;
USE taskForce;
CREATE TABLE categories(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name CHAR(64) NOT NULL
);
CREATE TABLE city (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    latitude DECIMAL NOT NULL,
    longitude DECIMAL NOT NULL
);
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name CHAR(64) NOT NULL,
    password CHAR(64) NOT NULL,
    email VARCHAR(128) NOT NULL UNIQUE,
    role enum('executor', 'customer') NOT NULL,
    date_registration TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    avatar CHAR(255) NOT NULL,
    birthday DATE DEFAULT (CURRENT_DATE),
    phone_number VARCHAR(32),
    telegram VARCHAR(255),
    city_id INT NOT NULL,
    vk VARCHAR(255) UNIQUE,
    FOREIGN KEY (city_id) REFERENCES city (id)
);
CREATE TABLE user_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    category_id INT NOT NULL,
    FOREIGN KEY (category_id) REFERENCES categories (id),
    FOREIGN KEY (user_id) REFERENCES users (id)
);
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(128) NOT NULL,
    description TEXT DEFAULT NULL,
    file VARCHAR(320) DEFAULT NULL,
    lng FLOAT,
    lat FLOAT,
    city_id INT,
    price INT NOT NULL,
    customer_id INT NOT NULL,
    executor_id INT NOT NULL,
    status ENUM (
        'new',
        'cancelled',
        'at work',
        'done',
        'failed'
    ),
    category_id INT NOT NULL,
    deadline TIMESTAMP,
    create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id),
    FOREIGN KEY (executor_id) REFERENCES users (id),
    FOREIGN KEY (customer_id) REFERENCES users (id),
    FOREIGN KEY (city_id) REFERENCES city (id)
);
CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    content TEXT NOT NULL,
    user_id INT NOT NULL,
    grade INT,
    FOREIGN KEY (user_id) REFERENCES users (id),
    task_id INT NOT NULL,
    FOREIGN KEY (task_id) REFERENCES tasks (id)
);
CREATE TABLE responses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    task_id INT NOT NULL,
    executor_id INT NOT NULL,
    content TEXT NOT NULL,
    price INT,
    FOREIGN KEY (task_id) REFERENCES tasks (id),
    FOREIGN KEY (executor_id) REFERENCES users (id)
);