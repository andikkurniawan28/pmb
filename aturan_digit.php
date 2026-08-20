<?php include('header.php'); ?>

<?php 
    // Query untuk mengambil data aturan digit berurutan berdasarkan kode kategori
    $query = "SELECT * FROM aturan_digit ORDER BY kode_kategori ASC";
    $result = mysqli_query($conn, $query);
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Aturan Digit</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-nowrap" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Kelompok</th>
                            <th>D6</th>
                            <th>D7</th>
                            <th>D8</th>
                            <th>D9</th>
                            <th>D10</th>
                            <th>D11</th>
                            <th>D12</th>
                            <th>D13</th>
                            <th>D14</th>
                            <th>D15</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><span class="badge badge-primary px-2 py-1"><?= htmlspecialchars($row['kode_kategori']); ?></span></td>
                                <td><strong><?= htmlspecialchars($row['nama_kelompok_excel'] ?? '-'); ?></strong></td>
                                <td><?= htmlspecialchars($row['param_d6'] ?? '-'); ?></td>
                                <td><?= htmlspecialchars($row['param_d7'] ?? '-'); ?></td>
                                <td><?= htmlspecialchars($row['param_d8'] ?? '-'); ?></td>
                                <td><?= htmlspecialchars($row['param_d9'] ?? '-'); ?></td>
                                <td><?= htmlspecialchars($row['param_d10'] ?? '-'); ?></td>
                                <td><?= htmlspecialchars($row['param_d11'] ?? '-'); ?></td>
                                <td><?= htmlspecialchars($row['param_d12'] ?? '-'); ?></td>
                                <td><?= htmlspecialchars($row['param_d13'] ?? '-'); ?></td>
                                <td><?= htmlspecialchars($row['param_d14'] ?? '-'); ?></td>
                                <td><?= htmlspecialchars($row['param_d15'] ?? '-'); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<?php include('footer.php'); ?>