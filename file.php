<?php 
    function stegano($fileImg, $pesan){
        $binPesan = "";
        for ($i = 0; $i < mb_strlen($pesan); ++$i) {
            $character = ord($pesan[$i]); // Mengubah ke ASCII => 72
            $binPesan .= str_pad(decbin($character), 8, '0', STR_PAD_LEFT);
        }

        // $binPesan .= '00000011';

        $gambar = imagecreatefromjpeg($fileImg);
        $lebar = imagesx($gambar); //34
        $tinggi = imagesy($gambar); //33

        echo $lebar;
        echo $tinggi;
        
        $ukuranPesan = strlen($binPesan);

        $posisiPesan = 0;
        for($y=0; $y < $tinggi; $y++){
            for($x = 0; $x < $lebar; $x++){
                $rgb = imagecolorat($gambar, $x, $y); //medapatkan nilai warna per pixel
                $warna = imagecolorsforindex($gambar, $rgb);
                $red = $warna['red'];
                $green = $warna['green'];
                $blue = $warna['blue'];
                $alpha = $warna['alpha'];
                
                $binRed = str_pad(decbin($red), 8, '0', STR_PAD_LEFT); 
                $binGreen = str_pad(decbin($green), 8, '0', STR_PAD_LEFT);
                $binBlue = str_pad(decbin($blue), 8, '0', STR_PAD_LEFT);   
            
            }
        }
    }
    // print_r(stegano("a.jpg", "H"));
    echo stegano("a.jpg", "Halo");
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel</title>
    <style>
        .tabel{
            display: flex;
            justify-content: space-around;
        }
    </style>
</head>
<body>
    <div class="tabel">
        <div class="tabel1">
            <table border="1">
                <tr>
                    <td>Pixel</td>
                    <td>Red</td>
                    <td>Green</td>
                    <td>Blue</td>
                </tr>
                <?php 
                    $gambar = imagecreatefromjpeg("a.jpg");
                    $lebar = imagesx($gambar); //115
                    $tinggi = imagesy($gambar); //127
                
                    $posisiPesan = 0;
                    for($y=0; $y < $tinggi; $y++){
                        for($x = 0; $x < $lebar; $x++){
                            $rgb = imagecolorat($gambar, $x, $y); //medapatkan nilai warna per pixel
                            $warna = imagecolorsforindex($gambar, $rgb);
                            $red = $warna['red'];
                            $green = $warna['green'];
                            $blue = $warna['blue'];
                            $alpha = $warna['alpha'];
                            
                            $binRed = str_pad(decbin($red), 8, '0', STR_PAD_LEFT); 
                            $binGreen = str_pad(decbin($green), 8, '0', STR_PAD_LEFT);
                            $binBlue = str_pad(decbin($blue), 8, '0', STR_PAD_LEFT); 

                            echo "<tr>";
                            echo "<td>" . $x . "</td>";
                            echo "<td>" . $binRed . "</td>";
                            echo "<td>" . $binGreen . "</td>";
                            echo "<td>" . $binBlue . "</td>";
                            echo "</tr>";
                            }
                        }
                    ?>
            </table>
        </div>
        <div class="tabel2">
            <?php 
                $binPesan = "";
                $pesan = "Halo";
                for ($i = 0; $i < mb_strlen($pesan); ++$i) {
                    $character = ord($pesan[$i]); // Mengubah ke ASCII => 72
                    $binPesan .= str_pad(decbin($character), 8, '0', STR_PAD_LEFT);
                }
                echo "<p>" . $binPesan . "<br> </p>";
            ?>
        </div>
        <div class="tabel3">
            <table border="1">
                <tr>
                    <td>Pixel</td>
                    <td>Red</td>
                    <td>Green</td>
                    <td>Blue</td>
                </tr>
                <?php 
                    $binPesan = "";
                    $pesan = "Halo";
                    for ($i = 0; $i < mb_strlen($pesan); ++$i) {
                        $character = ord($pesan[$i]); // Mengubah ke ASCII => 72
                        $binPesan .= str_pad(decbin($character), 8, '0', STR_PAD_LEFT);
                    }
            
                    $posisiPesan = 0;
                    $gambar = imagecreatefromjpeg("a.jpg");
                    $lebar = imagesx($gambar); //115
                    $tinggi = imagesy($gambar); //127
                
                    $posisiPesan = 0;
                    for($y=0; $y < $tinggi; $y++){
                        for($x = 0; $x < $lebar; $x++){
                            $rgb = imagecolorat($gambar, $x, $y); //medapatkan nilai warna per pixel
                            $warna = imagecolorsforindex($gambar, $rgb);
                            $red = $warna['red'];
                            $green = $warna['green'];
                            $blue = $warna['blue'];
                            $alpha = $warna['alpha'];
                            
                            $binRed = str_pad(decbin($red), 8, '0', STR_PAD_LEFT); 
                            $binGreen = str_pad(decbin($green), 8, '0', STR_PAD_LEFT);
                            $binBlue = str_pad(decbin($blue), 8, '0', STR_PAD_LEFT); 

                            $binRed[strlen($binRed) - 1] = $binPesan[$posisiPesan];
                            $newRed = bindec($binRed);
                            $binGreen[strlen($binGreen) - 1] = $binPesan[$posisiPesan];
                            $newGreen = bindec($binGreen);
                            $binBlue[strlen($binBlue) - 1] = $binPesan[$posisiPesan];
                            $newBlue = bindec($binBlue);
                            $posisiPesan = $posisiPesan + 1;

                            echo "<tr>";
                            echo "<td>" . $x . "</td>";
                            echo "<td>" . $binRed . "</td>";
                            echo "<td>" . $binGreen . "</td>";
                            echo "<td>" . $binBlue . "</td>";
                            echo "</tr>";
                            }
                        }
                    ?>
            </table>
        </div>
    </div>
</body>
</html>