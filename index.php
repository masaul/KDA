<!-- membatasi looping sesuai kebutuhan pesan string
perlu ada file untuk membaca gambar yang sudah dan sebelum di modif -->


<?php 
    function stegano($fileImg, $pesan){
        $binPesan = "";
        for ($i = 0; $i < mb_strlen($pesan); ++$i) {
            $character = ord($pesan[$i]); // Mengubah ke ASCII => 72
            $binPesan .= str_pad(decbin($character), 8, '0', STR_PAD_LEFT);
        }
            
        $posisiPesan = 0;
        $gambar = imagecreatefromjpeg($fileImg);
        $lebar = imagesx($gambar); //115
        $tinggi = imagesy($gambar); //127

        if(strlen($binPesan) > $lebar){
            echo "String lebih panjang dari pixel";
        }elseif(strlen($binPesan) <= $lebar) {
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

                    $newColor = imagecolorallocatealpha($gambar, $newRed, $newGreen, $newBlue, $alpha);
                    imagesetpixel($gambar, $x, $y, $newColor);
                    
                    $posisiPesan = $posisiPesan + 1;                
                }
            }
            $newImage = 'downloads.jpg';

            imagejpeg($gambar, $newImage );
            imagedestroy($gambar);

            echo "Berhasil mengenkripsi pesan!";
        }
    }


    if(isset($_POST["encrypt"])){
        $kataRahasia = $_POST["kata-rahasia"];
        $image_file = $_POST["image"];
        stegano($image_file, $kataRahasia);
    }



    function steganoDec($fileGambar){
        $img = imagecreatefromjpeg($fileGambar);

        // Read the message dimensions.
        $lebar = imagesx($img);
        $tinggi = imagesy($img);

        $binPesan = "";

        $binaryMessageCharacterParts = [];

        for ($y = 0; $y < $tinggi; $y++) {
            for ($x = 0; $x < $lebar; $x++) {
                $rgb = imagecolorat($img, $x, $y);
                $warna = imagecolorsforindex($img, $rgb);

                $red = $warna['red'];
                $green = $warna['green'];
                $blue = $warna['blue'];

                $binaryRed = decbin($red);
                $binaryGreen = decbin($green);
                $binaryBlue = decbin($blue);

                $binaryMessageCharacterPartsRed[] = $binaryRed[strlen($binaryRed) - 1];
                $binaryMessageCharacterPartsGreen[] = $binaryGreen[strlen($binaryGreen) - 1];
                $binaryMessageCharacterPartsBlue[] = $binaryBlue[strlen($binaryBlue) - 1];

                
            }
        }

    }

    steganoDec("downloads.jpg")
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keamanan Data dan Aplkasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-5">Steganografi Berbasis Algoritma LSB</h1>
        <h3>Encrypt Message</h3>
        <form action="" method="POST">
            <label for="kata-rahasia" class="mt-3">Kata Rahasia:</label>
            <input class="form-control" name="kata-rahasia" id="kata-rahasia" type="text" placeholder="Masukkan kata rahasia.." aria-label="default input example">
            <div class="mb-3 mt-3">
                <label for="formFile" class="form-label">Masukkan Gambar</label>
                <input class="form-control" name="image" type="file" id="formFile">
            </div>
            <button type="submit" class="btn btn-primary" name="encrypt">Encrypt</button>
        </form>

        <h3 class="mt-5">Decrypt Message</h3>
        <form action="#">
            <div class="mb-3 mt-3">
                <label for="formFile" class="form-label">Masukkan Gambar</label>
                <input class="form-control" type="file" id="formFile">
            </div>
            <button type="button" class="btn btn-primary">Decrypt</button>
        </form>
    </div>

    <div class="container mt-5">
        <h3>Hasil Decrypt</h3>
        <form action="#">
            <label for="#" class="mt-3">Plaintext :</label>
            <input class="form-control" type="text" aria-label="default input example">
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>