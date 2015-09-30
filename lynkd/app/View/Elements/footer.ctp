<section class="wrapper">
    <div class="about-sec">
      <div class="footer-heading">About Us</div>
      <div class="footer-logo"><?php echo $this->Html->image('footer-logo.jpg'); ?></div>
      <div class="footer-about"><?php echo $Site['Sitesetting']['summary']; ?></div>
    </div>
    <div class="footer-links">
      <div class="footer-heading">Links</div>
      <ul>
       <li><?php echo $this->Html->link('Home',$base_url); ?></li> 
       <li><?php echo $this->Html->link('Post',$base_url."/blogs"); ?></li>
	   <li><?php echo $this->Html->link('Donate',$base_url."/donate"); ?></li>
		<li><?php echo $this->Html->link('Sitemap',$base_url."/sitemap.xml"); ?></li> 
		<?php foreach($Staticpages as $static) { ?>	   
	   <li><?php echo $this->Html->link($static['Staticpage']['title'],$base_url."/staticpages/view/".$static['Staticpage']['id']); ?></li>        
        <?php } ?>
      </ul>
    </div>
    <div class="footer-social">
      <div class="footer-heading">Connect With Us</div>
      <ul>
        <li><a  target="_blank" class="fb" href="<?php echo $Site['Sitesetting']['facebook_url']; ?>"></a></li>
        <li><a target="_blank" class="twitter" href="<?php echo $Site['Sitesetting']['twitter_url']; ?>"></a></li>
        <li><a target="_blank" class="gplus" href="<?php echo $Site['Sitesetting']['googleplus']; ?>"></a></li>
      </ul>
    </div>
  </section>