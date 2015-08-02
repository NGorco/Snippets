jQuery.fn.mqSlider = function()
{	
	
	if(!jQuery.anythingSlider)
	{
		console.throw('MqSlider: anythingSlider installed required!');
		return false;
	}

	var global = {};

	global.initMqSlider = function(cnt, sldObject)
	{			
		var slider = $(sldObject);
		var slider_container = slider.closest(".mqslider-container");
		var local = {};

		slider.anythingSlider();

		slider_container.find(".slide-left").click(function()
		{
			slider.data("AnythingSlider").goBack();
		});

		slider_container.find(".slide-right").click(function()
		{
			slider.data("AnythingSlider").goForward();
		});
		

		slider_container.on("click", ".item_wrap", function()
		{	
			var cOrder = $(".overlay .cOrder");
			local.cOrder_temp = cOrder.children().clone();

			var popup_slider_c = $('<div class="mqslider-popup"><div class="controls"><div class="slide slide-left"></div><div class="slide slide-right"></div></div></div>');
			var slider_preview = $("<ul class='slider-previews'>");
			var slider_cont = $("<ul class='popup-slider-cont'>");

			var close = $('<div class="cOrder-close"></div>').click(function()
			{	
				cOrder.unbind("click");
				cOrder.html(local.cOrder_temp);
				cOrder.removeClass('mqcOrder');
				$(".cOrder-close").click(function()
				{
					$(".overlay").removeClass("active").find(".overlay-order").removeClass("active");
				});

				$(".overlay").removeClass("active").find(".overlay-order").removeClass("active");
			});
			popup_slider_c.append(close);		

			var slide_cnt = 0;			
			$(this).find(".gallery .gallery-item").each(function()
			{	
				var self = $(this).clone();
				/*MAIN PICS*/
				var img = $("<img>");
				img.attr("src", self.find("a").attr("href")).css({'max-width':'630px', 'width': 'auto!important', 'height': 'auto'});
				var li = $("<li class='slide_" + slide_cnt + "'>");
				li.append(img);

				slider_cont.append(li);


				/*PREVIEWS*/
				var pimg = self.find("img");
				var pwrap =  $("<div class='preview_wrap' id='wrapslide_" + slide_cnt + "'>");

				var pli = $("<li>");
				
				pwrap.append(pimg);
				pli.append(pwrap);

				slider_preview.append(pli);
				slide_cnt++;
			});


			popup_slider_c.append(slider_cont);

			cOrder.html(popup_slider_c).addClass("mqcOrder");
			$(".overlay").addClass("active").find(".overlay-order").addClass("active");


			slider_cont.anythingSlider({'enableNavigation' :false, 'infiniteSlides': false});



			popup_slider_c.append(slider_preview);
			slider_preview.anythingSlider({
				'showMultiple': 4,
				'changeBy': 4,
				'resizeContents': false,
				'infiniteSlides': false
			});

			popup_slider_c.find(".slide-left").click(function()
			{
				slider_preview.data("AnythingSlider").goBack();
			});

			popup_slider_c.find(".slide-right").click(function()
			{
				slider_preview.data("AnythingSlider").goForward();
			});

			cOrder.on("click", ".preview_wrap",function()
			{	
				var split = this.id.split("_");
				slider_cont.data("AnythingSlider").gotoPage(parseInt(split[1]) + 1);
			});


		});

		slider_container.on('mouseenter', '.item_wrap', function()
		{
			$(this).find(".gallery_text").fadeIn();
		});

		slider_container.on('mouseleave', '.item_wrap', function()
		{
			$(this).find(".gallery_text").fadeOut();
		});

		return slider;
	}

	if(this.length > 0)
	{
		this.map(global.initMqSlider);
	}	
}