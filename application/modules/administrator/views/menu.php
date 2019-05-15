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
		
		<!--Berita-->
		<li <?= $menuShow ?> ><a><i class="fa fa-edit"></i> Post <span class="fa fa-chevron-down"></span></a>
			<ul class="nav child_menu">
				<li><a href="<?= base_url() ?>administrator/new_post/index">New Post</a></li>
				<li><a href="<?= base_url() ?>administrator/all_post">All Post</a></li>
				<li <?= $menuShow ?> ><a href="<?= base_url() ?>administrator/all_category">All Category</a></li>
			</ul>
		</li>
		
		<!--e-Magazine-->
		<li <?= $menuShow ?> ><a><i class="fa fa-newspaper-o"></i> e-Magazine <span class="fa fa-chevron-down"></span></a>
			<ul class="nav child_menu">
				<li><a href="<?= base_url() ?>administrator/new_emagz/index">New e-Magazine</a></li>
				<li><a href="<?= base_url() ?>administrator/all_emagz">All e-Magazine</a></li>
				<li <?= $menuShow ?> ><a href="<?= base_url() ?>administrator/all_category">All Category</a></li>
			</ul>
		</li>
		
		<!-- Halaman -->
		<li <?= $menuShow ?> ><a><i class="fa fa-file-o"></i> Halaman <span class="fa fa-chevron-down"></span></a>
			<ul class="nav child_menu">
				<li><a href="<?= base_url() ?>administrator/new_page">New Halaman</a></li>
				<li><a href="<?= base_url() ?>administrator/all_page">All Halaman</a></li>
			</ul>
		</li>

		<!-- Profile kebawah -->
		<li <?= $menuShow ?> ><a><i class="fa fa-folder-open"></i> Profile <span class="fa fa-chevron-down"></span></a>
			<ul class="nav child_menu">
				<li><a href="<?= base_url() ?>administrator/new_profiles">New Profile</a></li>
				<li><a href="<?= base_url() ?>administrator/all_profiles">All Profile</a></li>
			</ul>
		</li>

    	<!-- KAJ -->
		<li <?= $menuShow ?> ><a><i class="fa fa-file"></i> KAJ <span class="fa fa-chevron-down"></span></a>
			<ul class="nav child_menu">
				<li><a href="<?= base_url() ?>administrator/new_kaj">New KAJ</a></li>
				<li><a href="<?= base_url() ?>administrator/all_kaj">All KAJ</a></li>
			</ul>
		</li>
		
		<?php if (1==2) : ?>
			<!-- Wilayah dan Lingkungan -->
			<li <?= $menuShow ?> ><a><i class="fa fa-archive"></i> Wilayah & Lingkungan <span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu">
					<li><a href="<?= base_url() ?>administrator/new_wilayah">New Wilayah</a></li>
					<li><a href="<?= base_url() ?>administrator/all_wilayah">All Wilayah</a></li>
				</ul>
			</li>
		<?php endif; ?>

		<!-- Wilayah -->
		<li <?= $menuShow ?> ><a><i class="fa fa-archive"></i> Wilayah <span class="fa fa-chevron-down"></span></a>
			<ul class="nav child_menu">
				<li><a href="<?= base_url() ?>administrator/new_new_wilayah">New Wilayah</a></li>
				<li><a href="<?= base_url() ?>administrator/all_new_wilayah">All Wilayah</a></li>
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
		
		<!-- Pelayanan -->
		<li <?= $menuShow ?> ><a><i class="fa fa-qq"></i> Pelayanan <span class="fa fa-chevron-down"></span></a>
			<ul class="nav child_menu">
				<li><a href="<?= base_url() ?>administrator/new_pelayanan">New Pelayanan</a></li>
				<li><a href="<?= base_url() ?>administrator/all_pelayanan">All Pelayanan</a></li>
			</ul>
		</li>		


		<li <?= $menuShow ?> >
			<a href="<?= base_url() ?>administrator/options"><i class="fa fa-gear"></i> Setting</a>
		</li>
	</ul>
	</div>
</div>
