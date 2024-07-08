var openModal = function (modalContent) {
	closeModal();
	var $modal = $('#modal');
	if (modalContent != '' && $modal.css('display') == 'none') {
		$modal.css('display', 'flex');
		$('body').css('overflow', 'hidden');
		$modal.append(modalContent);
	}
}
var closeModal = function () {
	var $modal = $('#modal');
	if ($modal.css('display') == 'flex') {
		$modal.css('display', 'none');
	}
	$('body').css('overflow', 'auto');
	$modal.html('');
}
var hideAlert = function () {
	var $alert = $('#alert');
	$alert.removeClass();
	$alert.addClass('alert hide');
}
var showAlert = function (message, status, delay = 3000) {
	if (status != '') {
		var $alert = $('#alert');
		$alert.removeClass();
		$alert.addClass('alert show ' + status);
		$alert.find('.alert-text').text(message);
		if (delay != null) setTimeout(hideAlert, delay);
	}
}
var showLoader = function () {
	if ($('.loader-outer').hasClass('active')) {
		$('.loader-outer').removeClass('active');
	}
	$('.loader-outer').addClass('active');
}
var hideLoader = function () {
	if ($('.loader-outer').hasClass('active')) {
		$('.loader-outer').removeClass('active');
	}
}
var postData = function (data, onSuccess, onError = null, beforeSend = null) {
	if (data) {
		$.ajax({
			url: (data.url ? data.url : ''),
			type: 'post',
			dataType: 'json',
			data: data,
			cache: false,
			processData: false,
			contentType: false,
			beforeSend: function () {
				if (typeof beforeSend === 'function') beforeSend();
				if (data.isShowLoader && data.isShowLoader === true) showLoader();
			},
			success: function (res) {
				if (data.isShowLoader && data.isShowLoader === true) hideLoader();
				if (res.error === false) {
					if (typeof onSuccess === 'function') onSuccess(res);
					if (typeof res.message !== 'undefined' && res.message) showAlert(res.message, 'success');
				}
				if (res.error === true) {
					if (typeof onError === 'function') onError(res);
					if (typeof res.message !== 'undefined' && res.message) showAlert(res.message, 'error');
				}
			},
			error: function (jqXHR) {
				var res;
				try {
					res = jqXHR.responseText ? JSON.parse(jqXHR.responseText) : '';
				} catch (err) {}
				if (typeof onError === 'function') onError(res);
			},
			xhr: function () {
				var xhr = new window.XMLHttpRequest();
				xhr.upload.addEventListener("progress", function (evt) {
					if (evt.lengthComputable) {
						var percentComplete = evt.loaded / evt.total;
					}
				}, false);
				xhr.addEventListener("progress", function (evt) {
					if (evt.lengthComputable) {
						var percentComplete = evt.loaded / evt.total;
					}
				}, false);
				return xhr;
			}
		});
	}
}
var wa_chat_toggle = function () {
	if ($(this).parent().hasClass('show')) {
		$(this).parent().removeClass('show');
	} else {
		$(this).parent().addClass('show');
	}
}
var wa_chat_trigger = function () {
	$('#wa-chat-send-button').trigger('click');
}
var copyToClipboard = function (text) {
	if (!navigator.clipboard) {
		var dummy = document.createElement("textarea");
		document.body.appendChild(dummy);
		dummy.value = text;
		dummy.select();
		document.execCommand("copy");
		document.body.removeChild(dummy);
		return showAlert('Berhasil di salin ke papan klip', 'success');
	} else {
		return navigator.clipboard.writeText(text).then(() => {
			showAlert('Berhasil di salin ke papan klip', 'success');
		});
	}
}
var copy_text = function (e) {
	e.preventDefault();
	var txt = $(this).attr('data-copy');
	if (txt && txt != '') return copyToClipboard(txt);
}
var getOffset = function (elem) {
	var offsetLeft = 0,
		offsetTop = 0,
		parent = elem;
	do {
		if (!isNaN(elem.offsetLeft)) {
			offsetLeft += elem.offsetLeft;
			offsetTop += elem.offsetTop;
			parent = elem;
		}
	} while (elem = elem.offsetParent);
	return {
		left: offsetLeft,
		top: offsetTop,
		parent: parent
	};
}
var generate_tooltip = function () {
	var target = this;
	var tip = target.getAttribute("title");
	var tooltip = document.createElement("div");
	tooltip.id = "tooltip";
	if (!tip || tip == "") return false;
	target.removeAttribute("title");
	tooltip.style.opacity = 0;
	tooltip.innerHTML = tip;
	document.body.appendChild(tooltip);
	var init_tooltip = function () {
		if (window.innerWidth < tooltip.offsetWidth * 1.5) {
			tooltip.style.maxWidth = window.innerWidth / 2;
		} else {
			tooltip.style.maxWidth = 340;
		}
		var pos_left = getOffset(target).left + (target.offsetWidth / 2) - (tooltip.offsetWidth / 2);
		var pos_top = getOffset(target).top - tooltip.offsetHeight - 10;
		var landingClassNames = ['background', 'active', 'shown'];
		if (landingClassNames.some(className => getOffset(target).parent.classList.contains(className))) {
			pos_top = (getOffset(target).top - tooltip.offsetHeight - 10) - ((getOffset(target).parent.offsetHeight * 12) / 100);
		}
		if (pos_left < 0) {
			pos_left = getOffset(target).left + target.offsetWidth / 2 - 20;
			tooltip.classList.add("left");
		} else {
			tooltip.classList.remove("left");
		}
		if (pos_left + tooltip.offsetWidth > window.innerWidth) {
			pos_left = getOffset(target).left - tooltip.offsetWidth + target.offsetWidth / 2 + 20;
			tooltip.classList.add("right");
			if (pos_left < 0) {
				pos_left = 10;
				tooltip.classList.add("left");
				tooltip.classList.remove("right");
			} else {
				tooltip.classList.remove("left");
			}
		} else {
			tooltip.classList.remove("right");
		}
		if (pos_top < 0) {
			pos_top = getOffset(target).top + target.offsetHeight + 15;
			tooltip.classList.add("top");
		} else {
			tooltip.classList.remove("top");
		}
		tooltip.style.left = pos_left + "px";
		tooltip.style.top = pos_top + "px";
		tooltip.style.opacity = 1;
	};
	init_tooltip();
	window.addEventListener("resize", init_tooltip);
	var remove_tooltip = function () {
		tooltip.style.opacity = 0;
		document.querySelector("#tooltip") && document.body.removeChild(document.querySelector("#tooltip"));
		target.setAttribute("title", tip);
	};
	target.addEventListener("mouseleave", remove_tooltip);
	tooltip.addEventListener("click", remove_tooltip);
}
var generate_chart = function (canvas, type, data, options) {
	if (canvas) return new Chart(canvas, {
		type,
		data,
		options
	});
}
var generate_chart_data = function (data, colors, labels) {
	return {
		datasets: [{
			data: data,
			backgroundColor: colors.background,
			hoverBackgroundColor: colors.hoverbackground,
			hoverBorderColor: colors.hoverBorder,
		}],
		labels: labels
	}
}
var chart_options = {
	tooltips: {
		enabled: false
	},
	legend: {
		display: false
	},
	cutoutPercentage: 65
}
var init_selectize = function (el, opt) {
	if (el) {
		var select = $(el).selectize(opt);
		if (select.length) {
			$(".selectize-input input").attr('readonly', 'readonly');
			return $(select)[0].selectize;
		}
	}
}
var selected_selectize = function (selectize, items = []) {
	if (items && items != '') return selectize.setValue(items, 1);
}
var selectize_options = function (opt) {
	if (opt) {
		return {
			maxItems: (opt.maxItems ? opt.maxItems : null),
			valueField: (opt.valueField ? opt.valueField : ''),
			labelField: (opt.labelField ? opt.labelField : ''),
			searchField: (opt.searchField ? opt.searchField : []),
			options: (opt.options ? opt.options : []),
			create: (opt.create ? opt.create : false),
			render: (opt.render ? opt.render : {})
		}
	}
}
var whatsapp_template_selection_options = function (data) {
	if (data && data != '') {
		var opt = {
			maxItems: 1,
			valueField: 'id',
			labelField: 'title',
			searchField: ['body', 'title'],
			options: (data ? data : []),
			render: {
				item: function (item, escape) {
					return '<div>' + (item.title ? '<p>' + escape(item.title) + '</p>' : '') + '</div>';
				},
				option: function (item, escape) {
					var label = item.title || item.body;
					return '<div class="item">' +
						'<p style="font-size: 14px;"><strong>' + escape(label) + '</strong></p>' +
						(item.body ? '<p class="copied-field" style="display: none;">' + escape(item.body) + '</p>' : '') +
						'</div>';
				}
			}
		}
		return selectize_options(opt);
	}
}
var whatsapp_template_selection = function (el, data = [], sel = []) {
	var options = whatsapp_template_selection_options(data);
	if (el && options != '') {
		var selectize = init_selectize(el, options);
		if (selectize) {
			if (sel && sel != '') {
				var selected = selected_selectize(selectize, sel);
				$(el).trigger('change');
			}
		}
	}
}
var guest_group_selection_options = function (data) {
	if (data && data != '') {
		var opt = {
			maxItems: 1,
			valueField: 'id',
			labelField: 'title',
			searchField: ['title', 'description'],
			options: (data ? data : []),
			render: {
				item: function (item, escape) {
					return '<div>' + '<p>' + (item.title ? escape(item.title) : '(Tanpa Grup)') + '</p>' + '</div>';
				},
				option: function (item, escape) {
					return '<div class="item">' +
						'<p style="font-size: 14px;"><strong>' + (item.title ? escape(item.title) : '(Tanpa Grup)') + '</strong></p>' +
						(item.description ? '<p style="font-size: 13px;">' + escape(item.description) + '</p>' : '') +
						'</div>';
				}
			}
		}
		return selectize_options(opt);
	}
}
var guest_group_selection = function (el, data = [], sel = []) {
	var options = guest_group_selection_options(data);
	if (el && options != '') {
		var selectize = init_selectize(el, options);
		if (selectize) {
			if (sel) {
				var selected = selected_selectize(selectize, sel);
			}
		}
	}
}
var counter = function (count, bar = null, step = 10) {
	if (count.length) {
		if (count.length == -1 && count.text && count.element) {
			return $(count.element).text(count.text);
		}
		var width = 0;
		var interval = setInterval(begin, step);

		function begin() {
			if (width >= count.length) {
				clearInterval(interval);
			} else {
				width++;
				if (bar && bar.element && bar.length) {
					$(bar.element).css('width', ((count.length * 100) / bar.length) + '%');
				}
				if (count.element) {
					$(count.element).text(width);
				}
			}
		}
	}
}
var textarea_height = function () {
	this.style.height = '1px';
	this.style.height = (0 + this.scrollHeight) + 'px';
}
var goto = function (page) {
	return window.location.href = page;
}
var goto_handler = function (e) {
	e.preventDefault();
	var page = $(this).attr('data-goto');
	if (page) return goto(page);
}
var goto_calculator = function (e) {
	e.preventDefault();
	var redirect = $(this).attr('href');
	if (!redirect) redirect = 'https://katsudoto.id/v2/package';
	var formStepGuest = {
		origin: redirect,
		prev: redirect,
		next: redirect,
		current: '',
		label: 'Calculator',
		updatedAt: new Date()
	}
	window.localStorage.setItem('formStep:guest', JSON.stringify(formStepGuest));
	window.open(redirect);
}
var dropdown_toggle = function (e) {
	e.preventDefault();
	e.stopPropagation();
	return $(this).next('.dropdown-content').addClass('show');
}
var hide_dropdown = function () {
	var dropdownContent = $('.dropdown-content');
	if (dropdownContent.length && $(dropdownContent).hasClass('show')) return $(dropdownContent).removeClass('show');
}
var init_tab = function (parent = '') {
	var navs = $('[data-tab-content]');
	for (var i = 0; i < navs.length; i++) {
		if (parent != '' && $(navs[i]).closest(parent).length && $(navs[i]).hasClass('active')) $(navs[i]).trigger('click');
		if (parent == '' && $(navs[i]).hasClass('active')) $(navs[i]).trigger('click');
	}
}
var tab_content_toggle = function (e) {
	e.preventDefault();
	var wrapper = $(this).attr('data-tab-wrapper');
	var target = $(this).attr('data-tab-content');
	var navs = $('[data-tab-content]');
	for (var i = 0; i < navs.length; i++) {
		if ($(navs[i]).attr('data-tab-wrapper') == wrapper) {
			$(navs[i]).removeClass('active');
			$($(navs[i]).attr('data-tab-content')).hide();
		}
	}
	$(this).addClass('active');
	if ($(target).css('display') == 'none') $(target).show();
}
var animateCSS = function (element, animation, speed = '', prefix = 'animate__') {
	return new Promise((resolve, reject) => {
		const animationInit = `${prefix}animated`;
		const animationSpeed = (speed != '' ? `${prefix}${speed}` : '');
		const animationName = `${prefix}${animation}`;
		const node = document.querySelector(element);
		$(element).addClass(animationInit + " " + animationName + " " + animationSpeed)

		function handleAnimationEnd(event) {
			event.stopPropagation();
			$(element).removeClass(animationInit + " " + animationName + " " + animationSpeed)
			resolve('Animation ended');
		}
		node.addEventListener('animationend', handleAnimationEnd, {
			once: true
		});
	});
}

function getViewport() {
	var e = window,
		a = 'inner';
	if (!('innerWidth' in window)) {
		a = 'client';
		e = document.documentElement || document.body;
	}
	return {
		width: e[a + 'Width'],
		height: e[a + 'Height']
	};
}

function getMobileOperatingSystem() {
	var userAgent = navigator.userAgent || navigator.vendor || window.opera;
	if (/windows phone/i.test(userAgent)) {
		return "Windows Phone";
	}
	if (/android/i.test(userAgent)) {
		return "Android";
	}
	if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
		return "iOS";
	}
	return "unknown";
}

function isValidDate(date) {
	const parsedDate = new Date(date);
	return !isNaN(parsedDate) && parsedDate.toString() !== 'Invalid Date';
}
$(document).on('click', '.close-modal', closeModal);
$(document).on('click', '.alert-close', hideAlert);
$(document).on('click', '#wa-chat-send-button', wa_chat_toggle);
$(document).on('click', '#close-wa-widget', wa_chat_trigger);
$(document).on('mouseenter', '[rel="tooltip"]', generate_tooltip);
$(document).on('keyup focus focusout', 'textarea', textarea_height);
$(document).on('click', '[data-copy]', copy_text);
$(document).on('click', '[data-goto]', goto_handler);
$(document).on('click', '.goto-calculator', goto_calculator);
$(document).on('click', '.dropdown-btn', dropdown_toggle);
$(document).on('click', '[data-tab-content]', tab_content_toggle);
var accordion_toogle = function (e) {
	e.preventDefault();
	var wrapper = $(this).closest('.accordion');
	var item = $(this).closest('.accordion-item');
	if (wrapper && wrapper.length && item && item.length) {
		var isItemShow = false;
		if ($(item).hasClass('show')) isItemShow = true;
		var items = $(wrapper).find('.accordion-item');
		for (var i = 0; i < items.length; i++) {
			if ($(items[i]).hasClass('show')) {
				$(items[i]).removeClass('show');
				$(items[i]).find('.accordion-panel').removeClass('show').slideUp();
			}
		}
		if (!isItemShow) {
			$(item).addClass('show');
			$(item).find('.accordion-panel').addClass('show').slideDown();
		}
		if (isItemShow) {
			$(item).removeClass('show');
			$(item).find('.accordion-panel').removeClass('show').slideUp();
		}
	}
}
$(document).on('click', '.accordion-label', accordion_toogle);
$(document).on('keyup', function (e) {
	if (e.key === "Escape") {
		if ($('#modal').length) closeModal();
	}
});
if (typeof NProgress !== 'undefined') {
	NProgress.start();
	var nprogressInterval = setInterval(function () {
		NProgress.inc();
	}, 1000);
	$(window).on('load', function () {
		clearInterval(nprogressInterval);
		NProgress.done();
	});
	$(window).on('unload', function () {
		NProgress.start();
	});
	$(document).ajaxStart(function () {
		NProgress.start();
	});
	$(document).ajaxStop(function () {
		NProgress.done();
	});
}
$(document).ready(function () {
	setTimeout(init_tab, 500);
	window.onclick = function (event) {
		if (event.target != $('.dropdown-btn')) hide_dropdown();
	}
	if ($.fn.pickadate) {
		$.extend($.fn.pickadate.defaults, {
			monthsFull: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
			monthsShort: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
			weekdaysFull: ["Minggu", "Senin", "Selasa", "Rabu", "kamis", "Jum'at", "Sabtu"],
			weekdaysShort: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
			today: 'Hari Ini',
			clear: 'Hapus',
			close: 'Tutup',
			formatSubmit: 'yyyy-mm-dd',
			format: 'dddd, dd mmmm yyyy'
		});
	}
	if ($.fn.pickatime) {
		$.extend($.fn.pickatime.defaults, {
			clear: '',
			format: 'HH:i',
			formatSubmit: 'HH:i',
			interval: 15,
		});
	}
});
