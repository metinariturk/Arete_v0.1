<style>
     .form-switch .form-check-input {
         width: 4em;
         height: 2em;
     }

     .project-info {
         font-family: Arial, sans-serif;
         line-height: 1.5;
         margin-bottom: 20px;
     }

     .info-header {
         margin-bottom: 10px;
     }

     .info-header h5 {
         font-size: 1.2rem;
         font-weight: bold;
         color: #333;
     }

     .info-header small.status {
         color: #777;
     }

     .status .badge {
         padding: 5px 10px;
         font-size: 0.9rem;
         border-radius: 5px;
     }

     .company-name {
         font-size: 1.1rem;
         margin-bottom: 8px;
         color: #444;
     }

     .site-info span {
         font-size: 1rem;
         margin-right: 10px;
     }
     
    .card-body {
        position: relative; /* Bu satırı ekleyin (eğer yoksa) */
        padding: 4px; /* veya mevcut padding değeriniz */
    }
    .dropdown {
        position: absolute; /* Ebeveyni .card-body'ye göre konumlanır */
        top: 15px;          /* Kartın üst kenarından 15px aşağı */
        right: 15px;        /* Kartın sağ kenarından 15px içeri */
        left: auto;         /* Sol konumlandırmayı iptal eder */
        z-index: 10;        /* Diğer içeriklerin üzerinde görünmesini sağlar */
    }

    /* Dropdown menüsünün kendisi (menünün sağa açılması için) */
    .dropdown-menu {
        position: absolute; /* Butonun ebeveyni olan .dropdown'a göre konumlanır */
        top: 100%;          /* Butonun hemen altına */
        right: 0;           /* Butonun sağ kenarına hizalanır */
        left: auto;         /* Sol hizalamayı iptal eder */
        z-index: 1000;      /* Diğer elementlerin üzerinde görünmesini sağlar */
    }

    /* Nokta ikonu içeren buton */
    .light-square {
        /* Bu div'in display özelliği önemli olabilir */
        /* Varsayılan olarak block olabilir, bunu inline-block veya flex yapmayı deneyin */
        display: inline-block;
        cursor: pointer;
    }
</style>
