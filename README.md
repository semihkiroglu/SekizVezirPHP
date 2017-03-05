Sekiz Vezir Algoritması
==========================

Bu PHP betiği ilk veziri kullanıcı tarafından yerleştirildikten sonra budama algoritmasıyla sekiz vezir problemini çözen algoritmadır.


## Test Edilen/Desteklenen Altyapılar
* Ubuntu 16.10 üzerinde Apache2 Web Server
* PHP 7.0
* Chromium Browser


## Desteklenmesi Öngörülen Altyapılar
* Apache2 veya Nginx Web Server
* PHP 5+
* JS destekli herhangi bir browser


## Gereksinimler
Bu betiğin başarıyla çalışması için şunlara dikkat edin:

* Internet bağlantısı olması (jQuery ve Bootstrap CDN ile gelir)
* Sayfa istenecek tarayıcının JS desteği olması
* Web server servisinin çalışıyor olması


## Kullanımı
Çok basittir. index.php, func.php ve queen.png dosyalarını web server'ın public dizinine kopyalayıp index.php'yi JS destekli herhangi bir tarayıcıdan görüntülemeniz yeterlidir. (isterseniz) Hesaplama hızını girmeyi ve tahta üzerinde ilk vezirin yerini seçmeyi unutmayın! :) 


## Yaşanabilecek Sorunlar

Yaşanabilme ihtimali olan bir kaç şey:

* İşlemi başlatıyorum ancak ekran uzun bir süre hareketsiz kalıyor, işlem başlamıyor, süreç uzun sürüyor, tarayıcım çöküyor.

	* Tarayıcınızın Developer Console'unu kontrol edin. Atama değerleri geliyorsa queen.png kök dizinde olmayabilir.
	* Eğer atama değerleri konsolda görünmüyor ve sayfa yüklenmeye devam ediyorsa tarayıcınızın JS desteğini kontrol edin.
  * Eğer sayfa yüklenmesi tamamlanmış ancak ekran ilk haliyle aynıysa yine tarayıcınızın JS desteğini kontrol edin.
	
* Başka bir sorun yaşıyorum.

	* Bunlardan hiç biri sorunu çözmediyse veya başka bir sorun yaşıyorsanız (yalnızca Apache2 için) index.php sayfasının en üstüne şu satırları ekleyip blog'umdan bana ulaşın lütfen:
    
    error_reporting(E_ALL);
    ini_set('display_errors',1);


## Kaldırma
Kurulum kadar basittir. Public dizine attığınız 3 dosyayı silmeniz yeterlidir. Portable yapıda kodlandığı için sistemde (web server log'ları dışında) data bırakmaz.


## Lisans
Bu projem GPLv3 lisansı ile koruma altına alınmıştır. Lisans metnini projedeki LICENSE dosyasında bulabilirsiniz.


## Teşekkürler
Bu projeyi başımıza musallat ederek programlamayı farklı boyutlara taşıyan çok kıymetli Yrd. Doç. Dr. Farzad KIANI'ye ve algoritmanın bitimine 5 kala tıkanan projeyi fikirleriyle sonuca taşıyan kıymetli eniştem Samet GÜZEL'e teşekkürlerin en büyüğünü borç bilirim.


## Hakkımda
Merhaba, ben Semih Kıroğlu. İstanbul Sabahattin Zaim Üniversitesi Bilgisayar Mühendisliği öğrencisiyim ve Bilişim Kulübü Yönetim Kurulu Başkanlığı görevimi sürdürüyorum.

Hakkımda daha detaylı bilgiye aşağıdaki linkten ulaşabilirsiniz (yakında).
Veya beni Google'lamanız hakkımda daha hızlı bilgiye ulaşmanızı sağlayabilir.
<a href="https://semih.kiroglu.net">https://semih.kiroglu.net</a> (bu link ismim ile soy ismim arasına @ işareti eklendiğinde bir e-posta adresine dönüşebilir, tabii protokolü mailto yaparsanız :))

Denediğiniz ve geri bildirimde bulunduğunuz için teşekkür ederim.
