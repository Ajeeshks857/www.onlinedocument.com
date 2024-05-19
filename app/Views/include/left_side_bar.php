<div class="left-side-bar">
    <div class="brand-logo">
        <a href="index.html">
            <img src="https://www.codepoints.in/static/img/logo/cp_logo.svg" alt="" class="dark-logo" />
            <img src="backend/vendors/images/deskapp-logo-white.svg" alt="" class="light-logo" />
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <li class="dropdown show">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon bi bi-house"></span><span class="mtext">Home</span>
                    </a>
                    <ul class="submenu" style="display: block;">
                        <?php if (isAdmin()): ?>
                            <li><a href="#">Documents Request</a></li>

                        <?php else: ?>
                        <li><a href="#">Documents</a></li>

                        <?php endif;?>

                    </ul>
                </li>






            </ul>
        </div>
    </div>
</div>