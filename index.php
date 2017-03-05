<?php
/* 
 * 
 *  Sekiz Vezir Algoritması
 
 *  Bu betik, meşhur Sekiz Vezir bulmacasını
    istenen satır ve sütundan başlayarak
    budama algoritmasıyla çözmeye çalışır.

 *  Copyright (C) 2017 Semih KIROĞLU
 
 *  Sekiz Vezir Algoritması is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Sekiz Vezir Algoritması is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Sekiz Vezir Algoritması. If not, see <http://www.gnu.org/licenses/>.
 
 *  Email: semih@kiroglu.net 
 * 
 */

// PHP timeout süresini değiştir
ini_set("max_execution_time",3000);

// Ana parametreleri tanımla
$ayar["board"] = 8;
$ayar["islemsay"] = 0;
$ayar["topislemsay"] = 0;
$atama = array();

// Vezir, kilit ve hata dizilerini oluştur
for($i=1; $i<=$ayar["board"]; $i++) for($j=1; $j<=$ayar["board"]; $j++) {
    $vezir[$i][$j] = 0;
    $kilit[$i][$j] = 0;
    $hata[$i][$j] = 0;
}

// Fonksiyonları çağır
require'func.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <meta charset="utf-8">
    <title>Sekiz Vezir Bulmacası</title>
</head>
<body style="background-color: #ccc;">
    <div class="col-xs-12">
        <h1>Sekiz Vezir Bulmacası <small>(2017 &copy; <a href="https://semih.kiroglu.net" target="_blank">Semih Kıroğlu</a>)</small></h1>
        <form action="?" method="post" id="hparam" style="display: none;"><input type="hidden" id="ilksatir" name="ilksatir"><input type="hidden" id="ilksutun" name="ilksutun"><input type="hidden" id="hhiz" name="hhiz"></form>
    </div>
    <div class="col-xs-12">
        <div class="panel panel-info">
            <div class="panel-heading"><strong>Nedir, Nasıl Çalışır?</strong></div>
            <div class="panel-body">
                8 Vezir Bulmacası, 8x8'lik bir satranç tahtasına 8 adet vezirin hiçbiri olağan vezir hamleleriyle birbirini alamayacak biçimde yerleştirmesi sorunudur. Her bir vezirin konumunun diğer bir vezire saldırmasına engel olması için hiçbir vezir başka bir vezirle aynı satıra, aynı kolona ya da aynı köşegene yerleştirilemez. 8 Vezir Bulmacası daha genel olan n Vezir Bulmacası'nın özel bir durumudur. n Vezir Bulmacası, n ≥ 4 için n×n boyutunda bir satranç tahtasına n adet vezirin birbirini alamayacak biçimde yerleştirilmesi sorunudur. <a href="https://tr.wikipedia.org/wiki/Sekiz_vezir_bulmacas%C4%B1" target="_blank">Daha fazla bilgi ></a>.<br><br>
                İlk vezirin pozisyonunu seçtikten sonra budama algoritması her veziri tek tek yerleştirip sonuca ulaşmayı dener. Bu sırada her kontrol sonrası satranç tahtası temizlenip tekrar oluşturulur. Bulmaca çözüldüğünde çözümün son hali sağ alanda görüntülenir.
            </div>
        </div>
        <div class="alert alert-danger"><strong>
            <?php if(isset($_POST["ilksatir"]) && isset($_POST["ilksutun"])) {
                echo 'Algoritma şu an '.$_POST["ilksatir"].'x'.$_POST["ilksutun"].' ilk veziri için çözümü hesaplıyor (Hesaplayıcı hızı = ';
                if(empty($_POST["hhiz"])) echo '30000'; else echo $_POST["hhiz"];
                echo ' mikrosaniye).<br>Sayfa herhangi bir yanıt verene kadar bekleyin. Çalışan tarayıcıdaki hiçbir sekme üzerinde işlem yapmayın. Eğer süreç çok uzarsa (dakikalarca) pencereyi kapatın, gerekirse tarayıcıyı çökertin.'; 
            } else echo 'Önce (isteğe bağlı) Hesaplayıcı Parametreleri\'ni doldurun, sonra ilk veziri seçin!'; ?>
            </strong></div>
    </div>
    <div class="col-xs-4" id="alan_tepe">
        <div class="panel panel-warning" id="alan_tumu">
            <div class="panel-heading" id="alan_baslik"><strong><?php if(isset($_POST["ilksatir"]) && isset($_POST["ilksutun"])) echo 'Hesaplanıyor...'; else echo 'İlk Veziri Seç'; ?></strong></div>
            <div class="panel-body">
                    <table border="0" align="center" id="mevcuttahta">
                    <?php for($i=1; $i<=$ayar["board"]; $i++) {
                        echo '<tr height="50px" style="background-color: ';
                        if($i%2==0) echo '#d18b47';
                        else echo '#ffce9e';
                        echo ';">';
                        for($j=1; $j<=$ayar["board"]; $j++) {                    
                            echo '<td align="center" id="mevcut-'.$i.$j.'" class="mevcut-hucreler" valign="middle" width="50px" style="padding: 5px; background-color: ';
                                if($i%2==0 && $j%2==1) echo '#ffce9e';
                                elseif($i%2==1 && $j%2==0) echo '#ffce9e';
                                elseif($i%2==0 && $j%2==0) echo '#d18b47';
                                elseif($i%2==1 && $j%2==1) echo '#d18b47';
                            echo ';">&nbsp;</td>';
                        }
                        echo '</tr>';
                    }
                    echo '</table>';
                    ?>
            </div>
        </div>
    </div>
    <div class="col-xs-4" id="alan_log">
        <div class="panel panel-warning">
            <div class="panel-heading"><strong>Hesaplayıcı Parametreleri</strong></div>
            <div class="panel-body" id="logalani">
                <?php if(isset($_POST["ilksatir"]) && isset($_POST["ilksutun"])) echo '<hr width="100%" style="margin:3px !important; padding:3px !important;"><center>1. tur başlıyor...</center><hr width="100%" style="margin:3px !important; padding:3px !important;">'; else echo '<input type="text" id="hhiz_form" class="form-control" placeholder="Hesaplayıcı Hızı (ms) (Öntanımlı = 0.03 sn = 30000 ms)">'; ?>
            </div>
        </div>
    </div>
    <div id="temp_alan" style="display: none;">
    <?php        
    if(isset($_POST["ilksatir"]) && isset($_POST["ilksutun"])) {        
        // İlk değerleri ata
        $ayar["ilksatir"] = $_POST["ilksatir"];
        $ayar["ilksutun"] = $_POST["ilksutun"];
        
        // İlk veziri yerleştir
        vezirAta($ayar["ilksatir"],$ayar["ilksutun"]);
        array_push($atama, $ayar["ilksatir"].$ayar["ilksutun"]);

        // İlk vezir için kilitleri sapta
        kilitAta($ayar["ilksatir"],$ayar["ilksutun"]);
        
        // Atama işlemleri
        AtamaDongusu:
        for($i=1; $i<=$ayar["board"]; $i++) {
            // Satır döngüsü başlangıcı
            
            // Her satır döngüsünde satırdaki tüm durumları sayacak değişkenler
            $vezirsay = 0;
            $hatasay = 0;
            $kilitsay = 0;
            
            for($j=1; $j<=$ayar["board"]; $j++) {
                // Sütun döngüsü başlangıcı
                
                // Vezir, kilit ve hata durumlarını,
                // sütun döngüsü sonunda kontrol etmek için sayar.
                // Eğer atanabilir bir alan saptarsa vezir atar,
                // ve durumu kontrol eder. Geçerli ise saklar,
                // sorun saptanırsa hata olarak işaretleyip başka bir
                // denemeye geçer. Eğer önceki satıra dönmüşse altta kalan
                // tüm hata durumlarını temizleyerek yeni açılan noktalara
                // atama denemesi yapar.
                if($vezir[$i][$j] == 1) { $vezirsay++; continue; }
                elseif($hata[$i][$j] == 1) { $hatasay++; continue; }
                elseif($kilit[$i][$j] != 0) { $kilitsay++; continue; }
                else {
                    // Sıradaki veziri ata
                    vezirAta($i,$j);
                    
                    // Atama array'ine de kaydet
                    array_push($atama, $i.$j);
                    
                    // Atama array'indeki indisleri tekrar sırala
                    atamaSirala();
                    
                    // Atanan vezirin tahtada kilitlediği yerleri işaretle
                    kilitAta($i,$j);
                    
                    // Bu atamadan sonra tamamı atanamaz olan bir satır var mı
                    // kontrolünde kullanılacak kilitsay değişkenini 0 değeriyle
                    // ata.
                    $ickilitsay = 0;
                    
                    // Tamamı atanamaz olan satırları bulmak için satır/sütun
                    // döngüsünü çalıştır. Her satırdaki kilitleri sayar.
                    // Sonraki satıra geçmeden önce tahta genişliği ile kilit
                    // sayılarının eşit olup olmadığına bakar. Eğer eşitse
                    // son satırı siler ve hata olarak işaretler.
                    for($x=1; $x<=$ayar["board"]; $x++) {           
                        for($y=1; $y<=$ayar["board"]; $y++) {
                            if(($kilit[$x][$y] != 0) && $vezir[$x][$y] == 0) $ickilitsay++;
                        }
                        if($ickilitsay == $ayar["board"]) {
                            sonSatiriSil();
                            goto AtamaDongusu;
                        }
                        $ickilitsay = 0;
                    }
                }
                mevcutCiz(1);
            }
            
            // Bir satırdaki tüm atanabilir hücrelere atama yaptıktan sonra
            // o satır için tüm hata ve kilit durumlarının toplamını alır.
            // Eğer tahta genişliği ile hata+kilit sayıları eşitse son satırı
            // siler ve hata olarak işaretler.
            if($hatasay+$kilitsay == $ayar["board"]) {
                sonSatiriSil();
                goto AtamaDongusu;
            }
        }
        
        // Döngü tamamlandıktan sonra işlemleri sayar ve tahta üzerinde yapılacak
        // hiç bir işlem kalmadığını doğrular. Eğer işlem kalmışsa son satırı siler
        // ve döngüye tekrar döner. Hesaplama kuralı = 
        // Hatalar + Kilitler + Atamalar = Board^2
        if(islemSay()==($ayar["board"]*$ayar["board"])) {
            // Bu state okunuyorsa tüm tahtaya atama süreci tamamlanmıştır.
            
            // Sonraki kontrol atanan vezir sayısının tahta genişliğine eşit
            // olup olmadığıdır. Eğer eşit değilse son satır silinir,
            // seçili noktadan altta kalan hata state'leri sıfırlanır ve 
            // döngüye tekrar dönülerek kalan diğer hamleler denenir.
            if(count($atama)!=$ayar["board"]) {
                sonSatiriSil();
                goto AtamaDongusu;
            }
            // Eğer iki eşitlik de sağlanırsa ekran çıktısı basılır.
            else {
                asenkyaz('<script>$("#alan_tumu").removeClass("panel-warning").addClass("panel-success"); $("#alan_tepe").addClass("col-xs-offset-4"); $("#alan_log").addClass("col-xs-offset-4"); $("#alan_baslik").html("<strong>Bulmaca Çözüldü!</strong>");</script>');
                echo mevcutCiz();
                exit;
            }
        }
        
        // Yukarıdaki kural gerçeklenmemişse hala atamaya müsait yerler var
        // demektir. Döngüye tekrar gidilir. Bu işlem 10 kez tekrarlanırsa 
        // program sonlandırılır.
        else {
            $ayar["topislemsay"]++;
            if($ayar["topislemsay"]>9) {
                asenkyaz('<script>$("#alan_tumu").removeClass("panel-warning").addClass("panel-danger"); $("#alan_baslik").html("<strong>Döngü deneme sınırı aşıldı! Program durduruldu!</strong>");</script>');
                exit;
            } else {
                goto AtamaDongusu;
            }
        }
    }
    ?>
    </div>
<script>
    $(document).ready(function(){
        var lastbgcolor = false;
        $(".mevcut-hucreler").mouseenter(function(e){
            lastbgcolor = $(this).css('background-color');
            $(this).css({
                'background-color': '#ccff33',
                'cursor': 'pointer'
            }).html('<img src="queen.png" class="img-responsive">');
        });
        $(".mevcut-hucreler").mouseleave(function(e){
            $(this).css({
                'background-color': lastbgcolor,
                'cursor': 'default'
            }).html('&nbsp;');
        });
        $(".mevcut-hucreler").click(function(){
            secilihucre = $(this).attr('id');
            secilihucre = secilihucre.split("-");
            ilksatir = secilihucre[1].substring(0,1);
            ilksutun = secilihucre[1].substring(1,2);
            if(ilksatir>0 && ilksatir<9) {
                var onayla = confirm("Algoritma, ilk vezir noktası " + ilksatir + "x" + ilksutun + " için bulmacayı çözmeyi deneyecek. Devam edilsin mi?");
                if(onayla) {
                    $("#ilksatir").val(ilksatir);
                    $("#ilksutun").val(ilksutun);
                    $("#hhiz").val($("#hhiz_form").val());
                    $("#hparam").submit();
                } else { 
                    return false;
                }                
            }
        });
    });
</script>
</body>
</html>
