
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">

        <ul id="main-menu" class="nav side-menu">
            <!-- add class "multiple-expanded" to allow multiple submenus to open -->
            <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->


            <!-- DASHBOARD -->
            <li class="<?php if ($page_name == 'dashboard') echo 'active'; ?> ">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/dashboard">
                    <i class="entypo-gauge"></i>
                    <span><?php echo get_phrase('dashboard'); ?></span>
                </a>
            </li>

           <!-- STUDENT -->
            <li class="<?php
            if ($page_name == 'loan_client_add' ||
                    $page_name == 'loan_client_information' )
                echo 'opened active has-sub';
            ?> ">
                <a href="#">
                    <i class="fa fa-group"></i>
                    <span><?php echo get_phrase('Applicant Information'); ?></span><span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                    <!-- STUDENT ADMISSION -->
                    <li class="<?php if ($page_name == 'loan_client_add') echo 'active'; ?> ">
                        <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/loan_client_add">
                            <span> <?php echo get_phrase('Open Account'); ?></span>
                        </a>
                    </li>

                    <!-- STUDENT INFORMATION -->
                    <li class="<?php if ($page_name == 'loan_client_information' || $page_name == 'student_marksheet') echo 'opened active'; ?> ">
                        <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/loan_client_information">
                                 
                            <span> <?php echo get_phrase('Profile_information'); ?></span></span>
                        </a>
                        
                    </li>

                </ul>
            </li>



<!-- STUDENT -->
            <li class="<?php
            if ($page_name == 'loan_manage_newapplication' ||
                    $page_name == 'loan_manage_approveloans' )
                echo 'opened active has-sub';
            ?> ">
                <a href="#">
                     <i class="entypo-flow-tree"></i>
                    <span><?php echo get_phrase('loans_information'); ?></span><span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                    
					 <!-- LOAN APPLICATION -->
            <li class="<?php if ($page_name == 'loan_manage_newapplication') echo 'active'; ?> ">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/loan_manage_newapplication/">
                    
                    <span><?php echo get_phrase('new loan_application'); ?></span>
                </a>
            </li>


            <!-- LOAN APPROVAL -->

            <li class="<?php if ($page_name == 'loan_manage_approveloans') echo 'active'; ?> ">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/loan_manage_approveloans/<?php echo $this->session->userdata('login_user_id'); ?>">
                   
                    <span><?php echo get_phrase('loan_approval_status'); ?></span>
                </a>
            </li>

                </ul>
            </li>

          
           

           

           

            <!-- NOTICEBOARD -->
            <li class="<?php if ($page_name == 'noticeboard') echo 'active'; ?> ">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/noticeboard">
                    <i class="entypo-doc-text-inv"></i>
                    <span><?php echo get_phrase('noticeboard'); ?></span>
                </a>
            </li>

            <!-- MESSAGE -->
            <li class="<?php if ($page_name == 'message') echo 'active'; ?> ">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/message">
                    <i class="entypo-mail"></i>
                    <span><?php echo get_phrase('message'); ?></span>
                </a>
            </li>

            <!-- ACCOUNT -->
            <li class="<?php if ($page_name == 'manage_profile') echo 'active'; ?> ">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/manage_profile">
                    <i class="entypo-lock"></i>
                    <span><?php echo get_phrase('account'); ?></span>
                </a>
            </li>

        </ul>

    </div>
</div>