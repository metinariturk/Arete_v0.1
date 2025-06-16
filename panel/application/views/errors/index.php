
    <?php $this->load->view("includes/head"); ?>

    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #667eea;
            background-image: url('https://www.transparenttextures.com/patterns/diagmonds.png');
            background-repeat: repeat;
            background-size: auto;
            background-position: top left;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: white;
        }

        .error-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            text-align: center;
            padding: 30px;
            background: rgba(0, 0, 0, 0.3); /* Hafif cam efekti */
            backdrop-filter: blur(8px); /* Cam efekti için bulanıklık */
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            margin: 20px;
        }

        .error-wrapper {
            min-height: calc(100vh - 40px); /* Alternatif */
            margin: 0; /* margin kaldır */
            padding: 40px 20px; /* içeriden boşluk ver */
        }

        .error-heading img {
            max-width: 300px;
            margin-bottom: 20px;
        }

        .btn-info-gradien {
            margin-top: 20px;
            padding: 12px 24px;
            font-size: 1.1rem;
            border-radius: 50px;
            background: linear-gradient(135deg, #42a5f5, #478ed1);
            border: none;
            color: white;
            transition: all 0.3s ease-in-out;
        }

        .btn-info-gradien:hover {
            transform: scale(1.05);
            background: linear-gradient(135deg, #478ed1, #42a5f5);
        }

        @media (max-width: 768px) {
            .error-wrapper {
                margin: 10px;
                padding: 20px;
            }

            .error-heading img {
                max-width: 200px;
            }

            .btn-info-gradien {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<div class="page-body-wrapper">
    <div class="page-body">
        <!-- page-wrapper Start-->
        <div class="page-wrapper compact-wrapper" id="pageWrapper">
            <!-- error-404 start-->
            <div class="error-wrapper">
                <img class="img-100" src="<?php echo base_url(); ?>/assets/images/other-images/sad.png" alt="Üzgün Yüz">

                <div class="error-heading">
                    <h3><img src="<?php echo base_url(); ?>/assets/images/logo/login.png" alt="Logo"></h3>
                </div>

                <h3> <?php echo "İşlem sırasında bir hata oluştu"; ?></h3>
                <div>
                    <a class="btn btn-info-gradien btn-lg" href="<?php echo base_url(); ?>">
                       Ana Sayfaya Dön
                    </a>
                    <a class="btn btn-info-gradien btn-lg" href="<?php echo base_url("Contract"); ?>">
                        Sözleşmelere Dön
                    </a>
                    <a class="btn btn-info-gradien btn-lg" href="<?php echo base_url("Site"); ?>">
                        Şantiyelere Dön
                    </a>
                    <a class="btn btn-info-gradien btn-lg" href="<?php echo base_url("Project"); ?>">
                        Projelere Dön
                    </a>

                </div>
            </div>
            <!-- error-404 end-->
        </div>
    </div>
</div>
</body>
</html>
