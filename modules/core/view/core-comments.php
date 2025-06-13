<?php

use WPFRW\Modules\Core\Core;

if (post_password_required()) {
   return;
}
?>

<div id="comments" class="comments-area mt-5">
   <?php if (have_comments()) : ?>
      <h2 class="comments-title h4">
         <?php
         $comments_number = get_comments_number();
         if (1 === $comments_number) {
            printf(_x('Un Comentario', 'comments title', 'WPFRW'));
         } else {
            printf(
               _nx(
                  '%1$s Comentario',
                  '%1$s Comentarios',
                  $comments_number,
                  'comments title',
                  'WPFRW'
               ),
               number_format_i18n($comments_number)
            );
         }
         ?>
      </h2>

      <ul class="comment-list list-unstyled mt-4">
         <?php
         wp_list_comments(
            array(
               'style'      => 'ul',
               'short_ping' => true,
               'avatar_size' => 64,
               'callback'   => function ($comment, $args, $depth) {
         ?>
            <li <?php comment_class('media mb-4'); ?> id="comment-<?php comment_ID(); ?>">
               <?php echo get_avatar($comment, 64, '', '', array('class' => 'mb-1 me-3 rounded-circle')); ?>
               <div class="media-body">
                  <h5 class="mt-0"><?php comment_author_link(); ?></h5>
                  <span class="text-muted small">
                     <?php echo Core::get_instance()->get_f_tra($comment->comment_date, 'EEEE, d \'de\' MMMM \'de\' y'); ?> a las <?php comment_time(); ?>
                  </span>
                  <div class="mt-2"><?php comment_text(); ?></div>
                  <div class="mt-2">
                     <?php
                     comment_reply_link(
                        array_merge(
                           $args,
                           array(
                              'reply_text' => __('Responder', 'WPFRW'),
                              'depth' => $depth,
                              'max_depth' => $args['max_depth']
                           )
                        )
                     );
                     ?>
                  </div>
               </div>
            </li>
         <?php
               },
            )
         );
         ?>
      </ul>

      <?php the_comments_navigation(); ?>
   <?php endif; ?>

   <?php if (! comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
      <p class="no-comments alert alert-warning"><?php esc_html_e('Los Comentrios están cerrados.', 'WPFRW'); ?></p>
   <?php endif; ?>

   <?php
   // Personalizar el formulario de comentarios con bootstrap y traducir el texto.
   comment_form(
      array(
         'title_reply'         => __('Deje un Comentario', 'WPFRW'),
         'title_reply_to' => 'Responder a %s',
         'cancel_reply_link' => 'Cancelar respuesta',
         'logged_in_as'        => sprintf(
            __('Ingresó como %s.', 'WPFRW'),
            wp_get_current_user()->display_name,
            admin_url('profile.php'),
            wp_logout_url(apply_filters('the_permalink', get_permalink()))
         ),
         'label_submit'        => __('Post Comment', 'WPFRW'),
         'comment_notes_before' => '<p class="comment-notes">' . __('Campos requeridos con *', 'WPFRW') . '</p>',
         'label_submit'        => __('Enviar Comentario', 'WPFRW'),
         'class_submit'  => 'btn btn-warning my-3',
         'comment_field' => '<div class="form-group col-lg-6"><label for="comment">' . _x('Comentario', 'noun', 'WPFRW') . '</label><textarea id="comment" name="comment" class="form-control mb-3" rows="5" required></textarea></div>',
         'fields'        => array(
            'author' => '<div class="form-group col-lg-6"><label for="author">' . __('Nombre', 'WPFRW') . '</label><input id="author" name="author" type="text" class="form-control mb-3" required /></div>',
            'email'  => '<div class="form-group col-lg-6"><label for="email">' . __('Correo', 'WPFRW') . '</label><input id="email" name="email" type="email" class="form-control mb-3" required /></div>',
            'url'    => '<div class="form-group col-lg-6"><label for="url">' . __('Sitio Web', 'WPFRW') . '</label><input id="url" name="url" type="url" class="form-control mb-3" /></div>',
            'cookies' => '<p class="comment-form-cookies-consent mb-3">' .
               '<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes" /> ' .
               '<label for="wp-comment-cookies-consent">Aceptar que mi nombre, correo electrónico y sitio web se guarden para la próxima vez que comente.</label></p>',
         ),
      )
   );
   ?>
</div>