<?php
class Elementor_Faq_Widget extends \Elementor\Widget_Base{
    public function get_name()
    {
        return "FaqWidget";
    }
    public function get_title()
    {
        return __("FAQ Widget", 'elementortestplugin');
    }
    public function get_icon()
    {
        return 'fa fa-question';
    }
    public function get_categories()
    {
        return ['general'];
    }
    protected function _register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'elementortestplugin' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control('title',[
            'label'=>__( 'Title', 'elementortestplugin' ),
            'type' =>\Elementor\Controls_Manager::TEXT,
        ]);
        $repeater->add_control('description',[
            'label'=>__( 'Description', 'elementortestplugin' ),
            'type' =>\Elementor\Controls_Manager::WYSIWYG,
        ]);
        $this->add_control('faqs', [
            'label'=>__('FAQs', 'elementortestplugin' ),
            'type' =>\Elementor\Controls_Manager::REPEATER,
            'fields' =>$repeater->get_controls(),
            'title_field' => '{{{ title }}}',
            'default'=>[
                [
                    'title' => 'FAQ 1',
                    'description' => 'DESC 1'
                ],
                [
                    'title' => 'FAQ 2',
                    'description' => 'DESC 2'
                ],
            ]
        ]);

        $this->end_controls_section();
    
    }
    protected function render()
    {
        
    }
    protected function _content_template()
    {
        
    }