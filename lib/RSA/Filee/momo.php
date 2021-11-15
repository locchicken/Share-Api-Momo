<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
include 'head.php'; 
$sql = hoangphuc("SELECT * FROM `caidat_momo`");
$row = fetch_array($sql);
?>
<body>
    <?php include 'nav.php'; ?>
    <div class="mb-4"></div>
  <div class="container">
    <div class="card">
      <div class="card-body">
        <center>
          <strong>
            <h3>MOMO SETTING</h3>
          </strong>
        </center>
        <div id="msg"></div>
        <div class="form-group">
          <label>Số tiền chơi tối thiểu:</label>
          <input type="text" class="form-control" id="min" placeholder="Nhập số tiền chơi tối thiểu..." value="<?= $row['toithieu'] ?>" />
        </div>
        <div class="form-group">
          <label>Mô tả:</label>
          <input type="text" class="form-control" id="max" placeholder="Nhập số tiền chơi tối đa..." value="<?= $row['toida'] ?>" />
        </div>
        <div class="form-group">
          <label>Nội dung trả thưởng:</label>
          <input type="text" class="form-control" id="noidung" placeholder="Nhập nội dung trả thưởng..." value="<?= $row['noidung'] ?>" />
        </div>
        <div class="mb-4"></div>
        <div class="form-group">
          <div class="d-grid gap-2">
            <button class="btn btn-primary" id="submit">Lưu lại</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include 'foot.php'; ?>
  <script>
    $(document).ready(function() {
      $('#submit').click(function() {
        var min = $('#min').val();
        var max = $('#max').val();
        var noidung = $('#noidung').val();
        if (!min && !max) {
          $("#msg").html('<i class="fa fa-close" aria-hidden="true"></i> Vui lòng nhập đầy đủ thông tin');
        } else {
          $.ajax({
            url: 'caidat_momo.php',
            type: 'post',
            data: {
              min: min,
              max: max,
              noidung: noidung
            },
            success: function(ketqua) {
              var msg = '';
              if (ketqua == 1) {
                msg = '<div class="alert alert-success d-flex align-items-center" role="alert"><svg class="bi flex-shrink-0 me-2" width="24" height="24"><use xlink:href="#check-circle-fill"/></svg><div>Lưu thay đổi thành công !</div></div>';
              } else {
                msg = '<div class="alert alert-danger d-flex align-items-center" role="alert"><svg class="bi flex-shrink-0 me-2" width="24" height="24"><use xlink:href="#check-circle-fill"/></svg><div>Có lỗi xảy ra. Vui lòng liên hệ người hổ trợ !</div></div>';
                window.location.href = "/";
              }
              $('#msg').html(msg);
            }
          })
        }
      })
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js" integrity="sha384-lpyLfhYuitXl2zRZ5Bn2fqnhNAKOAaM/0Kr9laMspuaMiZfGmfwRNFh8HlMy49eQ" crossorigin="anonymous"></script>
</body>

</html>