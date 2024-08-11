-- μου είχες πει στο call να κάνουομε ξεχωριστό πίνακα για τις συντεταγμένες. αυτό γιατί;;;
CREATE TABLE coordinates (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    latitude DECIMAL(10, 8),
    longitude DECIMAL(11, 8)
);

CREATE TABLE user (
    user_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(20) NOT NULL UNIQUE,
    password VARCHAR(20) NOT NULL,
    authentication_token ENUM('admin', 'rescuer', 'citizen') NOT NULL,
    user_coordinates_id INT NOT NULL, 
    creation_datetime DATETIME DEFAULT CURRENT_TIMESTAMP,
    -- fields only for citizen entries, not mandatory
    citizen_name VARCHAR(20),
    citizen_surname VARCHAR(20),
    citizen_phone SMALLINT,
    FOREIGN KEY (user_coordinates_id) REFERENCES coordinates(id)
);

CREATE TABLE category (
    category_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(20) NOT NULL UNIQUE
);

CREATE TABLE item (
    item_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(20) NOT NULL,
    item_details VARCHAR(100),
    category_id INT NOT NULL,
    date_added DATETIME,
    amount INT NOT NULL,
    status ENUM('vehicle', 'storage'),
    FOREIGN KEY (category_id) REFERENCES category(category_id)
);
-- +category_name join from category

CREATE TABLE storage (
    storage_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    storage_name VARCHAR(20) NOT NULL,
    storage_coordinates_id INT NOT NULL, 
    item_id INT NOT NULL,
    FOREIGN KEY (item_id) REFERENCES item(item_id),
    FOREIGN KEY (storage_coordinates_id) REFERENCES coordinates(id)
);
-- +item_name join from item
-- +item_category join from item

CREATE TABLE vehicle (
    vehicle_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    vehicle_coordinates_id INT NOT NULL,
    vehicle_name VARCHAR(20) NOT NULL UNIQUE,
    status ENUM('free', 'occupied'),
    number_of_tasks SMALLINT CHECK (number_of_tasks >= 0 AND number_of_tasks <= 4),
    FOREIGN KEY (vehicle_coordinates_id) REFERENCES coordinates(id)
);
--  +transaction_id join from transaction

-- merged table from request and offer
CREATE TABLE transaction (
    transaction_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    type ENUM('request', 'offer') NOT NULL,
    status ENUM('completed', 'pending', 'acquired', 'canceled') NOT NULL,
    transaction_date DATETIME,  -- Combines request_date and acquisition_date
    completion_date DATETIME,
    cancelation_date DATETIME,
    user_id INT,
    item_id INT,
    requested_item_amount INT,
    starting_date DATETIME,
    vehicle_id INT,
    rescuer_id INT,
    number_of_citizens_involved SMALLINT, -- Only relevant for requests
    FOREIGN KEY (user_id) REFERENCES user(user_id),
    FOREIGN KEY (item_id) REFERENCES item(item_id),
    FOREIGN KEY (vehicle_id) REFERENCES vehicle(vehicle_id)
);
-- citizen_name
-- citizen_surname
-- citizen_phone
-- citizen_position
-- item_name
-- vehicle_name

-- is this table even needed?
CREATE TABLE map (
    position_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    position_coordinates_id INT NOT NULL,
    transaction_id INT NOT NULL,
    vehicle_id INT NOT NULL,
    FOREIGN KEY (transaction_id) REFERENCES transaction(transaction_id),
    FOREIGN KEY (vehicle_id) REFERENCES vehicle(vehicle_id),
    FOREIGN KEY (position_coordinates_id) REFERENCES coordinates(id)
);

CREATE TABLE announcement (
    announcement_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    announcement_title VARCHAR(100) NOT NULL,
    announcement_date DATETIME,
    item_id INT,
    announcement_item_quantity VARCHAR(20),
    FOREIGN KEY (item_id) REFERENCES item(item_id)
);
-- item_name