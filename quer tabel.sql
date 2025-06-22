create database resto;
use resto;

CREATE TABLE menu_makanan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_menu VARCHAR(100),
    harga INT,
    deskripsi TEXT
);

CREATE TABLE menu_minuman (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_menu VARCHAR(100),
    harga INT,
    deskripsi TEXT
);

CREATE TABLE pelanggan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    no_hp VARCHAR(20),
    alamat TEXT
);

CREATE TABLE pesanan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_pelanggan INT,
    tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_pelanggan) REFERENCES pelanggan(id)
);

CREATE TABLE detail_pesanan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_pesanan INT,
    id_menu INT,
    kategori ENUM('makanan', 'minuman'),
    jumlah INT,
    subtotal INT,
    FOREIGN KEY (id_pesanan) REFERENCES pesanan(id)
);

-- Menu Makanan
INSERT INTO menu_makanan (nama_menu, harga, deskripsi) VALUES 
('Nasi Goreng Seafood', 35000, 'Nasi goreng dengan topping seafood'), 
('Mie Ayam', 15000, 'Mie dengan potongan ayam dan sayur'),
('Fire Chicken Wings', 27000, 'Ayam bagian sayap dengan saus buldak');

-- Menu Minuman
INSERT INTO menu_minuman (nama_menu, harga, deskripsi)
VALUES 
('Es Teh', 8000, 'Teh manis dingin'), 
('Americano', 19000, 'with One shot espresso'),
('Macchiato', 25000, 'two shot espresso with milk');

ALTER TABLE pesanan
ADD metode_pengiriman ENUM('dine in', 'take away', 'delivery') DEFAULT 'dine in';

SELECT * from pesanan;

ALTER TABLE pesanan
ADD status ENUM('Diproses', 'Dikirim', 'Selesai') DEFAULT 'Diproses';

ALTER TABLE pelanggan MODIFY alamat TEXT NULL;


CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(255)
);

INSERT INTO admin (username, password)
VALUES ('agni', MD5('agni09'));

SELECT * FROM detail_pesanan;

use resto;
SELECT * from pesanan;
desc pesanan;
ALTER TABLE pesanan ADD bukti_transfer VARCHAR(255) NULL;


