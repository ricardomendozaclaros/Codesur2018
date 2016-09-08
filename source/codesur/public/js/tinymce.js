var tinymceConfigs=[
	                    {
	                    	// Location of TinyMCE script
	                		script_url : '/js/jquery/tiny_mce/tiny_mce.js',
	                			
	                		// General options
	                		relative_urls : false,
	                		//width : "440",
	                		theme : "advanced",
	                		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
	                		extended_valid_elements : "iframe[src|width|height|name|align]",
	                		// Theme options
	                		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
	                		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,insertdate,inserttime,forecolor,backcolor,|,sub,sup",
	                		theme_advanced_buttons3 : "charmap,|,link,unlink,|,tablecontrols",		
	                		theme_advanced_toolbar_location : "top",
	                		theme_advanced_toolbar_align : "left",
	                		theme_advanced_statusbar_location : "bottom",
	                		theme_advanced_resizing : true,

	                		// Example content CSS (should be your site CSS)
	                		//content_css : "css/content.css",

	                		// Drop lists for link/image/media/template dialogs
	                		//template_external_list_url : "lists/template_list.js",
	                		//external_link_list_url : "lists/link_list.js",
	                		//external_image_list_url : "lists/image_list.js",
	                		//media_external_list_url : "lists/media_list.js",

	                		// Replace values for the template plugin
	                		template_replace_values : {
	                			username : "Some User",
	                			staffid : "991234"
	                		}	
	                    },
	                    {
	                    	// Location of TinyMCE script
	                		script_url : '/js/jquery/tiny_mce/tiny_mce.js',
	                			
	                		// General options
	                		relative_urls : false,
	                		entity_encoding : "raw",
	                		//width : "440",
	                		theme : "advanced",
	                		editor_selector : "mceSimple2",
	                		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

	                		// Theme options
	                		force_p_newlines : false,
	                		force_br_newlines : true,
	                		forced_root_block: false,
	                		theme_advanced_blockformats : "h6,h5,h4,h3,h2,h1",
	                		font_size_style_values : "0.8em,0.9em,1em,1.1em,1.2em,1.3em,1.4em",
	                		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect,forecolor,backcolor",
	                		theme_advanced_buttons2 : "",
	                		theme_advanced_buttons3 : "",		
	                		theme_advanced_toolbar_location : "top",
	                		theme_advanced_toolbar_align : "left",
	                		theme_advanced_statusbar_location : "bottom",
	                		theme_advanced_resizing : true,

	                		// Example content CSS (should be your site CSS)
	                		//content_css : "css/content.css",

	                		// Drop lists for link/image/media/template dialogs
	                		//template_external_list_url : "lists/template_list.js",
	                		//external_link_list_url : "lists/link_list.js",
	                		//external_image_list_url : "lists/image_list.js",
	                		//media_external_list_url : "lists/media_list.js",

	                		// Replace values for the template plugin
	                		template_replace_values : {
	                			username : "Some User",
	                			staffid : "991234"
	                		}
	                    },
	                    {
	                    	// Location of TinyMCE script
	                		script_url : '/js/jquery/tiny_mce/tiny_mce.js',
	                			
	                		// General options
	                		relative_urls : false,
	                		//width : "440",
	                		theme : "advanced",
	                		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
	                		extended_valid_elements : "iframe[src|width|height|name|align]",
	                		// Theme options
	                		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
	                		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,insertdate,inserttime,forecolor,backcolor,|,sub,sup",
	                		theme_advanced_buttons3 : "charmap,|,tablecontrols",		
	                		theme_advanced_toolbar_location : "top",
	                		theme_advanced_toolbar_align : "left",
	                		theme_advanced_statusbar_location : "bottom",
	                		theme_advanced_resizing : true,

	                		// Example content CSS (should be your site CSS)
	                		//content_css : "css/content.css",

	                		// Drop lists for link/image/media/template dialogs
	                		//template_external_list_url : "lists/template_list.js",
	                		//external_link_list_url : "lists/link_list.js",
	                		//external_image_list_url : "lists/image_list.js",
	                		//media_external_list_url : "lists/media_list.js",

	                		// Replace values for the template plugin
	                		template_replace_values : {
	                			username : "Some User",
	                			staffid : "991234"
	                		}	
	                    }
	                    ];

$().ready(function() {	
	
	$('textarea.tinymce').tinymce(tinymceConfigs[0]);
	$('textarea.tinymce2').tinymce(tinymceConfigs[1]);
	$('textarea.tinymce3').tinymce(tinymceConfigs[2]);

});
