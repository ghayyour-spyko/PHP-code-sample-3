<?php 
	/*
	 * Enum of available themes
	 */
	abstract class Theme {
        const _DEFAULT = 'default';
        const GREEN = 'green';
		const BLUE = 'blue';
		const YELLOW = 'yellow';
	}

    /*
	 * Theme schema model
	 */
	class Theme_Schema {
        public $primary_color;
        public $secondary_color;
        public $text_color;
    }

    /*
     * Theme template class
     */
    class Theme_Selector {
	    public $current_theme;

	    public function get_all_schemas() {
	        return array(
	            Theme::_DEFAULT => array(
	                'primary_color'     => '#22c3a4',
                    'secondary_color'   => '',
                    'text_color'        => ''
                ),
                Theme::YELLOW => array(
                    'primary_color'     => '#eccf38',
                    'secondary_color'   => '',
                    'text_color'        => ''
                ),
                Theme::GREEN => array(
                    'primary_color'     => '#3c763d',
                    'secondary_color'   => '',
                    'text_color'        => ''
                ),
                Theme::BLUE => array(
                    'primary_color'     => '#337ab7',
                    'secondary_color'   => '',
                    'text_color'        => ''
                )
            );
        }

        public function get_current_schema() {
	        return $this->get_all_schemas()[ $this->current_theme ];
        }

	    public function get_all_themes() {
	        return array (
	            Theme::_DEFAULT,
                Theme::BLUE,
                Theme::GREEN,
                Theme::YELLOW
            );
        }

	    public function __construct() {
            $this->current_theme = Theme::_DEFAULT;
        }

        public function is_valid_theme( $theme ) {
            $themes = $this->get_all_themes();
            return in_array( $theme, $themes);
        }

        public function set_current_theme( $theme ) {
	        if ( !isset($theme) ) {
	            $theme = Theme::_DEFAULT;
            }

            $themes = $this->get_all_themes();
	        if ( in_array( $theme, $themes ) ) {
                $this->current_theme = $theme;
            } else {
                $this->current_theme = Theme::_DEFAULT;
            }
        }

        public function get_current_theme() {
	        return $this->current_theme;
        }

        public function render_theme_schema() {
            $current_schema = (object) $this->get_current_schema();
	        echo "
	            <style>
	                :root {
	                    --primary-color: ". $current_schema->primary_color .";
	                    --secondary-color: ". $current_schema->secondary_color .";
	                    --text-color: ". $current_schema->text_color .";
	                    --hover-color: black;
	                }
                </style>
	        ";
        }

        public function render_theme_selector_widget() {
	        echo "
                <style>
                .theme-selector-widget { position: fixed;z-index: 1000;top: 30%;padding: 20px;box-shadow: 1px 1px 2px 1px lightgray;left:-225px;background: white;transition: all ease-out 0.5s;}
                .theme-selector-widget .theme-selector-box{ position: relative;}
                .theme-selector-widget .theme-selector-box .colors div{ width: 20px;height: 20px;overflow: hidden;padding: 20px;display: inline-block;margin: 1px;cursor: pointer;}
                .theme-selector-widget .theme-selector-box .colors div i{ color: white;}                
                .theme-selector-widget .theme-selector-box h3{ position: relative;top: -20px;font-size: 18px;}
                .theme-selector-widget .theme-selector-btn { border-radius: 0px 25px 25px 0px;position: relative;background: white;padding: 15px;left: 201px;top: -4px;font-size: 20px;box-shadow: 3px 1px 8px 0px lightgrey;cursor: pointer;color: var(--primary-color);}
                @media only screen and (max-width:500px) {
                    .theme-selector-widget{top:73px;left: -225px;}
                    .theme-selector-widget .theme-selector-btn{padding: 12px;font-size: 18px;top: -7px;}
                }
                </style>
                <div class='theme-selector-widget'>
                    <a class='theme-selector-btn' onclick='changeTheme()'><i class='fa fa-paint-brush'></i></a>
                    <div class='theme-selector-box'>
                        <h3>Select A Theme</h3>
                        <div class='colors'>
                            <div class='theme-default' onclick='window.location.href = window.location.origin + window.location.pathname + \"?theme=default\" + window.location.hash' style='background: #22c3a4'><i class='fa'></i></div>
                            <div class='theme-green' onclick='window.location.href = window.location.origin + window.location.pathname + \"?theme=green\" + window.location.hash' style='background: #3c763d'><i class='fa'></i></div>
                            <div class='theme-blue' onclick='window.location.href = window.location.origin + window.location.pathname + \"?theme=blue\" + window.location.hash' style='background: #337ab7'><i class='fa'></i></div>
                            <div class='theme-yellow' onclick='window.location.href = window.location.origin + window.location.pathname + \"?theme=yellow\" + window.location.hash' style='background: #eccf38'><i class='fa'></i></div>
                        </div>
                    </div>
                </div>
                <script>
                function changeTheme() {
                    let theme_name = window.location.search.replace(\"?theme=\", \"\");
                    theme_name = !theme_name ? 'default' : theme_name ;
                    $('.theme-' + theme_name + ' i').addClass('fa-check');
                    if ( $('.theme-selector-widget').css('left') != '0px' ) {
                        $('.theme-selector-widget').css('left', '0px');                    
                    } else {
                        $('.theme-selector-widget').css('left', '-225px');
                    }
                }
                </script>
	        ";
        }

    }

    $theme_selector = new Theme_Selector();
    if ( isset( $_REQUEST['theme'] ) ) {
        $theme_selector->set_current_theme( $_REQUEST['theme'] );
    } else {
        $theme_selector->set_current_theme( Theme::_DEFAULT );
    }
