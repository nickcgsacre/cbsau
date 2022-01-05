<?php
define("PAGINA", "DECLARAÇÕES/AUTORIZAÇÕES");
define("CSS", '');
define("JS", '');
include_once(__DIR__."/../header.php");
include_once(__DIR__."/../menu.php");

?>

<style>

/* For other boilerplate styles, see: /docs/general-configuration-guide/boilerplate-content-css/ */
/*
* For rendering images inserted using the image plugin.
* Includes image captions using the HTML5 figure element.
*/

figure.image {
  display: inline-block;
  border: 1px solid gray;
  margin: 0 2px 0 1px;
  background: #f5f2f0;
}

figure.align-left {
  float: left;
}

figure.align-right {
  float: right;
}

figure.image img {
  margin: 8px 8px 0 8px;
}

figure.image figcaption {
  margin: 6px 8px 6px 8px;
  text-align: center;
}


/*
 Alignment using classes rather than inline styles
 check out the "formats" option
*/

img.align-left {
  float: left;
}

img.align-right {
  float: right;
}

/* Basic styles for Table of Contents plugin (toc) */
.mce-toc {
  border: 1px solid gray;
}

.mce-toc h2 {
  margin: 4px;
}

.mce-toc li {
  list-style-type: none;
}


	</style>
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  
  
<script>

var useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;

tinymce.init({
  selector: 'textarea#open-source-plugins',
  plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
  imagetools_cors_hosts: ['picsum.photos'],
  menubar: 'file edit view insert format tools table help',
  toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
  toolbar_sticky: true,
  autosave_ask_before_unload: true,
  autosave_interval: '30s',
  autosave_prefix: '{path}{query}-{id}-',
  autosave_restore_when_empty: false,
  autosave_retention: '2m',
  image_advtab: true,
  link_list: [
    { title: 'My page 1', value: 'https://www.tiny.cloud' },
    { title: 'My page 2', value: 'http://www.moxiecode.com' }
  ],
  image_list: [
    { title: 'My page 1', value: 'https://www.tiny.cloud' },
    { title: 'My page 2', value: 'http://www.moxiecode.com' }
  ],
  image_class_list: [
    { title: 'None', value: '' },
    { title: 'Some class', value: 'class-name' }
  ],
  importcss_append: true,
  file_picker_callback: function (callback, value, meta) {
    /* Provide file and text for the link dialog */
    if (meta.filetype === 'file') {
      callback('https://www.google.com/logos/google.jpg', { text: 'My text' });
    }

    /* Provide image and alt text for the image dialog */
    if (meta.filetype === 'image') {
      callback('https://www.google.com/logos/google.jpg', { alt: 'My alt text' });
    }

    /* Provide alternative source and posted for the media dialog */
    if (meta.filetype === 'media') {
      callback('movie.mp4', { source2: 'alt.ogg', poster: 'https://www.google.com/logos/google.jpg' });
    }
  },
  templates: [
        { title: 'New Table', description: 'creates a new table', content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>' },
    { title: 'Starting my story', description: 'A cure for writers block', content: 'Once upon a time...' },
    { title: 'New list with dates', description: 'New List with dates', content: '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>' }
  ],
  template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
  template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
  height: 600,
  image_caption: true,
  quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
  noneditable_noneditable_class: 'mceNonEditable',
  toolbar_mode: 'sliding',
  contextmenu: 'link image imagetools table',
  skin: useDarkMode ? 'oxide-dark' : 'oxide',
  content_css: useDarkMode ? 'dark' : 'default',
  content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
 });
</script>
  
  <!-- END VENDOR CSS-->


  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
          <h3 class="content-header-title">DECLARAÇÕES/AUTORIZAÇÕES</h3>
          <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=URL_SISTEMA?>">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Declarações/Autorizações
                </li>
              </ol>
            </div>
          </div>
        </div>
		<!--
        <div class="content-header-right col-md-6 col-12">
          <div class="media width-500 float-right">
            <div class="media-body media-right text-right">
              
			  <div class="btn-group" role="group" aria-label="First Group">
				  <button type="button" class="btn btn-icon btn-outline-danger" onclick="removerEmMassa()"><i class="la la-trash"></i> EXCLUÍR SELECIONADOS</button>
				  <a href="<?=URL_SISTEMA?>/ordens/novo" class="btn btn-icon btn-outline-primary"><i class="la la-plus"></i> NOVA FICHA</a>
				</div>
			  
			  
            </div>
          </div>
        </div> 
		-->
      </div>
      <div class="content-body">
	  
        <!-- Ajax sourced data -->
        <section id="ajax">
          <div class="row">
            
			<div class="col-12 col-xl-12">
				<div class="row">
					<div class="col-12">
					
						<div class="card">
						  <div class="card-header">
							<h4 class="card-title"><i class="fa fa-search"></i> PROCURAR O PACIENTE</h4>
						  </div>
						  <div class="card-content">
							<div class="card-body p1">
							  <ul class="nav nav-tabs nav-underline no-hover-bg">
								<li class="nav-item">
								  <a class="nav-link active" id="base-associado" data-toggle="tab" aria-controls="associado" href="#associado" aria-expanded="true">ASSOCIADO</a>
								</li>
								<li class="nav-item">
								  <a class="nav-link" id="base-dependente" data-toggle="tab" aria-controls="dependente" href="#dependente" aria-expanded="false">DEPENDENTE</a>
								</li>
							  </ul>
							  <div class="tab-content px-1 pt-1">
								<div role="tabpanel" class="tab-pane active" id="associado" aria-expanded="true" aria-labelledby="base-associado">
								  <div class="row">
									<div class="col-12 border-right-blue-grey border-right-lighten-4 pr-2 p-0">
									  
									 	  <input type="hidden" name="acao" value="associado" />
									  
										  <div class="row">
											<div class="col-12">
											  <fieldset class="form-group position-relative">
												<input type="hidden" class="form-control form-control-xl input-xl" name="termo" id="termo"  placeholder="Digite o nome, CPF ou o código do associado">
												<div class="form-control-position">
												  <i class="ft-mic font-medium-4"></i>
												</div>
											  </fieldset>
											</div>
											<div class="col-12">
											  <fieldset class="form-group">
												<textarea class="form-control form-control-xl input-xl" name="declaracao" id="open-source-plugins" onkeyup="declaracao_key()" placeholder="">
												<div class="card-content">
							<div class="card-body printable">
									
							<h3 class="text-center"  style="text-align: center;">
										<img src="<?=URL_SISTEMA?>/app-assets/images/logo.png" style="width: 120px!important"/>
									</h3>
									<h1 class="text-center" style="font-size:24px !important; text-align: center; "><strong>CBSAÚDE</strong></h1>
									<h6 class="text-center"  style="font-size:10px !important; text-align: center; margin-top:-12px;">COOPERATIVA DE SAÚDE DOS SERVIDORES PÚBLICOS DO CORPO DE BOMBEIROS</h6>
									<span id="nomePaciente" style="font-size: 20px !important; text-align: center; margin-top:-8px;" class="text-center"></span>
									<hr/>
								
							</div>
						  </div>
											
											</textarea>
											  </fieldset>
											</div>
										  </div>
										  <div class="row">
											<div class="col-12 text-center">
											  <button onclick="impressao()" class="btn btn-primary btn-block btn-md">
												<i class="fa fa-print"></i>  Imprimir Declaração
											  </button>
											</div>
										  </div>
									 </div>
									
								  </div>
								  <script>
													function impressao(){
														document.querySelector('[title="Print"]').click();
													}
													</script>
						

								</div>
								
								<div class="tab-pane" id="dependente" aria-labelledby="base-dependente">
								  <div class="row">
									<div class="col-12 border-right-blue-grey border-right-lighten-4 pr-2 p-0">
									  
									  <form class="form form-horizontal" id="b2" onsubmit="atestado.procurar(); return false;">
										  <input type="hidden" name="acao" value="dependente" />
										  <div class="row">
											<div class="col-8">
											  <fieldset class="form-group position-relative">
												<input type="text" class="form-control form-control-xl input-xl" name="termo" id="termo"  placeholder="Digite o nome ou CPF do dependente">
												<div class="form-control-position">
												  <i class="ft-mic font-medium-4"></i>
												</div>
											  </fieldset>
											</div>
											<div class="col-4">
											  <fieldset class="form-group position-relative">
												<select class="form-control form-control-xl input-xl" name="opts">
													<option value="">Selecione uma opção</option>
													<option value="1">Atendido(a)</option>
													<option value="2">Medicado(a)</option>
													<option value="0">Atendido(a) & Medicado(a)</option>
											    </select>
											  </fieldset>
											</div>
											<div class="col-8">
											  <fieldset class="form-group position-relative">
												<input type="text" class="form-control form-control-xl input-xl" name="motivo" placeholder="Motivo do afastamento">
											  </fieldset>
											</div>
											<div class="col-4">
											  <fieldset class="form-group">
												<input type="number" class="form-control form-control-xl input-xl" name="dias" placeholder="Dias de afastamento">
											  </fieldset>
											</div>
											<div class="col-12">
											  <fieldset class="form-group">
												<input type="text" class="form-control form-control-xl input-xl" name="clinica" placeholder="Nome da clínica">
											  </fieldset>
											</div>
										  </div>
										  <div class="row">
											<div class="col-12 text-center">
											  <button type="submit" class="btn btn-primary btn-block btn-md">
												<i class="fa fa-stethoscope"></i>  GERAR ATESTADO MÉDICO
											  </button>
											</div>
										  </div>
									  
									  </form>
									</div>
									
								  </div>
								
								</div>
							  
							  </div>
							</div>
						  </div>
						</div>
					
					</div>
				</div>
				
				<div class="row">
					<div class="col-lg-12 col-12 imprime-resultado">
					
					</div>
				</div>
			
          </div>
        </section>
        <!--/ Ajax sourced data -->
		
      </div>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
 
 
  
<?php include_once(__DIR__."/../footer.php"); ?>