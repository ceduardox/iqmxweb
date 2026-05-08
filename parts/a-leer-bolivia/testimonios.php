<?php
require_once ("require/util.php");
require_once ("require/transacciones.php");
$obj = new ClssALeerBoliviaTestimonios();

$rows = $obj->lista();
if ($rows['total'] != 0) {
  ?>
  <section id='testimonios'>
    <div class='container'>
      <div class='row'>
        <div class='testimonios-sides'>
          <h2>Videos Motivadores
          </h2>
          <p class='subtitle'>
            ¡Únete a nuestra serie de videos para prepararte y destacarte en el concurso "A Leer Bolivia por un
            Futuro Mejor"!<br />Inspírate, motívate y domina el mundo de la lectura con nosotros. ¡Únete ahora
            para
            brillar!</p>
          <div id="carouselTestimonios" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner">
              <?php
              foreach ($rows['result'] as $key => $row) {
                $active = $key === 0 ? 'active' : '';
                ?>
                <div class="carousel-item <?php echo $active ?>">
                  <div class='carousel-item-container'>
                    <div class='testimonios-left-side'>
                      <div class='text'>
                        <p><?php echo $row['detail'] ?></p>
                        <small>- <?php echo $row['name'] ?></small>
                        <div class='circles'>
                          <a href='#carouselTestimonios' role="button" data-bs-slide="prev"><img
                              src='./assets/images/testimonios-left-circle.svg' alt='left-circle' /></a>
                          <a href='#carouselTestimonios' role="button" data-bs-slide="next"><img
                              src='./assets/images/testimonios-right-circle.svg' alt='right-circle' /></a>
                        </div>
                      </div>
                    </div>
                    <div class='testimonios-right-side-videos'>
                      <a href="javascript:void(0)" onclick="javascript:show($(this))"
                        data-video="https://www.youtube.com/embed/<?php echo limpiaVideo($row['video']) ?>"
                        data-name="<?php echo $row['name'] ?>"><img class='videos'
                          src="http://img.youtube.com/vi/<?php echo limpiaVideo($row['video']) ?>/maxresdefault.jpg" alt="">
                      </a>
                    </div>
                  </div>
                </div>
                <?php
              }
              ?>
            </div>
          </div>
        </div>
      </div>
  </section>


  <!-- Modal -->
  <div class="modal fade" id="testimonioModal" tabindex="-1" aria-labelledby="testimonioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="testimonioModalLabel">Title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <iframe id="video" width="100%" height="315" src="" title="YouTube video player" frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen></iframe>
        </div>
      </div>
    </div>
  </div>

  <script>
    var modal = $('#testimonioModal');

    function show(e) {
      modal.find('.modal-title').html($(e).data("name"))
      var video = modal.find('.modal-body').find("#video")
      video.attr('src', $(e).data("video"));
      video.attr('title', $(e).data("name"));
      modal.modal('show')
    }

    modal.on('hide.bs.modal', function () {
      $("#video").attr('src', '');
    });
    modal.on('show.bs.modal', function () {
      //
    });
  </script>
  <?php
}
?>