<?php
$pdo = new PDO('sqlite:dev.db');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// 1. Hapus semua data QA/DEBUG/test
$pdo->exec("DELETE FROM Car WHERE brand IN ('QA_TEST', 'DEBUG')");
$pdo->exec("DELETE FROM Booking WHERE userId IN (SELECT id FROM User WHERE email LIKE 'test%' OR email LIKE 'cust%' OR email LIKE 'admin%@cozy.com' OR email LIKE 'debug%')");
$pdo->exec("DELETE FROM User WHERE email LIKE 'test%' OR email LIKE 'cust%@example.com' OR email LIKE 'admin%@cozy.com' OR email LIKE 'debug%'");
echo "Cleaned QA/test data.\n";

// 2. Isi data mobil real
$now = date('Y-m-d H:i:s');

$cars = [
    [
        'brand' => 'Toyota',
        'model' => 'Alphard',
        'category' => 'MPV',
        'seats' => 7,
        'transmission' => 'Automatic',
        'fuel' => 'Hybrid',
        'pricePerDay' => 250,
        'images' => json_encode(['https://upload.wikimedia.org/wikipedia/commons/thumb/8/84/Toyota_Alphard_H40.jpg/1280px-Toyota_Alphard_H40.jpg']),
        'specifications' => json_encode(['engine' => '2.5L Hybrid', 'horsepower' => '197 hp']),
        'features' => json_encode(['Sunroof', 'Leather Seats', 'Navigation', 'Rear Entertainment']),
    ],
    [
        'brand' => 'BMW',
        'model' => 'M5',
        'category' => 'Sport',
        'seats' => 5,
        'transmission' => 'Automatic',
        'fuel' => 'Petrol',
        'pricePerDay' => 450,
        'images' => json_encode(['https://upload.wikimedia.org/wikipedia/commons/thumb/7/71/2018_BMW_M5_F90_automatic%2C_front_8.22.18.jpg/1280px-2018_BMW_M5_F90_automatic%2C_front_8.22.18.jpg']),
        'specifications' => json_encode(['engine' => '4.4L V8 Twin-Turbo', 'horsepower' => '600 hp']),
        'features' => json_encode(['M Sport Package', 'Harman Kardon', 'Head-Up Display', 'Lane Assist']),
    ],
    [
        'brand' => 'Mercedes-Benz',
        'model' => 'E-Class',
        'category' => 'Sedan',
        'seats' => 5,
        'transmission' => 'Automatic',
        'fuel' => 'Petrol',
        'pricePerDay' => 350,
        'images' => json_encode(['https://upload.wikimedia.org/wikipedia/commons/thumb/a/a1/Mercedes-Benz_W213_E_220_d_4MATIC_%28W213%29_%E2%80%93_Frontansicht%2C_17._Juli_2016%2C_D%C3%BCsseldorf.jpg/1280px-Mercedes-Benz_W213_E_220_d_4MATIC_%28W213%29_%E2%80%93_Frontansicht%2C_17._Juli_2016%2C_D%C3%BCsseldorf.jpg']),
        'specifications' => json_encode(['engine' => '2.0L Turbo', 'horsepower' => '255 hp']),
        'features' => json_encode(['Burmester Sound', 'Widescreen Cockpit', 'Massage Seats', 'Ambient Lighting']),
    ],
    [
        'brand' => 'Porsche',
        'model' => 'Cayenne',
        'category' => 'SUV',
        'seats' => 5,
        'transmission' => 'Automatic',
        'fuel' => 'Petrol',
        'pricePerDay' => 500,
        'images' => json_encode(['https://upload.wikimedia.org/wikipedia/commons/thumb/b/b6/2019_Porsche_Cayenne_S_in_White%2C_front_8.28.19.jpg/1280px-2019_Porsche_Cayenne_S_in_White%2C_front_8.28.19.jpg']),
        'specifications' => json_encode(['engine' => '2.9L V6 Twin-Turbo', 'horsepower' => '434 hp']),
        'features' => json_encode(['Sport Chrono', 'Panoramic Roof', 'BOSE Sound', 'Air Suspension']),
    ],
    [
        'brand' => 'Tesla',
        'model' => 'Model 3',
        'category' => 'Electric',
        'seats' => 5,
        'transmission' => 'Automatic',
        'fuel' => 'Electric',
        'pricePerDay' => 280,
        'images' => json_encode(['https://upload.wikimedia.org/wikipedia/commons/thumb/e/ef/Tesla_Model_3_Standard_Range_Plus_facelift%2C_front_8.28.19.jpg/1280px-Tesla_Model_3_Standard_Range_Plus_facelift%2C_front_8.28.19.jpg']),
        'specifications' => json_encode(['motor' => 'Dual Motor AWD', 'range' => '560 km']),
        'features' => json_encode(['Autopilot', '15" Touchscreen', 'Over-the-Air Updates', 'Supercharger']),
    ],
    [
        'brand' => 'Lamborghini',
        'model' => 'Huracán',
        'category' => 'Supercar',
        'seats' => 2,
        'transmission' => 'Automatic',
        'fuel' => 'Petrol',
        'pricePerDay' => 1200,
        'images' => json_encode(['https://upload.wikimedia.org/wikipedia/commons/thumb/4/41/2019_Lamborghini_Huracan_Evo_%28facelift%2C_white%29%2C_front_8.6.19.jpg/1280px-2019_Lamborghini_Huracan_Evo_%28facelift%2C_white%29%2C_front_8.6.19.jpg']),
        'specifications' => json_encode(['engine' => '5.2L V10 NA', 'horsepower' => '630 hp']),
        'features' => json_encode(['Carbon Fiber Body', 'LDVI System', 'Magnetic Suspension', 'Sport Exhaust']),
    ],
    [
        'brand' => 'Range Rover',
        'model' => 'Sport',
        'category' => 'SUV',
        'seats' => 7,
        'transmission' => 'Automatic',
        'fuel' => 'Diesel',
        'pricePerDay' => 420,
        'images' => json_encode(['https://upload.wikimedia.org/wikipedia/commons/thumb/f/fd/Range_Rover_Sport_SVR_%28facelift%2C_black%29%2C_front_8.26.19.jpg/1280px-Range_Rover_Sport_SVR_%28facelift%2C_black%29%2C_front_8.26.19.jpg']),
        'specifications' => json_encode(['engine' => '3.0L TD6 Diesel', 'horsepower' => '349 hp']),
        'features' => json_encode(['Terrain Response 2', 'Meridian Sound', 'Activity Key', 'Pixel LED Lights']),
    ],
    [
        'brand' => 'Toyota',
        'model' => 'Land Cruiser',
        'category' => 'SUV',
        'seats' => 8,
        'transmission' => 'Automatic',
        'fuel' => 'Diesel',
        'pricePerDay' => 320,
        'images' => json_encode(['https://upload.wikimedia.org/wikipedia/commons/thumb/1/11/2022_Toyota_Land_Cruiser_300_in_Sonic_Quartz%2C_front_8.27.22.jpg/1280px-2022_Toyota_Land_Cruiser_300_in_Sonic_Quartz%2C_front_8.27.22.jpg']),
        'specifications' => json_encode(['engine' => '3.3L V6 TwinTurbo Diesel', 'horsepower' => '309 hp']),
        'features' => json_encode(['Kinetic Dynamic Suspension', 'Multi-Terrain Select', 'E-KDSS', '14" Display']),
    ],
];

$stmt = $pdo->prepare("INSERT INTO Car (id, brand, model, category, seats, transmission, fuel, pricePerDay, images, specifications, features, updatedAt) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

foreach ($cars as $car) {
    $id = bin2hex(random_bytes(16));
    $stmt->execute([
        $id, $car['brand'], $car['model'], $car['category'],
        $car['seats'], $car['transmission'], $car['fuel'],
        $car['pricePerDay'], $car['images'], $car['specifications'],
        $car['features'], $now
    ]);
    echo "Added: {$car['brand']} {$car['model']}\n";
}

echo "\nDone! Total cars in DB: " . $pdo->query("SELECT COUNT(*) FROM Car")->fetchColumn() . "\n";
echo "Total users in DB: " . $pdo->query("SELECT COUNT(*) FROM User")->fetchColumn() . "\n";
