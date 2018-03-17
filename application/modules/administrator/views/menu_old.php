<?php 

$menuShow = (!$this->ion_auth->is_admin()) ? 'style="display:none;"' : '';

 ?>


<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
	<div class="menu_section">
	<ul class="nav side-menu">
		<li>
			<a href="<?= base_url() ?>administrator"><i class="fa fa-home"></i> Home</a>
		</li>
		<li><a><i class="fa fa-users"></i> Users <span class="fa fa-chevron-down"></span></a>
			<ul class="nav child_menu">
				<li <?= $menuShow ?> ><a href="<?= base_url() ?>administrator/new_user">New User</a></li>
				<li><a href="<?= base_url() ?>administrator/all_users">All User</a></li>
				<li <?= $menuShow ?> ><a href="<?= base_url() ?>administrator/all_dph">All DPH</a></li>
			</ul>
		</li>
		<li><a><i class="fa fa-edit"></i> Post <span class="fa fa-chevron-down"></span></a>
			<ul class="nav child_menu">
				<li><a href="<?= base_url() ?>administrator/new_post">New Post</a></li>
				<li><a href="<?= base_url() ?>administrator/all_post">All Post</a></li>
				<li <?= $menuShow ?> ><a href="<?= base_url() ?>administrator/all_category">All Category</a></li>
			</ul>
		</li>
		<li <?= $menuShow ?> ><a><i class="fa fa-image"></i> Slider <span class="fa fa-chevron-down"></span></a>
			<ul class="nav child_menu">
				<li><a href="<?= base_url() ?>administrator/new_slider">New Slider</a></li>
				<li><a href="<?= base_url() ?>administrator/all_slider">All Slider</a></li>
			</ul>
		</li>
		<li <?= $menuShow ?> ><a><i class="fa fa-bars"></i> Menu <span class="fa fa-chevron-down"></span></a>
			<ul class="nav child_menu">
				<li><a href="<?= base_url() ?>administrator/new_menu">New Menu</a></li>
				<li><a href="<?= base_url() ?>administrator/all_menu">All Menu</a></li>
			</ul>
		</li>

		<!-- Profile kebawah -->
		<li <?= $menuShow ?> ><a><i class="fa fa-folder-open"></i> Profile <span class="fa fa-chevron-down"></span></a>
			<ul class="nav child_menu">
				<li><a href="<?= base_url() ?>administrator/new_profiles">New Profile</a></li>
				<li><a href="<?= base_url() ?>administrator/all_profiles">All Profile</a></li>
			</ul>
		</li>

		<!-- Wilayah dan Lingkungan -->
		<li <?= $menuShow ?> ><a><i class="fa fa-archive"></i> Wilayah & Lingkungan <span class="fa fa-chevron-down"></span></a>
			<ul class="nav child_menu">
				<li><a href="<?= base_url() ?>administrator/new_wilayah">New Wilayah</a></li>
				<li><a href="<?= base_url() ?>administrator/all_wilayah">All Wilayah</a></li>
			</ul>
		</li>

		<!-- Seksi - Seksi -->
		<li <?= $menuShow ?> ><a><i class="fa fa-th-list"></i> Seksi-Seksi <span class="fa fa-chevron-down"></span></a>
			<ul class="nav child_menu">
				<li><a href="<?= base_url() ?>administrator/new_seksi">New Seksi</a></li>
				<li><a href="<?= base_url() ?>administrator/all_seksi">All Seksi</a></li>
			</ul>
		</li>

		<!-- KELOMPOK KATEGORIAL -->
		<li <?= $menuShow ?> ><a><i class="fa fa-list-alt"></i> Kelompok Kategorial <span class="fa fa-chevron-down"></span></a>
			<ul class="nav child_menu">
				<li><a href="<?= base_url() ?>administrator/new_kategorial">New Kelompok Kategorial</a></li>
				<li><a href="<?= base_url() ?>administrator/all_kategorial">All Kelompok Kategorial</a></li>
			</ul>
		</li>

		
		<li <?= $menuShow ?> >
			<a href="<?= base_url() ?>administrator/options"><i class="fa fa-gear"></i> Setting</a>
		</li>
	</ul>
	</div>
</div>