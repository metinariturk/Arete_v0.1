;; Phi karakterlerini 'Q' ile değiştiren yardımcı fonksiyon
(defun clean-phi-symbols (txt / replaceList result)
  ;; Çap ve phi benzeri özel karakterleri "Q" ile değiştir
  (setq replaceList
    '(
      ("Φ" . "Q") ; Φ (Büyük harf Phi)
      ("∅" . "Q") ; ∅ (Boş Küme Sembolü)
      ("Ø" . "Q") ; Ø (Sıfır Çizgisi, Danca/Norveççe O)
      ("ø" . "Q") ; ø (Küçük harf Sıfır Çizgisi)
      ("⌀" . "Q") ; ⌀ (Çap Sembolü)
      ("ƒ" . "Q") ; ƒ (F-hook, bazen çap yerine kullanılır)
      ("%%c" . "Q") ; AutoCAD çap kodu
      ("%%f" . "Q") ; AutoCAD fi kodu
	  ("ƒ" . "Q") ; AutoCAD fi kodu
      ;; Unicode kaçış dizilerini de tekrar ekleyelim, daha geniş kapsama için
      ("\\U+03A6" . "Q") ; Unicode Φ
      ("\\U+2205" . "Q") ; Unicode ∅
      ("\\U+00D8" . "Q") ; Unicode Ø
      ("\\U+00F8" . "Q") ; Unicode ø
      ("\\U+2300" . "Q") ; Unicode ⌀
      ("\\U+0192" . "Q") ; Unicode ƒ (F-hook)
      ("??" . "Q") ; Bozuk karakterler için son çare
    )
  )
  (setq result txt)
  (foreach pair replaceList
    (setq result (vl-string-subst (cdr pair) (car pair) result))
  )
  result
)

;; Bir listenin son elemanı hariç tüm elemanlarını döndüren yardımcı fonksiyon
(defun butlast (lst)
 (reverse (cdr (reverse lst)))
)

(defun draw-center-line (pt height len / midY halfLen p1 p2)
 ;; Yazının ortasına çizgi çizer
 (if (and pt height len)
  (progn
   (setq midY (+ (cadr pt) (/ height 2.5))) ; yukarıda ortalama bir noktaya çeker
   (setq halfLen (/ len 2.0))
   (setq p1 (list (- (car pt) halfLen) midY))
   (setq p2 (list (+ (car pt) halfLen) midY))
   (command "._LINE" p1 p2 "")
  )
  (prompt "\n[Uyari] Cizgi icin eksik veri.")
 )
)

(defun c:TextToCSV ( / dwgName csvPath csvFile done txt txtGroup entData content
            insPt txtHeight txtLength rot processedTxtGroup csvLine )

 ;; Dosya yolu oluştur
 (setq dwgName (vl-filename-base (getvar "DWGNAME")))
 (setq csvPath (strcat (getenv "USERPROFILE") "\\Desktop\\" dwgName ".csv"))
 (setq csvFile (open csvPath "a"))

 ;; Dosya açılamadıysa uyar
 (if (not csvFile)
  (progn
   (alert (strcat "CSV dosyasina yazilamiyor:\n\n" csvPath "\n\nMuhtemelen Excel’de acik."))
   (exit)
  )
 )

 (princ "\nYazi secmeye baslayin. SPACE ile yeni satira gecin, ESC ile cik.")
 (setq done nil)

 (while (not done)
  (setq txtGroup '())
  (setq lineDone nil)

  ;; Her satır için
  (while (not lineDone)
   (setq txt (entsel "\nYazi secin (SPACE ile satiri tamamlayin): "))

   (if txt
    (progn
     (setq entData (entget (car txt)))
     (if (member (cdr (assoc 0 entData)) '("TEXT" "MTEXT"))
      (progn
       (setq content (vl-string-trim " " (cdr (assoc 1 entData))))
       (setq content (clean-phi-symbols content))
       (if (not (equal content ""))
        (progn
         (setq txtGroup (append txtGroup (list content)))

         ;; Rengi beyaz yap
         (if (assoc 62 entData)
          (setq entData (subst (cons 62 7) (assoc 62 entData) entData))
          (setq entData (append entData (list (cons 62 7))))
         )
         (entmod entData)
         (entupd (car txt))

         ;; Koordinat ve uzunluk
         (setq insPt (cdr (assoc 10 entData)))
         (setq txtHeight (cond ((cdr (assoc 40 entData))) (1.0)))
         (setq txtLength (* (strlen content) (* txtHeight 0.65)))

         ;; Ortadan kırmızı çizgi
         (draw-center-line insPt txtHeight txtLength)
        )
       )
      )
      (princ "\nSadece TEXT veya MTEXT secilebilir.")
     )
    )
    (progn
     ;; SPACE ile satır bitti
     (if (null txtGroup)
      (setq done t)
      (princ "\nSatir tamamlandi. Yeni satir icin yazilari secin.")
     )
     (setq lineDone t)
    )
   )
  )

  ;; CSV'ye satır yaz (DOSYA KAPATILMADAN ÖNCE!)
  (if (> (length txtGroup) 0)
   (progn
    (setq csvLine "") ; CSV satırını oluşturmak için boş bir string başlat
    (setq firstItem T) ; İlk öğe bayrağı

    (foreach str txtGroup
      ;; Her stringi CSV kuralına göre formatla:
      ;; 1. İçindeki çift tırnakları ikiye katla (örn: " -> "")
      ;; 2. Sonucu çift tırnak içine al (örn: değer -> "değer")
      (setq cleaned-str (vl-string-subst "\"\"" "\"" str)) ; String içindeki tırnakları ikiye katla
      (setq quoted-str (strcat "\"" cleaned-str "\"")) ; Tamamını tırnak içine al

      (if firstItem
        (progn
          (setq csvLine quoted-str) ; İlk öğeyi doğrudan ata
          (setq firstItem nil) ; Bayrağı sıfırla
        )
        (setq csvLine (strcat csvLine "," quoted-str)) ; Sonraki öğeleri virgül ile ekle
      )
    )
    (write-line csvLine csvFile) ; Oluşturulan satırı dosyaya yaz
   )
  )
 ) ; Dış döngü sonu

 (close csvFile) ;; Dosyayı burada kapat
 (princ (strcat "\nCSV dosyasina yazildi: " csvPath))
 (princ)
)

;; Yardımcı fonksiyon: Bir listenin elemanlarını belirtilen ayraçla birleştirir
;; Bu fonksiyon artık doğrudan kullanılmıyor, ancak tanımını bırakıyorum.
(defun intersperse (lst sep / result)
  (setq result '())
  (while lst
    (setq result (append result (list (car lst))))
    (setq lst (cdr lst))
    (if lst (setq result (append result (list sep))))
  )
  result
)

;; Yeni komut: Mevcut CSV dosyasını siler ve belirtilen adım kadar UNDO uygular.
(defun c:ResetTextToCSV ( / dwgName csvPath fileHandle)
 (setq dwgName (vl-filename-base (getvar "DWGNAME")))
 (setq csvPath (strcat (getenv "USERPROFILE") "\\Desktop\\" dwgName ".csv"))

 ;; CSV dosyasını silme denemesi
 (if (findfile csvPath)
  (progn
   ;; Dosyanın kilitli olup olmadığını kontrol et
   (setq fileHandle (open csvPath "w")) ; Yazma modunda açmaya çalış
   (if fileHandle
    (progn
     (close fileHandle) ; Başarılı olursa hemen kapat
     (vl-file-delete csvPath)
     (princ (strcat "\nCSV dosyası silindi: " csvPath))
    )
    (alert (strcat "CSV dosyası silinemiyor:\n\n" csvPath "\n\nMuhtemelen Excel gibi başka bir programda açık. Lütfen dosyayı kapatın ve tekrar deneyin."))
   )
  )
  (princ (strcat "\nCSV dosyası bulunamadı: " csvPath))
 )

 ;; 1500 adımlık UNDO uygula
 (command "._UNDO" 1500) ; Varsayılan UNDO modunda 1500 adım geri al
 (princ "\n1500 adım UNDO uygulandı.")

 (princ) ; Komutu temiz bitir
)