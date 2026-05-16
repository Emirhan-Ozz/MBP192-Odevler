<?php

require "db.php";

$sql = "SELECT * FROM ogrenciler";
$sonuc = $conn->query($sql);

function harfNotuBul($not) {
    if ($not >= 90) {
        return ["AA", 4.00, "Başarılı"];
    } elseif ($not >= 85) {
        return ["BA", 3.50, "Başarılı"];
    } elseif ($not >= 80) {
        return ["BB", 3.00, "Başarılı"];
    } elseif ($not >= 75) {
        return ["CB", 2.50, "Başarılı"];
    } elseif ($not >= 70) {
        return ["CC", 2.00, "Başarılı"];
    } elseif ($not >= 60) {
        return ["DC", 1.50, "Geçer"];
    } elseif ($not >= 50) {
        return ["DD", 1.00, "Geçer"];
    } else {
        return ["FF", 0.00, "Kaldı"];
    }
}

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>PHP & MySQL Not Hesaplama</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0,0,0,0.15);
        }

        h2 {
            text-align: center;
            color: #2c3e50;
        }

        .aciklama {
            text-align: center;
            color: #666;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #2c3e50;
            color: white;
            padding: 12px;
        }

        td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        .basarili {
            background-color: #d4edda;
            color: #155724;
        }

        .kaldi {
            background-color: #f8d7da;
            color: #721c24;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            color: white;
            font-weight: bold;
        }

        .badge-basarili {
            background-color: #28a745;
        }

        .badge-kaldi {
            background-color: #dc3545;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 13px;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>PHP & MySQL Not Hesaplama Uygulaması</h2>

    <div class="aciklama">
        Öğrenci notları MySQL veritabanından okunarak dönem sonu notu hesaplanmıştır.
    </div>

    <table>
        <tr>
            <th>Okul No</th>
            <th>Ad Soyad</th>
            <th>Ders Adı</th>
            <th>Vize</th>
            <th>Ödev</th>
            <th>Proje</th>
            <th>Final</th>
            <th>Dönem Sonu Notu</th>
            <th>Harf Notu</th>
            <th>Katsayı</th>
            <th>Statü</th>
        </tr>

        <?php if ($sonuc && $sonuc->num_rows > 0): ?>

            <?php while ($ogrenci = $sonuc->fetch_assoc()): ?>

                <?php
                $donemSonuNotu =
                    $ogrenci["vize"] * 0.25 +
                    $ogrenci["odev"] * 0.25 +
                    $ogrenci["proje"] * 0.05 +
                    $ogrenci["final"] * 0.45;

                list($harfNotu, $katsayi, $statu) = harfNotuBul($donemSonuNotu);

                if ($donemSonuNotu < 50) {
                    $satirRengi = "kaldi";
                    $badgeRengi = "badge-kaldi";
                } else {
                    $satirRengi = "basarili";
                    $badgeRengi = "badge-basarili";
                }
                ?>

                <tr class="<?php echo $satirRengi; ?>">
                    <td><?php echo $ogrenci["okul_no"]; ?></td>
                    <td><?php echo $ogrenci["ad_soyad"]; ?></td>
                    <td><?php echo $ogrenci["ders_adi"]; ?></td>
                    <td><?php echo $ogrenci["vize"]; ?></td>
                    <td><?php echo $ogrenci["odev"]; ?></td>
                    <td><?php echo $ogrenci["proje"]; ?></td>
                    <td><?php echo $ogrenci["final"]; ?></td>
                    <td><strong><?php echo number_format($donemSonuNotu, 2); ?></strong></td>
                    <td><strong><?php echo $harfNotu; ?></strong></td>
                    <td><?php echo number_format($katsayi, 2); ?></td>
                    <td>
                        <span class="badge <?php echo $badgeRengi; ?>">
                            <?php echo $statu; ?>
                        </span>
                    </td>
                </tr>

            <?php endwhile; ?>

        <?php else: ?>

            <tr>
                <td colspan="11">Veritabanında kayıt bulunamadı.</td>
            </tr>

        <?php endif; ?>

    </table>

    <div class="footer">
        Dönem Sonu Notu = Vize %25 + Ödev %25 + Proje %5 + Final %45
    </div>

</div>

</body>
</html>

<?php
$conn->close();
?>