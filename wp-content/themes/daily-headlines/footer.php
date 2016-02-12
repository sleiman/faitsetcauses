<?php 
global $options;
foreach ($options as $value) {
    if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); }
} 
?>

  <div id="prefooter">
    <div class="wrap">
    
      <div class="column">
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer: Left Column') ) : //?> <?php endif; ?>
      </div><!-- end .column -->
      
      <div class="column">
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer: Center Column') ) : //?> <?php endif; ?>
      </div><!-- end .column -->
      
      <div class="column column-last">
        <?php  if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer: Right Column') ) : //?> <?php endif; ?>
      </div><!-- end .column -->
    
    <div class="clear">&nbsp;</div>
    
    </div><!-- end .wrap -->
  </div><!-- end #footer -->

  <div id="footer">
    <div class="wrap">
    
        <?php wp_nav_menu( array('container' => '', 'container_class' => '', 'menu_class' => '', 'depth' => '1', 'menu_id' => 'menufooter', 'sort_column' => 'menu_order', 'theme_location' => 'secondary' ) ); ?>
        <p>&copy; <?php echo date("Y",time()); ?> <?php echo "Agence de presse ACPress"; ?>. Tous droits réservés. | Les textes publiés sur le site Faits et Causes n'engagent que leurs auteurs et ne sont pas des opinions juridiques. </p>
      
    <div class="clear">&nbsp;</div>
    
    </div><!-- end .wrap -->
  </div><!-- end #footer -->

</div><!-- end #wrap -->

<?php wp_footer(); ?>
<?php if ($proud_misc_analytics != '' && $proud_misc_analytics_select == 'Yes')
{
  echo stripslashes($proud_misc_analytics);
} ?>
</body>
</html>
