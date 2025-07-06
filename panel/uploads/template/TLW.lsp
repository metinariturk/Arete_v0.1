

(defun C:TLW(/ ss tl n ent itm obj l insertionPoint mtextobj totalInsertionPoint)
  (setq ss (ssget)
        tl 0
        n (1- (sslength ss)))

  (if ss
    (progn
      (while (>= n 0)
        (setq ent (entget (setq itm (ssname ss n)))
              obj (cdr (assoc 0 ent))
              l (cond
                  ((= obj "LINE")
                   (distance (cdr (assoc 10 ent))(cdr (assoc 11 ent))))
                  ((= obj "ARC")
                   (* (cdr (assoc 40 ent))
                      (if (minusp (setq l (- (cdr (assoc 51 ent))
                                             (cdr (assoc 50 ent)))))
                        (+ pi pi l) l)))
                  ((or (= obj "CIRCLE") (= obj "SPLINE") 
                       (= obj "POLYLINE") (= obj "LWPOLYLINE") 
                       (= obj "ELLIPSE"))
                   (command "_.area" "_o" itm)
                   (getvar "perimeter"))
                  (T 0))
              )

        ;; Her nesnenin uzunlu�unu yaz
        (if (and l (> l 0)) ; Uzunlu�u kontrol et
          (progn
            ;; Her nesne i�in yazma noktas� belirle
            (setq insertionPoint (vlax-3D-Point (trans (cdr (assoc 10 ent)) 1 0)))
            (setq l (/ l 100.0))  ; Uzunlu�u cm'den m'ye d�n��t�r
            (setq mtextobj (vla-addMText (vla-get-modelspace (vla-get-ActiveDocument (vlax-get-acad-object)))
                                          insertionPoint
                                          0.0
                                          (strcat "L = " (rtos l 2 2) " m"))) ; "Length" yerine "L =" kullan�ld�
            (vla-put-AttachmentPoint mtextobj 5) ; Metnin konumunu ayarla
          )
        )

        (setq tl (+ tl l)
              n (1- n)))

      ;; Toplam uzunlu�u kullan�c�dan nokta alarak yazd�r
      (setq totalInsertionPoint (getpoint "\nToplam uzunlu�u yazmak i�in bir nokta se�in: "))
      (setq tl (/ tl 100.0))  ; Toplam uzunlu�u cm'den m'ye d�n��t�r
      (vla-addMText (vla-get-modelspace (vla-get-ActiveDocument (vlax-get-acad-object)))
                    (vlax-3D-Point totalInsertionPoint)
                    0.0
                    (strcat "Toplam uzunluk: " (rtos tl 2 2) " m"))) ; Toplam uzunlu�u virg�lden sonra 2 basamak olarak g�sterir.

    (progn
      (alert "Hi�bir nesne se�ilmedi.")
    ))

  (princ)
)
