<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">IQMAXIMO</li>
      <li class="<?php validActive('main', true); ?> treeview"> <a href="main"> <i class="fa fa-dashboard"></i>
          <span>Dashboard</span> </a> </li>
      <li class="treeview <?php validActive(array('rankings', 'ranking', 'ranking_modulos', 'ranking_modulo')); ?>"> <a
          href="#"> <i class="fa fa-users"></i> <span>Ranking</span> </a>
        <ul class="treeview-menu">
          <li class='<?php validActive('rankings'); ?>'><a href="page-rankings"><i class="fa fa-circle-o"></i> Ver
              todas</a></li>
          <li class='<?php validActive('ranking'); ?>'><a href="page-ranking"><i class="fa fa-circle-o"></i> Crear
              nuevo</a></li>
        </ul>
      </li>
      <li class="treeview <?php validActive(array('testimonios', 'testimonio')); ?>"> <a href="#"> <i
            class="fa fa-video-camera"></i> <span>Testimonios</span> </a>
        <ul class="treeview-menu">
          <li class='<?php validActive('testimonios'); ?>'><a href="page-testimonios"><i class="fa fa-circle-o"></i> Ver
              todos</a></li>
          <li class='<?php validActive('testimonio'); ?>'><a href="page-testimonio"><i class="fa fa-circle-o"></i> Crear
              nuevo</a></li>
        </ul>
      </li>
      <li class="treeview <?php validActive(array('videos', 'video')); ?>"> <a href="#"> <i
            class="fa fa-video-camera"></i> <span>Videos</span> </a>
        <ul class="treeview-menu">
          <li class='<?php validActive('videos'); ?>'><a href="page-videos"><i class="fa fa-circle-o"></i> Ver todos</a>
          </li>
          <!-- <li class='<?php validActive('video'); ?>'><a href="page-video"><i class="fa fa-circle-o"></i> Crear nuevo</a></li>-->
        </ul>
      </li>
      <li
        class="treeview <?php validActive(array('materiales', 'material', 'materiales_categorias', 'materiales_categoria')); ?>">
        <a href="#"> <i class="fa fa-file"></i> <span>Materiales</span> </a>
        <ul class="treeview-menu">
          <li class='<?php validActive('materiales'); ?>'><a href="page-materiales"><i class="fa fa-circle-o"></i> Ver
              todos</a></li>
          <li class='<?php validActive('material'); ?>'><a href="page-material"><i class="fa fa-circle-o"></i> Crear
              nuevo</a></li>
          <li class='<?php validActive('materiales_categorias'); ?>'><a href="page-materiales_categorias"><i
                class="fa fa-circle-o"></i> Categorías</a></li>
        </ul>
      </li>
      <li
        class="treeview <?php validActive(array('noticias', 'noticia', 'noticias_categoria', 'noticias_etiqueta', 'noticias_categorias', 'noticias_etiquetas', 'noticia_comentario')); ?>">
        <a href="#"> <i class="fa fa-newspaper-o"></i> <span>Noticias</span> </a>
        <ul class="treeview-menu">
          <li class='<?php validActive('noticias'); ?>'><a href="page-noticias"><i class="fa fa-circle-o"></i> Ver
              todos</a></li>
          <li class='<?php validActive('noticia'); ?>'><a href="page-noticia"><i class="fa fa-circle-o"></i> Crear
              nuevo</a></li>
          <li class='<?php validActive(array('noticias_categorias', 'noticias_categoria')); ?>'><a
              href="page-noticias_categorias"><i class="fa fa-circle-o"></i> Categorías</a></li>
          <li class='<?php validActive(array('noticias_etiquetas', 'noticias_etiqueta')); ?>'><a
              href="page-noticias_etiquetas"><i class="fa fa-circle-o"></i> Etiquetas</a></li>
        </ul>
      </li>
      <li class="treeview <?php validActive(array('contactos', 'contacto', 'contacto_mensajes')); ?>"> <a href="#"> <i
            class="fa fa-map-marker"></i> <span>Contactos</span> </a>
        <ul class="treeview-menu">
          <li class='<?php validActive('contactos'); ?>'><a href="page-contactos"><i class="fa fa-circle-o"></i> Ver
              todos</a></li>
          <li class='<?php validActive('contacto'); ?>'><a href="page-contacto"><i class="fa fa-circle-o"></i> Crear
              nuevo</a></li>
          <li class='<?php validActive('contacto_mensajes'); ?>'><a href="page-contacto_mensajes"><i class="fa fa-circle-o"></i> Mensajes</a></li>
        </ul>
      </li>
      <li
        class="  <?php validActive(array('test_lectura', 'test_lectura_tipos', 'test_lectura_tipos_lecturas', 'test_lectura_tipos_lectura')); ?>">
        <a href="page-test_lectura"> <i class="fa fa-book"></i> <span>Test de Lectura</span> </a>
      </li>
      <li
        class="  <?php validActive(array('test_iq_tipos', 'test_iq_tipo', 'test_iq_preguntas', 'test_iq_pregunta', 'test_iq_alternativas', 'test_iq_alternativa')); ?>">
        <a href="page-test_iq_tipos"> <i class="fa fa-th-large"></i> <span>Test iQ</span> </a>
      </li>
      <li
        class="  <?php validActive(array('landings', 'landing', 'landing_faq', 'landing_testimonios', 'landing_testimonio', 'landing_precios', 'landing_precio')); ?>">
        <a href="page-landings"> <i class="fa fa-file"></i> <span>Landing Page</span> </a>
      </li>
    </ul>
    <ul class="sidebar-menu">
      <li class="header">A LEER BOLIVIA</li>

      <li class="treeview <?php validActive(array('a_leer_bolivia_testimonios', 'a_leer_bolivia_testimonios')); ?>"> <a
          href="#"> <i class="fa fa-video-camera"></i> <span>Testimonios</span> </a>
        <ul class="treeview-menu">
          <li class='<?php validActive('a_leer_bolivia_testimonios'); ?>'><a href="page-a_leer_bolivia_testimonios"><i
                class="fa fa-circle-o"></i> Ver
              todos</a></li>
          <li class='<?php validActive('a_leer_bolivia_testimonios'); ?>'><a href="page-a_leer_bolivia_testimonios"><i
                class="fa fa-circle-o"></i> Crear
              nuevo</a></li>
        </ul>
      </li>

      <li class="treeview <?php validActive(array('a_leer_bolivia_logos', 'a_leer_bolivia_logo')); ?>"> <a href="#"> <i
            class="fa fa-file-image-o"></i> <span>Logos</span> </a>
        <ul class="treeview-menu">
          <li class='<?php validActive('a_leer_bolivia_logos'); ?>'><a href="page-a_leer_bolivia_logos"><i
                class="fa fa-circle-o"></i> Ver
              todos</a></li>
          <li class='<?php validActive('a_leer_bolivia_logo'); ?>'><a href="page-a_leer_bolivia_logo"><i
                class="fa fa-circle-o"></i> Crear
              nuevo</a></li>
        </ul>
      </li>

      <li class="treeview <?php validActive(array('a_leer_bolivia_fichas', 'a_leer_bolivia_ficha')); ?>"> <a href="#">
          <i class="fa fa-file-text"></i> <span>Fichas</span> </a>
        <ul class="treeview-menu">
          <li class='<?php validActive('a_leer_bolivia_fichas'); ?>'><a href="page-a_leer_bolivia_fichas"><i
                class="fa fa-circle-o"></i> Ver
              todos</a></li>
          <li class='<?php validActive('a_leer_bolivia_ficha'); ?>'><a href="page-a_leer_bolivia_ficha"><i
                class="fa fa-circle-o"></i> Crear
              nuevo</a></li>
        </ul>
      </li>
    </ul>
    <ul class="sidebar-menu">
      <li class="header">NOTIFICACIÓN PUSH</li>
      <li class="treeview <?php validActive(array('push_notification_messages', 'push_notification_message')); ?>"> <a
          href="#">
          <i class="fa fa-mobile fa-lg"></i> <span>Mensajes</span> </a>
        <ul class="treeview-menu">
          <li class='<?php validActive('push_notification_messages'); ?>'><a href="page-push_notification_messages"><i
                class="fa fa-circle-o"></i> Ver
              todos</a></li>
          <li class='<?php validActive('push_notification_message'); ?>'><a href="page-push_notification_message"><i
                class="fa fa-circle-o"></i> Crear
              nuevo</a></li>
        </ul>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
