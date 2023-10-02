<div class="email-app-sidebar left-bookmark">
    <div class="media">
        <div class="media-size-email"><img class="me-3 rounded-circle"
                <?php echo get_avatar($user->id); ?> alt="">
        </div>
        <div class="media-body">
            <h6 class="f-w-600"><?php echo full_name($user->id); ?></h6>
            <p><?php echo $user->unvan; ?></p>
        </div>
    </div>
    <ul class="nav main-menu contact-options" role="tablist">
        <li class="nav-item">
            <a href="<?php echo base_url("user/new_form"); ?>" class="badge-light-primary btn-block btn-mail w-100" type="button">
                <i class="me-2" data-feather="users"></i>
                Yeni Kullanıcı
            </a>
        </li>
        <li class="nav-item"><span class="main-title"> Gruplar</span></li>
        <li><a id="pills-personal-tab" data-bs-toggle="pill" href="#pills-personal"
               role="tab" aria-controls="pills-personal" aria-selected="true"><span
                        class="title"> Tüm Kişiler</span></a></li>
        <?php foreach ($user_roles as $user_role) { ?>
            <li><a class="show" id="pills-<?php echo $user_role->id; ?>-tab" data-bs-toggle="pill"
                   href="#pills-<?php echo $user_role->id; ?>" role="tab" aria-controls="pills-<?php echo $user_role->id; ?>"
                   aria-selected="false"><span class="title"> <?php echo $user_role->title; ?></span></a></li>
        <?php } ?>
    </ul>
</div>
