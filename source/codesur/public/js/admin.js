var tinymceConfigs=[
	                      {
	                    	// Location of TinyMCE script
	                		script_url : '/js/jquery/tiny_mce/tiny_mce.js',
	                			
	                		// General options
	                		relative_urls : false,
	                		//width : "440",
	                		theme : "advanced",
	                		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,phpimage",

	                		// Theme options
	                		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
	                		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,insertdate,inserttime,code,preview",
	                		theme_advanced_buttons3 : "tablecontrols,|,forecolor,backcolor,|,sub,sup,|,emotions,|,insertlayer,moveforward,movebackward,absolute,|,link,unlink,|,phpimage",		
                                        
                                        
                
                                        
                                        
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
	                    }];

$().ready(function() {
/*	
	$('.navigation').Accordion({
		active: 'a.selected',
		header: 'a.head',
		alwaysOpen: false,
		animated: true,
			showSpeed: "fast",
		hideSpeed: "fast"
	});	
	
	*/
	
	$('a#guardar_g').click(function(){
	$('form#form_admin').submit();
	
		});
	
	
	
	
	
	$('textarea.tinymce').tinymce(tinymceConfigs[0]);
	$('textarea.tinymce2').tinymce(tinymceConfigs[1]);
/*
	$('textarea.tinymce').tinymce({
		// Location of TinyMCE script
		script_url : '/js/jquery/tiny_mce/tiny_mce.js',

		// General options
		relative_urls : false,
		theme : "advanced",
		plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
	
*/
	
	
	
	

});
function toggleEditor(id) {
	var settingid=0;
	var element_class=$("#"+id).attr('class');
	if(element_class=='tinymce2')
		settingid=1;
	else
		settingid=0;
	
	
    if (!tinyMCE.getInstanceById(id))
    {
    	tinyMCE.settings = tinymceConfigs[settingid];
        tinyMCE.execCommand('mceAddControl', false, id);
    }
    else
    {
    	tinyMCE.settings = tinymceConfigs[settingid];
        tinyMCE.execCommand('mceRemoveControl', false, id);
    }
  
                
}
  $().ready(function()
		{		  /*  $("#form_admin").submit(function()			{		        if($("#gupo_id_uno").val())				{					alert("Por favor, seleccione la//////// subcategoria");					return false;				}				return true;			});*/
			$("#cat_id").change(function()
			{
				var dato=$(this).val();
				var obj=document.getElementById('cat_id');
				var grupo =obj.options[obj.selectedIndex].text;
			$.ajax({
				async:true,
				url:"/admin/producto/subcategoria",
				data: {'dato':dato, 'grupo':grupo},
				beforeSend:function()
				{
					$("#sub_id1").html("<option value=''>Cargando...</option>");
				},
				dataType:"json",
				success:function(res)
				{
					if(res.ok)
						$("#sub_id1").html(res.html);
				}
				});
			});
                        /*paises*/
                        $("#Code").change(function()
			{
				var dato=$(this).val();
				var obj=document.getElementById('code');
				var grupo =obj.options[obj.selectedIndex].text;
			$.ajax({
				async:true,
				url:"/carrito/ciudad",
				data: {'dato':dato, 'grupo':grupo},
				beforeSend:function()
				{
					$("#ciudad").html("<option value=''>Cargando...</option>");
				},
				dataType:"json",
				success:function(res)
				{
					if(res.ok)
						$("#ciudad").html(res.html);
				}
				});
			});
		});
$().ready(function() {
$("#sub_id1").change(function(){
var cbo=document.getElementById("sub_id1");
var id=cbo.options[cbo.selectedIndex].value;
$("#sub_id").val(id);
});
$("#ciudad").change(function(){
var cbo=document.getElementById("ciudad");
var id=cbo.options[cbo.selectedIndex].value;
$("#ID").val(id);
});
});






