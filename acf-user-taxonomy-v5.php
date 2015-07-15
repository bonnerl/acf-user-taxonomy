<?php

class acf_field_user_taxonomy extends acf_field {
	
	
	/*
	*  __construct
	*
	*  This function will setup the field type data
	*
	*  @type	function
	*  @date	5/03/2014
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function __construct() {
		
		/*
		*  name (string) Single word, no spaces. Underscores allowed
		*/
		
		$this->name = 'user_taxonomy';
		
		
		/*
		*  label (string) Multiple words, can include spaces, visible when selecting a field type
		*/
		
		$this->label = __('User Taxonomy', 'acf-user-taxonomy');
		
		
		/*
		*  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
		*/
		
		$this->category = 'relational';
		
		
		/*
		*  defaults (array) Array of default settings which are merged into the field object. These are used later in settings
		*/
		
		$this->defaults = array(
			'taxonomy' => '',
			'allow_null' => 0,
		);
		
		
		/*
		*  l10n (array) Array of strings that are used in JavaScript. This allows JS strings to be translated in PHP and loaded via:
		*  var message = acf._e('user_taxonomy', 'error');
		*/
		
		$this->l10n = array(
			'error'	=> __('Error! Please enter a higher value', 'acf-user-taxonomy'),
		);
		
				
		// do not delete!
    	parent::__construct();
    	
	}
	
	
	/*
	*  render_field_settings()
	*
	*  Create extra settings for your field. These are visible when editing a field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/
	
	function render_field_settings( $field ) {
				
		// Add option to select taxonomy used for field
		acf_render_field_setting( $field, array(
			'label'			=> __('User Taxonomy','acf'),
			'instructions'	=> __('Select the taxonomy to be displayed','acf'),
			'type'			=> 'select',
			'name'			=> 'taxonomy',
			'choices'		=> acf_get_taxonomies(),
		));

		// Allow field to not be set.
		acf_render_field_setting( $field, array(
			'label'			=> __('Allow Null','acf'),
			'instructions'	=> '',
			'type'			=> 'true_false',
			'name'			=> 'allow_null'
		));

	}
	
	
	
	/*
	*  render_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field (array) the $field being rendered
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/
	
	function render_field( $field ) {
		// Get terms for the field's taxonomy.
		$terms = get_terms('user-region', [
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
	
}


// create field
new acf_field_user_taxonomy();

?>
