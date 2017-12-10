<?php
	$template_loader = new WPRI_Template_Loader;
	$template_loader->get_template_part( 'wpri', 'header' );
?>
 	<div class="row">

		<div class="col-xs-12 col-md-9">
		<p class="single">
			Gebze Technical University Institute of Information Technologies (GTU IIT) conducts qualified research and development activities at national and international level with an industrial perspective.
			<br>
			The institute aims to be in cooperation with other departments, especially the GTU computer engineering department, domestic and foreign universities, public institutions, research centers and IT companies. IIT brings together researchers and resources from different disciplines aiming at collaboration.
			<br>
			Bringing together institutions, organizations in the industry with innovative technology, gathering the R&D capabilities and development of university-industry collaborations are shown to be in the country’s priorities. IIT aims to be among the stakeholders in the formation of industrial policy towards the achievement of global competitive advantage and usage of high technology with indigenous and local content. Successful completion, by private and public research institutions and universities, of R & D projects for the development of needed high-tech products is very important. IIT continues the activities related to the creation of new R & D projects and carrying them out as well as to the improvement of the quality of other ongoing projects. According to the objectives mentioned above with the use of international support funds (the European Union, etc.), national support funds (TUBITAK, ministries, foundations, etc.) and equity capitals, IIT plays a significant role both alone and with the institutions it has collaboration with. With the subject-oriented research centers established within itself, IIT brings academics and industrialists together and gains valuable projects to the country.
			<br>
			With national and international collaborations, personnel movement and creation of policies, GTU IIT positions itself as the center of attraction.
		</p>
		</div> <!-- /.blog-main -->

		<div class="col-xs-12 col-md-3">

            <?php
                $template_loader->get_template_part( 'sidebar', 'news' );
            ?>
        </div> <!-- /.col -->
	</div> <!-- /.row -->

<?php
	$template_loader->get_template_part( 'wpri', 'footer' );
?>
