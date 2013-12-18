<?php
/*
	Plugin Name:ECT SEO 
	Plugin URI: http://www.ecommercetemplates.com/wordpress/wp-plugins.asp
	Description:This plugin will automatically add meta description tags and will set title the for all ECT store pages.
	Author:Andy Chapman
	Author URI:http://www.ecommercetemplates.com
	Version:1.0
*/ 
function ect_seo_fun( $arr) {
	$Title=$Meta=$Key='';
	
//	$GLOBALS['ectcartpage']='affiliate';
	if(@$GLOBALS['ectcartpage']=='proddetail')
	{
		$Title=esc_attr(get_bloginfo('name', 'display')).' store: '.$arr['pn']. " | " . $arr['sn']. " | " . $arr['pid'];
		$Meta=str_replace('"','&quot;',$arr['pd']);
		return GenerateSeoTags('proddetail',$Title,$Meta,'');
	}
	elseif(@$GLOBALS['ectcartpage']=='products')
	{

		$Title=esc_attr(get_bloginfo('name', 'display')).' store: ';
		if($arr['ts']!= "")
			$Title=$Title.$arr['ts'] . ", ";
		$Title=$Title.$arr['sn'];
		$Meta=str_replace('"','&quot;',$arr['sd']);
               return GenerateSeoTags('products',$Title,$Meta,'');
	}
	elseif(@$GLOBALS['ectcartpage']=='categories')
	{

		$Title=esc_attr(get_bloginfo('name', 'display')).' store: ';
			if($arr['ts'] != "") 
				$Title=$Title.$arr['ts']. ", ";
			$Title=$Title.$arr['sn'];
		$Meta=str_replace('"','&quot;',$arr['sd']);
return GenerateSeoTags('categories',$Title,$Meta,'');
	}
	elseif(@$GLOBALS['ectcartpage']=='cart')
	{
		$Title	='Shopping cart and checkout for '.esc_attr(get_bloginfo('name', 'display'));
		$Meta	='Online store shopping cart and checkout for '.esc_attr(get_bloginfo('name', 'display'));
		$Key	=''; 
		return GenerateSeoTags('cart',$Title,$Meta,$Key);
	}
	elseif(@$GLOBALS['ectcartpage']=='affiliate')
	{
		$Title='Affiliate program for '.esc_attr(get_bloginfo('name', 'display'));
		$Meta=esc_attr(get_bloginfo('name', 'display')).' affiliate program';
		return GenerateSeoTags('affiliate',$Title,$Meta);
	}
	elseif(@$GLOBALS['ectcartpage']=='clientlogin')
	{
		$Title='Customer account for '.esc_attr(get_bloginfo('name', 'display'));
		$Meta=esc_attr(get_bloginfo('name', 'display')).' client login';
		return GenerateSeoTags('clientlogin',$Title,$Meta);
	}
	elseif(@$GLOBALS['ectcartpage']=='giftcertificate')
	{
		$Title='Purchase a gift certificate from '.esc_attr(get_bloginfo('name', 'display'));
		$Meta=esc_attr(get_bloginfo('name', 'display')).' gift certificates';
		return GenerateSeoTags('giftcertificate',$Title,$Meta);
	}
	elseif(@$GLOBALS['ectcartpage']=='orderstatus')
	{
		$Title='Check the status of your order on '.esc_attr(get_bloginfo('name', 'display'));
		$Meta=esc_attr(get_bloginfo('name', 'display')).' order status';
		return GenerateSeoTags('orderstatus',$Title,$Meta);
	}
	elseif(@$GLOBALS['ectcartpage']=='search')
	{
		$Title='Search for products on '.esc_attr(get_bloginfo('name', 'display'));
		$Meta=esc_attr(get_bloginfo('name', 'display')).' search';
		return GenerateSeoTags('search',$Title,$Meta);
	}
	elseif(@$GLOBALS['ectcartpage']=='sorry')
	{
		$Title='Sorry - there seems to be a problem with the order';
		$Meta='Sorry - there seems to be a problem with the order';
		return GenerateSeoTags('sorry',$Title,$Meta);
	}
	elseif(@$GLOBALS['ectcartpage']=='thanks')
	{
		$Title='Thank you for purchasing from '.esc_attr(get_bloginfo('name', 'display'));
		$Meta=esc_attr(get_bloginfo('name', 'display')).' confirmation page';
		return GenerateSeoTags('thanks',$Title,$Meta);
	}
	elseif(@$GLOBALS['ectcartpage']=='tracking')
	{
		$Title='Track your purchase from '.esc_attr(get_bloginfo('name', 'display'));
		$Meta=esc_attr(get_bloginfo('name', 'display')).' tracking page';
		return GenerateSeoTags('tracking',$Title,$Meta);
	}
	elseif(is_front_page()){
		
		return GenerateSeoTags('front_page',$Title,$Meta,'');
	}
	else
	{
		if ( defined( 'WPSEO_VERSION' ) ) {
    		// WordPress SEO is activated
        		$Title=wp_title('',false).' '.esc_attr(get_bloginfo('name', 'display'));
			return GenerateSeoTags('',$Title,'');		
		} 
		else {
			    // WordPress SEO is not activated
			$Title=wp_title( '&#124;', false, 'right' ).' '.esc_attr(get_bloginfo('name', 'display'));
				return GenerateSeoTags('',$Title,'');		
		}
	} 
}
add_shortcode('ect_seo','ect_seo_fun');
add_action('admin_menu','ect_seo_nav');
function ect_seo_nav()
{
	add_menu_page('ECT SEO','ECT SEO','manage_options','ect_seo','ect_seo_nav_fun',plugin_dir_url(__FILE__).'img/ect28x28.png',1104);
}
function ect_seo_nav_fun()
{
	$PagesArr=array('front_page','proddetail','products','categories','cart','affiliate','clientlogin','giftcertificate','orderstatus','search','sorry','thanks','tracking');
	$Exc=array('proddetail','products','categories');	
?>
	<h2>ECT SEO MANAGER</h2>
	<?php echo (isset($_GET['msg'])) ? 'Settings Saved' : '';?>
	<ul class="ect_Seo_top">
		<li>Page</li>
		<li>Title</li>
		<li>Meta Description</li>
		<li>&nbsp;</li>
	</ul>
	<form method="post">
		<ul class="ect_seo">
			<?php foreach($PagesArr as $P):?>
			<?php if(!in_array($P,$Exc)):?>
			<li>
				<label><?php echo ucfirst(str_replace('_',' ',$P));?></label>
				<input type="text" name="seo_data_title[<?php echo $p?>]" value="<?php echo stripslashes(get_option('ect_seo_'.$P.'_title'))?>" />
				<input type="text" name="seo_data_metacnt[<?php echo $p?>]" value="<?php echo stripslashes(get_option('ect_seo_'.$P.'_meta_description'))?>" />
			</li>	
			
			<?php endif;?>
			<?php endforeach;?>	
			<li><input type="submit" value="Update Settings"/>
			<span style="float:right;">Use:<code>%SHOW_BLOG_NAME%</code></span></li>
		</ul>
	</form>
	<style>
		.ect_seo li label
		{
			width:150px;
			display:inline-block;
		}
		.ect_seo li input[type=text]
		{
			width:330px;
		}
		.ect_Seo_top li
		{
			float:left;
			font-weight:bold;
			width:284px;
		}
		.ect_Seo_top li:last-child
		{
			float:none;
		}
	</style>
<?php
	if(!empty($_POST))
	{
		$PagesArr2=array('front_page','cart','affiliate','clientlogin','giftcertificate','orderstatus','search','sorry','thanks','tracking');
		if(!empty($_POST['seo_data_title']) && !empty($_POST['seo_data_metacnt']))
		{
			for($i=0;$i<count($_POST['seo_data_title']);$i++)
			{
				update_option('ect_seo_'.$PagesArr2[$i].'_title',$_POST['seo_data_title'][$i]);
				update_option('ect_seo_'.$PagesArr2[$i].'_meta_description',$_POST['seo_data_metacnt'][$i]);
			}
			echo '<script type="text/javascript">window.location="admin.php?page=ect_seo&msg=1"</script>';
		}
		
	}
}

function GenerateSeoTags($P,$DefTitle='',$DefDesc='',$DefKey='')
{
		global $post;
		$BlogInfo=esc_attr(get_bloginfo('name', 'display'));
		$Title=get_option('ect_seo_'.$P.'_title');
		$Meta=get_option('ect_seo_'.$P.'_meta_description');
		$Key=get_option('ect_seo_'.$P.'_meta_keywords');
		
		$Title1=get_option('ect_seo_'.$post->ID.'_title');
		$Meta1=get_option('ect_seo_'.$post->ID.'_meta_description');
		if(!empty($post->ID) && !empty($Title1))
			$Title=$Title1.' | '.$BlogInfo;
		if(!empty($post->ID) && !empty($Meta1))	
			$Meta=$Meta1;
		$Title	=!empty($Title) ? $Title : $DefTitle;
		$Meta	=!empty($Meta) ? $Meta : $DefDesc;
		$Key	=!empty($Key) ? $Key : $DefKey;
	//echo $productname;
	
	$T	=str_replace("%SHOW_BLOG_NAME%",$BlogInfo,$Title);
	$M	=str_replace("%SHOW_BLOG_NAME%",$BlogInfo,$Meta);
	$K	=str_replace("%SHOW_BLOG_NAME%",$BlogInfo,$Key);
	
	return '	<title>'.$T.'</title> 
			<meta name="Description" content="'.$M.'" /> ';
}
add_action( 'add_meta_boxes', 'ect_seo_box_fun' );
function ect_seo_box_fun()
{
	$screens = array( 'post', 'page' );

    foreach ( $screens as $screen ) 
	    add_meta_box('ect_cust_seo_mb',__( 'ECT SEO ', 'myplugin_textdomain' ),'ect_seo_b',$screen);
}
function ect_seo_b()
{
	global $post;
	echo '<ul class="ect_seo">
		<li>
			<label>Page Title</label>
			<input type="text" name="ect_seo_title" value="'.get_option('ect_seo_'.$post->ID.'_title').'"/>
		</li>
		<li>
			<label>Page Meta Description</label>
			<textarea name="ect_seo_desc" >'.get_option('ect_seo_'.$post->ID.'_meta_description').'</textarea>
		</li>
	</ul><style>
		.ect_seo li input[type=text]
		{
			width:320px;
		}
		.ect_seo li textarea
		{
			width:320px;
			height:85px;
		}
		.ect_seo li label
		{
			width:138px;
			display:inline-block;
			float:left;
		}
	</style>';
}
add_action( 'save_post', 'ect_seo_save_post_fun' );
function ect_seo_save_post_fun()
{
	global $post;
	update_option('ect_seo_'.$post->ID.'_title',$_POST['ect_seo_title']);
	update_option('ect_seo_'.$post->ID.'_meta_description',$_POST['ect_seo_desc']);
}
?>