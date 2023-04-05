<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Maskapai Penerbangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  </head>
  <body>
    <center>
    <table border=0 cellspacing=0 width="1000px" style="background-color: #F8F8FF;">
        <tr>
          <td>
          <br>
          <h1><center>Pendaftaran Rute Penerbangan</center></h1>
          <br>
          <form action="" method="GET">
            <center>
            <table border=0>
              <tr>
                <td width="150px"><label for="exampleFormControlInput1" class="form-label">Maskapai</label></td>
                <td width="500px"><input type="text" class="form-control" id="exampleFormControlInput1" name="nm" placeholder="Nama Maskapai"></td>
              </tr>
              <tr>
                <td width="150px"><label for="exampleFormControlInput1" class="form-label">Bandara Asal</label></td>
                <td>
                <select name="ba" class="form-select" aria-label="Default select example">
                  <?php
                    $ba = array('Soekarno-Hatta (CGK)', 'Husein Sastranegara (BDO)', 'Abdul Rachman Saleh (MLG)', 'Juanda (SUB)');
                     sort($ba);
                    foreach ($ba as $value) {
                  ?>
                     <option value="<?php echo ($value); ?>"><?php echo $value; ?></option>
                  <?php
                    }
                  ?>
                </select></td>
              </tr>
              <tr>
                <td width="150px"><label for="exampleFormControlInput1" class="form-label">Bandara Tujuan</label></td>
                <td><select name="bt" class="form-select" 
                aria-label="Default select example">
                  <?php
                    $bt = array('Ngurah Rai (DPS)', 'Hasanuddin (UPG)', 'Inanwatan (INX)', 'Sultan Iskandarmuda (BJT)');
                     sort($bt);
                    foreach ($bt as $value) {
                   ?>
                     <option value="<?php echo ($value); ?>"><?php echo $value; ?></option>
                  <?php
                    }
                  ?>
                </select></td>
              </tr>
              <tr>
                <td width="150px"><label for="exampleFormControlInput1" class="form-label">Harga Tiket</label></td>
                <td width="500px"><input name="ht" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Harga Tiket"></td>
              </tr>
              <tr>
                <td><button name="submit" type="submit" class="btn btn-primary">Submit</button></td>
              </tr>
            </table>
            </center>
            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
          </form>
          <?php
          $dt = "js/data.json";
          $json = array();

          $data = file_get_contents($dt);
          $json = json_decode($data, true);
          //echo "<pre>"; print_r($json); echo "</pre>";
          ?>

          <?php
          function totalHarga ($harga, $pajak) {
            $totalTiket = $harga + $pajak;
            return $totalTiket;
          }
          if (isset($_GET['submit'])) {
            ?>

            <?php
            $nama = $_GET['nm'];
            $ba = $_GET['ba'];
            if ($ba == "Soekarno-Hatta (CGK)") {
              $pajak1 = 50000;
            } elseif ($ba == "Husein Sastranegara (BDO)") {
              $pajak1 = 30000;
            }  elseif ($ba == "Abdul Rachman Saleh (MLG)") {
              $pajak1 = 40000;
            } elseif ($ba == "Juanda (SUB)") {
              $pajak1 = 40000;
            }
            $bt = $_GET['bt'];
            if ($bt == "Ngurah Rai (DPS)") {
              $pajak2 = 80000;
            } elseif ($bt == "Hasanuddin (UPG)") {
              $pajak2 = 70000;
            } elseif ($bt == "Inanwatan (INX)") {
              $pajak2 = 90000;
            } elseif ($bt == "Sultan Iskandarmuda (BTJ)") {
              $pajak2 = 70000;
            }
            $ht = $_GET['ht'];
            $pajakAkhir = $pajak1 + $pajak2;
            $hargaTiket = totalHarga ($ht, $pajakAkhir);
            $tambahData = array (
              $_GET['nm'],
              $_GET['ba'],
              $_GET['bt'],
              $_GET['ht'],
              $pajakAkhir,
              $hargaTiket,
            );
            array_push($json, $tambahData);
            $data = json_encode($json, JSON_PRETTY_PRINT);
            file_put_contents($dt, $data);
          }
          ?>
          <h1><center>Daftar Rute Tersedia</center></h1>
          <table class="table table-striped-columns">
            <tr>
              <th>No</th>
              <th>Maskapai</th>
              <th>Asal Penerbangan</th>
              <th>Tujuan Penerbangan</th>
              <th>Harga Tiket</th>
              <th>Pajak</th>
              <th>Total Harga Tiket</th>
            </tr>
            <?php
            $no = 1;
            for ($i = 0; $i < count($json); $i++) {
              $nama = $json[$i][0];
              $ba = $json[$i][1];
              $bt = $json[$i][2];
              $ht = $json[$i][3];
              $pj = $json[$i][4];
              $tht = $json[$i][5];

              echo "<tr>
              <td>" . $no++ . "</td>
              <td>" . $nama . "</td>
              <td>" . $ba . "</td>
              <td>" . $bt . "</td>
              <td>" . $ht . "</td>
              <td>" . $pj . "</td>
              <td>" . $tht . "</td>
            </tr>";
            }
            ?>
          </table>
        </td>
      </tr>
    </table>
    </center>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  </body>
</html>