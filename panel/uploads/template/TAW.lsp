
;;; Set up the area in square meters
(setq jtbfieldformula ">%).Area \\f \"%lu2%pr2%ct8%qf1 m²\">%")

(defun Get-ObjectIDx64 (obj / util)
  (setq util (vla-get-Utility
               (vla-get-activedocument (vlax-get-acad-object))))
  (if (= (type obj) 'ENAME)
    (setq obj (vlax-ename->vla-object obj)))
  (if (= (type obj) 'VLA-OBJECT)
    (if (> (vl-string-search "x64" (getvar "platform")) 0)
      (vlax-invoke-method util "GetObjectIdString" obj :vlax-False)
      (rtos (vla-get-objectid obj) 2 0))))

(defun c:TAW (/ ss1 nr tot_area ent entObject entObjectID InsertionPoint ad minExt maxExt en mtextobj totalInsertionPoint area_text)
  (vl-load-com)
  (if (setq ss1 (ssget '((-4 . "<OR") (0 . "POLYLINE") (0 . "LWPOLYLINE") (0 . "CIRCLE") (0 . "ELLIPSE") (0 . "SPLINE") (0 . "REGION") (-4 . "OR>"))))
    (progn
      (setq nr 0 tot_area 0.0 en (ssname ss1 nr))
      (while en
        (setq entObject (vlax-ename->vla-object en)
              entObjectID (Get-ObjectIDx64 entObject)
              ad (vla-get-ActiveDocument (vlax-get-acad-object)))
        (vla-GetBoundingBox entObject 'minExt 'maxExt)
        (setq minExt (vlax-safearray->list minExt)
              maxExt (vlax-safearray->list maxExt)
              InsertionPoint (vlax-3D-Point (list (/ (+ (car minExt) (car maxExt)) 2)
                                                 (/ (+ (cadr minExt) (cadr maxExt)) 2)
                                                 (/ (+ (caddr minExt) (caddr maxExt)) 2))))
        ;; Her nesnenin alanýný cm² olarak alýp 10,000’e bölerek m²'ye çeviriyoruz
        (command "._area" "_O" en)
        (setq area_text (strcat (rtos (/ (getvar "area") 10000.0) 2 2) " m²"))
        ;; Her çokgenin alanýný m² olarak gösteren mtext ekliyoruz
        (setq mtextobj (vla-addMText (if (= 1 (vla-get-activespace ad)) (vla-get-modelspace ad) (vla-get-paperspace ad))
                                     InsertionPoint
                                     0.0
                                     area_text))
        (vla-put-AttachmentPoint mtextobj 5)
        (vla-put-insertionPoint mtextobj InsertionPoint)
        ;; Toplam alaný da m² cinsinden topluyoruz
        (setq tot_area (+ tot_area (/ (getvar "area") 10000.0)))
        (setq nr (1+ nr) en (ssname ss1 nr)))
      ;; Toplam alaný kullanýcý tarafýndan iþaretlenen yere yazdýrma
      (setq totalInsertionPoint (getpoint "\nToplam alaný yazmak için bir nokta seçin: "))
      (vla-addMText (if (= 1 (vla-get-activespace ad)) (vla-get-modelspace ad) (vla-get-paperspace ad))
                    (vlax-3D-Point totalInsertionPoint)
                    0.0
                    (strcat "Toplam Alan = " (rtos tot_area 2 2) " m²"))))
  (princ))


(princ)
