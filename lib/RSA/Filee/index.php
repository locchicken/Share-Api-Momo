<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
$result = hoangphuc("SELECT * FROM momo");
$rows = mysqli_num_rows($result);
$result2 = hoangphuc('SELECT SUM(amount) AS chitieu FROM momo WHERE nguoigui != ""');
$rows2 = mysqli_fetch_assoc($result2);
$chitieu = $rows2['chitieu'];
$result3 = hoangphuc('SELECT SUM(amount) AS thunhap FROM momo WHERE nguoigui = ""');
$rows3 = mysqli_fetch_assoc($result3);
$thunhap = $rows3['thunhap'];
$sql = hoangphuc("SELECT * FROM `momo` WHERE nguoigui = ''");
?>
<?php include 'head.php'; ?>

<body>
    <?php include 'nav.php'; ?>
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body bg-success">
            <h4 style="color:#fff">Giao dịch: <?= $rows; ?></h4>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body bg-primary">
            <h4 style="color:#fff">Chi tiêu: <?= formatvnd($chitieu) . ' VNĐ' ?></h4>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body bg-danger">
            <h4 style="color:#fff">Thu nhập: <?= formatvnd($thunhap) . ' VNĐ' ?></h4>
          </div>
        </div>
      </div>
    </div>
    <br />
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
                <td><?= $momos['sdt_nguoinhan']; ?></td>
                <td><?= $momos['loinhan']; ?></td>
                <td><?= $momos['amount']; ?></td>
                <td><?= $momos['thoigian']; ?></td>
                <td><?= $momos['tranid']; ?></td>
                <td><?php
                  if ($momos['loinhan'] == "a" || $momos['loinhan'] == "A") {
                    if ($momos['socuoi'] == 0 || $momos['socuoi'] == 2 || $momos['socuoi'] == 4 || $momos['socuoi'] == 6 || $momos['socuoi'] == 8) {
                      echo '<span class="badge bg-success">Thắng</span>';
                    } else {
                      echo '<span class="badge bg-danger">Thua</span>';
                    }
                  }
                  if ($momos['loinhan'] == "b" || $momos['loinhan'] == "B") {
                    if ($momos['socuoi'] == 1 || $momos['socuoi'] == 3 || $momos['socuoi'] == 5 || $momos['socuoi'] == 7 || $momos['socuoi'] == 9) {
                      echo '<span class="badge bg-success">Thắng</span>';
                    } else {
                      echo '<span class="badge bg-danger">Thua</span>';
                    }
                  }
                  if ($momos['loinhan'] == 'x' || $momos['loinhan'] == 'X') {
                    if ($momos['socuoi'] == 1 || $momos['socuoi'] == 2 || $momos['socuoi'] == 3 || $momos['socuoi'] == 4) {
                      echo '<span class="badge bg-success">Thắng</span>';
                    } else {
                      echo '<span class="badge bg-danger">Thua</span>';
                    }
                  }
                  if ($momos['loinhan'] == 'y' || $momos['loinhan'] == 'Y') {
                    if ($momos['socuoi'] == 5 || $momos['socuoi'] == 6 || $momos['socuoi'] == 7 || $momos['socuoi'] == 8) {
                      echo '<span class="badge bg-success">Thắng</span>';
                    } else {
                      echo '<span class="badge bg-danger">Thua</span>';
                    }
                  }
                  if ($momos['loinhan'] == 't3' || $momos['loinhan'] == 'T3') {
                    if ($tong3 == 7 || $tong3 == 8 || $tong3 == 9) {
                      echo '<span class="badge bg-success">Thắng</span>';
                    } else {
                      echo '<span class="badge bg-danger">Thua</span>';
                    }
                  }
                  if ($momos['loinhan'] == 'C1' || $momos['loinhan'] == 'c1') {
                    if ($momos['socuoi'] == 0 || $momos['socuoi'] == 3 || $momos['socuoi'] == 6) {
                      echo '<span class="badge bg-success">Thắng</span>';
                    } else {
                      echo '<span class="badge bg-danger">Thua</span>';
                    }
                  }
                  if ($momos['loinhan'] == 'C2' || $momos['loinhan'] == 'c2') {
                    if ($momos['socuoi'] == 1 || $momos['socuoi'] == 4 || $momos['socuoi'] == 7) {
                      echo '<span class="badge bg-success">Thắng</span>';
                    } else {
                      echo '<span class="badge bg-danger">Thua</span>';
                    }
                  }
                  if ($momos['loinhan'] == 'C3' || $momos['loinhan'] == 'c3') {
                    if ($momos['socuoi'] == 2 || $momos['socuoi'] == 5 || $momos['socuoi'] == 8) {
                      echo '<span class="badge bg-success">Thắng</span>';
                    } else {
                      echo '<span class="badge bg-danger">Thua</span>';
                    }
                  }
                  if ($momos['loinhan'] == 'max1' || $momos['loinhan'] == 'Max1') {
                    if ($socuoi_max2 == 01 || $socuoi_max2 == 21 || $socuoi_max2 == 31 || $socuoi_max2 == 41 || $socuoi_max2 == 51 || $socuoi_max2 == 61 || $socuoi_max2 == 71 || $socuoi_max2 == 81 || $socuoi_max2 == 91 || $socuoi_max2 == 00 || $socuoi_max2 == 11 || $socuoi_max2 == 22 || $socuoi_max2 == 33 || $socuoi_max2 == 44 || $socuoi_max2 == 55 || $socuoi_max2 == 66 || $socuoi_max2 == 77 || $socuoi_max2 == 88 || $socuoi_max2 == 99) {
                      echo '<span class="badge bg-success">Thắng</span>';
                    } else {
                      echo '<span class="badge bg-danger">Thua</span>';
                    }
                  }
                  if ($momos['loinhan'] == 'max2' || $momos['loinhan'] == 'Max2') {
                    if ($socuoi_max3 == 111 || $socuoi_max3 == 222 || $socuoi_max3 == 333 || $socuoi_max3 == 444) {
                      echo '<span class="badge bg-success">Thắng</span>';
                    } else {
                      echo '<span class="badge bg-danger">Thua</span>';
                    }
                  }
                  if ($momos['loinhan'] == 'max3' || $momos['loinhan'] == 'Max3') {
                    if ($socuoi_max4 == 8888) {
                      echo '<span class="badge bg-success">Thắng</span>';
                    } else {
                      echo '<span class="badge bg-danger">Thua</span>';
                    }
                  }
                  ?></td>
              </tr>
            <?php  } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function() {
      $('#table_id').DataTable();
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js" integrity="sha384-lpyLfhYuitXl2zRZ5Bn2fqnhNAKOAaM/0Kr9laMspuaMiZfGmfwRNFh8HlMy49eQ" crossorigin="anonymous"></script>
</body>