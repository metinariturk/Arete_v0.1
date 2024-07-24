<!DOCTYPE html>
<html lang="en">
<head>
    <?php $this->load->view("includes/head"); ?>
    <?php $this->load->view("{$viewFolder}/common/page_style"); ?>
    <style>
        /* Genel ayarlar ve temalar */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .todo-list-wrapper {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .todo-list-container {
            padding: 20px;
        }

        .mark-all-tasks {
            text-align: right;
        }

        .mark-all-tasks button {
            border: none;
            background: none;
            cursor: pointer;
            color: #d9534f;
            font-size: 16px;
            display: flex;
            align-items: center;
        }

        .todo-list-body {
            margin-top: 20px;
        }

        /* Sayma özelliği ekleme */
        #todo-list {
            list-style: none;
            padding: 0;
            counter-reset: task-counter;
        }

        .task {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #e9e9e9;
            counter-increment: task-counter;
        }

        .task:last-child {
            border-bottom: none;
        }

        .task::before {
            content: counter(task-counter) ". ";
            font-weight: bold;
            margin-right: 10px;
        }

        .task.completed .task-label {
            text-decoration: line-through;
            color: #bbb;
        }

        .task-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .task-label {
            font-size: 16px;
            flex-grow: 1;
        }

        .task-action-btn button {
            border: none;
            background: none;
            cursor: pointer;
            color: #d9534f;
            font-size: 14px; /* Daha küçük font boyutu */
            display: flex;
            align-items: center;
            padding: 5px 8px; /* Daha küçük padding */
            width: 70px; /* Genişliği %70 olarak ayarla */
            justify-content: center;
        }

        .task-action-btn button i {
            margin-right: 5px;
        }

        #task_form {
            display: flex;
            margin-top: 20px;
        }

        #new_task {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 10px;
        }

        button.btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button.btn:hover {
            background-color: #0056b3;
        }

        button.btn-outline-danger {
            border: 1px solid #d9534f;
            color: #d9534f;
            background: none;
            padding: 5px 10px;
            border-radius: 4px;
            display: flex;
            align-items: center;
        }

        button.btn-outline-danger:hover {
            background-color: #d9534f;
            color: #fff;
        }

        button.btn-pill {
            border-radius: 50px;
        }

        button.btn-air-danger {
            background-color: rgba(217, 83, 79, 0.2);
        }

    </style>

</head>
<body onload="startTime()" class="<?php echo ($this->Theme_mode == 1) ? "dark-only" : ""; ?>">
<div class="loader-wrapper">
    <div class="loader-index"><span></span></div>
    <svg>
        <defs></defs>
        <filter id="goo">
            <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
            <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo"></fecolormatrix>
        </filter>
    </svg>
</div>
<div class="tap-top"><i data-feather="chevrons-up"></i></div>
<div class="page-wrapper compact-wrapper" id="pageWrapper">
    <div class="page-header">
        <div class="header-wrapper row m-0">
            <?php $this->load->view("includes/navbar_left"); ?>
        </div>
    </div>
    <div class="page-body-wrapper">
        <?php $this->load->view("includes/aside"); ?>
        <div class="page-body">

            <?php $this->load->view("{$viewFolder}/{$subViewFolder}/content"); ?>
        </div>
        <?php $this->load->view("includes/footer"); ?>
    </div>
</div>
<?php $this->load->view("includes/include_script"); ?>
<?php $this->load->view("{$viewFolder}/common/page_script"); ?>
<?php $this->load->view("includes/include_form_script"); ?>

</body>
</html>

