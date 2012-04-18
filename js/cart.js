/**
* jQuery Cart Plugin 1.0
*
* Copyright (c) 2012 Shilov Vasily
* Site: www.aiway.ru
* E-mail: support@aiway.ru
*/
(function($) {
	var defaults = {
		content : '.content', // селектор главного блока на странице корзины
		count : '.prod span font', // в блоке .prod на странице количество товаров в корзине
		summ : '.summ span font', // в блоке .prod общая сумма
		add : '.tocart', // селектор элемента, при нажатии на который товар будет добавлен в корзину
		addattr : 'name', // атрибут элемента, содержащий ID товара
		counta : '.carts .actions .count input', // поле содержащее количество товаров одного наименования в корзине
		countattr : 'name', // атрибут поля, содержащий ID товара
		countvattr : 'value', // атрибут поля, содержащий количество товаров
		del : '.carts .actions .delete input', // селектор элемента, при нажатии на который 1 наименование товара будет удалено из корзины
		delattr : 'name', // атрибут элемента, содержащий ID товара
		clear : '.cartclear', // селектор элемента, при нажатии на который корзина будет очищена
		topcart : '.topcart', // селектор ссылки ведущей в корзину
		urladd : '/cart/add/', // url добавления товара в корзину
		urlget : '/cart/get/', // url информации о количестве товаров в корзине и общей сумме
		urlcart : '/cart/', // url непосредственно самой корзины
		urlcount : '/cart/count/', // url обновления количества товаров одного наименования
		urlclear : '/cart/clear/', // url полной очистки корзины
		urldel : '/cart/del/', // url удаления одного наименования товара из корзины
		type_message : 'flash', // тип сообщения при добавлении товара в корзину
		time_message : 3000, // время показа сообщения
		interval : 10000 // интервал времени, через который будет обновляться блок с информацией о количестве товаров в корзине и общей сумме
	};
	$.Cart = {
		init : function(settings){
			$.extend(defaults, settings);
			this.settings = defaults;
			this.get();
			setInterval(function(){
				$.Cart.get();
			}, this.settings.interval);
			$(this.settings.add).click(function(){
				$.Cart.add(this);
			});
			$(this.settings.counta).live('blur', function(){
				$.Cart.count(this);
			});
			$(this.settings.del).live('click', function(){
				$.Cart.del(this);
			});
			$(this.settings.clear).live('click', function(){
				$.Cart.clear();
			});
			return this;
		},
		add : function(context){
			$.Cart.updateCart({
				url : $.Cart.settings.urladd,
				data : {
					id : $(context).attr($.Cart.settings.addattr)
				}
			});
		},
		get : function(){
			$.Cart.updateCart({
				url : $.Cart.settings.urlget,
				data : {}
			});
		},
		count : function(context) {
			$.post($.Cart.settings.urlcount, {
				id : $(context).attr($.Cart.settings.countattr),
				count : $(context).attr($.Cart.settings.countvattr)
			}, function(data){
				$($.Cart.settings.content).html(data);
				$.Cart.get();
			});
		},
		del : function(context) {
			$.post($.Cart.settings.urldel, {
				id : $(context).attr($.Cart.settings.delattr)
			}, function(data){
				$($.Cart.settings.content).html(data);
				$.Cart.get();
			});
		},
		clear : function(){
			$.post($.Cart.settings.urlclear, {}, function(data){
				$($.Cart.settings.content).html(data);
				$.Cart.get();
			});
		},
		updateCart : function(data){
			var vars = data;
			$.ajax({
				url : data.url, 
				type : 'post',
				dataType: 'json',
				data : vars.data,
				success : function(data){
					if (data.count && data.summ || data.count===0 && data.summ===0) {
						$($.Cart.settings.count).html(data.count);
						$($.Cart.settings.summ).html(data.summ);
						if (data.count>0)
							$($.Cart.settings.topcart).find('a').attr('href', $.Cart.settings.urlcart);
						else
							$($.Cart.settings.topcart).find('a').attr('href', 'javascript:void(0);');
						if (vars.data.id)
							$.Cart.showMessage('<p>'+data.message+'</p>'+$($.Cart.settings.topcart).html());
					}
				},
				error : function(err) {
					if (err.status!==200)
						console.log(err.status+' '+err.statusText);
				}
			});
		},
		showMessage : function(message){
			if ($.Cart.settings.type_message==='alert') {
				alert(message);
				return;
			} else if ($.Cart.settings.type_message==='flash') {
				if ($('.flashmessage').length===0)
					$('<div />').addClass('flashmessage').html(message).hide().appendTo('body').fadeIn();
				else
					$('.flashmessage').html(message);
				if (typeof($.Cart.message_time)==='number')
					clearTimeout($.Cart.message_time);
				$.Cart.message_time = setTimeout(function(){
					$('.flashmessage').fadeOut(function(){
						$(this).remove();
					});
				}, $.Cart.settings.time_message);
			}
		}
	}
})(jQuery);