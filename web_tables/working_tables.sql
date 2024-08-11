-- 1
CREATE TABLE admin (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    admin_username VARCHAR(20) UNIQUE,
    admin_password VARCHAR(20),
    admin_authentication_token ENUM('admin', 'rescuer', 'citizen')
);

-- 2
CREATE TABLE rescuer (
    rescuer_id INT AUTO_INCREMENT PRIMARY KEY,
    rescuer_username VARCHAR(20) UNIQUE,
    rescuer_password VARCHAR(20),
    rescuer_authentication_token ENUM('admin', 'rescuer', 'citizen'),
    rescuer_latitude DECIMAL(10, 8), -- Decimal for latitude
    rescuer_longitude DECIMAL(11, 8) -- Decimal for longitude
);

-- 3
CREATE TABLE citizen (
    citizen_id INT AUTO_INCREMENT PRIMARY KEY,
    citizen_username VARCHAR(20) UNIQUE,
    citizen_password VARCHAR(20),
    citizen_authentication_token ENUM('admin', 'rescuer', 'citizen'),
    citizen_name VARCHAR(20),
    citizen_surname VARCHAR(20),
    citizen_phone SMALLINT,
    citizen_latitude DECIMAL(10, 8), -- Decimal for latitude
    citizen_longitude DECIMAL(11, 8) -- Decimal for longitude
);

-- 4
CREATE TABLE category (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(20) UNIQUE
);

-- 5
CREATE TABLE item (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(20),
    item_details VARCHAR(100),
    category_id INT,
    date_added DATETIME,
    amount INT,
    status ENUM('vehicle', 'storage'),
    FOREIGN KEY (category_id) REFERENCES category(category_id)
);
-- +category_name join from category

-- 6
CREATE TABLE storage (
    storage_id INT AUTO_INCREMENT PRIMARY KEY,
    storage_latitude DECIMAL(10, 8), -- Decimal for latitude
    storage_longitude DECIMAL(11, 8), -- Decimal for longitude
    item_id INT,
    FOREIGN KEY (item_id) REFERENCES item(item_id)
);
-- +item_name join from item
-- +item_category join from item

-- 7
CREATE TABLE vehicle (
    vehicle_id INT AUTO_INCREMENT PRIMARY KEY,
    vehicle_latitude DECIMAL(10, 8), -- Decimal for latitude
    vehicle_longitude DECIMAL(11, 8), -- Decimal for longitude
    vehicle_name VARCHAR(20) UNIQUE,
    status ENUM('free', 'occupied'),
    number_of_tasks SMALLINT CHECK (number_of_tasks >= 0 AND number_of_tasks <= 4)
);
--  +request_id join from request
--  +offer_id join from offer

-- 8
CREATE TABLE request (
    request_id INT AUTO_INCREMENT PRIMARY KEY,
    status ENUM('completed', 'pending', 'acquired', 'canceled'),
    request_date DATETIME,
    acquisition_date DATETIME,
    completion_date DATETIME,
    cancelation_date DATETIME,
    citizen_id INT,
    item_id INT,
    requested_item_amount INT,
    starting_date DATETIME,
    vehicle_id INT,
    rescuer_id INT,
    number_of_citizens_involved SMALLINT,
    FOREIGN KEY (citizen_id) REFERENCES citizen(citizen_id),
    FOREIGN KEY (item_id) REFERENCES item(item_id),
    FOREIGN KEY (vehicle_id) REFERENCES vehicle(vehicle_id),
    FOREIGN KEY (rescuer_id) REFERENCES rescuer(rescuer_id)
);
-- citizen_name
-- citizen_surname
-- citizen_phone
-- citizen_position
-- item_name
-- vehicle_name

-- 9
CREATE TABLE offer (
    offer_id INT AUTO_INCREMENT PRIMARY KEY,
    status ENUM('completed', 'pending', 'acquired', 'canceled'),
    request_date DATETIME,
    acquisition_date DATETIME,
    completion_date DATETIME,
    cancelation_date DATETIME,
    request_id INT,
    citizen_id INT,
    item_id INT,
    requested_item_amount INT,
    starting_date DATETIME,
    vehicle_id INT,
    rescuer_id INT,
    FOREIGN KEY (citizen_id) REFERENCES citizen(citizen_id),
    FOREIGN KEY (item_id) REFERENCES item(item_id),
    FOREIGN KEY (vehicle_id) REFERENCES vehicle(vehicle_id),
    FOREIGN KEY (rescuer_id) REFERENCES rescuer(rescuer_id)
);
-- citizen_name
-- citizen_surname
-- citizen_phone
-- citizen_position
-- item_name
-- vehicle_name

-- 10
CREATE TABLE map (
    position_id INT AUTO_INCREMENT PRIMARY KEY,
    position_latitude DECIMAL(10, 8), -- Decimal for latitude
    position_longitude DECIMAL(11, 8), -- Decimal for longitude
    request_id INT,
    offer_id INT,
    vehicle_id INT,
    FOREIGN KEY (request_id) REFERENCES request(request_id),
    FOREIGN KEY (offer_id) REFERENCES offer(offer_id),
    FOREIGN KEY (vehicle_id) REFERENCES vehicle(vehicle_id)
);
-- 11
CREATE TABLE announcement (
    announcement_id INT AUTO_INCREMENT PRIMARY KEY,
    announcement_title VARCHAR(100),
    announcement_date DATETIME,
    item_id INT,
    announcement_item_quantity VARCHAR(20),
    FOREIGN KEY (item_id) REFERENCES item(item_id)
);

-- item_name