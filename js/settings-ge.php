<?php
$SelecionarLeiaute = SelecionarLeiaute();
$LeiauteDesabled = $SelecionarLeiaute[0] == 1 ? "disabled" : "";
?>
<script type='text/javascript'>  
var site_settings = '<div class="ts-button">'
        +'<span class="fa fa-cog"></span>'
    +'</div>'
    +'<div class="ts-body">'
        +'<div class="ts-title">Optionen</div>'
        +'<div class="ts-row">'
            +'<label class="check <?php echo $LeiauteDesabled; ?>"><input type="checkbox" class="icheckbox" name="st_head_fixed" value="1"/> Feste Kopf</label>'
        +'</div>'
        +'<div class="ts-row">'
            +'<label class="check <?php echo $LeiauteDesabled; ?>"><input type="checkbox" class="icheckbox" name="st_sb_fixed" value="1" checked/> Feste Sidebar</label>'
        +'</div>'
        +'<div class="ts-row">'
            +'<label class="check"><input type="checkbox" class="icheckbox" name="st_sb_scroll" value="1"/> Scroll Sidebar</label>'
        +'</div>'
        +'<div class="ts-row">'
            +'<label class="check"><input type="checkbox" class="icheckbox" name="st_sb_right" value="1"/> Rechter Sidebar</label>'
        +'</div>'
        +'<div class="ts-row">'
            +'<label class="check"><input type="checkbox" class="icheckbox" name="st_sb_custom" value="1"/> Individuelle Navigation</label>'
        +'</div>'
        +'<div class="ts-row">'
            +'<label class="check"><input type="checkbox" class="icheckbox" name="st_sb_toggled" value="1"/> Toggle Navigation</label>'
        +'</div>'
        +'<div class="ts-title">Layout</div>'
        +'<div class="ts-row">'
            +'<label class="check"><input type="radio" class="iradio" name="st_layout_boxed" value="0"/> Voll</label>'
        +'</div>'
        +'<div class="ts-row">'
            +'<label class="check"><input type="radio" class="iradio" name="st_layout_boxed" value="1"/> Zentriert</label>'
        +'</div>'
        +'<div id="ts-wallpapers">'
        +'<div class="ts-title">Wallpapers</div>'
            +'<div class="ts-themes">'
                +'<a href="#" data-wall="wall_1"><img src="img/backgrounds/wall_1.jpg"/></a>'
                +'<a href="#" data-wall="wall_2"><img src="img/backgrounds/wall_2.jpg"/></a>'
                +'<a href="#" data-wall="wall_3"><img src="img/backgrounds/wall_3.jpg"/></a>'
                +'<a href="#" data-wall="wall_4"><img src="img/backgrounds/wall_4.jpg"/></a>'    
                +'<a href="#" data-wall="wall_5"><img src="img/backgrounds/wall_5.jpg"/></a>'

                +'<a href="#" data-wall="wall_6"><img src="img/backgrounds/wall_6.jpg"/></a>'
                +'<a href="#" data-wall="wall_7"><img src="img/backgrounds/wall_7.jpg"/></a>'
                +'<a href="#" data-wall="wall_8"><img src="img/backgrounds/wall_8.jpg"/></a>'
                +'<a href="#" data-wall="wall_9"><img src="img/backgrounds/wall_9.jpg"/></a>'    
                +'<a href="#" data-wall="wall_10"><img src="img/backgrounds/wall_10.jpg"/></a>'    
            +'</div>'
        +'</div>'
    +'</div>';
    

var settings_block = document.createElement('div');
    settings_block.className = "theme-settings";
    settings_block.innerHTML = site_settings;
    document.body.appendChild(settings_block);

$(document).ready(function(){
/*
    $.get("assets/settings.html",function(data){        
        $("body").append($(data));
    });*/
    
    /* Default settings */
    var theme_settings = {
        st_head_fixed: <?php echo $SelecionarLeiaute[2]; ?>,
        st_sb_fixed: <?php echo $SelecionarLeiaute[3]; ?>,
        st_sb_scroll: <?php echo $SelecionarLeiaute[4]; ?>,
        st_sb_right: <?php echo $SelecionarLeiaute[5]; ?>,
        st_sb_custom: <?php echo $SelecionarLeiaute[6]; ?>,
        st_sb_toggled: <?php echo $SelecionarLeiaute[7]; ?>,
        st_layout_boxed: <?php echo $SelecionarLeiaute[0]; ?>
    };
		
    /* End Default settings */
    
    set_settings(theme_settings,false); 
	
	<?php
	if( ($SelecionarLeiaute[7] == 1) || ($SelecionarLeiaute[8] == "S") ){
	?>
		$(".page-container").addClass("page-navigation-toggled");
		$(".x-navigation-minimize").trigger("click");
	<?php
	}
	?>
	
	$(".x-navigation-minimize").click(function(){
        $.post('AtualizarMinimizar.php');
    });
		
	//Define o Papel de Parede
	if(theme_settings.st_layout_boxed == 1){
	$(".page-container-boxed").removeClass("wall_1 wall_2 wall_3 wall_4 wall_5 wall_6 wall_7 wall_8 wall_9 wall_10").addClass("<?php echo $SelecionarLeiaute[1]; ?>");
	
	var input = $(".theme-settings").find("input[name=st_head_fixed]");
	input.prop("checked",false);            
    input.parent("div").removeClass("checked");
    input.prop("disabled",true);            
    input.parent("div").addClass("disabled").parent(".check").addClass("disabled");
	
	var input = $(".theme-settings").find("input[name=st_sb_fixed]");
	input.prop("checked",false);            
    input.parent("div").removeClass("checked");
    input.prop("disabled",true);            
    input.parent("div").addClass("disabled").parent(".check").addClass("disabled");
	
	}
	
    $(".theme-settings input").on("ifClicked",function(){
        
        var input   = $(this);
		
		if(input.attr("name") == 'st_layout_boxed'){
			var leiaute = input.val();
			$.post('AtualizarLeiaute.php', {leiaute: leiaute});
		}

        if(input.attr("name") != 'st_layout_boxed'){
                
            if(!input.prop("checked")){
                theme_settings[input.attr("name")] = input.val();
            }else{            
                theme_settings[input.attr("name")] = 0;
            }
            
        }else{
            theme_settings[input.attr("name")] = input.val();
        }

        /* Rules */
        if(input.attr("name") === 'st_sb_fixed'){
            if(theme_settings.st_sb_fixed == 1){
                theme_settings.st_sb_scroll = 1;
            }else{
                theme_settings.st_sb_scroll = 0;
            }
        }
        
        if(input.attr("name") === 'st_sb_scroll'){
            if(theme_settings.st_sb_scroll == 1 && theme_settings.st_layout_boxed == 0){
                theme_settings.st_sb_fixed = 1;
            }else if(theme_settings.st_sb_scroll == 1 && theme_settings.st_layout_boxed == 1){
                theme_settings.st_sb_fixed = -1;
            }else if(theme_settings.st_sb_scroll == 0 && theme_settings.st_layout_boxed == 1){
                theme_settings.st_sb_fixed = -1;
            }else{
                theme_settings.st_sb_fixed = 0;
            }
        }
        
        if(input.attr("name") === 'st_layout_boxed'){
            if(theme_settings.st_layout_boxed == 1){                
                theme_settings.st_head_fixed    = -1;
                theme_settings.st_sb_fixed      = -1;
                theme_settings.st_sb_scroll     = 1;
                
                $("#ts-wallpapers").show();
            }else{
                theme_settings.st_head_fixed    = 0;
                theme_settings.st_sb_fixed      = 1;
                theme_settings.st_sb_scroll     = 1;
                
                $("#ts-wallpapers").hide();
            }
        }
        /* End Rules */
        
        set_settings(theme_settings,input.attr("name"));
        
    });
    
    /* Change Theme */	
    $(".ts-themes a[data-theme]").click(function(){
        $(".ts-themes a[data-theme]").removeClass("active");
        $(this).addClass("active");
        $("#theme").attr("href",$(this).data("theme"));
        return false;
    });
    /* END Change Theme */
    
    /* Change Wallpaper */
    $(".ts-themes a[data-wall]").click(function(){
        $(".ts-themes a[data-wall]").removeClass("active");
        $(this).addClass("active");
        $(".page-container-boxed").removeClass("wall_1 wall_2 wall_3 wall_4 wall_5 wall_6 wall_7 wall_8 wall_9 wall_10").addClass($(this).data("wall"));
		var PapelWall = $(this).data("wall");
		$.post('AtualizarWall.php', {wall: PapelWall});	
        return false;
    });
    /* END Change Wallpaper */
    
    /* Open/Hide Settings */
    $(".ts-button").on("click",function(){
        $(".theme-settings").toggleClass("active");
    });
    /* End open/hide settings */
});

function set_settings(theme_settings,option){

    /* Start Header Fixed */
    if(theme_settings.st_head_fixed == 1){
        $(".page-container").addClass("page-navigation-top-fixed");
	}
    else{
        $(".page-container").removeClass("page-navigation-top-fixed");  
	}
    /* END Header Fixed */
    
    /* Start Sidebar Fixed */
    if(theme_settings.st_sb_fixed == 1){        
        $(".page-sidebar").addClass("page-sidebar-fixed");
    }else
        $(".page-sidebar").removeClass("page-sidebar-fixed");
    /* END Sidebar Fixed */
    
    /* Start Sidebar Fixed */
    if(theme_settings.st_sb_scroll == 1){          
        $(".page-sidebar").addClass("scroll").mCustomScrollbar("update");        
    }else
        $(".page-sidebar").removeClass("scroll").css("height","").mCustomScrollbar("disable",true);
    
    /* END Sidebar Fixed */
    
    /* Start Right Sidebar */
    if(theme_settings.st_sb_right == 1)
        $(".page-container").addClass("page-mode-rtl");
    else
        $(".page-container").removeClass("page-mode-rtl");
    /* END Right Sidebar */
    
    /* Start Custom Sidebar */
    if(theme_settings.st_sb_custom == 1){
        $(".page-sidebar .x-navigation").addClass("x-navigation-custom");
	}
    else{
        $(".page-sidebar .x-navigation").removeClass("x-navigation-custom");
	}
    /* END Custom Sidebar */
    
	//Salvar em banco de dados 
	$.post('AtualizarLeiauteOpcoes.php', {cabecalho: theme_settings.st_head_fixed, barralateral: theme_settings.st_sb_fixed, scroll: theme_settings.st_sb_scroll, barradireita: theme_settings.st_sb_right, navpersonalizado: theme_settings.st_sb_custom, alternarnav: theme_settings.st_sb_toggled});	
	
    /* Start Custom Sidebar */
    if(option && option === 'st_sb_toggled'){
        if(theme_settings.st_sb_toggled == 1){
            $(".page-container").addClass("page-navigation-toggled");
            $(".x-navigation-minimize").trigger("click");
        }else{          
            $(".page-container").removeClass("page-navigation-toggled");
            $(".x-navigation-minimize").trigger("click");
        }
    }
    /* END Custom Sidebar */
    
    /* Start Layout Boxed */
    if(theme_settings.st_layout_boxed == 1)
        $("body").addClass("page-container-boxed");
    else
        $("body").removeClass("page-container-boxed");
    /* END Layout Boxed */
    
    /* Set states for options */
    if(option === false || option === 'st_layout_boxed' || option === 'st_sb_fixed' || option === 'st_sb_scroll'){        
        for(option in theme_settings){
            set_settings_checkbox(option,theme_settings[option]);
        }
    }
    /* End states for options */
    
    /* Call resize window */
    $(window).resize();
    /* End call resize window */
}

function set_settings_checkbox(name,value){
    
    if(name == 'st_layout_boxed'){    
        
        $(".theme-settings").find("input[name="+name+"]").prop("checked",false).parent("div").removeClass("checked");
        
        var input = $(".theme-settings").find("input[name="+name+"][value="+value+"]");
                
        input.prop("checked",true);
        input.parent("div").addClass("checked");        
        
    }else{
        
        var input = $(".theme-settings").find("input[name="+name+"]");
        
        input.prop("disabled",false);            
        input.parent("div").removeClass("disabled").parent(".check").removeClass("disabled");        
        
        if(value === 1){
            input.prop("checked",true);
            input.parent("div").addClass("checked");
        }
        if(value === 0){
            input.prop("checked",false);            
            input.parent("div").removeClass("checked");            
        }
        if(value === -1){
            input.prop("checked",false);            
            input.parent("div").removeClass("checked");
            input.prop("disabled",true);            
            input.parent("div").addClass("disabled").parent(".check").addClass("disabled");
        }        
                
    }
}
</script>