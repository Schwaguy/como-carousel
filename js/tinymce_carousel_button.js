(function() {
    tinymce.PluginManager.add('comocarouselButton', function( editor, url ) {
        editor.addButton( 'comocarouselButton', {
            text: 'Add Carousel',
            icon: false,
            onclick: function() {
				var carouselSelectOptions = jQuery.parseJSON(tinyMCE_slider.carousel_select_options);
				var carouselTemplateOptions = jQuery.parseJSON(tinyMCE_slider.slide_template_select_options);
				var carouselImageSizeOptions = jQuery.parseJSON(tinyMCE_slider.slide_image_size_options);
				editor.windowManager.open( {
					title: 'Add Carousel',
					body: [
                        {
                            type   : 'listbox',
                            name   : 'name',
                            label  : 'Slider name',
                            values : carouselSelectOptions,
							value : '' // Sets the default
                        },
						{
                            type   : 'listbox',
                            name   : 'type',
                            label  : 'Slider Type',
                            values : [
                                { text: 'Slide', value: 'slide' },
								{ text: 'Fade', value: 'fade' },
                            ],
							value : 'slide' // Sets the default
                        },
						{
                            type   : 'listbox',
                            name   : 'indicators',
                            label  : 'Idicators',
                            values : [
                                { text: 'Show', value: 'show' },
								{ text: 'Hide', value: 'hide' },
                            ],
							value : 'show' // Sets the default
                        },
						{
                            type   : 'listbox',
                            name   : 'controls',
                            label  : 'Controls',
                            values : [
                                { text: 'Show', value: 'show' },
								{ text: 'Hide', value: 'hide' },
                            ],
							value : 'show' // Sets the default
                        },
						{
                            type   : 'listbox',
                            name   : 'captions',
                            label  : 'Captions',
                            values : [
                                { text: 'Show', value: 'show' },
								{ text: 'Hide', value: 'hide' },
                            ],
							value : 'show' // Sets the default
                        },
						{
                            type: 'textbox',
                            name: 'interval',
                            label: 'Interval',
                            value: '2000',
                            classes: '',
                        },
						{
                            type   : 'listbox',
                            name   : 'pause',
                            label  : 'Pause on Hover',
                            values : [
                                { text: 'True', value: 'true' },
								{ text: 'False', value: 'false' },
                            ],
							value : 'true' // Sets the default
                        },
						{
                            type   : 'listbox',
                            name   : 'orderby',
                            label  : 'Order By',
                            values : [
                                { text: 'Menu Order', value: 'menu_order' },
								{ text: 'Title', value: 'title' },
								{ text: 'Date', value: 'date' }
                            ],
							value : 'menu_order' // Sets the default
                        },
						{
                            type   : 'listbox',
                            name   : 'order',
                            label  : 'Order',
                            values : [
                                { text: 'Ascending', value: 'ASC' },
								{ text: 'Descending', value: 'DESC' }
                            ],
							value : 'ASC' // Sets the default
                        },
						{
                            type   : 'listbox',
                            name   : 'template',
                            label  : 'Slide Template',
                            values : carouselTemplateOptions,
							value : 'default' // Sets the default
                        },
						{
                            type   : 'listbox',
                            name   : 'imgsize',
                            label  : 'Slide Image Size',
                            values : carouselImageSizeOptions,
							value : 'default' // Sets the default
                        },
						/*{
                            type: 'textbox',
                            name: 'img',
                            label: tinyMCE_object.image_title,
                            value: '',
                            classes: 'my_input_image',
                        },
                        {
                            type: 'button',
                            name: 'my_upload_button',
                            label: '',
                            text: tinyMCE_object.image_button_title,
                            classes: 'my_upload_button',
                        },//new stuff!*/
                       /*{
                            type   : 'listbox',
                            name   : 'member_type',
                            label  : 'Member Role',
                            values : selectOptions
                        },*/
						/*{
                            type   : 'combobox',
                            name   : 'combobox',
                            label  : 'combobox',
                            values : [
                                { text: 'Test', value: 'test' },
                                { text: 'Test2', value: 'test2' }
                            ]
                        },*/
                        /*{
                            type   : 'textbox',
                            name   : 'textbox',
                            label  : 'textbox',
                            tooltip: 'Some nice tooltip to use',
                            value  : 'default value'
                        },
                        {
                            type   : 'container',
                            name   : 'container',
                            label  : 'container',
                            html   : '<h1>container<h1> is <i>ANY</i> html i guess...<br/><br/><pre>but needs some styling?!?</pre>'
                        },
                        {
                            type   : 'tooltip',
                            name   : 'tooltip',
                            label  : 'tooltip ( you dont use it like this check textbox params )'
                        },
                        {
                            type   : 'button',
                            name   : 'button',
                            label  : 'button ( i dont know the other params )',
                            text   : 'My Button'
                        },
                        {
                            type   : 'buttongroup',
                            name   : 'buttongroup',
                            label  : 'buttongroup ( i dont know the other params )',
                            items  : [
                                { text: 'Button 1', value: 'button1' },
                                { text: 'Button 2', value: 'button2' }
                            ]
                        },*/
                        /*{
                            type   : 'checkbox',
                            name   : 'showname',
                            label  : 'Name',
                            text   : 'Show Name',
                            checked : true
                        },
						{
                            type   : 'checkbox',
                            name   : 'showtitle',
                            label  : 'Title',
                            text   : 'Show Title',
                            checked : false
                        },
						{
                            type   : 'checkbox',
                            name   : 'showpicture',
                            label  : 'Picture',
                            text   : 'Show Picture',
                            checked : false
                        },
						{
                            type   : 'checkbox',
                            name   : 'showphone',
                            label  : 'Phone',
                            text   : 'Show Phone',
                            checked : false
                        },
						{
                            type   : 'checkbox',
                            name   : 'showemail',
                            label  : 'Email',
                            text   : 'Show Email',
                            checked : false
                        },
						{
                            type   : 'listbox',
                            name   : 'template',
                            label  : 'Display Template',
                            values : [
                                { text: 'Default (no template)', value: 'default-contact' },
								{ text: 'Single Contact Info', value: 'single-contact-info' },
                            ],
                            value : 'default-contact' // Sets the default
                        }*/
                       /* {
                            type   : 'colorbox',
                            name   : 'colorbox',
                            label  : 'colorbox ( i have no idea how it works )',
                            // text   : '#fff',
                            values : [
                                { text: 'White', value: '#fff' },
                                { text: 'Black', value: '#000' }
                            ]
                        },
                        {
                            type   : 'colorpicker',
                            name   : 'colorpicker',
                            label  : 'colorpicker'
                        },
                        {
                            type   : 'radio',
                            name   : 'team-limit',
                            label  : 'radio ( defaults to checkbox, or i`m missing something )',
                            text   : 'My Radio Button'
                        }*/
                    ],
                    onsubmit: function( e ) {
						var name = (e.data.name ? ' name='+ e.data.name : '');
						var type = (e.data.type ? ' type='+ e.data.type : '');
						var indicators = (e.data.indicators ? ' indicators='+ e.data.indicators : '');
						var controls = (e.data.controls ? ' controls='+ e.data.controls : '');
						var captions = (e.data.captions ? ' captions='+ e.data.captions : '');
						var interval = (e.data.interval ? ' interval='+ e.data.interval : '');
						var pause = (e.data.pause ? ' pause='+ e.data.pause : '');
						var orderby = (e.data.orderby ? ' orderby='+ e.data.orderby : '');
						var order = (e.data.order ? ' order='+ e.data.order : '');
						var template = (e.data.template ? ' template='+ e.data.template : '');
						var imgsize = (e.data.imgsize ? ' imgsize='+ e.data.imgsize : '');
						editor.insertContent( '[comocarousel '+ name + type + indicators + controls + captions + interval + pause + orderby + order + template + imgsize + ']');
                    }
                });
            },
        });
    });
})();