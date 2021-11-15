<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
include 'head.php';
$sql = hoangphuc("SELECT * FROM `caidat`");
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
            <h3>WEBSITE SETTING</h3>
          </strong>
        </center>
        <div id="msg"></div>
        <div class="form-group">
          <label>Tiêu đề:</label>
          <input type="text" class="form-control" id="tieude" placeholder="Nhập tiêu đề..." value="<?= $row['tieude'] ?>" />
        </div>
        <div class="form-group">
          <label>Mô tả:</label>
          <input type="text" class="form-control" id="mota" placeholder="Nhập mô tả..." value="<?= $row['mota'] ?>" />
        </div>
        <div class="form-group">
          <label>Từ khoá:</label>
          <input type="text" class="form-control" id="tukhoa" placeholder="Nhập từ khoá..." value="<?= $row['tukhoa'] ?>" />
        </div>
        <div class="form-group">
          <label>Ảnh giới thiệu website:</label>
          <input type="text" class="form-control" id="image" placeholder="Nhập từ khoá..." value="<?= $row['image'] ?>" />
        </div>
        <div class="form-group">
          <label>Email:</label>
          <input type="text" class="form-control" id="email" placeholder="Nhập email..." value="<?= $row['email'] ?>" />
        </div>
        <div class="form-group">
          <label>SĐT:</label>
          <input type="text" class="form-control" id="sdt" placeholder="Nhập số điện thoại..." value="<?= $row['sdt'] ?>" />
        </div>
        <div class="form-group">
          <input style="display:none;" type="text" class="form-control" id="chietkhau" placeholder="Nhập chiết khẩu..." value="<?= $row['chietkhau'] ?>" />
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
        var tieude = $('#tieude').val();
        var website = $('#website').val();
        var mota = $('#mota').val();
        var tukhoa = $('#tukhoa').val();
        var image = $('#image').val();
        var email = $('#email').val();
        var sdt = $('#sdt').val();
        var chietkhau = $('#chietkhau').val();
        if (!tieude && !mota || !tukhoa || !image || !email || !sdt || !chietkhau) {
          $("#msg").html('<i class="fa fa-close" aria-hidden="true"></i> Vui lòng nhập đầy đủ thông tin');
        } else {
          $.ajax({
            url: 'xuly.php',
            type: 'post',
            data: {
              tieude: tieude,
              website: website,
              mota: mota,
              tukhoa: tukhoa,
              image: image,
              email: email,
              sdt: sdt,
              chietkhau: chietkhau
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