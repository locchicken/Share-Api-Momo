<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
$sql = hoangphuc('SELECT * FROM `momo` WHERE nguoigui != ""');
include 'head.php';

?>

<body>
    <?php include 'nav.php'; ?>
    <div class="mb-4"></div>
  <div class="container">
      <center><h3><strong>LỊCH SỬ CHUYỂN TIỀN</strong></h3></center>
    <div class="card">
      <div class="card-body">
        <table id="table_id" class="display">
          <thead>
            <tr>
              <th>ID</th>
              <th>SĐT</th>
              <th>Lời nhắn</th>
              <th>VNĐ</th>
              <th>Mã GD</th>
              <th>Thời gian</th>
              <th>Tình trạng</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($sql as $momos) { ?>
              <tr>
                <td><?= $momos['id']; ?></td>
                <td><?= $momos['sdt_nguoigui']; ?></td>
                <td><?= $momos['loinhan']; ?></td>
                <td><?= $momos['amount']; ?></td>
                <td><?= $momos['thoigian']; ?></td>
                <td><?= $momos['tranid']; ?></td>
                <td><span class="badge bg-success">Trả thưởng</span></td>
              </tr>
            <?php  } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <?php include 'foot.php'; ?>
    <script>
    $(document).ready(function() {
      $('#table_id').DataTable();
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js" integrity="sha384-lpyLfhYuitXl2zRZ5Bn2fqnhNAKOAaM/0Kr9laMspuaMiZfGmfwRNFh8HlMy49eQ" crossorigin="anonymous"></script>
</body>

</html>