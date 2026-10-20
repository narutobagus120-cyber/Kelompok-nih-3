<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Menangkap data dari formulir DENNSTORE
    $game    = htmlspecialchars($_POST['game']);
    $user_id = htmlspecialchars($_POST['user_id']);
    $zone_id = htmlspecialchars($_POST['zone_id']);
    $nominal = intval($_POST['nominal']);
    $metode  = htmlspecialchars($_POST['metode']);
    
    // Perhitungan Harga Dasar
    $harga_dasar = 0;
    if ($nominal == 50) {
        $harga_dasar = 15000;
    } elseif ($nominal == 250) {
        $harga_dasar = 65000;
    } elseif ($nominal == 500) {
        $harga_dasar = 120000;
    } elseif ($nominal == 1000) {
        $harga_dasar = 230000;
    }

    // Perhitungan Pajak PPN (11%) & Biaya Admin
    $pajak       = $harga_dasar * 0.11;
    $biaya_admin = 1000; // Biaya admin QRIS
    $total_bayar = $harga_dasar + $pajak + $biaya_admin;
    
    $no_invoice = "GZ-" . rand(100000, 999999);
} else {
    header("Location: denn.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran - Dennstore</title>
    <style>
        body {
            background-color: #1e2022;
            color: #e2e8f0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
        }
        .struk-card {
            background-color: #282a2d;
            border-radius: 16px;
            border: 1px solid #3f444a;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.4);
            width: 100%;
            max-width: 400px;
            overflow: hidden;
        }
        .accent-bar {
            hight: 8px;
            height: 6px;
            background: linear-gradient(to right, #fbbf24, #f59e0b);
        }
        .struk-header {
            padding: 24px;
            text-align: center;
            border-b: 1px solid #3f444a;
            border-bottom: 1px solid #3f444a;
        }
        .struk-header span {
            font-size: 11px;
            text-transform: uppercase;
            font-weight: bold;
            color: #fbbf24;
            letter-spacing: 1px;
        }
        .struk-header h1 {
            font-size: 24px;
            font-weight: 900;
            color: white;
            margin: 6px 0;
        }
        .struk-header p {
            font-size: 11px;
            color: #94a3b8;
            margin: 0;
        }
        .struk-body {
            padding: 24px;
        }
        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 13px;
        }
        .label {
            color: #94a3b8;
        }
        .value {
            font-weight: bold;
            color: white;
        }
        .value-id {
            color: #34d399;
            font-family: monospace;
        }
        .value-diamond {
            color: #fbbf24;
        }
        .divider {
            border-top: 1px dashed #4b5563;
            margin: 16px 0;
        }
        .total-box {
            background-color: #1e2022;
            border: 1px solid #3f444a;
            border-radius: 12px;
            padding: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }
        .total-label {
            font-size: 11px;
            font-weight: bold;
            color: #94a3b8;
            text-transform: uppercase;
        }
        .total-value {
            font-size: 20px;
            font-weight: 900;
            color: #fbbf24;
        }
        .info-note {
            font-size: 10px;
            color: #94a3b8;
            text-align: center;
            line-height: 1.5;
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px solid #3f444a;
        }
        .btn-back {
            display: block;
            text-align: center;
            background-color: #383a3e;
            color: white;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            padding: 12px;
            border-radius: 10px;
            margin-top: 20px;
            transition: background-color 0.2s;
        }
        .btn-back:hover {
            background-color: #4b5563;
        }
    </style>
</head>
<body>

    <div class="struk-card">
        <div class="accent-bar"></div>

        <!-- Header Struk -->
        <div class="struk-header">
            <span>Struk Tagihan Top Up</span>
            <h1><?php echo $no_invoice; ?></h1>
            <p>Tanggal Pemrosesan: <?php echo date("d M Y - H:i"); ?> WIB</p>
        </div>

        <!-- Detail Pembelian -->
        <div class="struk-body">
            <div class="row">
                <div class="label">Item Game</div>
                <div class="value"><?php echo $game; ?></div>
            </div>
            
            <div class="row">
                <div class="label">Target Akun ID</div>
                <div class="value value-id"><?php echo $user_id; ?> (<?php echo $zone_id; ?>)</div>
            </div>

            <div class="row">
                <div class="label">Nominal Item</div>
                <div class="value value-diamond"><?php echo number_format($nominal); ?> Diamonds 💎</div>
            </div>

            <div class="row">
                <div class="label">Metode Bayar</div>
                <div class="value"><?php echo $metode; ?></div>
            </div>

            <div class="divider"></div>

            <!-- Rincian Harga Ringkas -->
            <div class="row" style="font-size: 11px;">
                <div class="label">Harga Produk</div>
                <div class="value" style="color: #cbd5e1;">Rp <?php echo number_format($harga_dasar, 0, ',', '.'); ?></div>
            </div>
            <div class="row" style="font-size: 11px;">
                <div class="label">PPN (11%)</div>
                <div class="value" style="color: #cbd5e1;">Rp <?php echo number_format($pajak, 0, ',', '.'); ?></div>
            </div>
            <div class="row" style="font-size: 11px;">
                <div class="label">Biaya Vendor</div>
                <div class="value" style="color: #cbd5e1;">Rp <?php echo number_format($biaya_admin, 0, ',', '.'); ?></div>
            </div>

            <!-- Total Akhir -->
            <div class="total-box">
                <div class="total-label">Total Bayar</div>
                <div class="total-value">Rp <?php echo number_format($total_bayar, 0, ',', '.'); ?></div>
            </div>

            <!-- Catatan -->
            <div class="info-note">
                ⚠️ Silakan selesaikan pembayaran. Diamond akan masuk ke dalam akun secara otomatis dalam 1-3 menit setelah dana terverifikasi.
            </div>

            <!-- Tombol Kembali -->
            <a href="denn.html" class="btn-back">
                ← Kembali ke Dennstore
            </a>
        </div>
    </div>

</body>
</html>
