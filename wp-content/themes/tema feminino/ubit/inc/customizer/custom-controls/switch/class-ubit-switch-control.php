<?php
/**
 * Switch for Customizer.
 *
 * @package ubit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Create a range slider control.
 * This control allows you to add responsive settings.
 */
class Ubit_Switch_Control extends WP_Customize_Control {

	/**
	 * Declare the control type.
	 *
	 * @var string
	 */
	public $type = 'switch';

	/**
	 * Declare left switch label.
	 *
	 * @var string
	 */
	public $left_switch;

	/**
	 * Declare right switch label.
	 *
	 * @var string
	 */
	public $right_switch;

	/**
	 * Enqueue scripts and styles for the custom control.
	 */
	public function enqueue() {
		wp_enqueue_style(
			'ubit-switch-control',
			UBIT_THEME_URI . 'inc/customizer/custom-controls/switch/css/switch.css',
			array(),
			ubit_version()
		);
	}

	/**
	 * Render the control to be displayed in the Customizer.
	 */
	public function render_content() {
		$name    = '_customize-switch-' . $this->id;
		$id      = $this->id;
		$label   = $this->label;
		$value   = false == $this->value() ? 0 : 1;
		$desc    = $this->description;
		?>

		<div class="ubit-switch-customize-control">
			<?php if ( ! empty( $label ) ) { ?>
				<span class="customize-control-title">
					<?php echo esc_html( $label ); ?>
				</span>
			<?php } ?>
			
			<div class="ubit-switch-toggle">
				<input
					id="<?php echo esc_attr( $id ); ?>"
					type="checkbox"
					name="<?php echo esc_attr( $name ); ?>"
					class="ubit-switch-control switch-control"
					value="<?php echo esc_attr( $value ); ?>"
					<?php
						$this->link();
						checked( $value );
					?>
					/>

				<label for="<?php echo esc_attr( $id ); ?>" class="switch-control-label">
					<span class="on-off-label"></span>
				</label>
				
				<span class="switch-label left-switch"><?php echo esc_html( $this->left_switch ); ?></span>
				<span class="switch-label right-switch"><?php echo esc_html( $this->right_switch ); ?></span>
			</div>

			<?php if ( ! empty( $desc ) ) { ?>
				<span class="description customize-control-description"><?php echo esc_html( $desc ); ?></span>
			<?php } ?>
		</div>

		<?php
	}
}

