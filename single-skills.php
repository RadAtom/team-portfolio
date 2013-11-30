<?php get_header(); ?>
<?php 
//this would go here in order ot put the sidebar on the left
//get_sidebar();
require_once('finderhelper.php');

//put the bulk of the body below this closing tag
//below is the content you will need to display the bulk of the body
?>


	<div id="internal-content-wrapper" class="row rounded-corners">
		<div class="small-12 large-8 columns" id="internal-content">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    				<h1 class="caps"><?php the_title(); ?></h1>
    				<?php the_content(); ?>
    				<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
    				<?php
                    $membersid = get_post_meta( get_the_ID(), 'skill_members_box');
                    $projectsid = get_post_meta( get_the_ID(), 'skill_projects_box');
                    $members = WordPressFinder::getMembers($membersid);
                    $projects = WordPressFinder::getProjects($projectsid);
                    ?>
                    <div class="small-12 columns" id="team-portfolio-related-overviews">
                        <div class="small-6 columns" id="projects-overview">
                            <h3><?php the_title(); ?>'s related projects</h3>
                            <?php
                            if($projects){
                                ?>
                                <ul class="small-block-grid-4 large-block-grid-2" id="projects-block-grid">
                                    <?php
                                    foreach($projects as $project){
                                        ?>
                                        <li><a href="<?php echo $project['link'] ;?>"><h4 ><?php echo $project['title'];?></h4><img src="<?php echo $project['image_url'];?>" alt="<?php echo $project['image_alt'] ;?>"></a></li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                                <?php
                            }else{
                                ?>
                                <p>Currently there are no projects here... That can only mean one thing, exciting projects will be added soon! Make sure to check back often!</p>
                                <?php
                            }
                            ?>
                            
                        </div>
                        <div class="small-6 columns" id="members-overview">
                            <h3><?php the_title(); ?>'s related members</h3>
                            <?php
                            if($members){
                                ?>
                                <ul class="small-block-grid-4 large-block-grid-2" id="members-block-grid">
                                    <?php
                                    foreach($members as $memeber){
                                        ?>
                                        <li><a href="<?php echo $memeber['link'] ;?>"><h4 ><?php echo $memeber['title'];?></h4><img src="<?php echo $memeber['image_url'];?>" alt="<?php echo $memeber['image_alt'] ;?>"></a></li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                                <?php
                            }else{
                                ?>
                                <p>Currently there are no members here... That can only mean one thing, exciting members will be added soon! Make sure to check back often!</p>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                        
    			<?php endwhile; endif; ?>
		</div>
        <div class="small-12 large-3 columns sidebar-attention">
            <?php 
            if ( dynamic_sidebar('skill-post-sidebar') ) : 
            else : 
            ?>
            <p>need some content here jym</p>
            <?php endif; ?>
        </div>
	</div>
	


<?php 
//this would go here in order ot put the sidebar on the right
//get_sidebar();
get_footer(); 
?>
