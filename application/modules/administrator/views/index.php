<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin Area</title>

    <!-- Bootstrap -->
    <link href="<?= base_url() ?>assets/admin/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?= base_url() ?>assets/admin/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- jVectorMap -->
    <link href="<?= base_url() ?>assets/admin/css/maps/jquery-jvectormap-2.0.3.css" rel="stylesheet"/>
  <!-- Datatables -->
    <link href="<?= base_url() ?>assets/admin/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/admin/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/admin/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/admin/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/admin/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
  <!-- Dropzone.js -->
    <link href="<?= base_url() ?>assets/admin/dropzone/dist/min/dropzone.min.css" rel="stylesheet">
  <!-- bootstrap-wysiwyg -->
    <link href="<?= base_url() ?>assets/admin/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
  
    <!-- Custom Theme Style -->
    <link href="<?= base_url() ?>assets/admin/css/custom.min.css" rel="stylesheet">

    <!-- Sweet alert -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/admin/sweetalert2/sweetalert2.min.css">
    <!-- Sweet Alert -->
    <script src="<?= base_url() ?>assets/admin/sweetalert2/sweetalert2.min.js"></script>
    <!-- jQuery -->
    <script src="<?= base_url() ?>assets/admin/jquery/dist/jquery.min.js"></script>

    <style type="text/css">
      .select2-container--default {
        width: 100% !important;
      }
    </style>
  
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="" class="site_title"><i class="fa fa-user"></i> <span>Admin Area</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <?php
        $this->load->view('administrator/menu');
      ?>
            <!-- /sidebar menu -->

          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav class="" role="navigation">
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <?= $users->first_name ?> <?= $users->last_name ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="<?= base_url().'administrator/edit_user/'.$this->ion_auth->user()->row()->id ?>"> Profile</a></li>
                    <li><a href="<?= base_url() ?>administrator/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
      <?php
        $this->load->view($page);
      ?>
          </div>
        </div>
        <!-- /page content -->
    
        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Gentelella
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- Bootstrap -->
    <script src="<?= base_url() ?>assets/admin/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?= base_url() ?>assets/admin/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?= base_url() ?>assets/admin/nprogress/nprogress.js"></script>
    <!-- jQuery Sparklines -->
    <script src="<?= base_url() ?>assets/admin/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
  <!-- Datatables -->
    <script src="<?= base_url() ?>assets/admin/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>assets/admin/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?= base_url() ?>assets/admin/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?= base_url() ?>assets/admin/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="<?= base_url() ?>assets/admin/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="<?= base_url() ?>assets/admin/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?= base_url() ?>assets/admin/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?= base_url() ?>assets/admin/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="<?= base_url() ?>assets/admin/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="<?= base_url() ?>assets/admin/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url() ?>assets/admin/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="<?= base_url() ?>assets/admin/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="<?= base_url() ?>assets/admin/jszip/dist/jszip.min.js"></script>
    <script src="<?= base_url() ?>assets/admin/pdfmake/build/pdfmake.min.js"></script>
    <script src="<?= base_url() ?>assets/admin/pdfmake/build/vfs_fonts.js"></script>
  
  <!-- bootstrap-wysiwyg -->
    <script src="<?= base_url() ?>assets/admin/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
    <script src="<?= base_url() ?>assets/admin/jquery.hotkeys/jquery.hotkeys.js"></script>
    <script src="<?= base_url() ?>assets/admin/google-code-prettify/src/prettify.js"></script>
  
  <!-- NProgress -->
    <script src="<?= base_url() ?>assets/admin/nprogress/nprogress.js"></script>
    <!-- Dropzone.js -->
    <script src="<?= base_url() ?>assets/admin/dropzone/dist/min/dropzone.min.js"></script>
    
    <!-- Custom Theme Scripts -->
    <script src="<?= base_url() ?>assets/admin/js/custom.min.js"></script>
  

    <!-- Tinymce text editor komplit -->
    <script src="<?= base_url() ?>assets/admin/tinymce/tinymce.min.js"></script>
	

    <!-- Tinymce COnfig -->
    <script>
  		tinymce.init({ 
        selector: '.editor-wysiwyg',
        theme: "modern",
        // width: 680,
        height: 500,
        plugins: [
        "advlist autolink link image lists charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
        "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
        ],
        toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
        toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
        image_advtab: true ,

        external_filemanager_path:"<?= base_url() ?>assets/admin/filemanager/",
        filemanager_title:"Responsive Filemanager" ,
        filemanager_access_key:"<?= $tinykey ?>",
        external_plugins: { "filemanager" : "<?= base_url() ?>assets/admin/filemanager/plugin.min.js"},
        // valid_elements :"a[href|target=_blank],strong,u,p,iframe[src|frameborder|style|scrolling|class|width|height|name|align]",
        extended_valid_elements : "iframe[src|frameborder|style|scrolling|class|width|height|name|align]",


        templates: [
        { title: 'Test template 1', content: 'Test 1' },
        { title: 'Test template 2', content: 'Test 2' }
        ],
        content_css: [
        '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
        '//www.tinymce.com/css/codepen.min.css'
        ]

      });

      // tinymce.init({
      //   selector: '.editor-wysiwyg',
      //   height: 500,
      //   plugins: [
      //   'advlist autolink lists link image charmap print preview anchor',
      //   'searchreplace visualblocks code fullscreen',
      //   'insertdatetime media table contextmenu paste code'
      //   ],
      //   toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
      //   content_css: [
      //   '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
      //   '//www.tinymce.com/css/codepen.min.css'
      //   ]
      // });

  	</script>
	
<!--     <script type="text/javascript">
      window.confirm = function (message, okCallback, cancelCallback) {
        swal({
          title: message,
          type: 'warning',
          showCancelButton: true,
          closeOnConfirm: true,
          allowOutsideClick: true
        }, okCallback);
      };

    </script> -->


	<script type="text/javascript">
		$(document).ready(function() {
			$('#datatables').DataTable();
			
			function initToolbarBootstrapBindings() {
			  var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
				  'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
				  'Times New Roman', 'Verdana'
				],
				fontTarget = $('[title=Font]').siblings('.dropdown-menu');
			  $.each(fonts, function(idx, fontName) {
				fontTarget.append($('<li><a data-edit="fontName ' + fontName + '" style="font-family:\'' + fontName + '\'">' + fontName + '</a></li>'));
			  });
			  $('a[title]').tooltip({
				container: 'body'
			  });
			  $('.dropdown-menu input').click(function() {
				  return false;
				})
				.change(function() {
				  $(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
				})
				.keydown('esc', function() {
				  this.value = '';
				  $(this).change();
				});

			  $('[data-role=magic-overlay]').each(function() {
				var overlay = $(this),
				  target = $(overlay.data('target'));
				overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
			  });

			  if ("onwebkitspeechchange" in document.createElement("input")) {
				var editorOffset = $('#editor').offset();

				$('.voiceBtn').css('position', 'absolute').offset({
				  top: editorOffset.top,
				  left: editorOffset.left + $('#editor').innerWidth() - 35
				});
			  } else {
				$('.voiceBtn').hide();
			  }
			}

			function showErrorAlert(reason, detail) {
			  var msg = '';
			  if (reason === 'unsupported-file-type') {
				msg = "Unsupported format " + detail;
			  } else {
				console.log("error uploading file", reason, detail);
			  }
			  $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>' +
				'<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
			}

			initToolbarBootstrapBindings();

			$('#editor').wysiwyg({
			  fileUploadError: showErrorAlert
			});

			window.prettyPrint;
			prettyPrint();
		});
	</script>


  <!-- Select 2 -->
  <link href="<?= base_url() ?>assets/admin/select2/dist/css/select2.min.css" rel="stylesheet" />
  <script src="<?= base_url() ?>assets/admin/select2/dist//js/select2.min.js"></script>
  
  <!-- Select 2 cong -->
  <script type="text/javascript">
    $('select').select2();
    
    $(".js-tags-post").select2({
      tags: true
    })
  </script>
  

  </body>
</html>