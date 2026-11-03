<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$country = $_GET['country'] ?? '';
$lookup  = $_GET['lookup'] ?? 'country';
$like    = '%' . $country . '%';

if ($lookup === 'cities') {
    $stmt = $conn->prepare(
        "SELECT c.name, c.district, c.population
         FROM cities c
         JOIN countries cs ON c.country_code = cs.code
         WHERE cs.name LIKE :country"
    );
    $headers = ['Name', 'District', 'Population'];
    $keys    = ['name', 'district', 'population'];
} else {
    $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
    $headers = ['Name', 'Continent', 'Independence', 'Head of State'];
    $keys    = ['name', 'continent', 'independence_year', 'head_of_state'];
}
$stmt->execute([':country' => $like]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<table>
    <thead>
        <tr>
            <?php foreach ($headers as $h): ?>
                <th><?= htmlspecialchars($h) ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $row): ?>
            <tr>
                <?php foreach ($keys as $k): ?>
                    <td><?= htmlspecialchars((string)$row[$k]) ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
