
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        
        <ul id="main-menu" class="nav side-menu">
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
                    $page_name == 'loan_client_information' 
                    )
                echo 'opened active has-sub';
            ?> ">
                <a href="#">
                    <i class="entypo-users"></i>
                    <span><?php echo get_phrase('Manage Clients'); ?></span><span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                    <!-- STUDENT ADMISSION -->
                    <li class="<?php if ($page_name == 'loan_client_add') echo 'active'; ?> ">
                        <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/loan_client_add">
                            <span> <?php echo get_phrase('New Client Account'); ?></span>
                        </a>
                    </li>
					
				<li class="<?php if ($page_name == 'loan_client_information') echo 'active'; ?> ">
					<a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/loan_client_information">
						<span> <?php echo get_phrase(' Clients information'); ?></span>
					</a>
				</li>


                </ul>
            </li>

            
			
			 <!-- STUDENT -->
            <li class="<?php
            if ($page_name == 'loan_officer' )
                echo 'opened active has-sub';
            ?> ">
                <a href="#">
                    <i class="entypo-users"></i>
                    <span><?php echo get_phrase('Manage Staff'); ?></span><span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                    
					
				<!-- OFFICERS -->
            <li class="<?php if ($page_name == 'loan_officer') echo 'active'; ?> ">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/loan_officer">
                    <i class="entypo-users"></i>
                    <span><?php echo get_phrase('Loan Officers'); ?></span>
                </a>
            </li>


                </ul>
            </li>
			

            

            
           
            <!-- LOAN PAGE -->
            <li class="<?php
            if ($page_name == 'loan_manage_newapplication' ||
                    $page_name == 'loan_manage_approveloans'|| $page_name == 'loan_manage_historypayments' || $page_name == 'loan_manage_makepayments_files')
                echo 'opened active';
            ?> ">
                <a href="#">
                    <i class="entypo-flow-tree"></i>
                    <span><?php echo get_phrase('manage_loans'); ?></span><span class="fa fa-chevron-down"></span>
                </a>
                <ul class="nav child_menu">
                    <li class="<?php if ($page_name == 'loan_manage_newapplication') echo 'active'; ?> ">
                        <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/loan_manage_newapplication">
                            <span> <?php echo get_phrase('new_loan_application'); ?></span>
                        </a>
                    </li>
                    <li class="<?php if ($page_name == 'loan_manage_approveloans') echo 'active'; ?> ">
                        <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/loan_manage_approveloans">
                            <span> <?php echo get_phrase('manage_loan_approvals'); ?></span>
                        </a>
                    </li>
					
					<li class="<?php if ($page_name == 'loan_manage_makepayments_files') echo 'active'; ?> ">
					<a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/loan_manage_makepayments_files">
					
					<span><?php echo get_phrase('loan_payments'); ?></span>
					</a>
				</li>
					
					<li class="<?php if ($page_name == 'loanpayhistory') echo 'active'; ?> ">
                        <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/loan_manage_historypayments">
                            <span> <?php echo get_phrase('loan_payments_history'); ?></span>
                        </a>
                    </li>
					
                </ul>
            </li>



			<!-- SETTINGS -->
            <li class="<?php
            if ($page_name == 'loan_reports_daily' ||
                    $page_name == 'loan_reports_daily' ||
                    $page_name == 'loan_reports_daily' || $page_name == 'loan_reports_daily')
                echo 'opened active';
            ?> ">
                <a href="#">
                    <i class="fa fa-gear"></i>
                    <span><?php echo get_phrase('Loan_reports'); ?></span><span class="fa fa-chevron-down"></span>
                
				</a>
                <ul class="nav child_menu">
                    <li class="<?php if ($page_name == 'loan_reports_daily') echo 'active'; ?> ">
                        <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/loan_reports_daily">
                            <span> <?php echo get_phrase('Daily_reports'); ?></span>
                        </a>
                    </li>
                  
					
                </ul>
            </li>



			

           
            <!-- MESSAGE -->
            <li class="<?php if ($page_name == 'message') echo 'active'; ?> ">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/message">
                    <i class="entypo-mail"></i>
                    <span><?php echo get_phrase('messages'); ?></span>
                </a>
            </li>
			
			<!-- NOTICEBOARD -->
            <li class="<?php if ($page_name == 'noticeboard') echo 'active'; ?> ">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/noticeboard">
                    <i class="entypo-doc-text-inv"></i>
                    <span><?php echo get_phrase('noticeboard'); ?></span>
                </a>
            </li>

            <!-- SETTINGS -->
            <li class="<?php
            if ($page_name == 'system_settings' ||
                    $page_name == 'manage_language' ||
                    $page_name == 'sms_settings' || $page_name == 'loan_settings')
                echo 'opened active';
            ?> ">
                <a href="#">
                    <i class="fa fa-gear"></i>
                    <span><?php echo get_phrase('system_settings'); ?></span><span class="fa fa-chevron-down"></span>
                
				</a>
                <ul class="nav child_menu">
                    <li class="<?php if ($page_name == 'system_settings') echo 'active'; ?> ">
                        <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/system_settings">
                            <span> <?php echo get_phrase('general_settings'); ?></span>
                        </a>
                    </li>
                    <li class="<?php if ($page_name == 'sms_settings') echo 'active'; ?> ">
                        <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/sms_settings">
                            <span> <?php echo get_phrase('sms_settings'); ?></span>
                        </a>
                    </li>
                    <li class="<?php if ($page_name == 'manage_language') echo 'active'; ?> ">
                        <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/manage_language">
                            <span> <?php echo get_phrase('language_settings'); ?></span>
                        </a>
                    </li>
					
					<li class="<?php if ($page_name == 'loan_settings') echo 'active'; ?> ">
                        <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/loan_settings">
                            <span> <?php echo get_phrase('loan_settings'); ?></span>
                        </a>
                    </li>
					
                </ul>
            </li>




           

            <!-- ACCOUNT -->
            <li class="<?php if ($page_name == 'manage_profile') echo 'active'; ?> ">
                <a href="<?php echo base_url(); ?>index.php?<?php echo $account_type; ?>/manage_profile">
                    <i class="entypo-lock"></i>
                    <span><?php echo get_phrase('manage_account'); ?></span>
                </a>
            </li>

        </ul>                
    </div>
</div>
