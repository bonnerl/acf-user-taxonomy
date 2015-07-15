<?php

class acf_field_user_taxonomy extends acf_field {
	
	// vars
	var $settings, // will hold info such as dir / path
		$defaults; // will hold default field options
		
		
	/*
	*  __construct
	*
	*  Set name / label needed for actions / filters
	*
	*  @since	3.6
	*  @date	23/01/13
	*/
	
	function __construct()
	{
		// vars
		$this->name = 'user_taxonomy';
		$this->label = __('User Taxonomy');
		$this->category = __("Relational",'acf'); // Basic, Content, Choice, etc
		$this->defaults = array(
			'taxonomy' => '',
			'allow_null' => 0,
		);
		
		
		// do not delete!
    	parent::__construct();
    	
    	
    	// settings
		$this->settings = array(
			'path' => apply_filters('acf/helpers/get_path', __FILE__),
			'dir' => apply_filters('acf/helpers/get_dir', __FILE__),
			'version' => '1.0.0'
		);

	}
	
	
	/*
	*  create_options()
	*
	*  Create extra options for your field. This is rendered when editing a field.
	*  The value of $field['name'] can be used (like below) to save extra data to the $field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field	- an array holding all the field's data
	*/
	
	function create_options( $field )
	{

		$field = array_merge($this->defaults, $field);
		
		// key is needed in the field names to correctly save the data
		$key = $field['name'];
		
		// Create Field Options HTML
		?>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("User Taxonomy",'acf'); ?></label>
		<p class="description"><?php _e("Select the taxonomy to be displayed",'acf'); ?></p>
	</td>
	<td>
		<?php

		do_action('acf/create_field', array(
			'type'		=>	'select',
			'name'		=>	'fields['.$key.'][taxonomy]',
			'value'		=>	$field['taxonomy'],
			'choices'		=> acf_get_taxonomies(),
		));
		
		?>
	</td>
</tr>
<tr class="field_option field_option_<?php echo $this->name; ?>">
	<td class="label">
		<label><?php _e("Allow Null",'acf'); ?></label>
		<p class="description"></p>
	</td>
	<td>
		<?php

		do_action('acf/create_field', array(
			'type'		=>	'true_false',
			'name'		=>	'fields['.$key.'][allow_null]',
			'value'		=>	$field['allow_null'],
		));
		
		?>
	</td>
</tr>
		<?php
		
	}
	
	
	/*
	*  create_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field - an array holding all the field's data
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/
	
	function create_field( $field )
	{
		// Get terms for the field's taxonomy.
		$terms = get_terms($field['taxonomy'], [
			'hide_empty'        => false, 
			'exclude'           => array(), 
			'include'           => array()
			] );
		?>
		<select name="<?php echo esc_attr($field['name']) ?>" id="">
			<?php if ( $field['allow_null'] ): ?>
				<option value=""<?php if ( $field['value'] == '' ) echo ' selected="selected"' ?>>N/A</option>
			<?php endif ?>
			<?php foreach ( $terms as $term ) :
				$selected = ( $field['value'] == $term->term_id ) ? ' selected="selected"' : '';
				?>
				<option value="<?php echo $term->term_id ?>"<?php echo $selected ?>><?php echo $term->name ?></option>
			<?php endforeach; ?>
		</select>
		<?php
	}
	
	
	/*
	*  input_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
	*  Use this action to add CSS + JavaScript to assist your create_field() action.
	*
	*  $info	http://codex.wordpress.org/Plugin_API/Action_Reference/admin_enqueue_scripts
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/

	function input_admin_enqueue_scripts()
	{
		// Note: This function can be removed if not used
		
		
		// register ACF scripts
		wp_register_script( 'acf-input-user_taxonomy', $this->settings['dir'] . 'js/input.js', array('acf-input'), $this->settings['version'] );
		wp_register_style( 'acf-input-user_taxonomy', $this->settings['dir'] . 'css/input.css', array('acf-input'), $this->settings['version'] ); 
		
		
		// scripts
		wp_enqueue_script(array(
			'acf-input-user_taxonomy',	
		));

		// styles
		wp_enqueue_style(array(
			'acf-input-user_taxonomy',	
		));
		
		
	}
	
}


// create field
new acf_field_user_taxonomy();

?>
