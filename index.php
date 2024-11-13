<?php
// Konfigurasi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pirdas_modul4";

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Memeriksa apakah ada data POST yang diterima
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $angka_sumbu = $_POST['angka_sumbu'];
    $arah = $_POST['arah'];
    $ldr_value = $_POST['ldr_value'];
    $kondisi_cahaya = $_POST['kondisi_cahaya'];
    
    // Menyimpan data ke database
    $sql = "INSERT INTO sensor_data (angka_sumbu, arah, ldr_value, kondisi_cahaya) VALUES ('$angka_sumbu', '$arah', '$ldr_value', '$kondisi_cahaya')";
    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil disimpan";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Query untuk mengambil data dari tabel sensor_data
$sql = "SELECT id_sensor, angka_sumbu, arah, ldr_value, kondisi_cahaya, waktu FROM sensor_data ORDER BY waktu DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Data Sensor MPU6050</title>
</head>
<body class="ml-10 mr-10 mt-10 bg-cyan-600">
    <h1 class="text-3xl font-bold text-center py-5">Data Sensor MPU6050</h1>
    <table class="mx-auto border-4 border-black " border="1">
        <tr class="border-2 ml-10 mr-10 border-black">
            <th class="border-2 px-3 py-3 border-black">ID</th>
            <th class="border-2 px-3 py-3 border-black">Angka Sumbu</th>
            <th class="border-2 px-3 py-3 border-black">Arah</th>
            <th class="border-2 px-3 py-3 border-black">LDR Value</th>
            <th class="border-2 px-3 py-3 border-black">Kondisi Cahaya</th>
            <th class="border-2 px-3 py-3 border-black">Waktu</th>
        </tr>
        <?php
        // Menampilkan data dari database
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr class='border-2 ml-10 mr-10 border-black'>
                        <td class='border-2 px-4 py-3 border-black'>" . $row["id_sensor"] . "</td>
                        <td class='border-2 px-4 py-3 border-black'>" . $row["angka_sumbu"] . "</td>
                        <td class='border-2 px-4 py-3 border-black'>" . $row["arah"] . "</td>
                        <td class='border-2 px-4 py-3 border-black'>" . $row["ldr_value"] . "</td>
                        <td class='border-2 px-4 py-3 border-black'>" . $row["kondisi_cahaya"] . "</td>
                        <td class='border-2 px-4 py-3 border-black'>" . $row["waktu"] . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Tidak ada data</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
// Menutup koneksi
$conn->close();
?>
