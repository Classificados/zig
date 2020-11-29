<!--Usando o Html Components-->
<?php
use System\HtmlComponents\Modal\Modal;
use System\HtmlComponents\FlashMessage\FlashMessage;
use System\Session\Session;
use App\Config\ConfigPerfil;
?>

<style type="text/css">
	.imagem-perfil {
		width:40px;
	    height:40px;
	    object-fit:cover;
	    object-position:center;
	    border-radius:50%;
	}
</style>

<div class="row">

  <div class="card col-lg-12 content-div">
    <div class="card-body">
      <h5 class="card-title">
        <?php iconFilter();?>
        Filtros
      </h5>
    </div>

    <form method="POST" action="<?php echo BASEURL; ?>/usuario/usuariosChamadosViaAjax" id="form">

      <!-- token de segurança -->
      <input type="hidden" name="_token" value="<?php echo TOKEN; ?>" />

      <div class="row">

        <div class="col-md-4">
          <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" name="email" id="email" placeholder="Pesquisar por Email">
          </div>
        </div>

      <?php if (session::get('idPerfil') == ConfigPerfil::superAdmin()):?>
        <div class="col-md-4">
          <div class="form-group">
            <label for="id_usuario">Empresas</label>
            <select class="form-control" name="id_cliente" id="id_cliente_filtro">
            <option value="todos">Todas</option>
            <?php foreach ($empresas as $empresa) : ?>
              <option value="<?php echo $empresa->id; ?>">
                <?php echo $empresa->nome; ?>
              </option>
            <?php endforeach; ?>
            </select>
          </div>
      <?php endif;?>

          <button type="submit" class="btn btn-sm btn-success text-right pull-right" id="buscar-pedidos" style="margin-left:10px">
            <i class="fas fa-search"></i> Buscar
          </button>

        </div>

      </div>
      <!--end row-->
    </form>

    <br>

  </div>
</div>

<script src="<?php echo BASEURL; ?>/public/assets/js/core/jquery.min.js"></script>

<div class="row">
  <div class="card col-lg-12 content-div">
		<div class="card-body">
	    <h5 class="card-title"><i class="fas fa-users"></i> Usuários</h5>
	  </div>
    <!-- Mostra as mensagens de erro-->
	  <?php FlashMessage::show();?>
    <div id="append-usuariosChamadosViaAjax"></div>
  </div>
</div>

<?php Modal::start([
    'id' => 'modalUsuarios',
    'width' => 'modal-lg',
    'title' => 'Cadastrar Usuários'
]);?>

<div id="formulario"></div>

<?php Modal::stop();?>

<script>
	function modalUsuarios(rota, usuarioId) {
        var url = "";

        if (usuarioId) {
            url = rota + "/" + usuarioId;
        } else {
            url = rota;
        }

        $("#modalUsuarios").modal({backdrop: 'static'});
        $("#formulario").load(url);
    }

  usuarios();
  function usuarios() {
    $('#append-usuariosChamadosViaAjax').html('<div class="col-md-12"><br><center><h3>Carregando...</h3></center></div>');
    var rota = $('#form').attr('action');
    $.post(rota,

     $('#form').serialize(),

    function(resultado) {
      $('#append-usuariosChamadosViaAjax').empty();
      $('#append-usuariosChamadosViaAjax').append(resultado);
    });
  }
</script>
