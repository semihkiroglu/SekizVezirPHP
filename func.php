<?php
/*  
 * 
 *  Sekiz Vezir Algoritması

 *  Copyright (C) 2017 Semih KIROĞLU
 
 *  This file is part of Sekiz Vezir Algoritması.

 *  Sekiz Vezir Algoritması is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Sekiz Vezir Algoritması is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Sekiz Vezir Algoritması.  If not, see <http://www.gnu.org/licenses/>.
 
 *  Email: semih@kiroglu.net  
 * 
 */

// Fonksiyonlar
// Satır ve sütun bilgisi gelen vezirin ilgili hücreye atamasını yapar.
function vezirAta($satir,$sutun) {
    // Okunacak ve yazılacak global değişkenleri fonksiyona çağır
    global $vezir;

    $vezir[$satir][$sutun] = 1;
}

// Satır ve sütun bilgisi gelen vezirin kilitlediği alanları işaretler.
function kilitAta($satir,$sutun) {
    // Okunacak ve yazılacak global değişkenleri fonksiyona çağır
    global $ayar;
    global $kilit;

    for($i=1; $i<=$ayar["board"]; $i++)
    for($j=1; $j<=$ayar["board"]; $j++) {
        // Doğrusal Kilitler
        $kilit[$i][$j] = ltrim($kilit[$i][$j], "0");
        if($satir == $i) $kilit[$i][$j] .= $satir.$sutun.',';
        elseif($sutun == $j) $kilit[$i][$j] .= $satir.$sutun.',';
    }

    // Soldan sağa çapraz uçlar - 1
    $i = $satir;
    $j = $sutun;
    while($i>=2 && $j>=2) {
        $kilit[$i-1][$j-1] = ltrim($kilit[$i-1][$j-1], "0");
        $kilit[$i-1][$j-1] .= $satir.$sutun.',';
        $i--;
        $j--;
    }
    // Soldan sağa çapraz uçlar - 2
    $i = $satir;
    $j = $sutun;
    while($i<$ayar["board"] && $j<$ayar["board"]) {
        $kilit[$i+1][$j+1] = ltrim($kilit[$i+1][$j+1], "0");
        $kilit[$i+1][$j+1] .= $satir.$sutun.',';
        $i++;
        $j++;
    }

    // Sağdan sola çapraz uçlar - 1
    $i = $satir;
    $j = $sutun;
    while($i>1 && $j<$ayar["board"]) {
        $kilit[$i-1][$j+1] = ltrim($kilit[$i-1][$j+1], "0");
        $kilit[$i-1][$j+1] .= $satir.$sutun.',';
        $i--;
        $j++;
    }
    // Sağdan sola çapraz uçlar - 2
    $i = $satir;
    $j = $sutun;
    while($i<$ayar["board"] && $j>1) {
        $kilit[$i+1][$j-1] = ltrim($kilit[$i+1][$j-1], "0");
        $kilit[$i+1][$j-1] .= $satir.$sutun.',';
        $i++;
        $j--;
    }
}

// Atanan bir vezirin atamasını iptal eder.
function vezirGeri($satir,$sutun) {
    // Okunacak ve yazılacak global değişkenleri fonksiyona çağır
    global $vezir;

    $vezir[$satir][$sutun] = 0;
}

// Bir vezirin kilitlediği hücreleri serbest bırakır.
function kilitGeri($satir,$sutun) {
    // Okunacak ve yazılacak global değişkenleri fonksiyona çağır
    global $ayar;
    global $kilit;

    for($i=1; $i<=$ayar["board"]; $i++)
    for($j=1; $j<=$ayar["board"]; $j++) {
        if($kilit[$i][$j] != 0) {
            $kilit[$i][$j] = str_replace($satir.$sutun.",", "", $kilit[$i][$j]);
            if(empty($kilit[$i][$j])) $kilit[$i][$j] = 0;
        }
    }
}

// Atamaların vezir iptallerinden sonra indislerini tekrar sıralar.
function atamaSirala() {
    // Okunacak ve yazılacak global değişkenleri fonksiyona çağır
    global $atama;

    $i = 0;
    $yenidizi = array();
    ksort($atama);
    foreach ($atama as $key => $value) {
        $yenidizi[$i] = $value;
        $i++;
    }
    $atama = $yenidizi;
}

// Tahtada bir çevrimde yapılan toplam işlem sayısını döndürür
function islemSay() {
    global $ayar;
    global $vezir;
    global $hata;
    global $kilit;

    $islemsay = array();
    $sonuc = 0;

    for($i=1; $i<=$ayar["board"]; $i++) for($j=1; $j<=$ayar["board"]; $j++) {
        if($vezir[$i][$j] == 1) $islemsay[$i.$j] = 1;
        elseif($hata[$i][$j] == 1) $islemsay[$i.$j] = 1;
        elseif($kilit[$i][$j] != 0) $islemsay[$i.$j] = 1;
    }
    foreach ($islemsay as $key => $value) {
        $sonuc += $value;
    }
    return $sonuc;
}

// Atamadaki son satırı siler ve hata olarak işaretler
function sonSatiriSil() {
    // Okunacak ve yazılacak global değişkenleri fonksiyona çağır
    global $atama;
    global $hata;
    global $ayar;

    // Son atanan satır ve sütun bilgisini al
    $sasatir = substr($atama[count($atama)-1],0,1);
    $sasutun = substr($atama[count($atama)-1],-1);

    // Hata olarak işaretle
    $hata[$sasatir][$sasutun] = 1;

    // Atanan veziri hücreden kaldır
    vezirGeri($sasatir, $sasutun);

    // Vezirin kilitlediği hücreleri serbest bırak
    kilitGeri($sasatir, $sasutun);

    // Atama array'inden ilgili atamayı sil
    unset($atama[count($atama)-1]);

    // Atama array'ini tekrar sırala
    atamaSirala();

    // Hata işaretlenen satırdan sonrası için olan bütün hata durumlarını kaldır
    for($i=$sasatir+1; $i<=$ayar["board"]; $i++) for($j=1; $j<=$ayar["board"]; $j++) $hata[$i][$j] = 0;
}

// Tahtayı mevcut durumuyla ekrana basar (İçerdeki yorum satırlarının yorum işaretçileri kaldırılırsa tüm durumları basar, şu an sadece vezirleri basıyor.)
function mevcutCiz($beklet = 0) {
    // Okunacak ve yazılacak global değişkenleri fonksiyona çağır
    global $vezir;
    global $kilit;
    global $hata;
    global $ayar;
    
    $ayar["islemsay"]++;
    
    asenkyaz('<script>$(".mevcut-hucreler").html("&nbsp;");</script>');
    /* 
     * for($i=1; $i<=$ayar["board"]; $i++) for($j=1; $j<=$ayar["board"]; $j++) {
     * if($i%2==0 && $j%2==1) asenkyaz('<script>$("#mevcut-'.$i.$j.'").css("background-color","#ffce9e");</script>');
     * elseif($i%2==1 && $j%2==0) asenkyaz('<script>$("#mevcut-'.$i.$j.'").css("background-color","#ffce9e");</script>');
     * elseif($i%2==0 && $j%2==0) asenkyaz('<script>$("#mevcut-'.$i.$j.'").css("background-color","#d18b47");</script>');
     * elseif($i%2==1 && $j%2==1) asenkyaz('<script>$("#mevcut-'.$i.$j.'").css("background-color","#d18b47");</script>');
     * }
     */
    for($i=1; $i<=$ayar["board"]; $i++) {
        for($j=1; $j<=$ayar["board"]; $j++) {   
            if($beklet == 1) beklet($_POST["hhiz"]);
            if($vezir[$i][$j]==1) asenkyaz('<script>$("#mevcut-'.$i.$j.'").html("<img src=\"queen.png\" class=\"img-responsive\">").attr("title","Atama yapılmış"); $("#logalani").prepend("<li>['.$i.'x'.$j.'] vezir yerleştirildi!</li>"); console.info("Tur '.$ayar["islemsay"].' -> ['.$i.'x'.$j.'] vezir yerleştirildi!");</script>');
            /* 
             * elseif($hata[$i][$j]==1) asenkyaz('<script>$("#mevcut-'.$i.$j.'").css("background-color","#ffff00").attr("title","Budanmış, bir süre atama yapılamaz!"); $("#logalani").prepend("<li>['.$i.'x'.$j.'] budandı!</li>"); console.warn("Tur '.$ayar["islemsay"].' -> ['.$i.'x'.$j.'] budandı!");</script>');
             * elseif($kilit[$i][$j]!=0) asenkyaz('<script>$("#mevcut-'.$i.$j.'").css("background-color","#cc0000").attr("title","Bir vezir tarafından kilitlenmiş, vezir geri dönene kadar atama yapılamaz!");  $("#logalani").prepend("<li>['.$i.'x'.$j.'] bir vezir tarafından kilitlendi!</li>"); console.error("Tur '.$ayar["islemsay"].' -> ['.$i.'x'.$j.'] bir vezir tarafından kilitlendi!");</script>');
             * else asenkyaz('<script>$("#mevcut-'.$i.$j.'").html("&nbsp;").css("background-color","#99cc00").attr("title","Atama için uygun"); $("#logalani").prepend("<li>['.$i.'x'.$j.'] atama için uygun!</li>"); console.log("Tur '.$ayar["islemsay"].' -> ['.$i.'x'.$j.'] atama için uygun!");</script>');
             */
        }
    }
    asenkyaz('<script>$("#temp_alan").empty(); $("#logalani").prepend("<hr width=\"100%\" style=\"margin:3px !important; padding:3px !important;\"><center>'.$ayar["islemsay"].'. tur tamamlandı!</center><hr width=\"100%\" style=\"margin:3px !important; padding:3px !important;\">");</script>');
    return true;
}

// PHP yorumlaması tamamlanmadan ekrana çıktı vermeyi sağlar
function asenkyaz($value) {
    flush();
    ob_flush();
    echo $value;
    flush();
    ob_flush();
}

// PHP'de çalışan bir betiği $ms mikrosaniye kadar bekletir
function beklet($ms = 30000) {
    if(empty($_POST["hhiz"])) $ms = 30000;
    flush();
    ob_flush();
    usleep($ms);
    flush();
    ob_flush();
}
?>